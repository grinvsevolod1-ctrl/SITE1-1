<?php
/**
 * Статья силоса «О компании и условия работы».
 * Главная (/) → О компании и условия работы (/o-kompanii/) → Оформление и соцгарантии
 */

require __DIR__ . '/../../inc/config.php';
require __DIR__ . '/../../inc/nav-data.php';

$pageTitle = 'Оформление курьера и социальные гарантии — ExpressLogist';
$pageDescription = 'Как проходит оформление курьера в ExpressLogist: список документов, договор, испытательный срок, больничные, отпуск и страхование. Разбор по шагам.';
$canonical = $baseUrl . '/o-kompanii/oformlenie-i-socgarantii/';

$breadcrumbs = [
    ['label' => 'Главная', 'url' => '/'],
    ['label' => 'О компании и условия работы', 'url' => '/o-kompanii/'],
    ['label' => 'Оформление и социальные гарантии', 'url' => null],
];

$sidebarSection = 'company';
$sidebarCurrent = '/o-kompanii/oformlenie-i-socgarantii/';

$faq = [
    [
        'q' => 'Оформляют ли по трудовой книжке или только по договору ГПХ?',
        'a' => 'По трудовому договору (ТК РФ) с первого дня. Запись в электронную трудовую книжку и отчисления в ПФР и ФСС начинаются с даты выхода на смену — договор ГПХ не используется.',
    ],
    [
        'q' => 'Есть ли испытательный срок и что будет, если он не пройден?',
        'a' => 'Испытательный срок — до 3 месяцев, зарплата на этот период не отличается от обычной ставки. Если маршрут или график не подошёл, менеджер предложит другой вариант до окончания срока — расстаться по инициативе компании без объяснения причин нельзя, всё оформляется по ТК РФ.',
    ],
    [
        'q' => 'Оплачивается ли больничный курьеру?',
        'a' => 'Да. Поскольку оформление официальное, больничный лист оплачивается по общим правилам ФСС — по среднему заработку за последние два года, в зависимости от стажа.',
    ],
    [
        'q' => 'Положен ли оплачиваемый отпуск?',
        'a' => 'Да, 28 календарных дней в год, как у любого сотрудника по трудовому договору. Даты отпуска согласовываются с региональным менеджером заранее, чтобы не терять маршрут.',
    ],
    [
        'q' => 'Что входит в страховку курьера?',
        'a' => 'Страхование от несчастных случаев на весь период смены — компенсация при травмах на маршруте. Оформляется компанией автоматически, дополнительных документов от курьера не требуется.',
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
                <h1 class="hero__title" style="font-size: 40px;">Оформление курьера и социальные гарантии</h1>
                <p class="article__lead">
                    Разбираем по шагам, как проходит трудоустройство в ExpressLogist: какие документы нужны,
                    какой договор подписывает курьер и на какие социальные гарантии он может рассчитывать
                    с первого рабочего дня.
                </p>

                <div class="article__body">
                    <h2>Шаги оформления</h2>
                    <ul>
                        <li><strong>Заявка и звонок.</strong> Менеджер связывается в течение 15 минут после отправки формы и уточняет город, желаемый график и тип маршрута.</li>
                        <li><strong>Собеседование.</strong> Короткая встреча в отделении или онлайн — без тестовых заданий и оплаты за обучение.</li>
                        <li><strong>Подписание трудового договора.</strong> Договор оформляется на основании паспорта и СНИЛС, всё занимает не больше одного визита.</li>
                        <li><strong>Инструктаж и выдача обеспечения.</strong> Курьер получает форму, топливную карту (для авто-маршрутов) и знакомится с зоной доставки.</li>
                        <li><strong>Первая смена.</strong> В среднем от заявки до первой смены проходит 1–2 рабочих дня.</li>
                    </ul>

                    <h2>Какой договор заключается</h2>
                    <p>
                        Курьеры ExpressLogist работают по трудовому договору в соответствии с Трудовым
                        кодексом РФ — не по договору ГПХ и не как самозанятые. Это означает запись в
                        электронную трудовую книжку, отчисления в Пенсионный фонд и Фонд социального
                        страхования с даты выхода на первую смену, а также все гарантии, описанные ниже.
                    </p>

                    <h2>Испытательный срок</h2>
                    <p>
                        Испытательный срок — до трёх месяцев, ставка на этот период не отличается от
                        основной. Если выбранный маршрут не подошёл, региональный менеджер предлагает
                        альтернативный вариант графика или зоны доставки, не дожидаясь окончания срока.
                    </p>

                    <h2>Социальные гарантии</h2>
                    <table class="compare-table">
                        <thead>
                            <tr>
                                <th scope="col">Гарантия</th>
                                <th scope="col">Условие</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">Больничный</th>
                                <td>Оплачивается по среднему заработку согласно правилам ФСС</td>
                            </tr>
                            <tr>
                                <th scope="row">Отпуск</th>
                                <td>28 календарных дней в год, даты согласуются с менеджером</td>
                            </tr>
                            <tr>
                                <th scope="row">Страхование</th>
                                <td>От несчастных случаев на весь период смены, оформляется автоматически</td>
                            </tr>
                            <tr>
                                <th scope="row">Стаж</th>
                                <td>Учитывается для ежемесячных бонусов и последующего расчёта пенсии</td>
                            </tr>
                        </tbody>
                    </table>

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
                        <p>Готовы оформиться официально с первого дня?</p>
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
