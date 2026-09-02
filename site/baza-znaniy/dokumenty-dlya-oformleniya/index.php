<?php
/**
 * Статья силоса «База знаний для соискателей».
 * Главная (/) → База знаний (/baza-znaniy/) → Документы для оформления
 */

require __DIR__ . '/../../inc/config.php';
require __DIR__ . '/../../inc/nav-data.php';

$pageTitle = 'Какие документы нужны для оформления курьером — ExpressLogist';
$pageDescription = 'Полный список документов для оформления курьером: для граждан РФ и иностранных граждан. Что нужно принести и что не потребуется.';
$canonical = $baseUrl . '/baza-znaniy/dokumenty-dlya-oformleniya/';

$breadcrumbs = [
    ['label' => 'Главная', 'url' => '/'],
    ['label' => 'База знаний для соискателей', 'url' => '/baza-znaniy/'],
    ['label' => 'Документы для оформления', 'url' => null],
];

$sidebarSection = 'knowledge';
$sidebarCurrent = '/baza-znaniy/dokumenty-dlya-oformleniya/';

$faq = [
    [
        'q' => 'Нужна ли медицинская книжка курьеру?',
        'a' => 'Нет, медицинская книжка для курьерской доставки не требуется — это не работа с продуктами питания на кухне или в общественном питании.',
    ],
    [
        'q' => 'Нужен ли ИНН для оформления?',
        'a' => 'Отдельно приносить ИНН не нужно — номер запрашивается автоматически через СНИЛС при подаче отчётности в налоговую.',
    ],
    [
        'q' => 'Можно ли оформиться без прописки в городе, где я хочу работать?',
        'a' => 'Да, регистрация по месту пребывания не обязательна для трудового договора — достаточно паспорта с любой актуальной регистрацией.',
    ],
    [
        'q' => 'Что делать, если патент оформлен на другой регион?',
        'a' => 'Патент действует только в том регионе, где выдан. Уточните у менеджера при звонке — в большинстве крупных городов можно оформить патент на месте до выхода на первую смену.',
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
                <h1 class="hero__title" style="font-size: 40px;">Какие документы нужны для оформления</h1>
                <p class="article__lead">
                    Список минимальный — оформление занимает один визит. Ниже — что нужно принести
                    гражданам РФ и иностранным гражданам, а также что точно не потребуется.
                </p>

                <div class="article__body">
                    <h2>Для граждан РФ</h2>
                    <table class="compare-table">
                        <thead>
                            <tr>
                                <th scope="col">Документ</th>
                                <th scope="col">Комментарий</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">Паспорт</th>
                                <td>Оригинал, любая актуальная регистрация подходит</td>
                            </tr>
                            <tr>
                                <th scope="row">СНИЛС</th>
                                <td>Нужен для трудового договора и отчислений в ПФР</td>
                            </tr>
                            <tr>
                                <th scope="row">Реквизиты карты</th>
                                <td>Для перевода зарплаты — подходит карта любого банка</td>
                            </tr>
                        </tbody>
                    </table>

                    <h2>Для иностранных граждан</h2>
                    <table class="compare-table">
                        <thead>
                            <tr>
                                <th scope="col">Документ</th>
                                <th scope="col">Комментарий</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">Паспорт и миграционная карта</th>
                                <td>С отметкой о законном въезде на территорию РФ</td>
                            </tr>
                            <tr>
                                <th scope="row">Патент или РВП/ВНЖ</th>
                                <td>Патент должен быть оформлен на регион, где будет работа</td>
                            </tr>
                            <tr>
                                <th scope="row">Полис ДМС или ОМС</th>
                                <td>Действующий на момент оформления трудового договора</td>
                            </tr>
                            <tr>
                                <th scope="row">СНИЛС</th>
                                <td>Если ранее не оформлялся — поможем получить на месте</td>
                            </tr>
                        </tbody>
                    </table>

                    <h2>Что не потребуется</h2>
                    <ul>
                        <li>Медицинская книжка — не нужна для курьерской доставки</li>
                        <li>Справка об отсутствии судимости — не запрашивается при первичном оформлении</li>
                        <li>Отдельная справка ИНН — номер определяется автоматически по СНИЛС</li>
                        <li>Плата за форму, обучение или инструктаж — всё предоставляется бесплатно</li>
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
                        <p>Документы собраны? Осталось оставить заявку.</p>
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
