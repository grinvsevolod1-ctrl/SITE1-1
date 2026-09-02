<?php
/**
 * Шаблон посадочной страницы под найм водителей (Яндекс.Директ / hh / Авито).
 *
 * Конверсионный лендинг вакансии: чёткий оффер по доходу, условия, требования,
 * шаги трудоустройства и форма отклика (пишет в logs/leads.txt с пометкой
 * [ВАКАНСИЯ ВОДИТЕЛЯ]).
 *
 * Страница-обёртка ДО подключения этого файла задаёт:
 *   $pageTitle, $pageDescription, $pageUrl, $assetsPrefix, $extraHead — для head.php
 *   $vacancy = [
 *     'h1' => (string), 'sub' => (string),
 *     'benefits' => (array) строк,
 *     'income'   => (array) [['value'=>'','label'=>''], ...],
 *     'offer'    => (array) [['title'=>'','text'=>''], ...],
 *     'requirements' => (array) строк,
 *     'steps'    => (array) [['title'=>'','text'=>''], ...],
 *     'seo'      => (string) необязательный,
 *   ];
 *
 * Требует уже подключённого config.php и head.php.
 */

$vacancy = $vacancy ?? [];
$vBenefits = $vacancy['benefits']     ?? [];
$vIncome   = $vacancy['income']       ?? [];
$vOffer    = $vacancy['offer']        ?? [];
$vReq      = $vacancy['requirements'] ?? [];
$vSteps    = $vacancy['steps']        ?? [];

require __DIR__ . '/head.php';
?>
<a class="skip-link" href="#form">Перейти к отклику</a>

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
            <a href="#form" class="btn btn--accent btn--sm">Откликнуться</a>
        </div>
    </div>
</header>

<main id="main">
    <!-- ГЕРОЙ: оффер вакансии + форма отклика -->
    <section class="promo-hero promo-hero--vacancy">
        <div class="container promo-hero__grid">
            <div class="promo-hero__text">
                <span class="promo-badge">Открыт набор водителей</span>
                <h1 class="promo-hero__title"><?php echo e($vacancy['h1'] ?? 'Работа водителем в транспортной компании'); ?></h1>
                <?php if (!empty($vacancy['sub'])): ?>
                <p class="promo-hero__sub"><?php echo e($vacancy['sub']); ?></p>
                <?php endif; ?>

                <?php if ($vBenefits): ?>
                <ul class="promo-benefits">
                    <?php foreach ($vBenefits as $b): ?>
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
                    <span class="promo-hero__hours">Перезвоним и ответим на вопросы в рабочее время</span>
                </div>
            </div>

            <!-- Форма отклика (пишет в logs/leads.txt с пометкой вакансии) -->
            <div class="lead-card" id="form">
                <p class="lead-card__title">Отклик на вакансию</p>
                <p class="lead-card__note">Заполните — рекрутёр перезвонит и всё расскажет</p>
                <form id="lead-form" action="/send.php" method="post" novalidate>
                    <input type="hidden" name="form_type" value="vacancy">
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
                        <label class="field__label" for="f-city">Город</label>
                        <input class="input" type="text" id="f-city" name="city" placeholder="Где вам удобно работать">
                    </div>
                    <div class="field">
                        <div class="field__row">
                            <div>
                                <label class="field__label" for="f-experience">Стаж вождения</label>
                                <select class="select" id="f-experience" name="experience">
                                    <option value="">Выберите</option>
                                    <option value="Без опыта">Без опыта</option>
                                    <option value="до 1 года">до 1 года</option>
                                    <option value="1–3 года">1–3 года</option>
                                    <option value="3–5 лет">3–5 лет</option>
                                    <option value="более 5 лет">более 5 лет</option>
                                </select>
                            </div>
                            <div>
                                <label class="field__label" for="f-category">Категории прав</label>
                                <select class="select" id="f-category" name="category">
                                    <option value="">Выберите</option>
                                    <option value="B">B</option>
                                    <option value="B, C">B, C</option>
                                    <option value="C">C</option>
                                    <option value="C, E (CE)">C, E (CE)</option>
                                    <option value="Все категории">Все категории</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label class="field__label" for="f-vehicle">Свой транспорт</label>
                        <select class="select" id="f-vehicle" name="vehicle">
                            <option value="">Выберите</option>
                            <option value="Свой тягач / фура">Свой тягач / фура</option>
                            <option value="Своя газель / до 5 т">Своя газель / до 5 т</option>
                            <option value="Без своего авто — на автопарк компании">Без своего авто — на автопарк компании</option>
                        </select>
                    </div>
                    <label class="consent">
                        <input type="checkbox" name="agree" value="1" required>
                        <span>Я даю согласие на обработку персональных данных в соответствии с Федеральным законом №&nbsp;152-ФЗ и принимаю <a href="/politika-konfidencialnosti/">политику конфиденциальности</a></span>
                    </label>
                    <div class="field__error" data-error="agree"></div>
                    <button type="submit" class="btn btn--accent btn--block">Откликнуться на вакансию</button>
                    <div class="form-status" role="status" aria-live="polite"></div>
                </form>
            </div>
        </div>
    </section>

    <!-- ДОХОД И ВЫПЛАТЫ -->
    <?php if ($vIncome): ?>
    <section class="promo-strip">
        <div class="container promo-strip__grid">
            <?php foreach ($vIncome as $s): ?>
            <div class="promo-strip__item">
                <span class="promo-strip__value"><?php echo e($s['value']); ?></span>
                <span class="promo-strip__label"><?php echo e($s['label']); ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- ЧТО ПРЕДЛАГАЕМ -->
    <?php if ($vOffer): ?>
    <section class="section section--tight promo-adv-wrap">
        <div class="container">
            <h2 class="promo-h2">Что мы предлагаем</h2>
            <div class="promo-adv">
                <?php foreach ($vOffer as $a): ?>
                <div class="promo-adv__card">
                    <h3 class="promo-adv__title"><?php echo e($a['title']); ?></h3>
                    <p class="promo-adv__text"><?php echo e($a['text']); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ТРЕБОВАНИЯ -->
    <?php if ($vReq): ?>
    <section class="section section--tight">
        <div class="container">
            <div class="vacancy-req">
                <h2 class="promo-h2">Что важно для нас</h2>
                <ul class="vacancy-req__list">
                    <?php foreach ($vReq as $r): ?>
                    <li>
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M20 6 9 17l-5-5" stroke="var(--accent)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span><?php echo e($r); ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- КАК УСТРОИТЬСЯ -->
    <?php if ($vSteps): ?>
    <section class="section section--tight">
        <div class="container">
            <h2 class="promo-h2">Как устроиться</h2>
            <div class="promo-steps">
                <?php foreach ($vSteps as $i => $st): ?>
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

    <!-- ФИНАЛЬНЫЙ CTA -->
    <section class="promo-final">
        <div class="container promo-final__inner">
            <div>
                <h2 class="promo-final__title">Готовы выйти на маршрут?</h2>
                <p class="promo-final__text">Оставьте отклик — рекрутёр перезвонит, ответит на вопросы и пригласит на оформление.</p>
            </div>
            <div class="promo-final__actions">
                <a href="#form" class="btn btn--accent">Откликнуться</a>
                <a href="tel:<?php echo e($phoneHref); ?>" class="btn btn--ghost"><?php echo e($phoneDisplay); ?></a>
            </div>
        </div>
    </section>

    <?php if (!empty($vacancy['seo'])): ?>
    <section class="section section--tight">
        <div class="container">
            <div class="promo-seo"><?php echo $vacancy['seo']; ?></div>
        </div>
    </section>
    <?php endif; ?>
</main>

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

    <script src="<?php echo asset('js/script.js', $assetsPrefix); ?>" defer></script>
</body>
</html>
