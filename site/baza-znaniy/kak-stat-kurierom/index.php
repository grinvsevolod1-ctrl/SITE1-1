<?php
/**
 * Статья силоса «База знаний для соискателей».
 * Главная (/) → База знаний (/baza-znaniy/) → Как стать курьером
 */

require __DIR__ . '/../../inc/config.php';
require __DIR__ . '/../../inc/nav-data.php';

$pageTitle = 'Как стать курьером: пошаговая инструкция — ExpressLogist';
$pageDescription = 'Пошаговая инструкция, как стать курьером в ExpressLogist: от заявки на сайте до первой смены. Сроки, документы и что происходит на каждом этапе.';
$canonical = $baseUrl . '/baza-znaniy/kak-stat-kurierom/';

$breadcrumbs = [
    ['label' => 'Главная', 'url' => '/'],
    ['label' => 'База знаний для соискателей', 'url' => '/baza-znaniy/'],
    ['label' => 'Как стать курьером', 'url' => null],
];

$sidebarSection = 'knowledge';
$sidebarCurrent = '/baza-znaniy/kak-stat-kurierom/';

$faq = [
    [
        'q' => 'Нужен ли опыт работы курьером?',
        'a' => 'Нет, опыт не требуется. Новых сотрудников вводит в курс региональный менеджер, а маршрут и график подбираются с учётом того, что человек выходит на смену впервые.',
    ],
    [
        'q' => 'Можно ли начать работать в тот же день, когда позвонил менеджер?',
        'a' => 'Обычно нет — между звонком и первой сменой нужен минимум один визит для подписания трудового договора. В большинстве случаев весь процесс укладывается в 1–2 рабочих дня.',
    ],
    [
        'q' => 'Что делать, если в моём городе нет отделения?',
        'a' => 'Оставьте заявку на сайте — менеджер уточнит формат оформления для вашего города: часть документов можно подписать дистанционно, финальный этап зависит от региона.',
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
                <h1 class="hero__title" style="font-size: 40px;">Как стать курьером: пошаговая инструкция</h1>
                <p class="article__lead">
                    От первой заявки на сайте до выхода на маршрут обычно проходит 1–2 рабочих дня.
                    Разбираем, что происходит на каждом шаге.
                </p>

                <div class="article__body">
                    <h2>Шаг 1. Заявка на сайте</h2>
                    <p>
                        Заполните форму на главной странице: имя, телефон и город. Это займёт меньше
                        минуты — специально сделали форму короткой, чтобы не отвлекать от других дел.
                    </p>

                    <h2>Шаг 2. Звонок менеджера</h2>
                    <p>
                        Региональный менеджер связывается в течение 15 минут после отправки заявки.
                        Он уточняет удобный график (5/2 или 2/2), тип маршрута — пешком, на велосипеде
                        или на автомобиле — и отвечает на вопросы об условиях.
                    </p>

                    <h2>Шаг 3. Собеседование</h2>
                    <p>
                        Короткая встреча в отделении города или онлайн-звонок. Тестовых заданий и оплаты
                        за обучение нет — на этом этапе просто знакомимся и подтверждаем детали графика.
                    </p>

                    <h2>Шаг 4. Документы и трудовой договор</h2>
                    <p>
                        Для оформления потребуется паспорт и СНИЛС (иностранным гражданам — разрешение
                        на работу или патент). Договор подписывается по Трудовому кодексу РФ с первого
                        рабочего дня. Полный список документов — на отдельной странице
                        <a href="/baza-znaniy/dokumenty-dlya-oformleniya/">«Какие документы нужны для оформления»</a>.
                    </p>

                    <h2>Шаг 5. Инструктаж и выдача обеспечения</h2>
                    <p>
                        Курьер получает форму, топливную карту для авто-маршрутов и знакомится с зоной
                        доставки. Наставник или менеджер объясняет, как пользоваться приложением для
                        маршрутов и что делать в нештатных ситуациях.
                    </p>

                    <h2>Шаг 6. Первая смена</h2>
                    <p>
                        Курьер выходит на маршрут — обычно это происходит на второй день после заявки.
                        В первые недели закреплённый менеджер остаётся на связи, чтобы помочь с
                        адаптацией к графику и маршруту.
                    </p>

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
                        <p>Готовы сделать первый шаг?</p>
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
