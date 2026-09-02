<?php
/**
 * Хаб силоса «Вакансии по городам».
 * Главная (/) → Вакансии по городам (/vakansii/)
 */

require __DIR__ . '/../inc/config.php';
require __DIR__ . '/../inc/nav-data.php';

$pageTitle = 'Вакансии курьера по городам — ExpressLogist';
$pageDescription = 'Работа курьером в 8 крупных городах России: доход, количество курьеров в штате и типы маршрутов в Москве, Санкт-Петербурге, Новосибирске и других городах.';
$canonical = $baseUrl . '/vakansii/';

$breadcrumbs = [
    ['label' => 'Главная', 'url' => '/'],
    ['label' => 'Вакансии по городам', 'url' => null],
];

$sidebarSection = 'vacancies';
$sidebarCurrent = '/vakansii/';

$cityCards = [
    ['title' => 'Москва', 'rate' => 'от 100 000 ₽', 'meta' => '420 курьеров в штате', 'url' => '/vakansii/moskva/'],
    ['title' => 'Санкт-Петербург', 'rate' => 'от 95 000 ₽', 'meta' => '310 курьеров в штате', 'url' => '/vakansii/sankt-peterburg/'],
    ['title' => 'Новосибирск', 'rate' => 'от 88 000 ₽', 'meta' => '190 курьеров в штате', 'url' => '/vakansii/novosibirsk/'],
    ['title' => 'Екатеринбург', 'rate' => 'от 90 000 ₽', 'meta' => '210 курьеров в штате', 'url' => '/vakansii/ekaterinburg/'],
    ['title' => 'Казань', 'rate' => 'от 88 000 ₽', 'meta' => '180 курьеров в штате', 'url' => '/vakansii/kazan/'],
    ['title' => 'Нижний Новгород', 'rate' => 'от 85 000 ₽', 'meta' => '160 курьеров в штате', 'url' => '/vakansii/nizhniy-novgorod/'],
    ['title' => 'Ростов-на-Дону', 'rate' => 'от 85 000 ₽', 'meta' => '150 курьеров в штате', 'url' => '/vakansii/rostov-na-donu/'],
    ['title' => 'Краснодар', 'rate' => 'от 88 000 ₽', 'meta' => '170 курьеров в штате', 'url' => '/vakansii/krasnodar/'],
];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="theme-color" content="#1A73E8">
    <link rel="canonical" href="<?php echo htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8'); ?>">

    <meta property="og:type" content="website">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:site_name" content="ExpressLogist">
    <meta property="og:title" content="<?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:image" content="<?php echo htmlspecialchars($baseUrl, ENT_QUOTES, 'UTF-8'); ?>/img/hero-courier.webp">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<?php $isHome = false; include __DIR__ . '/../inc/header.php'; ?>

<?php include __DIR__ . '/../inc/breadcrumbs.php'; ?>

<main>
    <section class="article section">
        <div class="container layout">
            <div>
                <h1 class="hero__title" style="font-size: 40px;">Вакансии курьера по городам</h1>
                <p class="article__lead">
                    ExpressLogist набирает курьеров в 150+ городах России, а на этих страницах —
                    подробности по 8 крупнейшим: доход, количество курьеров в штате и доступные
                    типы маршрутов. Если вашего города нет в списке, оставьте заявку на главной —
                    менеджер уточнит условия для вашего региона.
                </p>

                <div class="city-grid">
                    <?php foreach ($cityCards as $city): ?>
                    <a href="<?php echo htmlspecialchars($city['url'], ENT_QUOTES, 'UTF-8'); ?>" class="city-card">
                        <p class="city-card__name"><?php echo htmlspecialchars($city['title'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p class="city-card__rate"><?php echo htmlspecialchars($city['rate'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p class="city-card__meta"><?php echo htmlspecialchars($city['meta'], ENT_QUOTES, 'UTF-8'); ?></p>
                    </a>
                    <?php endforeach; ?>
                </div>

                <div class="article__cta">
                    <p>Не нашли свой город в списке?</p>
                    <a href="/#form" class="btn btn--accent">Оставить заявку</a>
                </div>
            </div>

            <?php include __DIR__ . '/../inc/sidebar.php'; ?>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../inc/footer.php'; ?>
</body>
</html>
