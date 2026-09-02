<?php
/**
 * Статья силоса «Вакансии по городам».
 * Главная (/) → Вакансии по городам (/vakansii/) → Курьер в Москве
 */

require __DIR__ . '/../../inc/config.php';
require __DIR__ . '/../../inc/nav-data.php';

$pageTitle = 'Работа курьером в Москве — доход от 100 000 ₽ | ExpressLogist';
$pageDescription = 'Вакансия курьера в Москве: доход от 100 000 ₽, 420 курьеров в штате, пешие, велосипедные и авто-маршруты по всем округам. Официальное оформление.';
$canonical = $baseUrl . '/vakansii/moskva/';

$breadcrumbs = [
    ['label' => 'Главная', 'url' => '/'],
    ['label' => 'Вакансии по городам', 'url' => '/vakansii/'],
    ['label' => 'Курьер в Москве', 'url' => null],
];

$sidebarSection = 'vacancies';
$sidebarCurrent = '/vakansii/moskva/';

$faq = [
    [
        'q' => 'В каких округах Москвы есть маршруты?',
        'a' => 'Маршруты открыты во всех округах — ЦАО, САО, СВАО, ВАО, ЮВАО, ЮАО, ЮЗАО, ЗАО, СЗАО и в Новой Москве. Конкретную зону подбирает региональный менеджер по адресу проживания, чтобы дорога до маршрута занимала минимум времени.',
    ],
    [
        'q' => 'Учитывается ли пробки при расчёте авто-маршрутов в Москве?',
        'a' => 'Да, зоны для авто-курьеров формируются с учётом транспортной ситуации — маршрут строится так, чтобы количество доставок за смену оставалось стабильным даже в час пик.',
    ],
    [
        'q' => 'Можно ли работать курьером в Москве без регистрации по месту жительства в городе?',
        'a' => 'Да, для трудового договора достаточно паспорта с любой актуальной регистрацией — прописка в Москве не обязательна.',
    ],
    [
        'q' => 'Сколько времени занимает оформление в Москве?',
        'a' => 'От заявки до первой смены в среднем 1–2 рабочих дня — в Москве работает несколько отделений, поэтому собеседование обычно назначают на следующий день после звонка менеджера.',
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
                <h1 class="hero__title" style="font-size: 40px;">Работа курьером в Москве</h1>
                <p class="article__lead">
                    Москва — крупнейший регион присутствия ExpressLogist: 420 курьеров в штате
                    и маршруты во всех округах города и в Новой Москве. Доход от 100&nbsp;000&nbsp;₽
                    в месяц при сдельной оплате и полном обеспечении со стороны компании.
                </p>

                <div class="city-stats">
                    <div class="city-stat">
                        <div class="city-stat__value">420</div>
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
                                <td>от 100 000 ₽</td>
                                <td>ЦАО, ЮВАО и другие плотнозаселённые округа</td>
                            </tr>
                            <tr>
                                <th scope="row">Велодоставка</th>
                                <td>от 108 000 ₽</td>
                                <td>Округа с плотной застройкой и короткими перегонами</td>
                            </tr>
                            <tr>
                                <th scope="row">Авто-маршрут</th>
                                <td>от 115 000 ₽</td>
                                <td>СВАО, ЗАО, Новая Москва — длинные маршруты, топливная карта включена</td>
                            </tr>
                        </tbody>
                    </table>

                    <h2>Округа, где работает ExpressLogist</h2>
                    <p>
                        Компания принимает заявки во всех округах Москвы — ЦАО, САО, СВАО, ВАО,
                        ЮВАО, ЮАО, ЮЗАО, ЗАО, СЗАО и в Новой Москве. Региональный менеджер закрепляет
                        маршрут ближе к месту проживания курьера, чтобы минимизировать время на дорогу
                        до начала смены.
                    </p>

                    <h2>Условия для курьеров в Москве</h2>
                    <ul>
                        <li>Официальное оформление по трудовому договору с первого рабочего дня.</li>
                        <li>Гибкий график 5/2 или 2/2 — можно совмещать с учёбой в одном из вузов города.</li>
                        <li>Топливная карта для авто-маршрутов — расходы на бензин не на стороне курьера.</li>
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
                        <p>Готовы начать работать курьером в Москве?</p>
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
