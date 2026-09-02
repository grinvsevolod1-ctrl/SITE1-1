<?php
/**
 * Статья силоса «Вакансии по городам».
 * Главная (/) → Вакансии по городам (/vakansii/) → Курьер в Новосибирске
 */

require __DIR__ . '/../../inc/config.php';
require __DIR__ . '/../../inc/nav-data.php';

$pageTitle = 'Работа курьером в Новосибирске — доход от 88 000 ₽ | ExpressLogist';
$pageDescription = 'Вакансия курьера в Новосибирске: доход от 88 000 ₽, 190 курьеров в штате, пешие и авто-маршруты на обоих берегах Оби. Официальное оформление.';
$canonical = $baseUrl . '/vakansii/novosibirsk/';

$breadcrumbs = [
    ['label' => 'Главная', 'url' => '/'],
    ['label' => 'Вакансии по городам', 'url' => '/vakansii/'],
    ['label' => 'Курьер в Новосибирске', 'url' => null],
];

$sidebarSection = 'vacancies';
$sidebarCurrent = '/vakansii/novosibirsk/';

$faq = [
    [
        'q' => 'Есть ли маршруты на левом берегу Оби?',
        'a' => 'Да, компания работает и в Ленинском, Кировском, Октябрьском районах на левом берегу, и в Центральном, Заельцовском, Дзержинском — на правом. Менеджер закрепляет маршрут ближе к месту проживания.',
    ],
    [
        'q' => 'Как организована работа курьеров зимой?',
        'a' => 'В зимний сезон авто-маршруты становятся приоритетным вариантом для длинных перегонов — компания выдаёт зимнюю форму, а маршруты пересматриваются с учётом погодных условий и состояния дорог.',
    ],
    [
        'q' => 'Можно ли начать работать студентам НГУ и других вузов?',
        'a' => 'Да, график 2/2 или несколько смен в неделю по договорённости с менеджером — удобный формат для совмещения с учёбой в вузах города.',
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
                <h1 class="hero__title" style="font-size: 40px;">Работа курьером в Новосибирске</h1>
                <p class="article__lead">
                    В Новосибирске работает 190 курьеров ExpressLogist на обоих берегах Оби.
                    Доход от 88&nbsp;000&nbsp;₽ в месяц, пешие и авто-маршруты, зимняя форма
                    предоставляется компанией.
                </p>

                <div class="city-stats">
                    <div class="city-stat">
                        <div class="city-stat__value">190</div>
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
                                <td>от 88 000 ₽</td>
                                <td>Центральный, Заельцовский — плотная застройка правого берега</td>
                            </tr>
                            <tr>
                                <th scope="row">Авто-маршрут</th>
                                <td>от 98 000 ₽</td>
                                <td>Ленинский, Кировский, Октябрьский — левый берег, длинные перегоны</td>
                            </tr>
                        </tbody>
                    </table>

                    <h2>Районы, где работает ExpressLogist</h2>
                    <p>
                        Маршруты открыты в Ленинском, Кировском, Октябрьском районах левобережья
                        и в Центральном, Заельцовском, Дзержинском районах правого берега. Менеджер
                        закрепляет маршрут ближе к дому, чтобы сократить время в пути между сменами.
                    </p>

                    <h2>Условия для курьеров в Новосибирске</h2>
                    <ul>
                        <li>Официальное оформление по трудовому договору с первого рабочего дня.</li>
                        <li>Зимняя форма и утеплённая экипировка предоставляются бесплатно.</li>
                        <li>Гибкий график, подходящий для совмещения с учёбой в вузах города.</li>
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
                        <p>Готовы начать работать курьером в Новосибирске?</p>
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
