<?php
/**
 * ExpressLogist — first-party коллектор аналитики.
 *
 * Принимает события от инлайн-трекера на страницах (navigator.sendBeacon).
 * Работает на вашем же домене, поэтому не блокируется антитрекерами.
 * Пишет по одной JSON-строке на событие в logs/analytics.jsonl.
 *
 * Приватность (152-ФЗ):
 *  - Данные принимаются ТОЛЬКО при наличии cookie согласия (cookie_consent=1).
 *  - IP не хранится в открытом виде — только необратимый хэш с секретной солью.
 *  - Никаких сторонних сервисов, всё остаётся на вашем сервере.
 */

declare(strict_types=1);

require __DIR__ . '/../inc/config.php';

/* Тихо выходим со статусом 204 — трекеру ответ не нужен. */
function elg_no_content(): void
{
    http_response_code(204);
    exit;
}

/* Аналитика выключена в конфиге — ничего не делаем. */
if (empty($analytics['enabled'])) {
    elg_no_content();
}

/* Принимаем только POST. */
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    elg_no_content();
}

/* Ключевое: сбор только после согласия пользователя. */
if (($_COOKIE['cookie_consent'] ?? '') !== '1') {
    elg_no_content();
}

/* Читаем тело запроса (sendBeacon шлёт JSON-текст). */
$raw = file_get_contents('php://input');
if ($raw === false || $raw === '' || strlen($raw) > 8192) {
    elg_no_content();
}

$data = json_decode($raw, true);
if (!is_array($data)) {
    elg_no_content();
}

/* --- Хелперы очистки --- */
$clean = static function ($v, int $max = 255): string {
    if (!is_scalar($v)) {
        return '';
    }
    $s = (string) $v;
    $s = str_replace(["\r", "\n", "\t"], ' ', $s);
    $s = trim($s);
    if (function_exists('mb_substr')) {
        $s = mb_substr($s, 0, $max);
    } else {
        $s = substr($s, 0, $max);
    }
    return $s;
};

/* Разрешённые типы событий. */
$allowedEvents = ['pageview', 'lead', 'vacancy', 'click', 'scroll', 'phone', 'ping'];
$event = $clean($data['e'] ?? 'pageview', 32);
if (!in_array($event, $allowedEvents, true)) {
    $event = 'other';
}

/* Обезличенный IP: необратимый хэш с секретной солью. */
$ip = $_SERVER['REMOTE_ADDR'] ?? '';
$ipHash = $ip !== ''
    ? substr(hash('sha256', $ip . '|' . ($analytics['ipSalt'] ?? '')), 0, 16)
    : '';

/* Идентификатор посетителя (first-party cookie, обезличенный). */
$vid = $_COOKIE['elg_vid'] ?? '';
if (!preg_match('/^[a-f0-9]{16}$/', $vid)) {
    try {
        $vid = bin2hex(random_bytes(8));
    } catch (Exception $e) {
        $vid = substr(hash('sha256', $ipHash . microtime()), 0, 16);
    }
    /* Ставим на год, HttpOnly — недоступен из JS. */
    setcookie('elg_vid', $vid, [
        'expires'  => time() + 31536000,
        'path'     => '/',
        'secure'   => (($_SERVER['HTTPS'] ?? '') === 'on'),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
}

/* Простое определение устройства по User-Agent. */
$ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
$device = 'desktop';
if (preg_match('/Mobile|Android|iPhone|iPod/i', $ua)) {
    $device = 'mobile';
} elseif (preg_match('/iPad|Tablet/i', $ua)) {
    $device = 'tablet';
}
$isBot = preg_match('/bot|crawl|spider|slurp|yandex|google|bing|preview/i', $ua) ? 1 : 0;

/* Формируем запись события. */
$record = [
    'ts'       => date('c'),
    'e'        => $event,
    'vid'      => $vid,
    'path'     => $clean($data['p'] ?? '', 255),
    'ref'      => $clean($data['r'] ?? '', 255),
    'utm_source'   => $clean($data['us'] ?? '', 100),
    'utm_medium'   => $clean($data['um'] ?? '', 100),
    'utm_campaign' => $clean($data['uc'] ?? '', 150),
    'utm_term'     => $clean($data['ut'] ?? '', 150),
    'utm_content'  => $clean($data['un'] ?? '', 150),
    'label'    => $clean($data['l'] ?? '', 120),
    'device'   => $device,
    'bot'      => $isBot,
    'iph'      => $ipHash,
];

/* Пишем JSONL с блокировкой. Папку logs/ создаём при отсутствии (как send.php). */
$logDir = __DIR__ . '/../logs';
$logFile = $logDir . '/analytics.jsonl';
if (!is_dir($logDir)) {
    @mkdir($logDir, 0775, true);
}
if (is_dir($logDir) && is_writable($logDir)) {
    $line = json_encode($record, JSON_UNESCAPED_UNICODE) . "\n";
    @file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX);
}

elg_no_content();
