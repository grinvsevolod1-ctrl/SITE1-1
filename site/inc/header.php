<?php
/**
 * Общая шапка сайта (используется на главной и во всех страницах силоса).
 *
 * Перед подключением можно задать:
 *   $isHome (bool) — влияет только на порядок фокуса/якоря "О нас" на главной.
 */
$isHome = $isHome ?? false;
?>
<header class="header" id="top">
    <div class="container header__inner">
        <a href="/" class="logo" aria-label="ExpressLogist — на главную">
            <svg class="logo__mark" width="36" height="36" viewBox="0 0 36 36" fill="none" aria-hidden="true">
                <rect width="36" height="36" rx="8" fill="#FF6B35"/>
                <path d="M7 12h14l-2 4H9l-2-4Zm3 6h12l-2 4h-8l-2-4Zm3 6h10l-2 4h-6l-2-4Z" fill="#fff"/>
            </svg>
            <span class="logo__text">Express<span>Logist</span></span>
        </a>

        <nav class="nav" id="nav" aria-label="Основное меню">
            <a href="/o-kompanii/" class="nav__link">О компании</a>
            <a href="/baza-znaniy/" class="nav__link">База знаний</a>
            <a href="/vakansii/" class="nav__link">Вакансии</a>
            <a href="/kontakty/" class="nav__link">Контакты</a>
            <a href="tel:88005553535" class="nav__phone nav__phone--mobile">8 (800) 555-35-35</a>
        </nav>

        <a href="tel:88005553535" class="nav__phone nav__phone--desktop">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg>
            8 (800) 555-35-35
        </a>

        <!-- Кнопка бургер-меню (видна только на мобильных) -->
        <button class="burger" id="burger" type="button" aria-label="Открыть меню" aria-expanded="false" aria-controls="nav">
            <span></span><span></span><span></span>
        </button>
    </div>
</header>
