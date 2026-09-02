<?php
/**
 * Боковая навигация для страниц силоса (категории и статьи).
 *
 * Перед подключением задайте:
 *   $sidebarSection  (string) — ключ раздела из $siloNav: 'services' | 'directions' | 'drivers'
 *   $sidebarCurrent  (string|null) — URL текущей страницы, чтобы подсветить активный пункт
 *
 * Требует $siloNav (site/inc/nav-data.php) — подключить до этого файла.
 */
$sidebarSection = $sidebarSection ?? null;
$sidebarCurrent = $sidebarCurrent ?? null;
$section = $sidebarSection && isset($siloNav[$sidebarSection]) ? $siloNav[$sidebarSection] : null;
$phoneHref    = $phoneHref ?? '88005553535';
$phoneDisplay = $phoneDisplay ?? '8 (800) 555-35-35';
?>
<aside class="sidebar" aria-label="Навигация по разделу">
    <?php if ($section): ?>
    <div class="sidebar__group">
        <p class="sidebar__heading">В этом разделе</p>
        <nav>
            <ul class="sidebar__list">
                <li>
                    <a href="<?php echo htmlspecialchars($section['url'], ENT_QUOTES, 'UTF-8'); ?>"
                       class="sidebar__link<?php echo $sidebarCurrent === $section['url'] ? ' is-active' : ''; ?>">
                        <?php echo htmlspecialchars($section['title'], ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                </li>
                <?php foreach ($section['pages'] as $page): ?>
                <li>
                    <a href="<?php echo htmlspecialchars($page['url'], ENT_QUOTES, 'UTF-8'); ?>"
                       class="sidebar__link sidebar__link--sub<?php echo $sidebarCurrent === $page['url'] ? ' is-active' : ''; ?>">
                        <?php echo htmlspecialchars($page['title'], ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </div>
    <?php endif; ?>

    <div class="sidebar__group">
        <p class="sidebar__heading">Другие разделы</p>
        <nav>
            <ul class="sidebar__list">
                <?php foreach ($siloNav as $key => $other): ?>
                    <?php if ($key === $sidebarSection) continue; ?>
                <li>
                    <a href="<?php echo htmlspecialchars($other['url'], ENT_QUOTES, 'UTF-8'); ?>" class="sidebar__link">
                        <?php echo htmlspecialchars($other['title'], ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                </li>
                <?php endforeach; ?>
                <li><a href="/kontakty/" class="sidebar__link">Контакты</a></li>
            </ul>
        </nav>
    </div>

    <div class="sidebar__cta">
        <p>Нужен расчёт доставки?</p>
        <a href="/#form" class="btn btn--accent btn--block">Оставить заявку</a>
        <a href="tel:<?php echo htmlspecialchars($phoneHref, ENT_QUOTES, 'UTF-8'); ?>" class="sidebar__phone"><?php echo htmlspecialchars($phoneDisplay, ENT_QUOTES, 'UTF-8'); ?></a>
    </div>
</aside>
