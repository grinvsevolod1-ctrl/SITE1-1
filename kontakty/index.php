<?php
/**
 * Страница «Контакты» — вне силосов, единая точка связи для соискателей и партнёров.
 */

require __DIR__ . '/../inc/config.php';

$pageTitle = 'Контакты — ExpressLogist';
$pageDescription = 'Свяжитесь с ExpressLogist: телефон горячей линии, форма заявки для соискателей и адрес центрального офиса. Ответим в течение 15 минут.';
$canonical = $baseUrl . '/kontakty/';

$breadcrumbs = [
    ['label' => 'Главная', 'url' => '/'],
    ['label' => 'Контакты', 'url' => null],
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
        <div class="container">
            <h1 class="hero__title" style="font-size: 40px; text-align: center;">Контакты</h1>
            <p class="section__subtitle">
                Вопросы по вакансиям, оформлению или сотрудничеству — звоните на горячую линию
                или оставьте заявку, менеджер свяжется с вами в течение 15 минут.
            </p>

            <div class="city-stats" style="max-width: 900px; margin: 48px auto 0; grid-template-columns: repeat(3, 1fr);">
                <div class="city-stat">
                    <div class="city-stat__value" style="font-size: 22px;">8 (800) 555-35-35</div>
                    <div class="city-stat__label">Горячая линия, звонок бесплатный</div>
                </div>
                <div class="city-stat">
                    <div class="city-stat__value" style="font-size: 22px;">info@expresslogist.ru</div>
                    <div class="city-stat__label">Почта для соискателей и партнёров</div>
                </div>
                <div class="city-stat">
                    <div class="city-stat__value" style="font-size: 22px;">Пн–Вс, 8:00–22:00</div>
                    <div class="city-stat__label">Режим работы горячей линии</div>
                </div>
            </div>

            <div class="article__body" style="max-width: 760px; margin: 48px auto 0;">
                <h2>Центральный офис</h2>
                <p>г. Москва, ул. Складочная, д. 6, стр. 1, БЦ «Северный», 4 этаж</p>

                <h2>Вакансии по городам</h2>
                <p>
                    Подробные условия работы, доход и районы для 8 крупнейших городов присутствия —
                    на странице <a href="/vakansii/">«Вакансии по городам»</a>. Работаем в 150+
                    городах России — если вашего города нет в списке, уточните условия по телефону.
                </p>

                <h2>Для СМИ и партнёров</h2>
                <p>
                    По вопросам сотрудничества, франшизы и партнёрских программ пишите на
                    info@expresslogist.ru — ответим в течение одного рабочего дня.
                </p>

                <div class="article__cta">
                    <p>Хотите стать курьером ExpressLogist?</p>
                    <a href="/#form" class="btn btn--accent">Оставить заявку</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../inc/footer.php'; ?>
</body>
</html>
