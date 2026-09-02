<?php
/**
 * ExpressLogist — обработчик формы заявки.
 *
 * Принимает POST (имя, телефон, город, согласие), валидирует данные на сервере,
 * сохраняет заявку в logs/leads.txt и отвечает JSON.
 *
 * Формат строки в файле:
 *   [2026-02-09 15:30:45] | Имя: Иван | Телефон: 79261234567 | Город: Москва
 *
 * Требования: PHP 7.4+, права на запись в папку logs/.
 */

declare(strict_types=1);

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

// Список допустимых городов — должен совпадать со списком в index.php
$allowedCities = [
    'Москва', 'Санкт-Петербург', 'Новосибирск', 'Екатеринбург', 'Казань',
    'Нижний Новгород', 'Челябинск', 'Омск', 'Ростов-на-Дону', 'Уфа',
    'Красноярск', 'Пермь', 'Воронеж', 'Волгоград', 'Краснодар',
    'Саратов', 'Тюмень', 'Тольятти', 'Ижевск', 'Барнаул',
];

/* -------------------- Получение и очистка данных -------------------- */

// Имя: убираем лишние пробелы и управляющие символы, экранируем HTML (защита от XSS)
$name = trim((string) ($_POST['name'] ?? ''));
$name = preg_replace('/[\x00-\x1F\x7F]/u', '', $name);
$name = preg_replace('/\s+/u', ' ', $name);
$name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

// Телефон: оставляем только цифры
$phone = preg_replace('/\D/', '', (string) ($_POST['phone'] ?? ''));
// 8XXXXXXXXXX -> 7XXXXXXXXXX
if (strlen($phone) === 11 && $phone[0] === '8') {
    $phone = '7' . substr($phone, 1);
}

// Город
$city = trim((string) ($_POST['city'] ?? ''));

// Согласие
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

if (!in_array($city, $allowedCities, true)) {
    $errors['city'] = 'Выберите город из списка';
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

// Создаём папку, если её нет
if (!is_dir($logDir) && !mkdir($logDir, 0755, true)) {
    respond(['success' => false, 'message' => 'Не удалось сохранить заявку. Попробуйте позже.'], 500);
}

// Город экранируем на случай, если список когда-то станет свободным полем
$line = sprintf(
    "[%s] | Имя: %s | Телефон: %s | Город: %s\n",
    date('Y-m-d H:i:s'),
    $name,
    $phone,
    htmlspecialchars($city, ENT_QUOTES, 'UTF-8')
);

// LOCK_EX защищает файл от порчи при одновременных записях
$written = file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX);

if ($written === false) {
    respond(['success' => false, 'message' => 'Не удалось сохранить заявку. Попробуйте позже.'], 500);
}

respond(['success' => true, 'message' => 'Заявка успешно отправлена']);
