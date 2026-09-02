<?php
/**
 * Шаблон посадочной страницы под Яндекс.Директ (и другую рекламу).
 *
 * Максимально простой и конверсионный лендинг: минимум навигации,
 * один чёткий оффер, форма заявки выше сгиба, шаги и преимущества.
 *
 * Страница-обёртка ДО подключения этого файла задаёт:
 *   $pageTitle, $pageDescription, $pageUrl, $assetsPrefix  — для head.php
 *   $promo = [
 *     'h1'        => (string) заголовок-оффер,
 *     'sub'       => (string) подзаголовок,
 *     'benefits'  => (array)  короткие выгоды (буллеты в герое),
 *     'service'   => (string) тип груза, предвыбранный в форме (из $serviceTypes),
 *     'stats'     => (array)  [['value'=>'', 'label'=>''], ...],
 *     'steps'     => (array)  [['title'=>'', 'text'=>''], ...],
 *     'adv'       => (array)  [['title'=>'', 'text'=>''], ...],
 *     'seo'       => (string) необязательный SEO-абзац внизу,
 *   ];
 *
 * Требует уже подключённого config.php (переменные компании) и наличия
 * head.php. Реклама-лендинги закрыты от индексации (noindex) в обёртке.
 */

$promo = $promo ?? [];
$pBenefits = $promo['benefits'] ?? [];
$pStats    = $promo['stats']    ?? [];
$pSteps    = $promo['steps']    ?? [];
$pAdv      = $promo['adv']      ?? [];
$pService  = $promo['service']  ?? '';

require __DIR__ . '/head.php';
?>
<a class="skip-link" href="#form">Перейти к заявке</a>

<header class="promo-header">
    <div class="container promo-header__inner">
        <a href="/" class="logo" aria-label="<?php echo e($siteName); ?> — на главную">
            <svg class="logo__mark" width="38" height="38" viewBox="0 0 42 42" fill="none" aria-hidden="true">
                <rect width="42" height="42" rx="11" fill="var(--accent)"/>
                <path d="M12 13l6.5 8-6.5 8" fill="none" stroke="#fff" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M21 13l6.5 8-6.5 8" fill="none" stroke="#fff" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round" opacity=".5"/>
            </svg>
            <span class="logo__text">Express<span>Logist</span></span>
        </a>
        <div class="promo-header__contact">
            <a href="tel:<?php echo e($phoneHref); ?>" class="promo-header__phone"><?php echo e($phoneDisplay); ?></a>
            <a href="#form" class="btn btn--accent btn--sm">Оставить заявку</a>
        </div>
    </div>
</header>

<main id="main">
    <!-- ГЕРОЙ: оффер + форма -->
    <section class="promo-hero">
        <div class="container promo-hero__grid">
            <div class="promo-hero__text">
                <h1 class="promo-hero__title"><?php echo e($promo['h1'] ?? $siteSlogan); ?></h1>
                <?php if (!empty($promo['sub'])): ?>
                <p class="promo-hero__sub"><?php echo e($promo['sub']); ?></p>
                <?php endif; ?>

                <?php if ($pBenefits): ?>
                <ul class="promo-benefits">
                    <?php foreach ($pBenefits as $b): ?>
                    <li>
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M20 6 9 17l-5-5" stroke="var(--accent)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span><?php echo e($b); ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>

                <div class="promo-hero__cta">
                    <a href="tel:<?php echo e($phoneHref); ?>" class="promo-hero__phone-big">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg>
                        <?php echo e($phoneDisplay); ?>
                    </a>
                    <span class="promo-hero__hours">Ответим за 15 минут в рабочее время</span>
                </div>
            </div>

            <!-- Форма заявки (та же, что и на сайте: пишет в logs/leads.txt) -->
            <div class="lead-card" id="form">
                <p class="lead-card__title">Заявка на расчёт</p>
                <p class="lead-card__note">Рассчитаем стоимость и сроки бесплатно</p>
                <form id="lead-form" action="/send.php" method="post" novalidate>
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
                            <option value="<?php echo e($type); ?>"<?php echo $pService === $type ? ' selected' : ''; ?>><?php echo e($type); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="field__error" data-error="service"></div>
                    </div>
                    <label class="consent">
                        <input type="checkbox" name="agree" value="1" required>
                        <span>Я даю согласие на обработку персональных данных в соответствии с Федеральным законом №&nbsp;152-ФЗ и принимаю <a href="/politika-konfidencialnosti/">политику конфиденциальности</a></span>
                    </label>
                    <div class="field__error" data-error="agree"></div>
                    <button type="submit" class="btn btn--accent btn--block">Получить расчёт</button>
                    <div class="form-status" role="status" aria-live="polite"></div>
                </form>
            </div>
        </div>
    </section>

    <!-- ДОВЕРИЕ: цифры -->
    <?php if ($pStats): ?>
    <section class="promo-strip">
        <div class="container promo-strip__grid">
            <?php foreach ($pStats as $s): ?>
            <div class="promo-strip__item">
                <span class="promo-strip__value"><?php echo e($s['value']); ?></span>
                <span class="promo-strip__label"><?php echo e($s['label']); ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- ШАГИ -->
    <?php if ($pSteps): ?>
    <section class="section section--tight">
        <div class="container">
            <h2 class="promo-h2">Как мы работаем</h2>
            <div class="promo-steps">
                <?php foreach ($pSteps as $i => $st): ?>
                <div class="promo-step">
                    <span class="promo-step__num"><?php echo $i + 1; ?></span>
                    <h3 class="promo-step__title"><?php echo e($st['title']); ?></h3>
                    <p class="promo-step__text"><?php echo e($st['text']); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ПРЕИМУЩЕСТВА -->
    <?php if ($pAdv): ?>
    <section class="section section--tight promo-adv-wrap">
        <div class="container">
            <h2 class="promo-h2">Почему выбирают <?php echo e($siteName); ?></h2>
            <div class="promo-adv">
                <?php foreach ($pAdv as $a): ?>
                <div class="promo-adv__card">
                    <h3 class="promo-adv__title"><?php echo e($a['title']); ?></h3>
                    <p class="promo-adv__text"><?php echo e($a['text']); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ФИНАЛЬНЫЙ CTA -->
    <section class="promo-final">
        <div class="container promo-final__inner">
            <div>
                <h2 class="promo-final__title">Нужен точный расчёт доставки?</h2>
                <p class="promo-final__text">Оставьте заявку — менеджер свяжется с вами и подберёт оптимальный транспорт под ваш груз.</p>
            </div>
            <div class="promo-final__actions">
                <a href="#form" class="btn btn--accent">Оставить заявку</a>
                <a href="tel:<?php echo e($phoneHref); ?>" class="btn btn--ghost"><?php echo e($phoneDisplay); ?></a>
            </div>
        </div>
    </section>

    <?php if (!empty($promo['seo'])): ?>
    <section class="section section--tight">
        <div class="container">
            <div class="promo-seo"><?php echo $promo['seo']; ?></div>
        </div>
    </section>
    <?php endif; ?>
</main>

<!-- Минимальный футер с юр-данными (обязательно для модерации Яндекс.Директа) -->
<footer class="promo-footer">
    <div class="container promo-footer__inner">
        <div class="promo-footer__col">
            <span class="promo-footer__brand">Express<span>Logist</span></span>
            <p class="promo-footer__slogan"><?php echo e($siteSlogan); ?></p>
        </div>
        <div class="promo-footer__col">
            <a href="tel:<?php echo e($phoneHref); ?>" class="promo-footer__link"><?php echo e($phoneDisplay); ?></a>
            <a href="mailto:<?php echo e($email); ?>" class="promo-footer__link"><?php echo e($email); ?></a>
            <a href="/politika-konfidencialnosti/" class="promo-footer__link">Политика конфиденциальности</a>
        </div>
    </div>
    <div class="promo-footer__legal container">
        <?php
        $legalBits = [];
        if (!empty($legal['name']))      { $legalBits[] = e($legal['name']); }
        if (!empty($legal['inn']))       { $legalBits[] = 'ИНН ' . e($legal['inn']); }
        if (!empty($legal['ogrn']))      { $legalBits[] = 'ОГРН ' . e($legal['ogrn']); }
        if (!empty($legal['legalAddr'])) { $legalBits[] = e($legal['legalAddr']); }
        echo $legalBits ? implode(' · ', $legalBits) : e($siteName);
        ?>
        <span class="promo-footer__year">© <?php echo date('Y'); ?></span>
    </div>
</footer>

<script src="<?php echo e($assetsPrefix); ?>js/script.js" defer></script>
</body>
</html>
