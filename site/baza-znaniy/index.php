<?php
/**
 * Хаб силоса «База знаний для соискателей».
 * Главная (/) → База знаний для соискателей (/baza-znaniy/)
 */

require __DIR__ . '/../inc/config.php';
require __DIR__ . '/../inc/nav-data.php';

$pageTitle = 'База знаний для соискателей — вакансия курьера ExpressLogist';
$pageDescription = 'Всё, что нужно знать перед тем, как стать курьером: инструкция по оформлению, список документов, уровень дохода и выбор графика 2/2 или 5/2.';
$canonical = $baseUrl . '/baza-znaniy/';

$breadcrumbs = [
    ['label' => 'Главная', 'url' => '/'],
    ['label' => 'База знаний для соискателей', 'url' => null],
];

$sidebarSection = 'knowledge';
$sidebarCurrent = '/baza-znaniy/';

$articles = [
    [
        'title' => 'Как стать курьером: пошаговая инструкция',
        'text' => 'От заявки до первой смены — что происходит на каждом шаге и сколько это занимает по времени.',
        'meta' => '6 шагов · 1–2 дня до первой смены',
        'url' => '/baza-znaniy/kak-stat-kurierom/',
    ],
    [
        'title' => 'Какие документы нужны для оформления',
        'text' => 'Полный список документов для граждан РФ и иностранных граждан, а также что не потребуется.',
        'meta' => 'Паспорт, СНИЛС и патент/РВП',
        'url' => '/baza-znaniy/dokumenty-dlya-oformleniya/',
    ],
    [
        'title' => 'Сколько зарабатывает курьер',
        'text' => 'Разбор сдельной оплаты по типам маршрутов, бонусов за стаж и того, что влияет на итоговый доход.',
        'meta' => 'От 90 000 ₽ в месяц',
        'url' => '/baza-znaniy/skolko-zarabatyvaet-kurier/',
    ],
    [
        'title' => 'График 2/2 и 5/2: как выбрать',
        'text' => 'Сравнение двух графиков смен — кому подходит каждый и как перейти с одного на другой.',
        'meta' => 'Плюсы и минусы каждого графика',
        'url' => '/baza-znaniy/grafik-2-2-i-5-2/',
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

    <meta property="og:type" content="website">
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
</head>
<body>

<?php $isHome = false; include __DIR__ . '/../inc/header.php'; ?>

<?php include __DIR__ . '/../inc/breadcrumbs.php'; ?>

<main>
    <section class="article section">
        <div class="container layout">
            <div>
                <h1 class="hero__title" style="font-size: 40px;">База знаний для соискателей</h1>
                <p class="article__lead">
                    Собрали ответы на вопросы, которые чаще всего задают перед тем, как выйти на первую
                    смену курьером: как проходит оформление, какие документы нужны, сколько можно
                    заработать и какой график выбрать.
                </p>

                <div class="hub-grid">
                    <?php foreach ($articles as $article): ?>
                    <a href="<?php echo htmlspecialchars($article['url'], ENT_QUOTES, 'UTF-8'); ?>" class="hub-card">
                        <p class="hub-card__eyebrow">База знаний</p>
                        <h2 class="hub-card__title"><?php echo htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8'); ?></h2>
                        <p class="hub-card__text"><?php echo htmlspecialchars($article['text'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p class="hub-card__meta"><?php echo htmlspecialchars($article['meta'], ENT_QUOTES, 'UTF-8'); ?> →</p>
                    </a>
                    <?php endforeach; ?>
                </div>

                <div class="article__cta">
                    <p>Не нашли ответ на свой вопрос?</p>
                    <a href="/#form" class="btn btn--accent">Оставить заявку</a>
                </div>
            </div>

            <?php include __DIR__ . '/../inc/sidebar.php'; ?>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../inc/footer.php'; ?>
</body>
</html>
