<?php
/**
 * Рендер страницы направления (одна страна).
 *
 * Перед подключением задайте только:
 *   $countrySlug (string) — ключ страны из $countries (inc/countries-data.php)
 *
 * Файл сам подтягивает config, nav-data, countries-data, собирает мета-теги,
 * хлебные крошки, hero и блоки контента, после чего выводит через content-page.php.
 * Благодаря этому каждая из 9 стран — это тонкий файл в 3 строки.
 */

require __DIR__ . '/config.php';
require __DIR__ . '/nav-data.php';
require __DIR__ . '/countries-data.php';

$countrySlug = $countrySlug ?? '';

// Если страна не найдена — 404
if (!isset($countries[$countrySlug])) {
    http_response_code(404);
    $pageTitle = 'Направление не найдено';
    $pageDescription = 'Запрошенное направление не найдено.';
    $pageUrl = '/napravleniya/';
    $assetsPrefix = '../../';
    require __DIR__ . '/head.php';
    require __DIR__ . '/header.php';
    echo '<main id="main"><section class="section"><div class="container center"><h1 class="section__title">Направление не найдено</h1><p class="section__subtitle">Вернитесь к <a href="/napravleniya/">списку направлений</a>.</p></div></section></main>';
    require __DIR__ . '/footer.php';
    return;
}

$c = $countries[$countrySlug];

$pageTitle       = 'Доставка грузов в ' . $c['name'] . ' — перевозки для бизнеса — ' . $siteName;
$pageDescription = 'Грузовые перевозки в ' . $c['name'] . ' для бизнеса: сборные грузы и отдельные машины, сроки ' . $c['term'] . ', доставка в ' . $c['capital'] . ' и регионы. ' . $c['customs'] . '.';
$pageUrl         = '/napravleniya/' . $countrySlug . '/';
$assetsPrefix    = '../../';
$navActive       = 'directions';

$sidebarSection = 'directions';
$sidebarCurrent = $pageUrl;

$crumbs = [
    ['title' => 'Главная', 'url' => '/'],
    ['title' => 'Направления по СНГ', 'url' => '/napravleniya/'],
    ['title' => 'Доставка в ' . $c['name'], 'url' => null],
];

$hero = [
    'h1'   => 'Доставка грузов в ' . $c['name'],
    'lead' => $c['intro'],
];

$blocks = [
    ['type' => 'lead', 'text' => 'Организуем перевозку в ' . $c['name'] . ' под ключ: подбор транспорта, документы, ' . mb_strtolower($c['customs']) . '. Основной хаб — ' . $c['capital'] . '.'],

    ['type' => 'h2', 'text' => 'Города доставки'],
    ['type' => 'p', 'text' => 'Доставляем в столицу и крупные города страны, а также в регионы по согласованию:'],
    ['type' => 'list', 'items' => array_merge([$c['capital'] . ' (основной хаб)'], $c['cities'])],

    ['type' => 'h2', 'text' => 'Условия перевозки'],
    ['type' => 'table', 'head' => ['Параметр', 'Значение'],
        'rows' => [
            ['Направление', 'Россия → ' . $c['nom']],
            ['Срок доставки', $c['term']],
            ['Таможня', $c['customs']],
            ['Типы перевозки', 'Сборные грузы (LTL) и отдельные машины (FTL)'],
        ]],

    ['type' => 'h2', 'text' => 'Что мы берём на себя'],
    ['type' => 'list', 'items' => [
        'Подбор оптимального транспорта под груз и маршрут',
        'Забор груза у отправителя и доставка до двери',
        'Оформление перевозочных и таможенных документов',
        'Страхование груза на полную стоимость',
        'Отслеживание и поддержку персонального менеджера',
    ]],

    ['type' => 'h2', 'text' => 'Какие грузы возим в ' . $c['name']],
    ['type' => 'list', 'items' => [
        'Крупногабаритные грузы и промышленное оборудование',
        'Сборные партии от 1 кг',
        'Товары для ритейла и маркетплейсов',
        'Строительные материалы и спецтехнику',
    ]],

    ['type' => 'faq', 'items' => [
        ['q' => 'За сколько дней доставите груз в ' . $c['name'] . '?', 'a' => 'Типовой срок доставки — ' . $c['term'] . ' в зависимости от города и типа перевозки. Точный срок назовём при расчёте.'],
        ['q' => 'Кто занимается таможней?', 'a' => $c['customs'] . '. Все процедуры и документы мы берём на себя.'],
        ['q' => 'Можно ли отправить небольшой груз?', 'a' => 'Да, на этом направлении работают сборные рейсы — принимаем груз от 1 кг.'],
    ]],

    ['type' => 'cta', 'title' => 'Рассчитать доставку в ' . $c['name'], 'text' => 'Укажите груз и город — пришлём стоимость и срок по этому направлению.'],
];

// Перелинковка: несколько соседних стран + хаб услуг
$related = [];
foreach ($countries as $slug => $c) {
    if ($slug === $currentSlug) { continue; }
    $related[] = [
        'url'   => '/napravleniya/' . $slug . '/',
        'title' => 'Доставка в ' . $c['name'],
        'desc'  => !empty($c['capital']) ? ('Маршруты и сроки · ' . $c['capital']) : 'Маршруты и сроки доставки',
    ];
    if (count($related) >= 3) { break; }
}
$related[] = ['url' => '/uslugi/', 'title' => 'Все услуги', 'desc' => 'Крупногабарит, сборные, FTL, склад'];

require __DIR__ . '/content-page.php';
