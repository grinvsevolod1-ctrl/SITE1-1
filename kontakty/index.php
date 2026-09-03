<?php
/**
 * Страница «Контакты» — единая точка связи для клиентов (заявки на доставку),
 * водителей и партнёров по всему СНГ.
 */

require __DIR__ . '/../inc/config.php';
require __DIR__ . '/../inc/nav-data.php';

$pageTitle       = 'Контакты — ' . $siteName;
$pageDescription = 'Свяжитесь с ' . $siteName . ': отдел логистики и приём заявок на грузоперевозки по СНГ, отдел по работе с водителями, адрес терминала. Рассчитаем перевозку за 15 минут.';
$pageUrl         = '/kontakty/';
$assetsPrefix    = '../';
$navActive       = '/kontakty/';

$crumbs = [
    ['title' => 'Главная', 'url' => '/'],
    ['title' => 'Контакты', 'url' => null],
];

// BreadcrumbList для страницы контактов (Organization задаётся глобально в head.php)
$pos = 1;
$crumbItems = [];
foreach ($crumbs as $cr) {
    $entry = ['@type' => 'ListItem', 'position' => $pos, 'name' => $cr['title']];
    if (!empty($cr['url'])) {
        $entry['item'] = rtrim($baseUrl, '/') . $cr['url'];
    }
    $crumbItems[] = $entry;
    $pos++;
}
$extraHead = '<script type="application/ld+json">' . json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => $crumbItems,
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';

require __DIR__ . '/../inc/head.php';
require __DIR__ . '/../inc/header.php';
?>
<main id="main">
    <section class="page-hero">
        <div class="container">
            <h1>Контакты</h1>
            <p>Рассчитываем стоимость перевозки за 15 минут в рабочее время. Отдельные линии для клиентов, водителей и партнёров.</p>
        </div>
    </section>

    <div class="container"><?php require __DIR__ . '/../inc/breadcrumbs.php'; ?></div>

    <section class="section section--tight">
        <div class="container">
            <div class="contact-grid">
                <div class="contact-card">
                    <div class="contact-card__label">Отдел логистики — заявки на перевозку</div>
                    <a class="contact-card__value" href="tel:<?php echo e($phoneHref); ?>" data-goal="phone_click"><?php echo e($phoneDisplay); ?></a>
                    <p class="contact-card__note">Бесплатно по всему СНГ. Расчёт сборных и отдельных машин, крупногабарит.</p>
                </div>
                <div class="contact-card">
                    <div class="contact-card__label">Электронная почта</div>
                    <a class="contact-card__value" href="mailto:<?php echo e($email); ?>"><?php echo e($email); ?></a>
                    <p class="contact-card__note">Заявки со спецификацией, документы, договоры, бухгалтерия.</p>
                </div>
                <div class="contact-card">
                    <div class="contact-card__label">Отдел по работе с водителями</div>
                    <a class="contact-card__value" href="/voditelyam/">Раздел «Водителям»</a>
                    <p class="contact-card__note">Набор дальнобойщиков, городских водителей и владельцев своего авто.</p>
                </div>
                <div class="contact-card">
                    <div class="contact-card__label">Режим работы</div>
                    <div class="contact-card__value contact-card__value--sm">Пн–Пт 8:00–20:00, Сб 9:00–18:00</div>
                    <p class="contact-card__note">Диспетчерская и мониторинг грузов — круглосуточно, 24/7.</p>
                </div>
            </div>

            <div class="layout">
                <article class="article">
                    <h2>Центральный офис и терминал</h2>
                    <p><?php echo e($address['zip'] . ', г. ' . $address['city'] . ', ' . $address['street']); ?></p>
                    <p>
                        Головной терминал входит в сеть из 140+ складских комплексов и перегрузочных
                        хабов в 9 странах СНГ. Приём и выдача грузов, ответственное хранение,
                        кросс-докинг и таможенное оформление — на одной площадке.
                    </p>

                    <h2>Направления перевозок</h2>
                    <p>
                        Возим по всей России и между странами СНГ: Беларусь, Казахстан, Армения,
                        Кыргызстан, Узбекистан, Азербайджан, Таджикистан, Молдова. Условия, сроки
                        и таможенные нюансы по каждой стране — в разделе
                        <a href="/napravleniya/">«Направления»</a>.
                    </p>

                    <h2>Для водителей</h2>
                    <p>
                        Набираем дальнобойщиков на межгород и международные рейсы, городских
                        водителей и владельцев собственных фур. Условия, ставки и требования —
                        в разделе <a href="/voditelyam/">«Водителям»</a>.
                    </p>

                    <h2>Партнёрам и перевозчикам</h2>
                    <p>
                        По вопросам подключения транспорта, агентских и партнёрских программ
                        пишите на <a href="mailto:<?php echo e($email); ?>"><?php echo e($email); ?></a> —
                        ответим в течение одного рабочего дня.
                    </p>

                    <?php if (!empty($legal['name']) || !empty($legal['inn']) || !empty($legal['ogrn']) || !empty($legal['legalAddr'])): ?>
                    <h2>Реквизиты</h2>
                    <ul class="req-list">
                        <?php if (!empty($legal['name'])): ?><li><span>Наименование</span><b><?php echo e($legal['name']); ?></b></li><?php endif; ?>
                        <?php if (!empty($legal['inn'])): ?><li><span>ИНН</span><b><?php echo e($legal['inn']); ?></b></li><?php endif; ?>
                        <?php if (!empty($legal['kpp'])): ?><li><span>КПП</span><b><?php echo e($legal['kpp']); ?></b></li><?php endif; ?>
                        <?php if (!empty($legal['ogrn'])): ?><li><span>ОГРН</span><b><?php echo e($legal['ogrn']); ?></b></li><?php endif; ?>
                        <?php if (!empty($legal['director'])): ?><li><span>Генеральный директор</span><b><?php echo e($legal['director']); ?></b></li><?php endif; ?>
                        <?php if (!empty($legal['legalAddr'])): ?><li><span>Юридический адрес</span><b><?php echo e($legal['legalAddr']); ?></b></li><?php endif; ?>
                    </ul>
                    <?php endif; ?>

                    <div class="cta-band" style="margin-top:8px">
                        <div class="cta-band__text">
                            <h2>Нужно перевезти груз?</h2>
                            <p>Оставьте заявку — рассчитаем маршрут, сроки и стоимость.</p>
                        </div>
                        <div class="cta-band__actions">
                            <a href="/#form" class="btn btn--accent">Рассчитать перевозку</a>
                            <a href="tel:<?php echo e($phoneHref); ?>" class="btn btn--outline-light"><?php echo e($phoneDisplay); ?></a>
                        </div>
                    </div>
                </article>

                <?php $sidebarSection = null; require __DIR__ . '/../inc/sidebar.php'; ?>
            </div>
        </div>
    </section>
</main>
<?php require __DIR__ . '/../inc/footer.php'; ?>
