<?php
/**
 * Статья силоса: «Сравнение условий ExpressLogist, Wildberries и Ozon».
 * Главная (/) → О компании и условия работы (/o-kompanii/) → эта статья
 */

require __DIR__ . '/../../inc/config.php';

$pageTitle = 'Курьер ExpressLogist или Wildberries/Ozon: сравнение условий и оплаты';
$pageDescription = 'Сравниваем оформление, оплату, обеспечение и выплаты курьера ExpressLogist с типовыми условиями сервис-партнёров Wildberries и Ozon.';
$canonical = $baseUrl . '/o-kompanii/sravnenie-s-wildberries-i-ozon/';

$breadcrumbs = [
    ['label' => 'Главная', 'url' => '/'],
    ['label' => 'О компании и условия работы', 'url' => '/o-kompanii/'],
    ['label' => 'Сравнение с Wildberries и Ozon', 'url' => null],
];

$faq = [
    [
        'q' => 'Можно ли одновременно быть самозанятым курьером у партнёра Wildberries или Ozon и работать в ExpressLogist?',
        'a' => 'Нет, если вы оформлены по трудовому договору в ExpressLogist на полную смену — совмещение с другой регулярной курьерской занятостью ограничено графиком. При смене 2/2 подработка в свободные дни не запрещена, если это не создаёт конфликта интересов с текущим маршрутом.',
    ],
    [
        'q' => 'Почему трудовой договор выгоднее самозанятости для курьера?',
        'a' => 'Трудовой договор даёт оплачиваемый отпуск, больничный, стаж для пенсии и гарантированную минимальную ставку независимо от количества заказов — при самозанятости эти гарантии отсутствуют, а доход полностью зависит от объёма выполненных доставок.',
    ],
    [
        'q' => 'Что будет с доходом, если в городе меньше заказов, чем обычно?',
        'a' => 'У курьеров ExpressLogist есть гарантированная сдельная ставка и фиксированные бонусы за стаж, которые не зависят от сезонных колебаний спроса — в отличие от чисто заказной оплаты у большинства сервис-партнёров маркетплейсов.',
    ],
];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="theme-color" content="#1A73E8">
    <link rel="canonical" href="<?php echo htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8'); ?>">

    <meta property="og:type" content="article">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:site_name" content="ExpressLogist">
    <meta property="og:title" content="<?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:image" content="<?php echo htmlspecialchars($baseUrl, ENT_QUOTES, 'UTF-8'); ?>/img/hero-courier.webp">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">

    <!-- FAQPage JSON-LD -->
    <script type="application/ld+json">
    <?php echo json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => array_map(static function (array $item): array {
            return [
                '@type' => 'Question',
                'name' => $item['q'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item['a']],
            ];
        }, $faq),
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>
    </script>
</head>
<body>

<?php $isHome = false; include __DIR__ . '/../../inc/header.php'; ?>

<?php include __DIR__ . '/../../inc/breadcrumbs.php'; ?>

<main>
    <section class="article section">
        <div class="container">
            <h1 class="hero__title" style="font-size: 40px;">
                Курьер ExpressLogist или Wildberries/Ozon: что выгоднее
            </h1>
            <p class="article__lead">
                Разбираем по пунктам, чем оформление и оплата курьера в ExpressLogist отличаются
                от типовых условий у сервис-партнёров крупных маркетплейсов — Wildberries и Ozon.
            </p>

            <div class="article__body">
                <h2>Оформление: трудовой договор против самозанятости</h2>
                <p>
                    В ExpressLogist курьер устраивается по трудовому договору с первого дня — это
                    даёт официальный стаж, оплачиваемый отпуск и больничный. У большинства
                    сервис-партнёров маркетплейсов курьеры оформляются как самозанятые или по
                    договору ГПХ, что означает отсутствие этих социальных гарантий и полную
                    зависимость дохода от количества выполненных заказов.
                </p>

                <h2>Оплата: фиксированная ставка против оплаты за заказ</h2>
                <p>
                    Наша сдельная ставка от 90&nbsp;000&nbsp;₽ в месяц не зависит от сезонных
                    провалов спроса и дополняется ежемесячными бонусами за стаж. Оплата за заказ
                    у агрегаторов-партнёров маркетплейсов может резко колебаться: в межсезонье
                    количество заказов падает, а тариф за доставку пересматривается регионально.
                </p>

                <h2>Обеспечение и поддержка</h2>
                <p>
                    Форма, топливная карта для авто-маршрутов и страховка предоставляются
                    ExpressLogist бесплатно, а рабочие вопросы решает закреплённый региональный
                    менеджер. У сервис-партнёров маркетплейсов расходы на топливо и форму нередко
                    частично или полностью лежат на курьере, а поддержка ограничена общим чатом
                    агрегатора.
                </p>

                <h2>Итоговое сравнение</h2>
                <table class="compare-table">
                    <thead>
                        <tr>
                            <th scope="col">Параметр</th>
                            <th scope="col">ExpressLogist</th>
                            <th scope="col">WB / Ozon (типовые условия партнёров)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Гарантия дохода</th>
                            <td>Фиксированная сдельная ставка + бонусы</td>
                            <td>Зависит от количества заказов в сезон</td>
                        </tr>
                        <tr>
                            <th scope="row">Соцпакет</th>
                            <td>Отпуск, больничный, стаж</td>
                            <td>Обычно отсутствует при самозанятости</td>
                        </tr>
                        <tr>
                            <th scope="row">Расходы курьера</th>
                            <td>Форма и топливо предоставляет компания</td>
                            <td>Часто частично на стороне курьера</td>
                        </tr>
                        <tr>
                            <th scope="row">Поддержка</th>
                            <td>Личный региональный менеджер</td>
                            <td>Общий чат-поддержки агрегатора</td>
                        </tr>
                    </tbody>
                </table>
                <p class="article__note">
                    Данные приведены усреднённо по открытым вакансиям и отзывам курьеров на
                    конец 2025&nbsp;— начало 2026&nbsp;года и могут отличаться по регионам и
                    конкретному сервис-партнёру. Материал не является официальной позицией
                    Wildberries или Ozon.
                </p>

                <h2>Частые вопросы</h2>
                <div class="faq">
                    <?php foreach ($faq as $item): ?>
                    <details class="faq__item">
                        <summary><?php echo htmlspecialchars($item['q'], ENT_QUOTES, 'UTF-8'); ?></summary>
                        <p><?php echo htmlspecialchars($item['a'], ENT_QUOTES, 'UTF-8'); ?></p>
                    </details>
                    <?php endforeach; ?>
                </div>

                <div class="article__cta">
                    <p>Хотите работать на стабильных условиях? Оставьте заявку сейчас.</p>
                    <a href="/#form" class="btn btn--accent">Оставить заявку</a>
                </div>

                <p class="article__note">
                    <a href="/o-kompanii/">← Назад: о компании и условия работы</a>
                </p>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../../inc/footer.php'; ?>
</body>
</html>
