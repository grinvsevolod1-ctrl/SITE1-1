<?php
/**
 * Статья силоса «База знаний для соискателей».
 * Главная (/) → База знаний (/baza-znaniy/) → График 2/2 и 5/2
 */

require __DIR__ . '/../../inc/config.php';
require __DIR__ . '/../../inc/nav-data.php';

$pageTitle = 'График 2/2 и 5/2 для курьера: как выбрать — ExpressLogist';
$pageDescription = 'Сравнение графиков 2/2 и 5/2 для курьера: плюсы, минусы, кому подходит каждый вариант и можно ли поменять график после оформления.';
$canonical = $baseUrl . '/baza-znaniy/grafik-2-2-i-5-2/';

$breadcrumbs = [
    ['label' => 'Главная', 'url' => '/'],
    ['label' => 'База знаний для соискателей', 'url' => '/baza-znaniy/'],
    ['label' => 'График 2/2 и 5/2', 'url' => null],
];

$sidebarSection = 'knowledge';
$sidebarCurrent = '/baza-znaniy/grafik-2-2-i-5-2/';

$faq = [
    [
        'q' => 'Можно ли поменять график после того, как уже начал работать?',
        'a' => 'Да, по согласованию с региональным менеджером — обычно переход возможен с начала следующего месяца, чтобы не нарушать текущее расписание маршрутов.',
    ],
    [
        'q' => 'Какой график выбирают чаще?',
        'a' => 'Оба варианта популярны примерно одинаково — выбор зависит от личных обстоятельств: 5/2 чаще выбирают те, у кого есть другие дела по будням, 2/2 — кто хочет больше свободных дней подряд.',
    ],
    [
        'q' => 'Есть ли ночные смены?',
        'a' => 'В большинстве городов курьерская доставка работает в дневное и вечернее время. Ночные маршруты — редкость и обсуждаются отдельно с менеджером при наличии такой потребности у клиентов в регионе.',
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
                <h1 class="hero__title" style="font-size: 40px;">График 2/2 и 5/2: как выбрать</h1>
                <p class="article__lead">
                    Оба графика доступны в большинстве городов присутствия. Сравниваем, кому какой
                    вариант подходит лучше.
                </p>

                <div class="article__body">
                    <h2>Сравнение графиков</h2>
                    <table class="compare-table">
                        <thead>
                            <tr>
                                <th scope="col">Параметр</th>
                                <th scope="col">График 5/2</th>
                                <th scope="col">График 2/2</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">Рабочих дней в неделю</th>
                                <td>5, по будням</td>
                                <td>Через день, включая выходные</td>
                            </tr>
                            <tr>
                                <th scope="row">Стабильность дохода</th>
                                <td>Равномерная нагрузка по неделям</td>
                                <td>Выше пиковая нагрузка в рабочие дни</td>
                            </tr>
                            <tr>
                                <th scope="row">Свободное время</th>
                                <td>Выходные всегда сб/вс</td>
                                <td>Больше подряд идущих дней отдыха</td>
                            </tr>
                            <tr>
                                <th scope="row">Кому подходит</th>
                                <td>Тем, у кого есть дела по будням вечером</td>
                                <td>Тем, кто хочет совмещать с учёбой или другой работой</td>
                            </tr>
                        </tbody>
                    </table>

                    <h2>Плюсы и минусы 5/2</h2>
                    <ul>
                        <li><strong>Плюс:</strong> предсказуемое расписание, выходные всегда совпадают с календарными.</li>
                        <li><strong>Плюс:</strong> равномерная нагрузка без длинных рабочих отрезков подряд.</li>
                        <li><strong>Минус:</strong> меньше гибкости, если нужно освободить будний день.</li>
                    </ul>

                    <h2>Плюсы и минусы 2/2</h2>
                    <ul>
                        <li><strong>Плюс:</strong> больше свободных дней подряд — удобно для поездок или учёбы.</li>
                        <li><strong>Плюс:</strong> легче совмещать с подработкой в свободные дни.</li>
                        <li><strong>Минус:</strong> рабочие дни выпадают и на выходные, включая праздники.</li>
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
                        <p>Скажите менеджеру, какой график вам удобен, при заявке.</p>
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
