<?php
/**
 * Единый реестр разделов сайта (SILO-структура).
 * Используется в inc/sidebar.php (навигация по разделу) и как справочник
 * при добавлении новых страниц — sitemap.xml обновляется вручную по этому списку.
 *
 * Главная (/)
 *  ├─ О компании и условия работы (/o-kompanii/)
 *  │   ├─ Сравнение с Wildberries и Ozon
 *  │   └─ Оформление и социальные гарантии
 *  ├─ База знаний для соискателей (/baza-znaniy/)
 *  │   ├─ Как стать курьером
 *  │   ├─ Документы для оформления
 *  │   ├─ Сколько зарабатывает курьер
 *  │   └─ График 2/2 и 5/2
 *  ├─ Вакансии по городам (/vakansii/)
 *  │   └─ 8 городов (Москва, СПб, Новосибирск, Екатеринбург, Казань,
 *  │      Нижний Новгород, Ростов-на-Дону, Краснодар)
 *  ├─ Контакты (/kontakty/)
 *  └─ Политика конфиденциальности (/politika-konfidencialnosti/)
 */

$siloNav = [
    'company' => [
        'title' => 'О компании и условия работы',
        'url' => '/o-kompanii/',
        'pages' => [
            ['title' => 'Сравнение с Wildberries и Ozon', 'url' => '/o-kompanii/sravnenie-s-wildberries-i-ozon/'],
            ['title' => 'Оформление и социальные гарантии', 'url' => '/o-kompanii/oformlenie-i-socgarantii/'],
        ],
    ],
    'knowledge' => [
        'title' => 'База знаний для соискателей',
        'url' => '/baza-znaniy/',
        'pages' => [
            ['title' => 'Как стать курьером: пошаговая инструкция', 'url' => '/baza-znaniy/kak-stat-kurierom/'],
            ['title' => 'Какие документы нужны для оформления', 'url' => '/baza-znaniy/dokumenty-dlya-oformleniya/'],
            ['title' => 'Сколько зарабатывает курьер', 'url' => '/baza-znaniy/skolko-zarabatyvaet-kurier/'],
            ['title' => 'График 2/2 и 5/2: как выбрать', 'url' => '/baza-znaniy/grafik-2-2-i-5-2/'],
        ],
    ],
    'vacancies' => [
        'title' => 'Вакансии по городам',
        'url' => '/vakansii/',
        'pages' => [
            ['title' => 'Курьер в Москве', 'url' => '/vakansii/moskva/'],
            ['title' => 'Курьер в Санкт-Петербурге', 'url' => '/vakansii/sankt-peterburg/'],
            ['title' => 'Курьер в Новосибирске', 'url' => '/vakansii/novosibirsk/'],
            ['title' => 'Курьер в Екатеринбурге', 'url' => '/vakansii/ekaterinburg/'],
            ['title' => 'Курьер в Казани', 'url' => '/vakansii/kazan/'],
            ['title' => 'Курьер в Нижнем Новгороде', 'url' => '/vakansii/nizhniy-novgorod/'],
            ['title' => 'Курьер в Ростове-на-Дону', 'url' => '/vakansii/rostov-na-donu/'],
            ['title' => 'Курьер в Краснодаре', 'url' => '/vakansii/krasnodar/'],
        ],
    ],
];

/** Плоский список самостоятельных страниц (не входят в SILO с подстраницами) */
$standaloneNav = [
    ['title' => 'Контакты', 'url' => '/kontakty/'],
    ['title' => 'Политика конфиденциальности', 'url' => '/politika-konfidencialnosti/'],
];
