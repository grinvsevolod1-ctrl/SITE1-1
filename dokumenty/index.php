<?php
/**
 * Страница «Документы и лицензии» — сигнал доверия для клиентов и модерации.
 * Индексируемая. Список документов формируется из массива $documents;
 * реальные файлы (PDF/скан) добавляются в /docs/ и подключаются по мере готовности.
 */

require __DIR__ . '/../inc/config.php';
require __DIR__ . '/../inc/nav-data.php';

$pageTitle       = 'Документы и лицензии — ' . $siteName;
$pageDescription = 'Учредительные и разрешительные документы ' . $siteName . ': свидетельства, договоры, страхование ответственности перевозчика и условия сотрудничества.';
$pageUrl         = '/dokumenty/';
$assetsPrefix    = '../';
$navActive       = null;

$crumbs = [
    ['title' => 'Главная', 'url' => '/'],
    ['title' => 'Документы и лицензии', 'url' => null],
];

require __DIR__ . '/../inc/head.php';
require __DIR__ . '/../inc/header.php';

/*
 * Реестр документов. Чтобы опубликовать документ:
 *  1. Положите файл в папку /docs/ (например, /docs/svidetelstvo-ogrn.pdf)
 *  2. Укажите путь в поле 'file'. Пока файла нет — оставьте 'file' => null,
 *     и документ покажется как «предоставляется по запросу».
 */
$documents = [
    [
        'title' => 'Свидетельство о регистрации (ОГРН)',
        'desc'  => 'Подтверждает регистрацию компании в качестве юридического лица.',
        'file'  => null,
    ],
    [
        'title' => 'Свидетельство о постановке на учёт (ИНН)',
        'desc'  => 'Подтверждает постановку на налоговый учёт.',
        'file'  => null,
    ],
    [
        'title' => 'Страхование ответственности перевозчика',
        'desc'  => 'Полис страхования ответственности за сохранность перевозимого груза.',
        'file'  => null,
    ],
    [
        'title' => 'Типовой договор перевозки',
        'desc'  => 'Форма договора транспортно-экспедиционного обслуживания для юридических лиц.',
        'file'  => null,
    ],
    [
        'title' => 'Публичная оферта',
        'desc'  => 'Общие условия оказания транспортно-экспедиционных услуг.',
        'file'  => '/oferta/',
    ],
];
?>
<main id="main">
    <section class="page-hero">
        <div class="container">
            <h1>Документы и лицензии</h1>
            <p>Работаем официально по договору с полным пакетом документов и закрывающих актов для бухгалтерии.</p>
        </div>
    </section>

    <div class="container"><?php require __DIR__ . '/../inc/breadcrumbs.php'; ?></div>

    <section class="section section--tight">
        <div class="container">
            <div class="layout">
                <div class="layout__main">
                    <article class="article article--narrow">
                        <p class="lead">
                            <?php echo e($siteName); ?> — официальный перевозчик. Все услуги оказываются
                            на основании договора, с оформлением полного комплекта перевозочных
                            и бухгалтерских документов (счёт, акт, транспортная накладная, счёт-фактура
                            при работе с НДС).
                        </p>

                        <div class="doc-list">
                            <?php foreach ($documents as $doc): ?>
                            <div class="doc-item">
                                <div class="doc-item__icon" aria-hidden="true">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                    </svg>
                                </div>
                                <div class="doc-item__body">
                                    <h3 class="doc-item__title"><?php echo e($doc['title']); ?></h3>
                                    <p class="doc-item__desc"><?php echo e($doc['desc']); ?></p>
                                </div>
                                <div class="doc-item__action">
                                    <?php if (!empty($doc['file'])): ?>
                                        <a class="btn btn--ghost btn--sm" href="<?php echo e($doc['file']); ?>"<?php echo (substr($doc['file'], -4) === '.pdf' ? ' target="_blank" rel="noopener"' : ''); ?>>Открыть</a>
                                    <?php else: ?>
                                        <span class="doc-item__badge">По запросу</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <h2>Как мы работаем с документами</h2>
                        <ul class="list">
                            <li>заключаем договор перевозки до начала работ;</li>
                            <li>предоставляем полный пакет закрывающих документов;</li>
                            <li>работаем с НДС и без НДС — под вашу форму учёта;</li>
                            <li>по запросу направляем учредительные и разрешительные документы.</li>
                        </ul>

                        <div class="notice notice--info">
                            <p>
                                Нужен конкретный документ для проверки контрагента или тендера?
                                Напишите на <a href="mailto:<?php echo e($email); ?>"><?php echo e($email); ?></a>
                                или позвоните по телефону
                                <a href="tel:<?php echo e($phoneHref); ?>"><?php echo e($phoneDisplay); ?></a>
                                — вышлем в течение рабочего дня.
                            </p>
                        </div>
                    </article>
                </div>

                <aside class="layout__aside">
                    <?php require __DIR__ . '/../inc/sidebar.php'; ?>
                </aside>
            </div>
        </div>
    </section>
</main>
<?php require __DIR__ . '/../inc/footer.php'; ?>
