<?php
/**
 * ExpressLogist — обработчик заявки на расчёт доставки.
 *
 * Принимает POST (имя, телефон, компания, откуда, куда, тип груза, комментарий,
 * согласие), валидирует данные на сервере, сохраняет заявку в logs/leads.txt
 * и отвечает JSON. Работает автономно на любом PHP-хостинге (VPS) — без внешних
 * сервисов. Для e-mail-уведомлений раскомментируйте блок mail() ниже.
 *
 * Требования: PHP 7.4+, права на запись в папку logs/.
 */

declare(strict_types=1);

require __DIR__ . '/inc/config.php';

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-store');

date_default_timezone_set('Europe/Moscow');

/** Отправляет JSON и завершает выполнение */
function respond(array $payload, int $status = 200): void
{
    http_response_code($status);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

// Принимаем только POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(['success' => false, 'message' => 'Метод не поддерживается'], 405);
}

// Анти-спам: honeypot-поле «website» должно быть пустым.
// Боты заполняют все поля — если оно не пустое, тихо имитируем успех, не сохраняя.
if (trim((string) ($_POST['website'] ?? '')) !== '') {
    respond(['success' => true, 'message' => 'Заявка отправлена. Менеджер свяжется с вами в ближайшее время.']);
}

/* -------------------- Получение и очистка данных -------------------- */

/** Нормализует строку: срезает пробелы, убирает управляющие символы, схлопывает пробелы */
function clean_text(string $value): string
{
    $value = preg_replace('/[\x00-\x1F\x7F]/u', '', $value);
    $value = preg_replace('/\s+/u', ' ', $value);
    return trim($value);
}

$name    = clean_text((string) ($_POST['name'] ?? ''));
$company = clean_text((string) ($_POST['company'] ?? ''));
$from    = clean_text((string) ($_POST['from'] ?? ''));
$to      = clean_text((string) ($_POST['to'] ?? ''));
$service = clean_text((string) ($_POST['service'] ?? ''));
$comment = clean_text((string) ($_POST['comment'] ?? ''));

// Телефон: оставляем только цифры, 8XXXXXXXXXX -> 7XXXXXXXXXX
$phone = preg_replace('/\D/', '', (string) ($_POST['phone'] ?? ''));
if (strlen($phone) === 11 && $phone[0] === '8') {
    $phone = '7' . substr($phone, 1);
}

$agree = (string) ($_POST['agree'] ?? '') === '1';

/* -------------------- Валидация -------------------- */

$errors = [];

if (mb_strlen($name, 'UTF-8') < 2) {
    $errors['name'] = 'Введите имя (минимум 2 символа)';
} elseif (mb_strlen($name, 'UTF-8') > 100) {
    $errors['name'] = 'Слишком длинное имя';
}

if (!preg_match('/^7\d{10}$/', $phone)) {
    $errors['phone'] = 'Телефон должен содержать 11 цифр и начинаться с +7';
}

// Тип груза сверяем со справочником из config.php ($serviceTypes)
if ($service !== '' && !in_array($service, $serviceTypes, true)) {
    $errors['service'] = 'Выберите тип груза из списка';
}

if (mb_strlen($from, 'UTF-8') > 120 || mb_strlen($to, 'UTF-8') > 120) {
    $errors['route'] = 'Слишком длинное название пункта';
}

if (mb_strlen($comment, 'UTF-8') > 2000) {
    $errors['comment'] = 'Комментарий слишком длинный';
}

if (!$agree) {
    $errors['agree'] = 'Необходимо согласие на обработку персональных данных';
}

if ($errors) {
    respond([
        'success' => false,
        'message' => 'Проверьте правильность заполнения полей',
        'errors'  => $errors,
    ], 422);
}

/* -------------------- Сохранение в файл -------------------- */

$logDir  = __DIR__ . '/logs';
$logFile = $logDir . '/leads.txt';

if (!is_dir($logDir) && !mkdir($logDir, 0755, true)) {
    respond(['success' => false, 'message' => 'Не удалось сохранить заявку. Попробуйте позже.'], 500);
}

$line = sprintf(
    "[%s] | Имя: %s | Тел: %s | Компания: %s | Откуда: %s | Куда: %s | Груз: %s | Комментарий: %s\n",
    date('Y-m-d H:i:s'),
    $name,
    $phone,
    $company !== '' ? $company : '—',
    $from !== '' ? $from : '—',
    $to !== '' ? $to : '—',
    $service !== '' ? $service : '—',
    $comment !== '' ? $comment : '—'
);

// LOCK_EX защищает файл от порчи при одновременных записях
$written = file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX);

if ($written === false) {
    respond(['success' => false, 'message' => 'Не удалось сохранить заявку. Попробуйте позже.'], 500);
}

/* -------------------- E-mail уведомление (по желанию) --------------------
   Раскомментируйте на боевом сервере с настроенным sendmail/SMTP.

$subject = '=?UTF-8?B?' . base64_encode('Новая заявка — ' . $siteName) . '?=';
$body    = "Имя: $name\nТелефон: +$phone\nКомпания: $company\n"
         . "Маршрут: $from → $to\nТип груза: $service\nКомментарий: $comment";
$headers = "From: $siteName <no-reply@" . parse_url($baseUrl, PHP_URL_HOST) . ">\r\n"
         . "Content-Type: text/plain; charset=UTF-8\r\n";
@mail($email, $subject, $body, $headers);
------------------------------------------------------------------------- */

respond(['success' => true, 'message' => 'Заявка отправлена. Менеджер свяжется с вами в ближайшее время.']);
