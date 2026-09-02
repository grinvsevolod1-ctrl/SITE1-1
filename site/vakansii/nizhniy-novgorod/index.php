<?php
/**
 * Статья силоса «Вакансии по городам».
 * Главная (/) → Вакансии по городам (/vakansii/) → Курьер в Нижнем Новгороде
 */

require __DIR__ . '/../../inc/config.php';
require __DIR__ . '/../../inc/nav-data.php';

$pageTitle = 'Работа курьером в Нижнем Новгороде — доход от 85 000 ₽ | ExpressLogist';
$pageDescription = 'Вакансия курьера в Нижнем Новгороде: доход от 85 000 ₽, 160 курьеров в штате, пешие и авто-маршруты на обоих берегах Оки. Официальное оформление.';
$canonical = $baseUrl . '/vakansii/nizhniy-novgorod/';

$breadcrumbs = [
    ['label' => 'Главная', 'url' => '/'],
    ['label' => 'Вакансии по городам', 'url' => '/vakansii/'],
    ['label' => 'Курьер в Нижнем Новгороде', 'url' => null],
];

$sidebarSection = 'vacancies';
$sidebarCurrent = '/vakansii/nizhniy-novgorod/';

$faq = [
    [
        'q' => 'Есть ли маршруты в Автозаводском районе?',
        'a' => 'Да, Автозаводский район — один из крупнейших по числу заказов благодаря высокой плотности населения. Маршруты там доступны как пешие, так и авто.',
    ],
    [
        'q' => 'Учитывается ли рельеф города при расчёте пеших маршрутов?',
        'a' => 'Да, верхняя и нижняя части города (например, съезды к Оке и Волге) учитываются при формировании зон — маршрут подбирается так, чтобы перепады высот не увеличивали время доставки сверх нормы.',
    ],
    [
        'q' => 'Сколько времени занимает оформление в Нижнем Новгороде?',
        'a' => 'От заявки до первой смены обычно проходит 1–2 рабочих дня, как и в других городах присутствия компании.',
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
                <h1 class="hero__title" style="font-size: 40px;">Работа курьером в Нижнем Новгороде</h1>
                <p class="article__lead">
                    В Нижнем Новгороде работает 160 курьеров ExpressLogist на обоих берегах Оки.
                    Доход от 85&nbsp;000&nbsp;₽ в месяц, пешие и авто-маршруты по всему городу.
                </p>

                <div class="city-stats">
                    <div class="city-stat">
                        <div class="city-stat__value">160</div>
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
                                <td>Нижегородский, Советский районы — верхняя часть города</td>
                            </tr>
                            <tr>
                                <th scope="row">Авто-маршрут</th>
                                <td>от 95 000 ₽</td>
                                <td>Автозаводский, Ленинский — нижняя часть, длинные перегоны</td>
                            </tr>
                        </tbody>
                    </table>

                    <h2>Районы, где работает ExpressLogist</h2>
                    <p>
                        Маршруты открыты в Нижегородском, Советском, Автозаводском и Ленинском
                        районах. При подборе зоны учитывается рельеф города — перепады высот между
                        верхней и нижней частью не увеличивают нагрузку сверх нормы.
                    </p>

                    <h2>Условия для курьеров в Нижнем Новгороде</h2>
                    <ul>
                        <li>Официальное оформление по трудовому договору с первого рабочего дня.</li>
                        <li>Маршруты подбираются с учётом рельефа и близости к дому курьера.</li>
                        <li>Гибкий график 5/2 или 2/2 для совмещения с учёбой или другой работой.</li>
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
                        <p>Готовы начать работать курьером в Нижнем Новгороде?</p>
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
