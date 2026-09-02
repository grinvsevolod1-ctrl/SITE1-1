<?php
/**
 * Статья силоса «Вакансии по городам».
 * Главная (/) → Вакансии по городам (/vakansii/) → Курьер в Ростове-на-Дону
 */

require __DIR__ . '/../../inc/config.php';
require __DIR__ . '/../../inc/nav-data.php';

$pageTitle = 'Работа курьером в Ростове-на-Дону — доход от 85 000 ₽ | ExpressLogist';
$pageDescription = 'Вакансия курьера в Ростове-на-Дону: доход от 85 000 ₽, 150 курьеров в штате, пешие и авто-маршруты по районам города. Официальное оформление.';
$canonical = $baseUrl . '/vakansii/rostov-na-donu/';

$breadcrumbs = [
    ['label' => 'Главная', 'url' => '/'],
    ['label' => 'Вакансии по городам', 'url' => '/vakansii/'],
    ['label' => 'Курьер в Ростове-на-Дону', 'url' => null],
];

$sidebarSection = 'vacancies';
$sidebarCurrent = '/vakansii/rostov-na-donu/';

$faq = [
    [
        'q' => 'В каких районах Ростова-на-Дону есть маршруты?',
        'a' => 'Маршруты открыты в Кировском, Первомайском, Ленинском и Пролетарском районах. Менеджер подбирает зону ближе к месту проживания курьера.',
    ],
    [
        'q' => 'Как влияет летняя жара на график смен?',
        'a' => 'В самые жаркие летние месяцы часть смен смещается на утренние и вечерние часы — компания следит за комфортными условиями работы и обеспечивает курьеров водой на маршруте.',
    ],
    [
        'q' => 'Можно ли подработать курьером на несколько часов в день?',
        'a' => 'Да, в дополнение к сменам 5/2 и 2/2 доступны частичные подработки — уточните формат у регионального менеджера при звонке.',
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
                <h1 class="hero__title" style="font-size: 40px;">Работа курьером в Ростове-на-Дону</h1>
                <p class="article__lead">
                    В Ростове-на-Дону работает 150 курьеров ExpressLogist. Доход от 85&nbsp;000&nbsp;₽
                    в месяц, пешие и авто-маршруты по всем районам города.
                </p>

                <div class="city-stats">
                    <div class="city-stat">
                        <div class="city-stat__value">150</div>
                        <div class="city-stat__label">Курьеров в штате</div>
                    </div>
                    <div class="city-stat">
                        <div class="city-stat__value">2</div>
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
                                <td>от 85 000 ₽</td>
                                <td>Кировский, Ленинский — центральные районы</td>
                            </tr>
                            <tr>
                                <th scope="row">Авто-маршрут</th>
                                <td>от 95 000 ₽</td>
                                <td>Первомайский, Пролетарский — длинные перегоны</td>
                            </tr>
                        </tbody>
                    </table>

                    <h2>Районы, где работает ExpressLogist</h2>
                    <p>
                        Маршруты открыты в Кировском, Первомайском, Ленинском и Пролетарском
                        районах. В летние месяцы часть смен смещается на утро и вечер, чтобы
                        снизить нагрузку в самые жаркие часы дня.
                    </p>

                    <h2>Условия для курьеров в Ростове-на-Дону</h2>
                    <ul>
                        <li>Официальное оформление по трудовому договору с первого рабочего дня.</li>
                        <li>Гибкий график, включая частичные подработки на несколько часов в день.</li>
                        <li>Летняя корректировка смен и обеспечение водой на маршруте.</li>
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
                        <p>Готовы начать работать курьером в Ростове-на-Дону?</p>
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
