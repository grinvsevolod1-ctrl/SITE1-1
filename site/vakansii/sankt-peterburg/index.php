<?php
/**
 * Статья силоса «Вакансии по городам».
 * Главная (/) → Вакансии по городам (/vakansii/) → Курьер в Санкт-Петербурге
 */

require __DIR__ . '/../../inc/config.php';
require __DIR__ . '/../../inc/nav-data.php';

$pageTitle = 'Работа курьером в Санкт-Петербурге — доход от 95 000 ₽ | ExpressLogist';
$pageDescription = 'Вакансия курьера в Санкт-Петербурге: доход от 95 000 ₽, 310 курьеров в штате, пешие, велосипедные и авто-маршруты по районам города. Официальное оформление.';
$canonical = $baseUrl . '/vakansii/sankt-peterburg/';

$breadcrumbs = [
    ['label' => 'Главная', 'url' => '/'],
    ['label' => 'Вакансии по городам', 'url' => '/vakansii/'],
    ['label' => 'Курьер в Санкт-Петербурге', 'url' => null],
];

$sidebarSection = 'vacancies';
$sidebarCurrent = '/vakansii/sankt-peterburg/';

$faq = [
    [
        'q' => 'В каких районах Петербурга есть маршруты?',
        'a' => 'Маршруты открыты в Невском, Приморском, Центральном, Выборгском, Московском и Фрунзенском районах. Менеджер подбирает зону ближе к месту проживания курьера.',
    ],
    [
        'q' => 'Как работают авто-маршруты в разводные ночи мостов?',
        'a' => 'График смен формируется с учётом расписания разводки мостов — авто-курьерам, работающим на маршрутах с пересечением Невы, заранее сообщают актуальное расписание, чтобы не терять время в пути.',
    ],
    [
        'q' => 'Платят ли надбавку за работу в историческом центре из-за пробок и пешеходных зон?',
        'a' => 'Да, маршруты в Центральном районе с плотным пешеходным трафиком и ограничениями для автотранспорта учитываются при расчёте ставки — пешая и велодоставка там оплачиваются по повышенному тарифу.',
    ],
    [
        'q' => 'Сколько времени занимает оформление в Санкт-Петербурге?',
        'a' => 'От заявки до первой смены обычно проходит 1–2 рабочих дня, как и в других крупных городах присутствия компании.',
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
                <h1 class="hero__title" style="font-size: 40px;">Работа курьером в Санкт-Петербурге</h1>
                <p class="article__lead">
                    В Санкт-Петербурге работает 310 курьеров ExpressLogist — маршруты открыты
                    в Невском, Приморском, Центральном и других районах. Доход от 95&nbsp;000&nbsp;₽
                    в месяц при сдельной оплате и полном обеспечении.
                </p>

                <div class="city-stats">
                    <div class="city-stat">
                        <div class="city-stat__value">310</div>
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
                                <td>от 95 000 ₽</td>
                                <td>Центральный, Невский — плотная пешеходная застройка</td>
                            </tr>
                            <tr>
                                <th scope="row">Велодоставка</th>
                                <td>от 102 000 ₽</td>
                                <td>Приморский, Московский — широкие проспекты, велополосы</td>
                            </tr>
                            <tr>
                                <th scope="row">Авто-маршрут</th>
                                <td>от 110 000 ₽</td>
                                <td>Выборгский, Фрунзенский — длинные маршруты, топливная карта включена</td>
                            </tr>
                        </tbody>
                    </table>

                    <h2>Районы, где работает ExpressLogist</h2>
                    <p>
                        Компания принимает заявки в Невском, Приморском, Центральном, Выборгском,
                        Московском и Фрунзенском районах. Маршрут закрепляется ближе к месту
                        проживания курьера — учитывается и разводка мостов для авто-маршрутов
                        с пересечением Невы.
                    </p>

                    <h2>Условия для курьеров в Санкт-Петербурге</h2>
                    <ul>
                        <li>Официальное оформление по трудовому договору с первого рабочего дня.</li>
                        <li>Повышенный тариф для пеших и велокурьеров в историческом центре.</li>
                        <li>Гибкий график 5/2 или 2/2 — подходит для совмещения с учёбой или другой работой.</li>
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
                        <p>Готовы начать работать курьером в Санкт-Петербурге?</p>
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
