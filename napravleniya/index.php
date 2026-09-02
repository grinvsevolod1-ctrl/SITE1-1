<?php
require __DIR__ . '/../inc/config.php';
require __DIR__ . '/../inc/nav-data.php';
require __DIR__ . '/../inc/countries-data.php';

$pageTitle       = 'Направления доставки по СНГ — Россия, Беларусь, Казахстан и другие — ExpressLogist';
$pageDescription = 'Грузовые перевозки для бизнеса по всему СНГ: Россия, Беларусь, Казахстан, Армения, Кыргызстан, Узбекистан, Азербайджан, Таджикистан, Молдова. Внутренние и международные рейсы с таможней.';
$pageUrl         = '/napravleniya/';
$assetsPrefix    = '../';
$navActive       = 'directions';

require __DIR__ . '/../inc/head.php';
require __DIR__ . '/../inc/header.php';

$crumbs = [
    ['title' => 'Главная', 'url' => '/'],
    ['title' => 'Направления по СНГ', 'url' => null],
];
?>
<main id="main">
    <section class="page-hero">
        <div class="container">
            <h1>Направления доставки по всему СНГ</h1>
            <p>Работаем со всеми странами региона равномерно: внутренние перевозки по России и международные рейсы с полным таможенным сопровождением. Ниже — все направления с типовыми сроками.</p>
        </div>
    </section>

    <div class="container"><?php require __DIR__ . '/../inc/breadcrumbs.php'; ?></div>

    <section class="section">
        <div class="container">
            <div class="geo-grid">
                <?php foreach ($countries as $slug => $c): ?>
                <a class="geo" href="/napravleniya/<?php echo e($slug); ?>/">
                    <span>
                        <span class="geo__name"><?php echo e($c['nom']); ?></span><br>
                        <span class="geo__meta"><?php echo e($c['capital']); ?> · срок <?php echo e($c['term']); ?></span>
                    </span>
                    <span class="geo__arrow" aria-hidden="true">→</span>
                </a>
                <?php endforeach; ?>
            </div>

            <div class="cta-band mt-32">
                <div class="cta-band__text">
                    <h2>Не нашли своё направление?</h2>
                    <p>Возим и в другие города и страны региона. Уточните маршрут — подготовим расчёт.</p>
                </div>
                <div class="cta-band__actions">
                    <a href="/#form" class="btn btn--accent">Запросить расчёт</a>
                </div>
            </div>
        </div>
    </section>
</main>
<?php require __DIR__ . '/../inc/footer.php'; ?>
