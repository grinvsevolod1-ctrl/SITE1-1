<?php
/**
 * Категория силоса: «О компании и условия работы».
 * Главная (/) → О компании и условия работы (/o-kompanii/) → Статья (/o-kompanii/sravnenie-s-wildberries-i-ozon/)
 */

require __DIR__ . '/../inc/config.php';

$pageTitle = 'О компании и условия работы курьером в ExpressLogist';
$pageDescription = 'ExpressLogist — федеральная служба доставки: официальное оформление, сдельная оплата от 90 000 ₽, соцпакет и график 5/2 или 2/2. Сравнение условий с Wildberries и Ozon.';
$canonical = $baseUrl . '/o-kompanii/';

$breadcrumbs = [
    ['label' => 'Главная', 'url' => '/'],
    ['label' => 'О компании и условия работы', 'url' => null],
];

$faq = [
    [
        'q' => 'Нужен ли личный автомобиль, чтобы стать курьером?',
        'a' => 'Нет. В ExpressLogist есть пешие, велокурьеры и авто-маршруты — тип развозки подбирает региональный менеджер по вашему городу и предпочтениям. Для авто-маршрутов компания выдаёт топливную карту, личный автомобиль не обязателен.',
    ],
    [
        'q' => 'Сколько времени занимает оформление на работу?',
        'a' => 'От заявки до первой смены обычно проходит 1–2 рабочих дня: звонок менеджера в течение 15 минут, короткое собеседование и подписание трудового договора в отделении или дистанционно.',
    ],
    [
        'q' => 'Какие документы нужны для трудоустройства?',
        'a' => 'Паспорт РФ (для иностранных граждан — разрешение на работу или патент) и СНИЛС. ИНН и медкнижка не требуются для базовых маршрутов доставки.',
    ],
    [
        'q' => 'Можно ли совмещать работу курьером с учёбой или другой работой?',
        'a' => 'Да, для этого предусмотрены смены 2/2 и гибкие подработки на несколько часов в день — график согласовывается с региональным менеджером индивидуально.',
    ],
    [
        'q' => 'Как часто выплачивается зарплата?',
        'a' => 'Два раза в месяц, без задержек: аванс и окончательный расчёт переводятся на карту в фиксированные даты, указанные в трудовом договоре.',
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

<?php $isHome = false; include __DIR__ . '/../inc/header.php'; ?>

<?php include __DIR__ . '/../inc/breadcrumbs.php'; ?>

<main>
    <section class="article section">
        <div class="container">
            <h1 class="hero__title" style="font-size: 40px;">О компании и условия работы курьером</h1>
            <p class="article__lead">
                ExpressLogist — федеральная служба доставки, работающая в 150+ городах России.
                Мы официально оформляем каждого курьера, платим сдельно от 90&nbsp;000&nbsp;₽ в месяц
                и полностью обеспечиваем всем необходимым для смены: формой, топливными картами и страховкой.
            </p>

            <div class="article__body">
                <h2>Кто мы</h2>
                <p>
                    Компания на рынке экспресс-доставки уже несколько лет и обслуживает более 50&nbsp;000
                    доставок в день силами штата свыше 2&nbsp;500 курьеров. Мы работаем как с частными
                    заказчиками, так и с крупными интернет-магазинами и маркетплейсами, поэтому маршруты
                    и объём заказов у наших курьеров стабильны в течение всего года, а не только в сезон
                    распродаж.
                </p>

                <h2>Условия работы курьером</h2>
                <ul>
                    <li>Официальное оформление по трудовому договору с первого рабочего дня — запись в трудовую книжку и отчисления идут с даты выхода на смену.</li>
                    <li>Сдельная оплата от 90&nbsp;000&nbsp;₽ в месяц плюс ежемесячные бонусы за стаж и выполнение плана.</li>
                    <li>Гибкий график смен 5/2 или 2/2 — можно подобрать под учёбу или вторую работу.</li>
                    <li>Полное обеспечение: форма, топливная карта для авто-маршрутов, страховка на весь период работы.</li>
                    <li>Выплаты два раза в месяц строго по датам, указанным в трудовом договоре.</li>
                    <li>Закреплённый региональный менеджер, который помогает с маршрутами и решает рабочие вопросы.</li>
                </ul>

                <h2>Чем условия ExpressLogist отличаются от Wildberries и Ozon</h2>
                <p>
                    Многие соискатели сравнивают вакансии курьера у крупных маркетплейсов с работой в
                    ExpressLogist. Разница в первую очередь в форме оформления и стабильности выплат —
                    ниже сводная таблица по типовым условиям на конец 2025&nbsp;— начало 2026&nbsp;года.
                </p>
                <table class="compare-table">
                    <thead>
                        <tr>
                            <th scope="col">Критерий</th>
                            <th scope="col">ExpressLogist</th>
                            <th scope="col">Типовые условия партнёров WB и Ozon</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Оформление</th>
                            <td>Трудовой договор с первого дня</td>
                            <td>Часто только самозанятость или договор ГПХ</td>
                        </tr>
                        <tr>
                            <th scope="row">Ставка</th>
                            <td>Фиксированная сдельная + бонус за стаж</td>
                            <td>Зависит от количества заказов и может меняться по регионам</td>
                        </tr>
                        <tr>
                            <th scope="row">Обеспечение</th>
                            <td>Форма, топливная карта, страховка от компании</td>
                            <td>Расходы на топливо и форму часто на стороне курьера</td>
                        </tr>
                        <tr>
                            <th scope="row">Выплаты</th>
                            <td>2 раза в месяц по фиксированным датам</td>
                            <td>Через агрегатора-партнёра, сроки могут отличаться</td>
                        </tr>
                        <tr>
                            <th scope="row">Поддержка</th>
                            <td>Закреплённый региональный менеджер</td>
                            <td>Чат-поддержка агрегатора без личного менеджера</td>
                        </tr>
                    </tbody>
                </table>
                <p class="article__note">
                    Условия у сервис-партнёров Wildberries и Ozon отличаются по регионам и юридическому
                    статусу оформления. Сравнение приведено усреднённо на основе открытых вакансий и
                    отзывов курьеров и не является официальной позицией маркетплейсов.
                </p>
                <p>
                    <a href="/o-kompanii/sravnenie-s-wildberries-i-ozon/">Подробное сравнение условий ExpressLogist, Wildberries и Ozon →</a>
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
                    <p>Готовы начать? Оставьте заявку — менеджер свяжется в течение 15 минут.</p>
                    <a href="/#form" class="btn btn--accent">Оставить заявку</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../inc/footer.php'; ?>
</body>
</html>
