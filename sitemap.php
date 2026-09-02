<?php
/**
 * Динамическая карта сайта. Строится из inc/nav-data.php, поэтому всегда
 * актуальна при добавлении страниц. Отдаётся по адресу /sitemap.xml
 * (см. правило RewriteRule в .htaccess).
 */

require __DIR__ . '/inc/config.php';
require __DIR__ . '/inc/nav-data.php';

header('Content-Type: application/xml; charset=utf-8');

/* Собираем плоский список URL с приоритетами */
$urls = [];
$urls[] = ['loc' => '/', 'priority' => '1.0', 'freq' => 'daily'];

foreach ($siloNav as $section) {
    $urls[] = ['loc' => $section['url'], 'priority' => '0.9', 'freq' => 'weekly'];
    foreach ($section['pages'] as $page) {
        $urls[] = ['loc' => $page['url'], 'priority' => '0.8', 'freq' => 'weekly'];
    }
}

/* Калькулятор стоимости — отдельная индексируемая страница */
$urls[] = ['loc' => '/kalkulyator/', 'priority' => '0.7', 'freq' => 'monthly'];

/* Самостоятельные страницы (кроме политики — она noindex) */
foreach ($standaloneNav as $page) {
    if ($page['url'] === '/politika-konfidencialnosti/') {
        continue;
    }
    $urls[] = ['loc' => $page['url'], 'priority' => '0.5', 'freq' => 'monthly'];
}

$today = date('Y-m-d');

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach ($urls as $u) {
    echo "  <url>\n";
    echo '    <loc>' . e($baseUrl . $u['loc']) . "</loc>\n";
    echo '    <lastmod>' . $today . "</lastmod>\n";
    echo '    <changefreq>' . $u['freq'] . "</changefreq>\n";
    echo '    <priority>' . $u['priority'] . "</priority>\n";
    echo "  </url>\n";
}
echo '</urlset>' . "\n";
