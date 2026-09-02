<?php
/**
 * Статья силоса «Вакансии по городам».
 * Главная (/) → Вакансии по городам (/vakansii/) → Курьер в Краснодаре
 */

require __DIR__ . '/../../inc/config.php';
require __DIR__ . '/../../inc/nav-data.php';

$pageTitle = 'Работа курьером в Краснодаре — доход от 88 000 ₽ | ExpressLogist';
$pageDescription = 'Вакансия курьера в Краснодаре: доход от 88 000 ₽, 170 курьеров в штате, пешие, велосипедные и авто-маршруты по районам растущего города. Официальное оформление.';
$canonical = $baseUrl . '/vakansii/krasnodar/';

$breadcrumbs = [
    ['label' => 'Главная', 'url' => '/'],
    ['label' => 'Вакансии по городам', 'url' => '/vakansii/'],
    ['label' => 'Курьер в Краснодаре', 'url' => null],
];

$sidebarSection = 'vacancies';
$sidebarCurrent = '/vakansii/krasnodar/';

$faq = [
    [
        'q' => 'В каких районах Краснодара есть маршруты?',
        'a' => 'Маршруты открыты в Центральном, Прикубанском, Западном и Карасунском округах. Прикубанский округ — один из самых быстрорастущих по числу новых жилых комплексов и заказов.',
    ],
    [
        'q' => 'Актуальны ли велосипедные маршруты летом при высокой температуре?',
        'a' => 'Да, но график смен для велокурьеров летом смещается на более прохладные часы — раннее утро и вечер, чтобы работа была комфортной.',
    ],
    [
        'q' => 'Растёт ли количество вакансий в Краснодаре?',
        'a' => 'Да, из-за активного строительства новых жилых районов спрос на курьеров в Прикубанском и Западном округах увеличивается каждый сезон — компания регулярно открывает дополнительные маршруты.',
    ],
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

    <meta property="og:type" content="article">
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

    <script type="application/ld+json">
    <?php echo json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => array_map(static function (array $item): array {
            return [
                '@type' => 'Question',
                'name' => $item['q'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item['a']],
            ];
        }, $faq),
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>
    </script>
</head>
<body>

<?php $isHome = false; include __DIR__ . '/../../inc/header.php'; ?>

<?php include __DIR__ . '/../../inc/breadcrumbs.php'; ?>

<main>
    <section class="article section">
        <div class="container layout">
            <div>
                <h1 class="hero__title" style="font-size: 40px;">Работа курьером в Краснодаре</h1>
                <p class="article__lead">
                    В Краснодаре работает 170 курьеров ExpressLogist — быстрорастущем городе
                    с активной застройкой. Доход от 88&nbsp;000&nbsp;₽ в месяц, пешие,
                    велосипедные и авто-маршруты в четырёх округах.
                </p>

                <div class="city-stats">
                    <div class="city-stat">
                        <div class="city-stat__value">170</div>
                        <div class="city-stat__label">Курьеров в штате</div>
                    </div>
                    <div class="city-stat">
                        <div class="city-stat__value">3</div>
                        <div class="city-stat__label">Типа маршрутов</div>
                    </div>
                    <div class="city-stat">
                        <div class="city-stat__value">1–2 дня</div>
                        <div class="city-stat__label">До первой смены</div>
                    </div>
                </div>

                <div class="article__body">
                    <h2>Доход по типам маршрутов</h2>
                    <table class="compare-table">
                        <thead>
                            <tr>
                                <th scope="col">Тип маршрута</th>
                                <th scope="col">Доход в месяц</th>
                                <th scope="col">Где работает</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">Пешая доставка</th>
                                <td>от 88 000 ₽</td>
                                <td>Центральный округ — плотная застройка</td>
                            </tr>
                            <tr>
                                <th scope="row">Велодоставка</th>
                                <td>от 95 000 ₽</td>
                                <td>Карасунский округ — парковые зоны, удобные велополосы</td>
                            </tr>
                            <tr>
                                <th scope="row">Авто-маршрут</th>
                                <td>от 102 000 ₽</td>
                                <td>Прикубанский, Западный — новые жилые районы, длинные перегоны</td>
                            </tr>
                        </tbody>
                    </table>

                    <h2>Округа, где работает ExpressLogist</h2>
                    <p>
                        Маршруты открыты в Центральном, Прикубанском, Западном и Карасунском
                        округах Краснодара. Прикубанский округ растёт особенно быстро благодаря
                        новым жилым комплексам — компания регулярно открывает там дополнительные
                        маршруты.
                    </p>

                    <h2>Условия для курьеров в Краснодаре</h2>
                    <ul>
                        <li>Официальное оформление по трудовому договору с первого рабочего дня.</li>
                        <li>Летний график для велокурьеров смещается на прохладные часы дня.</li>
                        <li>Гибкий график 5/2 или 2/2 — можно совмещать с учёбой или другой работой.</li>
                        <li>Выплаты два раза в месяц на карту любого банка.</li>
                    </ul>

                    <h2>Частые вопросы</h2>
                    <div class="faq">
                        <?php foreach ($faq as $item): ?>
                        <details class="faq__item">
                            <summary><?php echo htmlspecialchars($item['q'], ENT_QUOTES, 'UTF-8'); ?></summary>
                            <p><?php echo htmlspecialchars($item['a'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </details>
                        <?php endforeach; ?>
                    </div>

                    <div class="article__cta">
                        <p>Готовы начать работать курьером в Краснодаре?</p>
                        <a href="/#form" class="btn btn--accent">Оставить заявку</a>
                    </div>
                </div>
            </div>

            <?php include __DIR__ . '/../../inc/sidebar.php'; ?>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../../inc/footer.php'; ?>
</body>
</html>
