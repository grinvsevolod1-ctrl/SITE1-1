<?php
/**
 * Универсальный шаблон контент-страницы (услуга / страна / статья).
 *
 * Перед подключением задайте:
 *   $pageTitle, $pageDescription, $pageUrl, $assetsPrefix, $navActive  — как обычно (для head/header)
 *   $sidebarSection (string)  — ключ раздела для сайдбара: 'services'|'directions'|'drivers'
 *   $sidebarCurrent (string)  — URL текущей страницы (подсветка в сайдбаре)
 *   $crumbs (array)           — хлебные крошки [['title'=>..,'url'=>..], ...]
 *   $hero (array)             — ['h1'=>string, 'lead'=>string]
 *   $blocks (array)           — массив блоков контента, каждый — ассоц. массив:
 *        ['type'=>'p',     'text'=>string]
 *        ['type'=>'h2',    'text'=>string]
 *        ['type'=>'h3',    'text'=>string]
 *        ['type'=>'lead',  'text'=>string]
 *        ['type'=>'list',  'items'=>[string, ...]]
 *        ['type'=>'table', 'head'=>[..], 'rows'=>[[..],[..]]]
 *        ['type'=>'faq',   'items'=>[['q'=>..,'a'=>..], ...]]
 *        ['type'=>'cta',   'title'=>string, 'text'=>string]
 *        ['type'=>'html',  'html'=>string]   // уже безопасный HTML
 *
 * Требует config.php, nav-data.php (подключить до этого файла).
 */

/* ---------- Автогенерация Schema.org (JSON-LD) ---------- */
$schemaGraph = [];

// BreadcrumbList из хлебных крошек
if (!empty($crumbs)) {
    $items = [];
    $pos = 1;
    foreach ($crumbs as $cr) {
        $entry = [
            '@type'    => 'ListItem',
            'position' => $pos,
            'name'     => $cr['title'],
        ];
        // Абсолютный URL для всех крошек, кроме текущей (url === null)
        if (!empty($cr['url'])) {
            $entry['item'] = rtrim($baseUrl, '/') . $cr['url'];
        }
        $items[] = $entry;
        $pos++;
    }
    $schemaGraph[] = [
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $items,
    ];
}

// FAQPage из первого блока типа faq
foreach ($blocks as $b) {
    if (($b['type'] ?? '') === 'faq' && !empty($b['items'])) {
        $qa = [];
        foreach ($b['items'] as $f) {
            $qa[] = [
                '@type'          => 'Question',
                'name'           => $f['q'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
            ];
        }
        $schemaGraph[] = ['@type' => 'FAQPage', 'mainEntity' => $qa];
        break; // одна FAQPage на страницу
    }
}

// Дополнительная разметка страницы (например, Service) — задаётся до подключения шаблона
if (!empty($pageSchema) && is_array($pageSchema)) {
    $schemaGraph[] = $pageSchema;
}

if ($schemaGraph) {
    $ld = ['@context' => 'https://schema.org'];
    $ld['@graph'] = $schemaGraph;
    $json = json_encode($ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    $extraHead = ($extraHead ?? '') . '<script type="application/ld+json">' . $json . '</script>';
}

require INC . '/head.php';
require INC . '/header.php';
?>
<main id="main">
    <section class="page-hero">
        <div class="container">
            <h1><?php echo e($hero['h1']); ?></h1>
            <?php if (!empty($hero['lead'])): ?><p><?php echo e($hero['lead']); ?></p><?php endif; ?>
        </div>
    </section>

    <div class="container"><?php require INC . '/breadcrumbs.php'; ?></div>

    <section class="section section--tight">
        <div class="container">
            <div class="layout">
                <?php require INC . '/sidebar.php'; ?>

                <article class="article">
                    <?php foreach ($blocks as $b): ?>
                        <?php switch ($b['type']):
                            case 'p': ?>
                                <p><?php echo e($b['text']); ?></p>
                        <?php break; case 'lead': ?>
                                <p class="lead"><?php echo e($b['text']); ?></p>
                        <?php break; case 'h2': ?>
                                <h2><?php echo e($b['text']); ?></h2>
                        <?php break; case 'h3': ?>
                                <h3><?php echo e($b['text']); ?></h3>
                        <?php break; case 'list': ?>
                                <ul class="list">
                                    <?php foreach ($b['items'] as $li): ?><li><?php echo e($li); ?></li><?php endforeach; ?>
                                </ul>
                        <?php break; case 'table': ?>
                                <div class="table-wrap">
                                    <table class="data">
                                        <thead><tr><?php foreach ($b['head'] as $th): ?><th><?php echo e($th); ?></th><?php endforeach; ?></tr></thead>
                                        <tbody>
                                            <?php foreach ($b['rows'] as $row): ?>
                                            <tr><?php foreach ($row as $td): ?><td><?php echo e($td); ?></td><?php endforeach; ?></tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                        <?php break; case 'faq': ?>
                                <div class="faq">
                                    <?php foreach ($b['items'] as $f): ?>
                                    <div class="faq__item">
                                        <button class="faq__q" type="button" aria-expanded="false"><?php echo e($f['q']); ?></button>
                                        <div class="faq__a"><p><?php echo e($f['a']); ?></p></div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                        <?php break; case 'cta': ?>
                                <div class="cta-band" style="margin-top:8px">
                                    <div class="cta-band__text">
                                        <h2><?php echo e($b['title']); ?></h2>
                                        <p><?php echo e($b['text']); ?></p>
                                    </div>
                                    <div class="cta-band__actions">
                                        <a href="/#form" class="btn btn--accent">Получить расчёт</a>
                                        <a href="tel:<?php echo e($phoneHref); ?>" class="btn btn--outline-light"><?php echo e($phoneDisplay); ?></a>
                                    </div>
                                </div>
                        <?php break; case 'html': ?>
                                <?php echo $b['html']; ?>
                        <?php break; endswitch; ?>
                    <?php endforeach; ?>
                    <?php if (!empty($related)): ?>
                    <nav class="related" aria-label="Смотрите также">
                        <h2>Смотрите также</h2>
                        <div class="related__grid">
                            <?php foreach ($related as $rl): ?>
                            <a class="related__card" href="<?php echo e($rl['url']); ?>">
                                <span class="related__title"><?php echo e($rl['title']); ?></span>
                                <?php if (!empty($rl['desc'])): ?><span class="related__desc"><?php echo e($rl['desc']); ?></span><?php endif; ?>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </nav>
                    <?php endif; ?>
                </article>
            </div>
        </div>
    </section>
</main>
<?php require INC . '/footer.php'; ?>
