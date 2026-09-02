<?php
/**
 * Единый реестр разделов сайта (SILO-структура).
 * Используется в inc/header.php (главное меню), inc/sidebar.php (навигация
 * по разделу) и как справочник при обновлении sitemap.xml.
 *
 * Главная (/)
 *  ├─ Услуги (/uslugi/)
 *  │   ├─ Крупногабаритная доставка
 *  │   ├─ Сборные грузы (LTL)
 *  │   ├─ Отдельная машина (FTL)
 *  │   └─ Складское хранение и фулфилмент
 *  ├─ Направления по СНГ (/napravleniya/)
 *  │   └─ Россия, Беларусь, Казахстан, Армения, Кыргызстан, Узбекистан,
 *  │      Азербайджан, Таджикистан, Молдова
 *  ├─ Водителям (/voditelyam/)
 *  │   ├─ Дальнобойщикам (межгород и СНГ)
 *  │   ├─ Водителям в черте города
 *  │   └─ Владельцам собственных машин
 *  ├─ О компании (/o-kompanii/)
 *  ├─ Контакты (/kontakty/)
 *  └─ Политика конфиденциальности (/politika-konfidencialnosti/)
 */

$siloNav = [
    'services' => [
        'title' => 'Услуги',
        'url' => '/uslugi/',
        'pages' => [
            ['title' => 'Крупногабаритная доставка', 'url' => '/uslugi/krupnogabaritnaya-dostavka/'],
            ['title' => 'Сборные грузы (LTL)', 'url' => '/uslugi/sbornye-gruzy/'],
            ['title' => 'Отдельная машина (FTL)', 'url' => '/uslugi/otdelnaya-mashina/'],
            ['title' => 'Складское хранение и фулфилмент', 'url' => '/uslugi/sklad-i-fulfilment/'],
        ],
    ],
    'directions' => [
        'title' => 'Направления по СНГ',
        'url' => '/napravleniya/',
        'pages' => [
            ['title' => 'Доставка по России', 'url' => '/napravleniya/rossiya/'],
            ['title' => 'Доставка в Беларусь', 'url' => '/napravleniya/belarus/'],
            ['title' => 'Доставка в Казахстан', 'url' => '/napravleniya/kazahstan/'],
            ['title' => 'Доставка в Армению', 'url' => '/napravleniya/armeniya/'],
            ['title' => 'Доставка в Кыргызстан', 'url' => '/napravleniya/kyrgyzstan/'],
            ['title' => 'Доставка в Узбекистан', 'url' => '/napravleniya/uzbekistan/'],
            ['title' => 'Доставка в Азербайджан', 'url' => '/napravleniya/azerbaydzhan/'],
            ['title' => 'Доставка в Таджикистан', 'url' => '/napravleniya/tadzhikistan/'],
            ['title' => 'Доставка в Молдову', 'url' => '/napravleniya/moldova/'],
        ],
    ],
    'drivers' => [
        'title' => 'Водителям',
        'url' => '/voditelyam/',
        'pages' => [
            ['title' => 'Дальнобойщикам: межгород и СНГ', 'url' => '/voditelyam/dalnoboyshchikam/'],
            ['title' => 'Водителям в черте города', 'url' => '/voditelyam/v-gorode/'],
            ['title' => 'Владельцам собственных машин', 'url' => '/voditelyam/so-svoim-avto/'],
        ],
    ],
];

/** Плоский список самостоятельных страниц (без подстраниц) */
$standaloneNav = [
    ['title' => 'О компании', 'url' => '/o-kompanii/'],
    ['title' => 'Контакты', 'url' => '/kontakty/'],
    ['title' => 'Политика конфиденциальности', 'url' => '/politika-konfidencialnosti/'],
];
