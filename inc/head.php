<?php
/**
 * Общий <head> + открытие <body> и подключение аналитики.
 *
 * Перед подключением задайте в странице:
 *   $pageTitle       (string) — <title> и og:title
 *   $pageDescription (string) — meta description и og:description
 *   $pageUrl         (string) — путь страницы со слэшами, например '/uslugi/'
 *   $assetsPrefix    (string) — префикс до корня для css/js: '' | '../' | '../../'
 *   $bodyClass       (string, необязательно) — доп. класс на <body>
 *   $extraHead       (string, необязательно) — доп. разметка в <head> (JSON-LD и т.п.)
 *
 * Требует config.php (переменные $baseUrl, $siteName, аналитика).
 */
$pageTitle       = $pageTitle ?? $siteName;
$pageDescription = $pageDescription ?? $siteSlogan;
$pageUrl         = $pageUrl ?? '/';
$assetsPrefix    = $assetsPrefix ?? '';
$bodyClass       = $bodyClass ?? '';
$extraHead       = $extraHead ?? '';
$canonical       = $baseUrl . $pageUrl;
?>
<!DOCTYPE html>
<html lang="ru" class="theme">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($pageTitle); ?></title>
    <meta name="description" content="<?php echo e($pageDescription); ?>">
    <meta name="theme-color" content="#0B1F3A">
    <link rel="canonical" href="<?php echo e($canonical); ?>">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:site_name" content="<?php echo e($siteName); ?>">
    <meta property="og:title" content="<?php echo e($pageTitle); ?>">
    <meta property="og:description" content="<?php echo e($pageDescription); ?>">
    <meta property="og:url" content="<?php echo e($canonical); ?>">

    <!-- Шрифты: Manrope (заголовки) + Inter (текст) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo e($assetsPrefix); ?>css/style.css">

    <?php echo $extraHead; ?>

    <?php /* ---------- Google Analytics 4 ---------- */ ?>
    <?php if ($googleAnalyticsId !== ''): ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo e($googleAnalyticsId); ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '<?php echo e($googleAnalyticsId); ?>');
        window.GA_ID = '<?php echo e($googleAnalyticsId); ?>';
    </script>
    <?php endif; ?>

    <?php /* ---------- Яндекс.Метрика ---------- */ ?>
    <?php if ($yandexMetrikaId !== ''): ?>
    <script>
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
        ym(<?php echo (int) $yandexMetrikaId; ?>, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true });
        window.YM_ID = <?php echo (int) $yandexMetrikaId; ?>;
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/<?php echo (int) $yandexMetrikaId; ?>" style="position:absolute; left:-9999px;" alt=""></div></noscript>
    <?php endif; ?>
</head>
<body<?php echo $bodyClass ? ' class="' . e($bodyClass) . '"' : ''; ?>>
