<?php
/**
 * Статья силоса «Вакансии по городам».
 * Главная (/) → Вакансии по городам (/vakansii/) → Курьер в Казани
 */

require __DIR__ . '/../../inc/config.php';
require __DIR__ . '/../../inc/nav-data.php';

$pageTitle = 'Работа курьером в Казани — доход от 88 000 ₽ | ExpressLogist';
$pageDescription = 'Вакансия курьера в Казани: доход от 88 000 ₽, 180 курьеров в штате, пешие, велосипедные и авто-маршруты по районам города. Официальное оформление.';
$canonical = $baseUrl . '/vakansii/kazan/';

$breadcrumbs = [
    ['label' => 'Главная', 'url' => '/'],
    ['label' => 'Вакансии по городам', 'url' => '/vakansii/'],
    ['label' => 'Курьер в Казани', 'url' => null],
];

$sidebarSection = 'vacancies';
$sidebarCurrent = '/vakansii/kazan/';

$faq = [
    [
        'q' => 'В каких районах Казани есть маршруты?',
        'a' => 'Маршруты работают в Вахитовском, Советском, Приволжском и Ново-Савиновском районах. Зону подбирает региональный менеджер ближе к месту проживания курьера.',
    ],
    [
        'q' => 'Нужно ли знание татарского языка для работы курьером?',
        'a' => 'Нет, инструкции и приложение для маршрутов на русском языке — знание татарского не требуется, хотя приветствуется при общении с клиентами.',
    ],
    [
        'q' => 'Оформляют ли иностранных студентов, обучающихся в казанских вузах?',
        'a' => 'Да, при наличии патента или разрешения на работу — полный список документов на странице «Какие документы нужны для оформления».',
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
                <h1 class="hero__title" style="font-size: 40px;">Работа курьером в Казани</h1>
                <p class="article__lead">
                    В Казани работает 180 курьеров ExpressLogist. Доход от 88&nbsp;000&nbsp;₽
                    в месяц, пешие, велосипедные и авто-маршруты в четырёх районах города.
                </p>

                <div class="city-stats">
                    <div class="city-stat">
                        <div class="city-stat__value">180</div>
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
                                <td>Вахитовский — исторический центр и плотная застройка</td>
                            </tr>
                            <tr>
                                <th scope="row">Велодоставка</th>
                                <td>от 94 000 ₽</td>
                                <td>Советский — широкие проспекты и парковые зоны</td>
                            </tr>
                            <tr>
                                <th scope="row">Авто-маршрут</th>
                                <td>от 100 000 ₽</td>
                                <td>Приволжский, Ново-Савиновский — длинные перегоны</td>
                            </tr>
                        </tbody>
                    </table>

                    <h2>Районы, где работает ExpressLogist</h2>
                    <p>
                        Маршруты открыты в Вахитовском, Советском, Приволжском и Ново-Савиновском
                        районах Казани. Инструкции и рабочее приложение — на русском языке,
                        знание татарского не требуется.
                    </p>

                    <h2>Условия для курьеров в Казани</h2>
                    <ul>
                        <li>Официальное оформление по трудовому договору с первого рабочего дня.</li>
                        <li>Оформление студентов и иностранных граждан при наличии патента.</li>
                        <li>Гибкий график 5/2 или 2/2 — подходит для совмещения с учёбой в вузах города.</li>
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
                        <p>Готовы начать работать курьером в Казани?</p>
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
