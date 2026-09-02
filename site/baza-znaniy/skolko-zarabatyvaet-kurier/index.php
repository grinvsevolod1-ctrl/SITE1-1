<?php
/**
 * Статья силоса «База знаний для соискателей».
 * Главная (/) → База знаний (/baza-znaniy/) → Сколько зарабатывает курьер
 */

require __DIR__ . '/../../inc/config.php';
require __DIR__ . '/../../inc/nav-data.php';

$pageTitle = 'Сколько зарабатывает курьер в ExpressLogist — доход по маршрутам';
$pageDescription = 'Разбор дохода курьера ExpressLogist: сдельная ставка по типам маршрутов, бонусы за стаж и что влияет на итоговую сумму в месяц.';
$canonical = $baseUrl . '/baza-znaniy/skolko-zarabatyvaet-kurier/';

$breadcrumbs = [
    ['label' => 'Главная', 'url' => '/'],
    ['label' => 'База знаний для соискателей', 'url' => '/baza-znaniy/'],
    ['label' => 'Сколько зарабатывает курьер', 'url' => null],
];

$sidebarSection = 'knowledge';
$sidebarCurrent = '/baza-znaniy/skolko-zarabatyvaet-kurier/';

$faq = [
    [
        'q' => 'Ставка фиксированная или зависит от количества доставок?',
        'a' => 'Оплата сдельная: чем больше доставок за смену, тем выше доход. Указанные в статье суммы — типичный результат при полной загрузке маршрута и графике 5/2 или 2/2.',
    ],
    [
        'q' => 'Когда начисляются бонусы за стаж?',
        'a' => 'Бонусы за стаж начисляются ежемесячно и растут по фиксированной шкале — первое повышение происходит уже после первого полного месяца работы.',
    ],
    [
        'q' => 'Можно ли совмещать пешие и авто-маршруты для увеличения дохода?',
        'a' => 'В большинстве городов курьер закрепляется за одним типом маршрута на смену, но по согласованию с менеджером можно перейти на маршрут с более высокой ставкой, если есть свободные места.',
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
        <div class="container layout">
            <div>
                <h1 class="hero__title" style="font-size: 40px;">Сколько зарабатывает курьер</h1>
                <p class="article__lead">
                    Оплата сдельная — доход зависит от количества доставок, типа маршрута и стажа.
                    Ниже — ориентировочные суммы при полной загрузке смены.
                </p>

                <div class="article__body">
                    <h2>Доход по типам маршрутов</h2>
                    <table class="compare-table">
                        <thead>
                            <tr>
                                <th scope="col">Тип маршрута</th>
                                <th scope="col">Средний доход в месяц</th>
                                <th scope="col">Особенность</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">Пешая доставка</th>
                                <td>от 90 000 ₽</td>
                                <td>Плотные городские маршруты, короткие расстояния</td>
                            </tr>
                            <tr>
                                <th scope="row">Велодоставка</th>
                                <td>от 95 000 ₽</td>
                                <td>Больше доставок за смену за счёт скорости</td>
                            </tr>
                            <tr>
                                <th scope="row">Авто-маршрут</th>
                                <td>от 100 000 ₽</td>
                                <td>Топливная карта включена, длинные маршруты</td>
                            </tr>
                        </tbody>
                    </table>

                    <h2>Бонусы за стаж</h2>
                    <p>
                        Ежемесячный бонус растёт по фиксированной шкале: первое повышение — после
                        первого полного месяца, следующее — после трёх месяцев, далее — раз в квартал.
                        Бонус начисляется автоматически и не требует отдельного заявления.
                    </p>

                    <h2>Что влияет на итоговую сумму</h2>
                    <ul>
                        <li><strong>Город.</strong> В крупных городах с высокой плотностью заказов доход выше за счёт большего числа доставок за смену.</li>
                        <li><strong>Тип маршрута.</strong> Авто и велодоставка обычно дают больше доставок в час, чем пешие маршруты.</li>
                        <li><strong>Стаж.</strong> Ежемесячные бонусы за стаж увеличивают доход без изменения ставки за доставку.</li>
                        <li><strong>График.</strong> При графике 5/2 доход стабильнее по неделям, при 2/2 — выше пиковая нагрузка в рабочие дни.</li>
                    </ul>

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
                        <p>Узнайте точные цифры для вашего города у менеджера.</p>
                        <a href="/#form" class="btn btn--accent">Оставить заявку</a>
                    </div>
                </div>
            </div>

            <?php include __DIR__ . '/../../inc/sidebar.php'; ?>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../../inc/footer.php'; ?>
</body>
</html>
