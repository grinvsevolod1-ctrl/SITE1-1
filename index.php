<?php
require __DIR__ . '/inc/config.php';
require __DIR__ . '/inc/nav-data.php';

$pageTitle       = 'ExpressLogist — крупногабаритная доставка для бизнеса по всему СНГ';
$pageDescription = 'Перевозим крупногабаритные и сборные грузы для бизнеса по России и всему СНГ. Собственная сеть, отдельные машины и сборные отправки, страхование, документы. Рассчитайте доставку за 15 минут.';
$pageUrl         = '/';
$assetsPrefix    = '';
$navActive       = null;
$isHome          = true;

require __DIR__ . '/inc/head.php';
require __DIR__ . '/inc/header.php';
?>
<main id="main">

    <!-- ГЕРОЙ + ФОРМА ЗАЯВКИ -->
    <section class="hero">
        <div class="container hero__grid">
            <div class="hero__text">
                <span class="hero__badge">Работаем по <b>9&nbsp;странам СНГ</b> · с 2011 года</span>
                <h1 class="hero__title">Крупногабаритная доставка <span>для бизнеса</span> по всему&nbsp;СНГ</h1>
                <p class="hero__lead">
                    Перевозим негабарит, промышленное оборудование и сборные партии от 1&nbsp;кг до 20&nbsp;тонн.
                    Собственный автопарк и партнёрская сеть — от склада отправителя до двери получателя.
                </p>
                <div class="hero__actions">
                    <a href="#form" class="btn btn--accent">Рассчитать доставку</a>
                    <a href="/uslugi/" class="btn btn--outline-light">Все услуги</a>
                </div>
                <div class="hero__trust">
                    <div><b>9</b><span>стран СНГ</span></div>
                    <div><b>1&nbsp;800+</b><span>единиц транспорта</span></div>
                    <div><b>62&nbsp;000</b><span>доставок в год</span></div>
                    <div><b>99,3%</b><span>вовремя</span></div>
                </div>
            </div>

            <!-- Форма расчёта -->
            <div class="lead-card" id="form">
                <p class="lead-card__title">Заявка на расчёт</p>
                <p class="lead-card__note">Ответим в течение 15 минут в рабочее время</p>
                <form id="lead-form" action="/send.php" method="post" novalidate>
                    <!-- Honeypot: скрытое поле-ловушка для ботов. Люди его не заполняют. -->
                    <div class="hp-field" aria-hidden="true">
                        <label for="f-website">Не заполняйте это поле</label>
                        <input type="text" id="f-website" name="website" tabindex="-1" autocomplete="off">
                    </div>
                    <div class="field">
                        <label class="field__label" for="f-name">Ваше имя *</label>
                        <input class="input" type="text" id="f-name" name="name" autocomplete="name" required>
                        <div class="field__error" data-error="name"></div>
                    </div>
                    <div class="field">
                        <label class="field__label" for="f-phone">Телефон *</label>
                        <input class="input" type="tel" id="f-phone" name="phone" placeholder="+7 (___) ___-__-__" autocomplete="tel" required>
                        <div class="field__error" data-error="phone"></div>
                    </div>
                    <div class="field">
                        <label class="field__label" for="f-company">Компания</label>
                        <input class="input" type="text" id="f-company" name="company" autocomplete="organization">
                    </div>
                    <div class="field">
                        <div class="field__row">
                            <div>
                                <label class="field__label" for="f-from">Откуда</label>
                                <input class="input" type="text" id="f-from" name="from" placeholder="Город отправки">
                            </div>
                            <div>
                                <label class="field__label" for="f-to">Куда</label>
                                <input class="input" type="text" id="f-to" name="to" placeholder="Город доставки">
                            </div>
                        </div>
                        <div class="field__error" data-error="route"></div>
                    </div>
                    <div class="field">
                        <label class="field__label" for="f-service">Тип груза / услуга</label>
                        <select class="select" id="f-service" name="service">
                            <option value="">Выберите из списка</option>
                            <?php foreach ($serviceTypes as $type): ?>
                            <option value="<?php echo e($type); ?>"><?php echo e($type); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="field__error" data-error="service"></div>
                    </div>
                    <label class="consent">
                        <input type="checkbox" name="agree" value="1" required>
                        <span>Я даю согласие на обработку персональных данных в соответствии с Федеральным законом №&nbsp;152-ФЗ и принимаю <a href="/politika-konfidencialnosti/">политику конфиденциальности</a></span>
                    </label>
                    <div class="field__error" data-error="agree"></div>
                    <button type="submit" class="btn btn--accent btn--block">Отправить заявку</button>
                    <div class="form-status" role="status" aria-live="polite"></div>
                </form>
            </div>
        </div>
    </section>

    <!-- ПОЛОСА ДОВЕРИЯ -->
    <section class="marquee" aria-label="Отрасли, которым мы возим грузы">
        <div class="container">
            <div class="marquee__inner">
                <span class="marquee__item">Промышленное оборудование</span>
                <span class="marquee__item">Строительство</span>
                <span class="marquee__item">Ритейл и маркетплейсы</span>
                <span class="marquee__item">Агропром</span>
                <span class="marquee__item">Энергетика</span>
                <span class="marquee__item">Металлургия</span>
                <span class="marquee__item">Нефтегаз</span>
            </div>
        </div>
    </section>

    <!-- УСЛУГИ -->
    <section class="section">
        <div class="container">
            <div class="section__head">
                <span class="eyebrow">Что мы возим</span>
                <h2 class="section__title">Логистика под задачу вашего бизнеса</h2>
                <p class="section__subtitle">От одной паллеты до негабаритного модуля — подберём транспорт, оформим документы и застрахуем груз.</p>
            </div>
            <div class="grid grid--4">
                <?php
                $homeServices = [
                    ['Крупногабаритная доставка', 'Негабарит, спецтехника, оборудование. Тралы, низкорамники, сопровождение.', '/uslugi/krupnogabaritnaya-dostavka/', '<path d="M3 7h11v8H3zM14 10h4l3 3v2h-7z"/><circle cx="7" cy="17" r="1.6"/><circle cx="17.5" cy="17" r="1.6"/>'],
                    ['Сборные грузы (LTL)', 'Возим от 1 кг. Платите только за свой объём — выгодно для небольших партий.', '/uslugi/sbornye-gruzy/', '<rect x="4" y="4" width="7" height="7"/><rect x="13" y="4" width="7" height="7"/><rect x="4" y="13" width="7" height="7"/><rect x="13" y="13" width="7" height="7"/>'],
                    ['Отдельная машина (FTL)', 'Персональный транспорт под ваш груз без догрузки и перегрузов в пути.', '/uslugi/otdelnaya-mashina/', '<path d="M3 6h12v9H3zM15 9h4l2 3v3h-6z"/><circle cx="7" cy="17" r="1.6"/><circle cx="17.5" cy="17" r="1.6"/>'],
                    ['Склад и фулфилмент', 'Ответственное хранение, обработка заказов, комплектация и отгрузка.', '/uslugi/sklad-i-fulfilment/', '<path d="M3 21V9l9-5 9 5v12H3z"/><rect x="8" y="13" width="8" height="8"/>'],
                ];
                foreach ($homeServices as $s): ?>
                <article class="card service-card">
                    <div class="card__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"><?php echo $s[3]; ?></svg></div>
                    <h3 class="card__title"><?php echo e($s[0]); ?></h3>
                    <p class="card__text"><?php echo e($s[1]); ?></p>
                    <a class="card__link stretched" href="<?php echo e($s[2]); ?>">Подробнее →</a>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ПРОЦЕСС -->
    <section class="section section--mist">
        <div class="container">
            <div class="section__head">
                <span class="eyebrow">Как мы работаем</span>
                <h2 class="section__title">Четыре шага до доставленного груза</h2>
            </div>
            <div class="steps steps--row">
                <?php
                $steps = [
                    ['Заявка и расчёт', 'Оставляете заявку — считаем стоимость и сроки, предлагаем оптимальный транспорт.'],
                    ['Договор и подача', 'Заключаем договор, подаём машину к складу отправителя в согласованное время.'],
                    ['Перевозка', 'Везём груз с контролем на каждом этапе. Вы отслеживаете статус онлайн.'],
                    ['Доставка и документы', 'Передаём груз получателю, закрываем перевозку полным пакетом документов.'],
                ];
                foreach ($steps as $st): ?>
                <div class="step">
                    <div class="step__num"></div>
                    <h3 class="step__title"><?php echo e($st[0]); ?></h3>
                    <p class="step__text"><?php echo e($st[1]); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- СТАТИСТИКА СЕТИ -->
    <section class="section section--navy">
        <div class="container">
            <div class="section__head section__head--center">
                <span class="eyebrow">Масштаб сети</span>
                <h2 class="section__title">Разветвлённая грузовая сеть по всему СНГ</h2>
                <p class="section__subtitle">Терминалы, склады и партнёры в каждой стране региона — груз не «зависает» на границах.</p>
            </div>
            <div class="stats">
                <div class="stat"><b>140+</b><span>терминалов и складов</span></div>
                <div class="stat"><b>1&nbsp;800+</b><span>единиц транспорта</span></div>
                <div class="stat"><b>9</b><span>стран присутствия</span></div>
                <div class="stat"><b>24/7</b><span>диспетчерская поддержка</span></div>
            </div>
        </div>
    </section>

    <!-- НАПРАВЛЕНИЯ -->
    <section class="section">
        <div class="container">
            <div class="section__head">
                <span class="eyebrow">Направления</span>
                <h2 class="section__title">Доставка по всему СНГ</h2>
                <p class="section__subtitle">Внутренние и международные перевозки с таможенным оформлением. Работаем со всеми странами региона равномерно.</p>
            </div>
            <div class="geo-grid">
                <?php foreach ($siloNav['directions']['pages'] as $dir): ?>
                <a class="geo" href="<?php echo e($dir['url']); ?>">
                    <span>
                        <span class="geo__name"><?php echo e(str_replace(['Доставка по ', 'Доставка в '], '', $dir['title'])); ?></span><br>
                        <span class="geo__meta">Сборные и отдельные машины</span>
                    </span>
                    <span class="geo__arrow" aria-hidden="true">→</span>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="section section--mist">
        <div class="container">
            <div class="section__head">
                <span class="eyebrow">Вопросы и ответы</span>
                <h2 class="section__title">Частые вопросы бизнеса</h2>
            </div>
            <div class="faq">
                <?php
                $faq = [
                    ['Возите ли вы негабаритные грузы?', 'Да. У нас есть тралы, низкорамные платформы и разрешения на перевозку негабарита. Организуем сопровождение и согласование маршрута.'],
                    ['С какого веса и объёма работаете?', 'От 1 кг на сборных отправках до 20 тонн и более на отдельных машинах и спецтранспорте.'],
                    ['Работаете ли вы с НДС и по договору?', 'Да, работаем с юридическими лицами и ИП по договору, предоставляем полный пакет закрывающих документов, в том числе с НДС.'],
                    ['Страхуете ли груз?', 'Груз можно застраховать на полную стоимость. Для регулярных отправок предлагаем рамочные условия страхования.'],
                    ['Есть ли отслеживание груза?', 'Да, статус перевозки доступен онлайн, а персональный менеджер на связи на всех этапах.'],
                ];
                foreach ($faq as $item): ?>
                <div class="faq__item">
                    <button class="faq__q" type="button" aria-expanded="false"><?php echo e($item[0]); ?></button>
                    <div class="faq__a"><p><?php echo e($item[1]); ?></p></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="section section--tight">
        <div class="container">
            <div class="cta-band">
                <div class="cta-band__text">
                    <h2>Нужно перевезти груз по СНГ?</h2>
                    <p>Рассчитаем стоимость и сроки, предложим оптимальный транспорт под вашу задачу.</p>
                </div>
                <div class="cta-band__actions">
                    <a href="#form" class="btn btn--accent">Оставить заявку</a>
                    <a href="tel:<?php echo e($phoneHref); ?>" class="btn btn--outline-light"><?php echo e($phoneDisplay); ?></a>
                </div>
            </div>
        </div>
    </section>

</main>
<?php require __DIR__ . '/inc/footer.php'; ?>
