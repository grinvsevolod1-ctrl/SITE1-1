<?php
/**
 * Страница 404 — «страница не найдена».
 * Подключается через директиву ErrorDocument в .htaccess.
 * Отдаёт корректный HTTP-статус 404 и предлагает переход в основные разделы.
 */
require __DIR__ . '/inc/config.php';
require __DIR__ . '/inc/nav-data.php';

http_response_code(404);

$pageTitle       = 'Страница не найдена (404) — ' . $siteName;
$pageDescription = 'Запрошенная страница не найдена. Вернитесь на главную или выберите нужный раздел.';
$pageUrl         = '/404';
$assetsPrefix    = '';
$navActive       = null;
$extraHead       = '<meta name="robots" content="noindex, follow">';

require __DIR__ . '/inc/head.php';
require __DIR__ . '/inc/header.php';
?>
<main id="main">
    <section class="section section--navy error-page">
        <div class="container error-page__inner">
            <span class="error-page__code">404</span>
            <h1 class="error-page__title">Такой страницы нет</h1>
            <p class="error-page__text">
                Возможно, ссылка устарела или содержит ошибку. Давайте вернёмся к делу —
                выберите нужный раздел или оставьте заявку на расчёт доставки.
            </p>
            <div class="error-page__actions">
                <a href="/" class="btn btn--accent">На главную</a>
                <a href="/uslugi/" class="btn btn--outline-light">Услуги</a>
                <a href="/napravleniya/" class="btn btn--outline-light">Направления</a>
                <a href="/kontakty/" class="btn btn--outline-light">Контакты</a>
            </div>
        </div>
    </section>
</main>
<?php require __DIR__ . '/inc/footer.php'; ?>
