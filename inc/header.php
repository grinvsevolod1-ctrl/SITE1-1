<?php
/**
 * Общая шапка сайта.
 *
 * Необязательно:
 *   $navActive (string|null) — ключ активного раздела ('services'|'directions'|'drivers')
 *                              либо путь ('/o-kompanii/', '/kontakty/') для подсветки пункта.
 */
$navActive = $navActive ?? null;
?>
<a class="skip-link" href="#main">Перейти к содержимому</a>
<header class="header" id="top">
    <div class="container header__inner">
        <a href="/" class="logo" aria-label="<?php echo e($siteName); ?> — на главную">
            <svg class="logo__mark" width="42" height="42" viewBox="0 0 42 42" fill="none" aria-hidden="true">
                <rect width="42" height="42" rx="11" fill="var(--accent)"/>
                <path d="M12 13l6.5 8-6.5 8" fill="none" stroke="#fff" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M21 13l6.5 8-6.5 8" fill="none" stroke="#fff" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round" opacity=".5"/>
            </svg>
            <span class="logo__text">Express<span>Logist</span></span>
        </a>

        <nav class="nav" id="nav" aria-label="Основное меню">
            <a href="/uslugi/" class="nav__link<?php echo $navActive === 'services' ? ' is-active' : ''; ?>">Услуги</a>
            <a href="/napravleniya/" class="nav__link<?php echo $navActive === 'directions' ? ' is-active' : ''; ?>">Направления</a>
            <a href="/voditelyam/" class="nav__link<?php echo $navActive === 'drivers' ? ' is-active' : ''; ?>">Водителям</a>
            <a href="/o-kompanii/" class="nav__link<?php echo $navActive === '/o-kompanii/' ? ' is-active' : ''; ?>">О компании</a>
            <a href="/kontakty/" class="nav__link<?php echo $navActive === '/kontakty/' ? ' is-active' : ''; ?>">Контакты</a>
            <a href="tel:<?php echo e($phoneHref); ?>" class="nav__phone nav__phone--mobile"><?php echo e($phoneDisplay); ?></a>
            <a href="/#form" class="btn btn--accent btn--sm nav__cta">Рассчитать доставку</a>
        </nav>

        <a href="tel:<?php echo e($phoneHref); ?>" class="nav__phone nav__phone--desktop">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg>
            <?php echo e($phoneDisplay); ?>
        </a>

        <button class="burger" id="burger" type="button" aria-label="Открыть меню" aria-expanded="false" aria-controls="nav">
            <span></span><span></span><span></span>
        </button>
    </div>
</header>
