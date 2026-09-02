<?php
require __DIR__ . '/../inc/config.php';
require __DIR__ . '/../inc/nav-data.php';

$pageTitle       = 'Услуги грузовой логистики для бизнеса — ExpressLogist';
$pageDescription = 'Крупногабаритная доставка, сборные грузы (LTL), отдельные машины (FTL), складское хранение и фулфилмент по России и всему СНГ. Логистика под задачи вашего бизнеса.';
$pageUrl         = '/uslugi/';
$assetsPrefix    = '../';
$navActive       = 'services';

require __DIR__ . '/../inc/head.php';
require __DIR__ . '/../inc/header.php';

$crumbs = [
    ['title' => 'Главная', 'url' => '/'],
    ['title' => 'Услуги', 'url' => null],
];
?>
<main id="main">
    <section class="page-hero">
        <div class="container">
            <h1>Услуги грузовой логистики</h1>
            <p>Подбираем решение под груз, сроки и бюджет: от одной паллеты в сборной машине до негабаритного оборудования на спецтранспорте. Работаем с юрлицами и ИП по договору.</p>
        </div>
    </section>

    <div class="container"><?php require __DIR__ . '/../inc/breadcrumbs.php'; ?></div>

    <section class="section">
        <div class="container">
            <div class="grid grid--2">
                <?php
                $services = [
                    ['Крупногабаритная доставка', 'Перевозка негабарита, спецтехники и промышленного оборудования на тралах и низкорамниках с сопровождением и согласованием маршрута.', '/uslugi/krupnogabaritnaya-dostavka/'],
                    ['Сборные грузы (LTL)', 'Экономичная доставка небольших партий от 1 кг. Оплачиваете только свой объём, груз консолидируется на терминале.', '/uslugi/sbornye-gruzy/'],
                    ['Отдельная машина (FTL)', 'Персональный транспорт под ваш груз без догрузки. Прямая доставка от двери до двери без перегрузов.', '/uslugi/otdelnaya-mashina/'],
                    ['Складское хранение и фулфилмент', 'Ответственное хранение, приёмка, комплектация и отгрузка заказов. Подходит для маркетплейсов и ритейла.', '/uslugi/sklad-i-fulfilment/'],
                ];
                foreach ($services as $s): ?>
                <article class="card service-card">
                    <h2 class="card__title"><?php echo e($s[0]); ?></h2>
                    <p class="card__text"><?php echo e($s[1]); ?></p>
                    <a class="card__link stretched" href="<?php echo e($s[2]); ?>">Перейти к услуге →</a>
                </article>
                <?php endforeach; ?>
            </div>

            <div class="cta-band mt-32">
                <div class="cta-band__text">
                    <h2>Не нашли нужную услугу?</h2>
                    <p>Расскажите о задаче — подберём схему доставки под ваш груз и маршрут. Или прикиньте бюджет сами в онлайн-калькуляторе.</p>
                </div>
                <div class="cta-band__actions">
                    <a href="/#form" class="btn btn--accent">Получить расчёт</a>
                    <a href="/kalkulyator/" class="btn btn--outline-light">Калькулятор доставки</a>
                </div>
            </div>
        </div>
    </section>
</main>
<?php require __DIR__ . '/../inc/footer.php'; ?>
