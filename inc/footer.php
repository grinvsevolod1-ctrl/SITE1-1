<?php
/**
 * Общий футер сайта. Колонки строятся из $siloNav (inc/nav-data.php) —
 * подключите его до этого файла. Требует config.php ($siteName, телефон, email).
 */
$year = date('Y');
?>
<footer class="footer" id="contacts">
    <div class="container">
        <div class="footer__top">
            <div class="footer__about">
                <span class="logo__text logo__text--light">Express<span>Logist</span></span>
                <p class="footer__slogan"><?php echo e($siteSlogan); ?></p>
                <a href="tel:<?php echo e($phoneHref); ?>" class="footer__phone"><?php echo e($phoneDisplay); ?></a>
                <a href="mailto:<?php echo e($email); ?>" class="footer__email"><?php echo e($email); ?></a>
            </div>

            <?php foreach ($siloNav as $section): ?>
            <nav class="footer__col" aria-label="<?php echo e($section['title']); ?>">
                <p class="footer__heading">
                    <a href="<?php echo e($section['url']); ?>"><?php echo e($section['title']); ?></a>
                </p>
                <ul class="footer__list">
                    <?php foreach ($section['pages'] as $page): ?>
                    <li><a href="<?php echo e($page['url']); ?>" class="footer__link"><?php echo e($page['title']); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </nav>
            <?php endforeach; ?>

            <nav class="footer__col" aria-label="Компания">
                <p class="footer__heading">Компания</p>
                <ul class="footer__list">
                    <li><a href="/kalkulyator/" class="footer__link">Калькулятор доставки</a></li>
                    <li><a href="/dokumenty/" class="footer__link">Документы и лицензии</a></li>
                    <?php foreach ($standaloneNav as $page): ?>
                    <li><a href="<?php echo e($page['url']); ?>" class="footer__link"><?php echo e($page['title']); ?></a></li>
                    <?php endforeach; ?>
                    <li><a href="/oferta/" class="footer__link">Публичная оферта</a></li>
                </ul>
            </nav>
        </div>

        <?php
        // Собираем только заполненные реквизиты — пустые поля не выводятся.
        $legalParts = [];
        if (!empty($legal['name']))  { $legalParts[] = e($legal['name']); }
        if (!empty($legal['inn']))   { $legalParts[] = 'ИНН ' . e($legal['inn']); }
        if (!empty($legal['ogrn']))  { $legalParts[] = 'ОГРН ' . e($legal['ogrn']); }
        ?>
        <?php if ($legalParts || !empty($legal['legalAddr'])): ?>
        <p class="footer__legal">
            <?php echo implode(' · ', $legalParts); ?><?php if ($legalParts && !empty($legal['legalAddr'])): ?><br><?php endif; ?><?php if (!empty($legal['legalAddr'])): ?><?php echo e($legal['legalAddr']); ?><?php endif; ?>
        </p>
        <?php endif; ?>

        <div class="footer__bottom">
            <p class="footer__copy">© <?php echo e($year); ?> <?php echo e($siteName); ?>. Все права защищены</p>
            <a href="/politika-konfidencialnosti/" class="footer__link">Политика конфиденциальности</a>
        </div>
    </div>
</footer>

<div class="cookie-bar" id="cookie-bar" role="dialog" aria-live="polite" aria-label="Уведомление об использовании cookie" hidden>
    <p>Мы используем файлы cookie и системы аналитики для работы сайта и улучшения сервиса. Оставаясь на сайте, вы соглашаетесь с <a href="/politika-konfidencialnosti/">политикой конфиденциальности</a>.</p>
    <button type="button" class="btn btn--accent" id="cookie-accept">Принять</button>
</div>

<script src="<?php echo asset('js/script.js', $assetsPrefix ?? ''); ?>" defer></script>
