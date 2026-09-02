<?php
/**
 * Хлебные крошки: видимая навигация + микроразметка BreadcrumbList (JSON-LD).
 *
 * Перед подключением задайте:
 *   $breadcrumbs = [
 *       ['label' => 'Главная', 'url' => '/'],
 *       ['label' => 'О компании и условия работы', 'url' => '/o-kompanii/'],
 *       ['label' => 'Текущая страница', 'url' => null], // последний элемент без ссылки
 *   ];
 * $baseUrl должен быть подключён (site/inc/config.php) — используется для
 * абсолютных URL в JSON-LD.
 */
$breadcrumbs = $breadcrumbs ?? [];
?>
<nav class="breadcrumbs" aria-label="Хлебные крошки">
    <ol class="breadcrumbs__list">
        <?php foreach ($breadcrumbs as $crumb): ?>
        <li class="breadcrumbs__item">
            <?php if (!empty($crumb['url'])): ?>
            <a href="<?php echo htmlspecialchars($crumb['url'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($crumb['label'], ENT_QUOTES, 'UTF-8'); ?></a>
            <?php else: ?>
            <span aria-current="page"><?php echo htmlspecialchars($crumb['label'], ENT_QUOTES, 'UTF-8'); ?></span>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
    </ol>
</nav>
<script type="application/ld+json">
<?php
$itemListElement = [];
foreach ($breadcrumbs as $i => $crumb) {
    $item = [
        '@type' => 'ListItem',
        'position' => $i + 1,
        'name' => $crumb['label'],
    ];
    if (!empty($crumb['url'])) {
        $item['item'] = $baseUrl . $crumb['url'];
    }
    $itemListElement[] = $item;
}
echo json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => $itemListElement,
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
</script>
