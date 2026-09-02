<?php
require __DIR__ . '/../inc/config.php';
require __DIR__ . '/../inc/nav-data.php';

$pageTitle       = 'Водителям и дальнобойщикам — работа в ExpressLogist по всему СНГ';
$pageDescription = 'Приглашаем водителей и дальнобойщиков на межгород и рейсы по СНГ, водителей в черте города и владельцев собственных машин. Стабильные рейсы, своевременная оплата, поддержка 24/7.';
$pageUrl         = '/voditelyam/';
$assetsPrefix    = '../';
$navActive       = 'drivers';

require __DIR__ . '/../inc/head.php';
require __DIR__ . '/../inc/header.php';

$crumbs = [
    ['title' => 'Главная', 'url' => '/'],
    ['title' => 'Водителям', 'url' => null],
];
?>
<main id="main">
    <section class="page-hero">
        <div class="container">
            <h1>Работа для водителей и дальнобойщиков</h1>
            <p>Мы постоянно расширяем сеть и ищем водителей по всему СНГ. Стабильная загрузка рейсами, прозрачная и своевременная оплата, поддержка диспетчерской 24/7. Выберите формат работы.</p>
        </div>
    </section>

    <div class="container"><?php require __DIR__ . '/../inc/breadcrumbs.php'; ?></div>

    <section class="section">
        <div class="container">
            <div class="grid grid--3">
                <?php
                $tracks = [
                    ['Дальнобойщикам: межгород и СНГ', 'Длинные рейсы между городами и странами региона. Современный автопарк, топливные карты, оплата без задержек.', '/voditelyam/dalnoboyshchikam/'],
                    ['Водителям в черте города', 'Городская и региональная развозка. Дом каждый день, гибкий график, официальное оформление.', '/voditelyam/v-gorode/'],
                    ['Владельцам собственных машин', 'Постоянная загрузка для водителей с личным грузовым транспортом. Прямые заявки без простоев.', '/voditelyam/so-svoim-avto/'],
                ];
                foreach ($tracks as $t): ?>
                <article class="card service-card">
                    <h2 class="card__title"><?php echo e($t[0]); ?></h2>
                    <p class="card__text"><?php echo e($t[1]); ?></p>
                    <a class="card__link stretched" href="<?php echo e($t[2]); ?>">Подробнее →</a>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section section--navy">
        <div class="container">
            <div class="section__head section__head--center">
                <span class="eyebrow">Почему у нас</span>
                <h2 class="section__title">Что мы предлагаем водителям</h2>
            </div>
            <div class="grid grid--4">
                <?php
                $perks = [
                    ['Стабильные рейсы', 'Постоянная загрузка круглый год без простоев между заявками.'],
                    ['Оплата вовремя', 'Прозрачная система расчётов и выплаты без задержек.'],
                    ['Поддержка 24/7', 'Диспетчерская на связи в любое время в любой точке маршрута.'],
                    ['Официально', 'Оформление по договору, топливные карты и помощь в пути.'],
                ];
                foreach ($perks as $p): ?>
                <div class="card">
                    <h3 class="card__title" style="color:#fff"><?php echo e($p[0]); ?></h3>
                    <p class="card__text" style="color:#A9B7C9"><?php echo e($p[1]); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section section--tight">
        <div class="container">
            <div class="cta-band">
                <div class="cta-band__text">
                    <h2>Хотите работать с нами?</h2>
                    <p>Оставьте заявку или позвоните — расскажем об условиях и подберём формат работы.</p>
                </div>
                <div class="cta-band__actions">
                    <a href="tel:<?php echo e($phoneHref); ?>" class="btn btn--accent"><?php echo e($phoneDisplay); ?></a>
                </div>
            </div>
        </div>
    </section>
</main>
<?php require __DIR__ . '/../inc/footer.php'; ?>
