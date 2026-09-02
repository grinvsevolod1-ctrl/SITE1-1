<?php
/**
 * ExpressLogist — лендинг для привлечения курьеров.
 * Главная страница. Требования: PHP 7.4+, Apache + .htaccess.
 *
 * Список городов присутствия вынесен в массив, чтобы он один раз
 * использовался и в блоке «Города», и в выпадающем списке формы.
 */

$cities = [
    'Москва', 'Санкт-Петербург', 'Новосибирск', 'Екатеринбург', 'Казань',
    'Нижний Новгород', 'Челябинск', 'Омск', 'Ростов-на-Дону', 'Уфа',
    'Красноярск', 'Пермь', 'Воронеж', 'Волгоград', 'Краснодар',
    'Саратов', 'Тюмень', 'Тольятти', 'Ижевск', 'Барнаул',
];

// ID счётчика Яндекс.Метрики. Вставьте свой номер вместо пустой строки.
$yandexMetrikaId = '';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Работа курьером в ExpressLogist — доход от 90 000 ₽ в месяц</title>
    <meta name="description" content="Стань курьером в ExpressLogist. Доход от 90 000 ₽, гибкий график, официальное оформление. Работа в 150+ городах России.">
    <meta name="theme-color" content="#1A73E8">

    <!-- Шрифт Roboto (Google Fonts): 400 — текст, 700 — заголовки -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">

    <?php if ($yandexMetrikaId !== ''): ?>
    <!-- Yandex.Metrika counter -->
    <script>
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
        ym(<?php echo (int) $yandexMetrikaId; ?>, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true });
        // ID передаём в JS, чтобы отправлять цель «lead» после успешной заявки
        window.YM_ID = <?php echo (int) $yandexMetrikaId; ?>;
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/<?php echo (int) $yandexMetrikaId; ?>" style="position:absolute; left:-9999px;" alt=""></div></noscript>
    <!-- /Yandex.Metrika counter -->
    <?php else: ?>
    <!-- Яндекс.Метрика: укажите ID счётчика в переменной $yandexMetrikaId в начале файла -->
    <?php endif; ?>
</head>
<body>

<!-- ========== ШАПКА ========== -->
<header class="header" id="top">
    <div class="container header__inner">
        <a href="#top" class="logo" aria-label="ExpressLogist — на главную">
            <svg class="logo__mark" width="36" height="36" viewBox="0 0 36 36" fill="none" aria-hidden="true">
                <rect width="36" height="36" rx="8" fill="#FF6B35"/>
                <path d="M7 12h14l-2 4H9l-2-4Zm3 6h12l-2 4h-8l-2-4Zm3 6h10l-2 4h-6l-2-4Z" fill="#fff"/>
            </svg>
            <span class="logo__text">Express<span>Logist</span></span>
        </a>

        <nav class="nav" id="nav" aria-label="Основное меню">
            <a href="#about" class="nav__link">О нас</a>
            <a href="#jobs" class="nav__link">Вакансии</a>
            <a href="#contacts" class="nav__link">Контакты</a>
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

<main>
    <!-- ========== ГЕРОЙ-БЛОК ========== -->
    <section class="hero" id="about">
        <div class="container hero__inner">
            <div class="hero__content">
                <span class="hero__badge">Набор открыт в 150+ городах</span>
                <h1 class="hero__title">Стань курьером в&nbsp;ExpressLogist</h1>
                <p class="hero__subtitle">Доход от&nbsp;90&nbsp;000&nbsp;₽ в&nbsp;месяц. Работа по&nbsp;всей России</p>
                <p class="hero__text">Присоединяйся к команде лидера рынка доставки. Гибкий график, официальное оформление, поддержка на каждом этапе</p>
                <a href="#form" class="btn btn--accent btn--lg">Оставить заявку</a>
            </div>
            <div class="hero__image">
                <img src="img/hero-courier.webp" alt="Курьер ExpressLogist с посылкой" width="560" height="700" fetchpriority="high">
            </div>
        </div>
    </section>

    <!-- ========== ПРЕИМУЩЕСТВА ========== -->
    <section class="features section" id="jobs">
        <div class="container">
            <h2 class="section__title">Почему выбирают нас</h2>
            <div class="features__grid">
                <article class="feature">
                    <div class="feature__icon" aria-hidden="true">
                        <!-- Часы: гибкий график -->
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    </div>
                    <h3 class="feature__title">Гибкий график</h3>
                    <p class="feature__text">Смены 5/2, 2/2. Работай в удобное для себя время</p>
                </article>
                <article class="feature">
                    <div class="feature__icon" aria-hidden="true">
                        <!-- Монеты: высокий доход -->
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="8" r="6"/><path d="M18.1 10.4A6 6 0 1 1 10.4 18.1"/><path d="M7 6h1v4"/><path d="m16.7 13.7-.3.3"/></svg>
                    </div>
                    <h3 class="feature__title">Высокий доход</h3>
                    <p class="feature__text">Сдельная оплата + ежемесячные бонусы за стаж</p>
                </article>
                <article class="feature">
                    <div class="feature__icon" aria-hidden="true">
                        <!-- Щит: полное обеспечение -->
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 13c0 5-3.5 7.5-7.7 9a.6.6 0 0 1-.6 0C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.2-2.7a1.2 1.2 0 0 1 1.6 0C14.5 3.8 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg>
                    </div>
                    <h3 class="feature__title">Полное обеспечение</h3>
                    <p class="feature__text">Форма, страховка, топливные карты — всё предоставляем</p>
                </article>
            </div>
        </div>
    </section>

    <!-- ========== СТАТИСТИКА ========== -->
    <section class="stats">
        <div class="container stats__grid">
            <div class="stat">
                <div class="stat__value">150+</div>
                <div class="stat__label">Городов присутствия</div>
            </div>
            <div class="stat">
                <div class="stat__value">2&nbsp;500+</div>
                <div class="stat__label">Сотрудников в штате</div>
            </div>
            <div class="stat">
                <div class="stat__value">50&nbsp;000+</div>
                <div class="stat__label">Доставок в день</div>
            </div>
        </div>
    </section>

    <!-- ========== ГОРОДА ========== -->
    <section class="cities section">
        <div class="container">
            <h2 class="section__title">Города присутствия</h2>
            <p class="section__subtitle">Мы работаем по всей России — выбери свой город и начни зарабатывать уже на этой неделе</p>
            <ul class="cities__list">
                <?php foreach ($cities as $city): ?>
                <li class="cities__item"><?php echo htmlspecialchars($city, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <!-- ========== ФОРМА ЗАЯВКИ ========== -->
    <section class="lead section" id="form">
        <div class="container">
            <div class="lead__card">
                <div class="lead__head">
                    <h2 class="section__title section__title--left">Заполните форму</h2>
                    <p class="lead__subtitle">Наш менеджер свяжется с вами в течение 15 минут</p>
                </div>

                <!-- Отправка через AJAX (js/script.js) на send.php -->
                <form class="form" id="leadForm" action="send.php" method="post" novalidate>
                    <div class="form__field">
                        <label class="form__label" for="name">Ваше имя</label>
                        <input class="form__input" type="text" id="name" name="name" placeholder="Иван" autocomplete="name" required minlength="2">
                        <span class="form__error" data-error-for="name"></span>
                    </div>

                    <div class="form__field">
                        <label class="form__label" for="phone">Телефон</label>
                        <input class="form__input" type="tel" id="phone" name="phone" placeholder="+7 (___) ___-__-__" autocomplete="tel" inputmode="tel" required>
                        <span class="form__error" data-error-for="phone"></span>
                    </div>

                    <div class="form__field">
                        <label class="form__label" for="city">Город</label>
                        <select class="form__input form__select" id="city" name="city" required>
                            <option value="" disabled selected>Выберите город</option>
                            <?php foreach ($cities as $city): ?>
                            <option value="<?php echo htmlspecialchars($city, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($city, ENT_QUOTES, 'UTF-8'); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="form__error" data-error-for="city"></span>
                    </div>

                    <div class="form__field form__field--check">
                        <label class="checkbox">
                            <input type="checkbox" id="agree" name="agree" value="1" required>
                            <span class="checkbox__box" aria-hidden="true"></span>
                            <span class="checkbox__text">Согласен на обработку персональных данных</span>
                        </label>
                        <span class="form__error" data-error-for="agree"></span>
                    </div>

                    <button class="btn btn--accent btn--block" type="submit" id="submitBtn">
                        <span class="btn__text">Отправить заявку</span>
                        <span class="btn__loader" aria-hidden="true"></span>
                    </button>

                    <!-- Общая ошибка сервера / сети -->
                    <p class="form__status" id="formStatus" role="alert"></p>
                </form>
            </div>
        </div>
    </section>
</main>

<!-- ========== ФУТЕР ========== -->
<footer class="footer" id="contacts">
    <div class="container footer__inner">
        <div class="footer__brand">
            <span class="logo__text logo__text--light">Express<span>Logist</span></span>
            <a href="tel:88005553535" class="footer__phone">8 (800) 555-35-35</a>
        </div>
        <p class="footer__copy">© 2026 ExpressLogist. Все права защищены</p>
        <a href="#" class="footer__link">Политика конфиденциальности</a>
    </div>
</footer>

<!-- ========== ВСПЛЫВАЮЩЕЕ СООБЩЕНИЕ ОБ УСПЕХЕ ========== -->
<div class="modal" id="successModal" role="dialog" aria-modal="true" aria-labelledby="successTitle" hidden>
    <div class="modal__backdrop" data-close></div>
    <div class="modal__box">
        <div class="modal__icon" aria-hidden="true">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
        </div>
        <h3 class="modal__title" id="successTitle">Заявка отправлена!</h3>
        <p class="modal__text">Спасибо! Наш менеджер свяжется с вами в течение 15 минут.</p>
        <button class="btn btn--primary" type="button" data-close>Отлично</button>
    </div>
</div>

<script src="js/script.js" defer></script>
</body>
</html>
