/**
 * Прослойка ТОЛЬКО для превью в v0 (в песочнице нет PHP).
 * На реальном хостинге используется папка site/ напрямую (Apache + PHP).
 *
 * Здесь мы эмулируем минимальную логику index.php и страниц силоса:
 *  - вырезаем PHP-блоки,
 *  - разворачиваем циклы (города, статьи хаба, карточки городов),
 *  - подставляем шапку/футер/сайдбар/breadcrumbs/FAQ как чистый HTML.
 */
import { promises as fs } from 'node:fs'
import path from 'node:path'

export const SITE_DIR = path.join(process.cwd(), 'site')

export const CITIES = [
  'Москва', 'Санкт-Петербург', 'Новосибирск', 'Екатеринбург', 'Казань',
  'Нижний Новгород', 'Челябинск', 'Омск', 'Ростов-на-Дону', 'Уфа',
  'Красноярск', 'Пермь', 'Воронеж', 'Волгоград', 'Краснодар',
  'Саратов', 'Тюмень', 'Тольятти', 'Ижевск', 'Барнаул',
]

const esc = (s: string) =>
  s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;')

export const BASE_URL = 'https://expresslogist.ru'

type Crumb = { label: string; url: string | null }
type FaqItem = { q: string; a: string }
type SidebarPage = { title: string; url: string }
type SidebarSectionKey = 'company' | 'knowledge' | 'vacancies'

/** Мирроит site/inc/nav-data.php — реестр разделов силоса */
const SILO_NAV: Record<SidebarSectionKey, { title: string; url: string; pages: SidebarPage[] }> = {
  company: {
    title: 'О компании и условия работы',
    url: '/o-kompanii/',
    pages: [
      { title: 'Сравнение с Wildberries и Ozon', url: '/o-kompanii/sravnenie-s-wildberries-i-ozon/' },
      { title: 'Оформление и социальные гарантии', url: '/o-kompanii/oformlenie-i-socgarantii/' },
    ],
  },
  knowledge: {
    title: 'База знаний для соискателей',
    url: '/baza-znaniy/',
    pages: [
      { title: 'Как стать курьером: пошаговая инструкция', url: '/baza-znaniy/kak-stat-kurierom/' },
      { title: 'Какие документы нужны для оформления', url: '/baza-znaniy/dokumenty-dlya-oformleniya/' },
      { title: 'Сколько зарабатывает курьер', url: '/baza-znaniy/skolko-zarabatyvaet-kurier/' },
      { title: 'График 2/2 и 5/2: как выбрать', url: '/baza-znaniy/grafik-2-2-i-5-2/' },
    ],
  },
  vacancies: {
    title: 'Вакансии по городам',
    url: '/vakansii/',
    pages: [
      { title: 'Курьер в Москве', url: '/vakansii/moskva/' },
      { title: 'Курьер в Санкт-Петербурге', url: '/vakansii/sankt-peterburg/' },
      { title: 'Курьер в Новосибирске', url: '/vakansii/novosibirsk/' },
      { title: 'Курьер в Екатеринбурге', url: '/vakansii/ekaterinburg/' },
      { title: 'Курьер в Казани', url: '/vakansii/kazan/' },
      { title: 'Курьер в Нижнем Новгороде', url: '/vakansii/nizhniy-novgorod/' },
      { title: 'Курьер в Ростове-на-Дону', url: '/vakansii/rostov-na-donu/' },
      { title: 'Курьер в Краснодаре', url: '/vakansii/krasnodar/' },
    ],
  },
}

const KNOWLEDGE_ARTICLES = [
  {
    title: 'Как стать курьером: пошаговая инструкция',
    text: 'От заявки до первой смены — что происходит на каждом шаге и сколько это занимает по времени.',
    meta: '6 шагов · 1–2 дня до первой смены',
    url: '/baza-znaniy/kak-stat-kurierom/',
  },
  {
    title: 'Какие документы нужны для оформления',
    text: 'Полный список документов для граждан РФ и иностранных граждан, а также что не потребуется.',
    meta: 'Паспорт, СНИЛС и патент/РВП',
    url: '/baza-znaniy/dokumenty-dlya-oformleniya/',
  },
  {
    title: 'Сколько зарабатывает курьер',
    text: 'Разбор сдельной оплаты по типам маршрутов, бонусов за стаж и того, что влияет на итоговый доход.',
    meta: 'От 90 000 ₽ в месяц',
    url: '/baza-znaniy/skolko-zarabatyvaet-kurier/',
  },
  {
    title: 'График 2/2 и 5/2: как выбрать',
    text: 'Сравнение двух графиков смен — кому подходит каждый и как перейти с одного на другой.',
    meta: 'Плюсы и минусы каждого графика',
    url: '/baza-znaniy/grafik-2-2-i-5-2/',
  },
]

const CITY_CARDS = [
  { title: 'Москва', rate: 'от 100 000 ₽', meta: '420 курьеров в штате', url: '/vakansii/moskva/' },
  { title: 'Санкт-Петербург', rate: 'от 95 000 ₽', meta: '310 курьеров в штате', url: '/vakansii/sankt-peterburg/' },
  { title: 'Новосибирск', rate: 'от 88 000 ₽', meta: '190 курьеров в штате', url: '/vakansii/novosibirsk/' },
  { title: 'Екатеринбург', rate: 'от 90 000 ₽', meta: '210 курьеров в штате', url: '/vakansii/ekaterinburg/' },
  { title: 'Казань', rate: 'от 88 000 ₽', meta: '180 курьеров в штате', url: '/vakansii/kazan/' },
  { title: 'Нижний Новгород', rate: 'от 85 000 ₽', meta: '160 курьеров в штате', url: '/vakansii/nizhniy-novgorod/' },
  { title: 'Ростов-на-Дону', rate: 'от 85 000 ₽', meta: '150 курьеров в штате', url: '/vakansii/rostov-na-donu/' },
  { title: 'Краснодар', rate: 'от 88 000 ₽', meta: '170 курьеров в штате', url: '/vakansii/krasnodar/' },
]

export async function renderIndex(): Promise<string> {
  let html = await fs.readFile(path.join(SITE_DIR, 'index.php'), 'utf8')

  // 1. Головной PHP-блок с массивом городов и переменными
  html = html.replace(/^<\?php[\s\S]*?\?>\s*/, '')

  // 2. echo $baseUrl в canonical/OG-тегах
  html = html.replace(/<\?php echo htmlspecialchars\(\$baseUrl, ENT_QUOTES, 'UTF-8'\); \?>/g, esc(BASE_URL))

  // 3. Organization JSON-LD
  html = html.replace(
    /<script type="application\/ld\+json">[\s\S]*?<\?php echo json_encode\(\[[\s\S]*?\], JSON_UNESCAPED_UNICODE \| JSON_UNESCAPED_SLASHES\); \?>\s*<\/script>/,
    `<script type="application/ld+json">
${JSON.stringify({
  '@context': 'https://schema.org',
  '@type': 'Organization',
  name: 'ExpressLogist',
  url: `${BASE_URL}/`,
  logo: `${BASE_URL}/img/hero-courier.webp`,
  contactPoint: {
    '@type': 'ContactPoint',
    telephone: '+7-800-555-35-35',
    contactType: 'customer service',
    areaServed: 'RU',
  },
})}
</script>`,
  )

  // 4. Условие Яндекс.Метрики: оставляем ветку else (ID пустой)
  html = html.replace(
    /<\?php if \(\$yandexMetrikaId !== ''\): \?>[\s\S]*?<\?php else: \?>([\s\S]*?)<\?php endif; \?>/,
    '$1',
  )

  // 5. include header / footer
  html = html
    .replace(/<\?php include __DIR__ \. '\/inc\/header\.php'; \?>/, renderHeaderHtml())
    .replace(/<\?php include __DIR__ \. '\/inc\/footer\.php'; \?>/, renderFooterHtml())

  // 6. Циклы foreach по городам
  html = html.replace(
    /<\?php foreach \(\$cities as \$city\): \?>([\s\S]*?)<\?php endforeach; \?>/g,
    (_m, body: string) =>
      CITIES.map((c) =>
        body.replace(/<\?php echo htmlspecialchars\(\$city, ENT_QUOTES, 'UTF-8'\); \?>/g, esc(c)),
      ).join(''),
  )

  return html
}

function renderHeaderHtml(): string {
  return `<header class="header" id="top">
    <div class="container header__inner">
        <a href="/" class="logo" aria-label="ExpressLogist — на главную">
            <svg class="logo__mark" width="36" height="36" viewBox="0 0 36 36" fill="none" aria-hidden="true">
                <rect width="36" height="36" rx="8" fill="#FF6B35"/>
                <path d="M7 12h14l-2 4H9l-2-4Zm3 6h12l-2 4h-8l-2-4Zm3 6h10l-2 4h-6l-2-4Z" fill="#fff"/>
            </svg>
            <span class="logo__text">Express<span>Logist</span></span>
        </a>

        <nav class="nav" id="nav" aria-label="Основное меню">
            <a href="/o-kompanii/" class="nav__link">О компании</a>
            <a href="/baza-znaniy/" class="nav__link">База знаний</a>
            <a href="/vakansii/" class="nav__link">Вакансии</a>
            <a href="/kontakty/" class="nav__link">Контакты</a>
            <a href="tel:88005553535" class="nav__phone nav__phone--mobile">8 (800) 555-35-35</a>
        </nav>

        <a href="tel:88005553535" class="nav__phone nav__phone--desktop">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg>
            8 (800) 555-35-35
        </a>

        <button class="burger" id="burger" type="button" aria-label="Открыть меню" aria-expanded="false" aria-controls="nav">
            <span></span><span></span><span></span>
        </button>
    </div>
</header>`
}

function renderFooterHtml(): string {
  return `<footer class="footer" id="contacts">
    <div class="container footer__inner">
        <div class="footer__brand">
            <span class="logo__text logo__text--light">Express<span>Logist</span></span>
            <a href="tel:88005553535" class="footer__phone">8 (800) 555-35-35</a>
        </div>
        <p class="footer__copy">© 2026 ExpressLogist. Все права защищены</p>
        <nav class="footer__links" aria-label="Дополнительные ссылки">
            <a href="/o-kompanii/" class="footer__link">О компании</a>
            <a href="/baza-znaniy/" class="footer__link">База знаний</a>
            <a href="/vakansii/" class="footer__link">Вакансии по городам</a>
            <a href="/kontakty/" class="footer__link">Контакты</a>
            <a href="/politika-konfidencialnosti/" class="footer__link">Политика конфиденциальности</a>
        </nav>
    </div>
</footer>`
}

function renderBreadcrumbsHtml(crumbs: Crumb[]): string {
  const items = crumbs
    .map(
      (c) =>
        `<li class="breadcrumbs__item">${
          c.url ? `<a href="${esc(c.url)}">${esc(c.label)}</a>` : `<span aria-current="page">${esc(c.label)}</span>`
        }</li>`,
    )
    .join('\n        ')

  const itemListElement = crumbs.map((c, i) => {
    const item: Record<string, unknown> = { '@type': 'ListItem', position: i + 1, name: c.label }
    if (c.url) item.item = BASE_URL + c.url
    return item
  })

  const jsonLd = JSON.stringify({ '@context': 'https://schema.org', '@type': 'BreadcrumbList', itemListElement })

  return `<nav class="breadcrumbs" aria-label="Хлебные крошки">
    <ol class="breadcrumbs__list">
        ${items}
    </ol>
</nav>
<script type="application/ld+json">
${jsonLd}
</script>`
}

function renderFaqHtml(faq: FaqItem[]): string {
  return faq
    .map((item) => `<details class="faq__item">\n                        <summary>${esc(item.q)}</summary>\n                        <p>${esc(item.a)}</p>\n                    </details>`)
    .join('\n                    ')
}

function renderFaqJsonLd(faq: FaqItem[]): string {
  return JSON.stringify({
    '@context': 'https://schema.org',
    '@type': 'FAQPage',
    mainEntity: faq.map((item) => ({
      '@type': 'Question',
      name: item.q,
      acceptedAnswer: { '@type': 'Answer', text: item.a },
    })),
  })
}

function renderSidebarHtml(section: SidebarSectionKey | null, current: string | null): string {
  const active = section ? SILO_NAV[section] : null

  const sectionBlock = active
    ? `<div class="sidebar__group">
        <p class="sidebar__heading">В этом разделе</p>
        <nav>
            <ul class="sidebar__list">
                <li>
                    <a href="${esc(active.url)}" class="sidebar__link${current === active.url ? ' is-active' : ''}">
                        ${esc(active.title)}
                    </a>
                </li>
                ${active.pages
                  .map(
                    (p) =>
                      `<li>
                    <a href="${esc(p.url)}" class="sidebar__link sidebar__link--sub${current === p.url ? ' is-active' : ''}">
                        ${esc(p.title)}
                    </a>
                </li>`,
                  )
                  .join('\n                ')}
            </ul>
        </nav>
    </div>`
    : ''

  const otherSections = (Object.keys(SILO_NAV) as SidebarSectionKey[])
    .filter((key) => key !== section)
    .map(
      (key) =>
        `<li>
                    <a href="${esc(SILO_NAV[key].url)}" class="sidebar__link">
                        ${esc(SILO_NAV[key].title)}
                    </a>
                </li>`,
    )
    .join('\n                ')

  return `<aside class="sidebar" aria-label="Навигация по разделу">
    ${sectionBlock}

    <div class="sidebar__group">
        <p class="sidebar__heading">Другие разделы</p>
        <nav>
            <ul class="sidebar__list">
                ${otherSections}
                <li><a href="/kontakty/" class="sidebar__link">Контакты</a></li>
            </ul>
        </nav>
    </div>

    <div class="sidebar__cta">
        <p>Готовы начать?</p>
        <a href="/#form" class="btn btn--accent btn--block">Оставить заявку</a>
        <a href="tel:88005553535" class="sidebar__phone">8 (800) 555-35-35</a>
    </div>
</aside>`
}

function renderHubGridHtml(): string {
  return KNOWLEDGE_ARTICLES.map(
    (a) => `<a href="${esc(a.url)}" class="hub-card">
                        <p class="hub-card__eyebrow">База знаний</p>
                        <h2 class="hub-card__title">${esc(a.title)}</h2>
                        <p class="hub-card__text">${esc(a.text)}</p>
                        <p class="hub-card__meta">${esc(a.meta)} →</p>
                    </a>`,
  ).join('\n                    ')
}

function renderCityGridHtml(): string {
  return CITY_CARDS.map(
    (c) => `<a href="${esc(c.url)}" class="city-card">
                        <p class="city-card__name">${esc(c.title)}</p>
                        <p class="city-card__rate">${esc(c.rate)}</p>
                        <p class="city-card__meta">${esc(c.meta)}</p>
                    </a>`,
  ).join('\n                    ')
}

/**
 * Рендерит любую страницу силоса (категория/статья/хаб).
 * Читает реальный PHP-файл и подставляет только динамические части
 * (мета-теги, breadcrumbs, sidebar, FAQ, хаб-циклы) — контент (заголовки,
 * текст, таблицы) общий с продовым PHP-файлом, чтобы не расходовался в двух местах.
 */
async function renderContentPage(
  relPath: string,
  ctx: {
    pageTitle: string
    pageDescription: string
    canonical: string
    breadcrumbs: Crumb[]
    faq?: FaqItem[]
    sidebar?: { section: SidebarSectionKey | null; current: string | null }
    hubGrid?: 'knowledge' | 'vacancies'
  },
): Promise<string> {
  let html = await fs.readFile(path.join(SITE_DIR, relPath), 'utf8')

  // 1. Верхний PHP-блок (require + переменные) — до <!DOCTYPE
  html = html.replace(/^<\?php[\s\S]*?\?>\s*(?=<!DOCTYPE)/, '')

  // 2. Простые echo для мета-тегов
  html = html
    .replace(/<\?php echo htmlspecialchars\(\$pageTitle, ENT_QUOTES, 'UTF-8'\); \?>/g, esc(ctx.pageTitle))
    .replace(/<\?php echo htmlspecialchars\(\$pageDescription, ENT_QUOTES, 'UTF-8'\); \?>/g, esc(ctx.pageDescription))
    .replace(/<\?php echo htmlspecialchars\(\$canonical, ENT_QUOTES, 'UTF-8'\); \?>/g, esc(ctx.canonical))
    .replace(/<\?php echo htmlspecialchars\(\$baseUrl, ENT_QUOTES, 'UTF-8'\); \?>/g, esc(BASE_URL))

  // 3. FAQPage JSON-LD (если на странице есть FAQ)
  if (ctx.faq) {
    html = html.replace(
      /<script type="application\/ld\+json">[\s\S]*?<\?php echo json_encode\(\[[\s\S]*?\], JSON_UNESCAPED_UNICODE \| JSON_UNESCAPED_SLASHES\); \?>\s*<\/script>/,
      `<script type="application/ld+json">\n${renderFaqJsonLd(ctx.faq)}\n</script>`,
    )
  }

  // 4. include header / breadcrumbs / footer / sidebar (путь может быть ../ или ../../)
  html = html
    .replace(
      /<\?php \$isHome = false; include __DIR__ \. '\/(?:\.\.\/)+inc\/header\.php'; \?>/,
      renderHeaderHtml(),
    )
    .replace(/<\?php include __DIR__ \. '\/(?:\.\.\/)+inc\/breadcrumbs\.php'; \?>/, renderBreadcrumbsHtml(ctx.breadcrumbs))
    .replace(/<\?php include __DIR__ \. '\/(?:\.\.\/)+inc\/footer\.php'; \?>/, renderFooterHtml())
    .replace(
      /<\?php include __DIR__ \. '\/(?:\.\.\/)+inc\/sidebar\.php'; \?>/,
      ctx.sidebar ? renderSidebarHtml(ctx.sidebar.section, ctx.sidebar.current) : '',
    )

  // 5. foreach ($faq as $item): ... endforeach; — список <details>
  if (ctx.faq) {
    html = html.replace(/<\?php foreach \(\$faq as \$item\): \?>[\s\S]*?<\?php endforeach; \?>/, renderFaqHtml(ctx.faq))
  }

  // 6. Хаб-циклы: статьи базы знаний или карточки городов
  if (ctx.hubGrid === 'knowledge') {
    html = html.replace(/<\?php foreach \(\$articles as \$article\): \?>[\s\S]*?<\?php endforeach; \?>/, renderHubGridHtml())
  }
  if (ctx.hubGrid === 'vacancies') {
    html = html.replace(/<\?php foreach \(\$cityCards as \$city\): \?>[\s\S]*?<\?php endforeach; \?>/, renderCityGridHtml())
  }

  return html
}

const COMPANY_FAQ: FaqItem[] = [
  {
    q: 'Нужен ли личный автомобиль, чтобы стать курьером?',
    a: 'Нет. В ExpressLogist есть пешие, велокурьеры и авто-маршруты — тип развозки подбирает региональный менеджер по вашему городу и предпочтениям. Для авто-маршрутов компания выдаёт топливную карту, личный автомобиль не обязателен.',
  },
  {
    q: 'Сколько времени занимает оформление на работу?',
    a: 'От заявки до первой смены обычно проходит 1–2 рабочих дня: звонок менеджера в течение 15 минут, короткое собеседование и подписание трудового договора в отделении или дистанционно.',
  },
  {
    q: 'Какие документы нужны для трудоустройства?',
    a: 'Паспорт РФ (для иностранных граждан — разрешение на работу или патент) и СНИЛС. ИНН и медкнижка не требуются для базовых маршрутов доставки.',
  },
  {
    q: 'Можно ли совмещать работу курьером с учёбой или другой работой?',
    a: 'Да, для этого предусмотрены смены 2/2 и гибкие подработки на несколько часов в день — график согласовывается с региональным менеджером индивидуально.',
  },
  {
    q: 'Как часто выплачивается зарплата?',
    a: 'Два раза в месяц, без задержек: аванс и окончательный расчёт переводятся на карту в фиксированные даты, указанные в трудовом договоре.',
  },
]

const COMPARISON_FAQ: FaqItem[] = [
  {
    q: 'Можно ли одновременно быть самозанятым курьером у партнёра Wildberries или Ozon и работать в ExpressLogist?',
    a: 'Нет, если вы оформлены по трудовому договору в ExpressLogist на полную смену — совмещение с другой регулярной курьерской занятостью ограничено графиком. При смене 2/2 подработка в свободные дни не запрещена, если это не создаёт конфликта интересов с текущим маршрутом.',
  },
  {
    q: 'Почему трудовой договор выгоднее самозанятости для курьера?',
    a: 'Трудовой договор даёт оплачиваемый отпуск, больничный, стаж для пенсии и гарантированную минимальную ставку независимо от количества заказов — при самозанятости эти гарантии отсутствуют, а доход полностью зависит от объёма выполненных доставок.',
  },
  {
    q: 'Что будет с доходом, если в городе меньше заказов, чем обычно?',
    a: 'У курьеров ExpressLogist есть гарантированная сдельная ставка и фиксированные бонусы за стаж, которые не зависят от сезонных колебаний спроса — в отличие от чисто заказной оплаты у большинства сервис-партнёров маркетплейсов.',
  },
]

const OFORMLENIE_FAQ: FaqItem[] = [
  {
    q: 'С какого возраста можно оформиться курьером?',
    a: 'С 18 лет по трудовому договору на полную занятость. Для несовершеннолетних (14–17 лет) возможны только ограниченные форматы подработки с письменного согласия родителей и органов опеки.',
  },
  {
    q: 'Входит ли работа курьером в трудовой стаж для пенсии?',
    a: 'Да, при трудовом договоре все отчисления в Пенсионный фонд производятся официально, и период работы засчитывается в страховой стаж так же, как на любой другой официальной работе.',
  },
  {
    q: 'Что входит в форму, которую выдаёт компания?',
    a: 'Летний и зимний комплект: куртка, брюки/полукомбинезон, кепка или шапка, светоотражающие элементы и термосумка для сохранения температуры заказов. Обувь курьер подбирает самостоятельно, с компенсацией по программе для авто- и пеших маршрутов на дальние дистанции.',
  },
  {
    q: 'Оплачивается ли больничный лист?',
    a: 'Да, при трудовом договоре больничный оплачивается по общим правилам ТК РФ — на основании листка нетрудоспособности, оформленного в медицинском учреждении.',
  },
]

const KNOWLEDGE_HUB_META = {
  pageTitle: 'База знаний для соискателей — вакансия курьера ExpressLogist',
  pageDescription:
    'Всё, что нужно знать перед тем, как стать курьером: инструкция по оформлению, список документов, уровень дохода и выбор графика 2/2 или 5/2.',
  canonical: `${BASE_URL}/baza-znaniy/`,
  breadcrumbs: [
    { label: 'Главная', url: '/' },
    { label: 'База знаний для соискателей', url: null },
  ],
  sidebar: { section: 'knowledge' as SidebarSectionKey, current: '/baza-znaniy/' },
  hubGrid: 'knowledge' as const,
}

const KAK_STAT_FAQ: FaqItem[] = [
  {
    q: 'Сколько по времени занимает всё оформление от заявки до первой смены?',
    a: 'Обычно 1–2 рабочих дня: звонок менеджера в течение 15 минут после заявки, короткое собеседование в тот же или на следующий день, подписание договора и выход на первую смену.',
  },
  {
    q: 'Нужно ли проходить обучение перед первой сменой?',
    a: 'Да, короткий инструктаж по работе с приложением и маршрутами занимает 30–60 минут и проводится региональным менеджером в день оформления или накануне первой смены.',
  },
  {
    q: 'Что делать, если на собеседовании я не подхожу для одного типа маршрута?',
    a: 'Менеджер предложит альтернативный формат — например, вместо авто-маршрута пеший или велокурьерский, в зависимости от наличия документов, транспорта и вакансий в вашем городе.',
  },
]

const DOKUMENTY_FAQ: FaqItem[] = [
  {
    q: 'Нужна ли медицинская книжка курьеру?',
    a: 'Нет, медицинская книжка для курьерской доставки не требуется — это не работа с продуктами питания на кухне или в общественном питании.',
  },
  {
    q: 'Нужен ли ИНН для оформления?',
    a: 'Отдельно приносить ИНН не нужно — номер запрашивается автоматически через СНИЛС при подаче отчётности в налоговую.',
  },
  {
    q: 'Можно ли оформиться без прописки в городе, где я хочу работать?',
    a: 'Да, регистрация по месту пребывания не обязательна для трудового договора — достаточно паспорта с любой актуальной регистрацией.',
  },
  {
    q: 'Что делать, если патент оформлен на другой регион?',
    a: 'Патент действует только в том регионе, где выдан. Уточните у менеджера при звонке — в большинстве крупных городов можно оформить патент на месте до выхода на первую смену.',
  },
]

const SKOLKO_FAQ: FaqItem[] = [
  {
    q: 'Ставка фиксированная или зависит от количества доставок?',
    a: 'Оплата сдельная: чем больше доставок за смену, тем выше доход. Указанные в статье суммы — типичный результат при полной загрузке маршрута и графике 5/2 или 2/2.',
  },
  {
    q: 'Когда начисляются бонусы за стаж?',
    a: 'Бонусы за стаж начисляются ежемесячно и растут по фиксированной шкале — первое повышение происходит уже после первого полного месяца работы.',
  },
  {
    q: 'Можно ли совмещать пешие и авто-маршруты для увеличения дохода?',
    a: 'В большинстве городов курьер закрепляется за одним типом маршрута на смену, но по согласованию с менеджером можно перейти на маршрут с более высокой ставкой, если есть свободные места.',
  },
]

const GRAFIK_FAQ: FaqItem[] = [
  {
    q: 'Можно ли поменять график после того, как уже начал работать?',
    a: 'Да, по согласованию с региональным менеджером — обычно переход возможен с начала следующего месяца, чтобы не нарушать текущее расписание маршрутов.',
  },
  {
    q: 'Какой график выбирают чаще?',
    a: 'Оба варианта популярны примерно одинаково — выбор зависит от личных обстоятельств: 5/2 чаще выбирают те, у кого есть другие дела по будням, 2/2 — кто хочет больше свободных дней подряд.',
  },
  {
    q: 'Есть ли ночные смены?',
    a: 'В большинстве городов курьерская доставка работает в дневное и вечернее время. Ночные маршруты — редкость и обсуждаются отдельно с менеджером при наличии такой потребности у клиентов в регионе.',
  },
]

const VACANCIES_HUB_META = {
  pageTitle: 'Вакансии курьера по городам — ExpressLogist',
  pageDescription:
    'Работа курьером в 8 крупных городах России: доход, количество курьеров в штате и типы маршрутов в Москве, Санкт-Петербурге, Новосибирске и других городах.',
  canonical: `${BASE_URL}/vakansii/`,
  breadcrumbs: [
    { label: 'Главная', url: '/' },
    { label: 'Вакансии по городам', url: null },
  ],
  sidebar: { section: 'vacancies' as SidebarSectionKey, current: '/vakansii/' },
  hubGrid: 'vacancies' as const,
}

type CityFaqKey =
  | 'moskva'
  | 'sankt-peterburg'
  | 'novosibirsk'
  | 'ekaterinburg'
  | 'kazan'
  | 'nizhniy-novgorod'
  | 'rostov-na-donu'
  | 'krasnodar'

const CITY_META: Record<
  CityFaqKey,
  { name: string; namePrepositional: string; pageTitle: string; pageDescription: string; faq: FaqItem[] }
> = {
  moskva: {
    name: 'Москва',
    namePrepositional: 'Москве',
    pageTitle: 'Работа курьером в Москве — доход от 100 000 ₽ | ExpressLogist',
    pageDescription:
      'Вакансия курьера в Москве: доход от 100 000 ₽, 420 курьеров в штате, пешие, велосипедные и авто-маршруты по всем округам. Официальное оформление.',
    faq: [
      {
        q: 'В каких округах Москвы есть маршруты?',
        a: 'Маршруты открыты во всех округах — от ЦАО до новых территорий ТиНАО. Региональный менеджер закрепляет зону ближе к месту проживания курьера.',
      },
      {
        q: 'Учитывается ли пробки при формировании авто-маршрутов в Москве?',
        a: 'Да, зоны для авто-курьеров формируются с учётом дорожной ситуации — маршруты компактные, чтобы пробки не увеличивали время в пути сверх нормы.',
      },
      {
        q: 'Можно ли работать курьером в Москве без регистрации в городе?',
        a: 'Да, для трудового договора достаточно паспорта с любой актуальной регистрацией — прописка в Москве не обязательна.',
      },
    ],
  },
  'sankt-peterburg': {
    name: 'Санкт-Петербург',
    namePrepositional: 'Санкт-Петербурге',
    pageTitle: 'Работа курьером в Санкт-Петербурге — доход от 95 000 ₽ | ExpressLogist',
    pageDescription:
      'Вакансия курьера в Санкт-Петербурге: доход от 95 000 ₽, 310 курьеров в штате, пешие и авто-маршруты по районам города. Официальное оформление.',
    faq: [
      {
        q: 'Как компания учитывает разводные мосты при построении авто-маршрутов?',
        a: 'Маршруты строятся так, чтобы курьер оставался на одном берегу Невы за смену — это исключает риск задержек из-за разводки мостов в ночное время.',
      },
      {
        q: 'Есть ли маршруты в отдалённых районах — Колпино, Пушкин, Кронштадт?',
        a: 'Да, в этих районах работают отдельные пешие и авто-маршруты с учётом местной плотности заказов — уточните доступность у регионального менеджера при звонке.',
      },
      {
        q: 'Как погодные условия влияют на пешие маршруты зимой?',
        a: 'Зимняя форма выдаётся всем пешим и велокурьерам заранее, а маршруты пересматриваются в периоды гололёда — приоритет получают более безопасные зоны.',
      },
    ],
  },
  novosibirsk: {
    name: 'Новосибирск',
    namePrepositional: 'Новосибирске',
    pageTitle: 'Работа курьером в Новосибирске — доход от 88 000 ₽ | ExpressLogist',
    pageDescription:
      'Вакансия курьера в Новосибирске: доход от 88 000 ₽, 190 курьеров в штате, пешие и авто-маршруты на обоих берегах Оби. Официальное оформление.',
    faq: [
      {
        q: 'Есть ли маршруты на левом берегу Оби?',
        a: 'Да, компания работает и в Ленинском, Кировском, Октябрьском районах на левом берегу, и в Центральном, Заельцовском, Дзержинском — на правом. Менеджер закрепляет маршрут ближе к месту проживания.',
      },
      {
        q: 'Как организована работа курьеров зимой?',
        a: 'В зимний сезон авто-маршруты становятся приоритетным вариантом для длинных перегонов — компания выдаёт зимнюю форму, а маршруты пересматриваются с учётом погодных условий и состояния дорог.',
      },
      {
        q: 'Можно ли начать работать студентам НГУ и других вузов?',
        a: 'Да, график 2/2 или несколько смен в неделю по договорённости с менеджером — удобный формат для совмещения с учёбой в вузах города.',
      },
    ],
  },
  ekaterinburg: {
    name: 'Екатеринбург',
    namePrepositional: 'Екатеринбурге',
    pageTitle: 'Работа курьером в Екатеринбурге — доход от 90 000 ₽ | ExpressLogist',
    pageDescription:
      'Вакансия курьера в Екатеринбурге: доход от 90 000 ₽, 210 курьеров в штате, пешие и авто-маршруты по районам города. Официальное оформление.',
    faq: [
      {
        q: 'В каких районах Екатеринбурга есть маршруты?',
        a: 'Маршруты открыты в Верх-Исетском, Чкаловском, Кировском, Октябрьском и Железнодорожном районах. Менеджер подбирает зону ближе к месту проживания курьера.',
      },
      {
        q: 'Почему авто-маршруты в Екатеринбурге оплачиваются выше?',
        a: 'Город растянут между промышленными и жилыми зонами, поэтому авто-маршруты часто длиннее — за это предусмотрена повышенная ставка и топливная карта, покрывающая расходы на бензин.',
      },
      {
        q: 'Можно ли совмещать работу курьером с учёбой в УрФУ?',
        a: 'Да, график 2/2 или несколько дневных смен в неделю обсуждается с региональным менеджером индивидуально под расписание занятий.',
      },
    ],
  },
  kazan: {
    name: 'Казань',
    namePrepositional: 'Казани',
    pageTitle: 'Работа курьером в Казани — доход от 88 000 ₽ | ExpressLogist',
    pageDescription:
      'Вакансия курьера в Казани: доход от 88 000 ₽, 180 курьеров в штате, пешие, велосипедные и авто-маршруты по районам города. Официальное оформление.',
    faq: [
      {
        q: 'В каких районах Казани есть маршруты?',
        a: 'Маршруты работают в Вахитовском, Советском, Приволжском и Ново-Савиновском районах. Зону подбирает региональный менеджер ближе к месту проживания курьера.',
      },
      {
        q: 'Нужно ли знание татарского языка для работы курьером?',
        a: 'Нет, инструкции и приложение для маршрутов на русском языке — знание татарского не требуется, хотя приветствуется при общении с клиентами.',
      },
      {
        q: 'Оформляют ли иностранных студентов, обучающихся в казанских вузах?',
        a: 'Да, при наличии патента или разрешения на работу — полный список документов на странице «Какие документы нужны для оформления».',
      },
    ],
  },
  'nizhniy-novgorod': {
    name: 'Нижний Новгород',
    namePrepositional: 'Нижнем Новгороде',
    pageTitle: 'Работа курьером в Нижнем Новгороде — доход от 85 000 ₽ | ExpressLogist',
    pageDescription:
      'Вакансия курьера в Нижнем Новгороде: доход от 85 000 ₽, 160 курьеров в штате, пешие и авто-маршруты на обоих берегах Оки. Официальное оформление.',
    faq: [
      {
        q: 'Есть ли маршруты в Автозаводском районе?',
        a: 'Да, Автозаводский район — один из крупнейших по числу заказов благодаря высокой плотности населения. Маршруты там доступны как пешие, так и авто.',
      },
      {
        q: 'Учитывается ли рельеф города при расчёте пеших маршрутов?',
        a: 'Да, верхняя и нижняя части города (например, съезды к Оке и Волге) учитываются при формировании зон — маршрут подбирается так, чтобы перепады высот не увеличивали время доставки сверх нормы.',
      },
      {
        q: 'Сколько времени занимает оформление в Нижнем Новгороде?',
        a: 'От заявки до первой смены обычно проходит 1–2 рабочих дня, как и в других городах присутствия компании.',
      },
    ],
  },
  'rostov-na-donu': {
    name: 'Ростов-на-Дону',
    namePrepositional: 'Ростове-на-Дону',
    pageTitle: 'Работа курьером в Ростове-на-Дону — доход от 85 000 ₽ | ExpressLogist',
    pageDescription:
      'Вакансия курьера в Ростове-на-Дону: доход от 85 000 ₽, 150 курьеров в штате, пешие и авто-маршруты по районам города. Официальное оформление.',
    faq: [
      {
        q: 'В каких районах Ростова-на-Дону есть маршруты?',
        a: 'Маршруты открыты в Кировском, Первомайском, Ленинском и Пролетарском районах. Менеджер подбирает зону ближе к месту проживания курьера.',
      },
      {
        q: 'Как влияет летняя жара на график смен?',
        a: 'В самые жаркие летние месяцы часть смен смещается на утренние и вечерние часы — компания следит за комфортными условиями работы и обеспечивает курьеров водой на маршруте.',
      },
      {
        q: 'Можно ли подработать курьером на несколько часов в день?',
        a: 'Да, в дополнение к сменам 5/2 и 2/2 доступны частичные подработки — уточните формат у регионального менеджера при звонке.',
      },
    ],
  },
  krasnodar: {
    name: 'Краснодар',
    namePrepositional: 'Краснодаре',
    pageTitle: 'Работа курьером в Краснодаре — доход от 88 000 ₽ | ExpressLogist',
    pageDescription:
      'Вакансия курьера в Краснодаре: доход от 88 000 ₽, 170 курьеров в штате, пешие, велосипедные и авто-маршруты по районам растущего города. Официальное оформление.',
    faq: [
      {
        q: 'В каких районах Краснодара есть маршруты?',
        a: 'Маршруты открыты в Центральном, Прикубанском, Западном и Карасунском округах. Прикубанский округ — один из самых быстрорастущих по числу новых жилых комплексов и заказов.',
      },
      {
        q: 'Актуальны ли велосипедные маршруты летом при высокой температуре?',
        a: 'Да, но график смен для велокурьеров летом смещается на более прохладные часы — раннее утро и вечер, чтобы работа была комфортной.',
      },
      {
        q: 'Растёт ли количество вакансий в Краснодаре?',
        a: 'Да, из-за активного строительства новых жилых районов спрос на курьеров в Прикубанском и Западном округах увеличивается каждый сезон — компания регулярно открывает дополнительные маршруты.',
      },
    ],
  },
}

export async function renderCompanyPage(): Promise<string> {
  return renderContentPage('o-kompanii/index.php', {
    pageTitle: 'О компании и условия работы курьером в ExpressLogist',
    pageDescription:
      'ExpressLogist — федеральная служба доставки: официальное оформление, сдельная оплата от 90 000 ₽, соцпакет и график 5/2 или 2/2. Сравнение условий с Wildberries и Ozon.',
    canonical: `${BASE_URL}/o-kompanii/`,
    breadcrumbs: [
      { label: 'Главная', url: '/' },
      { label: 'О компании и условия работы', url: null },
    ],
    sidebar: { section: 'company', current: '/o-kompanii/' },
    faq: COMPANY_FAQ,
  })
}

export async function renderComparisonPage(): Promise<string> {
  return renderContentPage('o-kompanii/sravnenie-s-wildberries-i-ozon/index.php', {
    pageTitle: 'Курьер ExpressLogist или Wildberries/Ozon: сравнение условий и оплаты',
    pageDescription:
      'Сравниваем оформление, оплату, обеспечение и выплаты курьера ExpressLogist с типовыми условиями сервис-партнёров Wildberries и Ozon.',
    canonical: `${BASE_URL}/o-kompanii/sravnenie-s-wildberries-i-ozon/`,
    breadcrumbs: [
      { label: 'Главная', url: '/' },
      { label: 'О компании и условия работы', url: '/o-kompanii/' },
      { label: 'Сравнение с Wildberries и Ozon', url: null },
    ],
    sidebar: { section: 'company', current: '/o-kompanii/sravnenie-s-wildberries-i-ozon/' },
    faq: COMPARISON_FAQ,
  })
}

export async function renderOformlениеPage(): Promise<string> {
  return renderContentPage('o-kompanii/oformlenie-i-socgarantii/index.php', {
    pageTitle: 'Оформление и социальные гарантии курьера — ExpressLogist',
    pageDescription:
      'Как оформляют курьеров ExpressLogist: трудовой договор, страховка, отпуск, больничный и полный список социальных гарантий.',
    canonical: `${BASE_URL}/o-kompanii/oformlenie-i-socgarantii/`,
    breadcrumbs: [
      { label: 'Главная', url: '/' },
      { label: 'О компании и условия работы', url: '/o-kompanii/' },
      { label: 'Оформление и социальные гарантии', url: null },
    ],
    sidebar: { section: 'company', current: '/o-kompanii/oformlenie-i-socgarantii/' },
    faq: OFORMLENIE_FAQ,
  })
}

export async function renderKnowledgeHubPage(): Promise<string> {
  return renderContentPage('baza-znaniy/index.php', KNOWLEDGE_HUB_META)
}

export async function renderKakStatPage(): Promise<string> {
  return renderContentPage('baza-znaniy/kak-stat-kurierom/index.php', {
    pageTitle: 'Как стать курьером: пошаговая инструкция — ExpressLogist',
    pageDescription:
      'Пошаговая инструкция, как стать курьером ExpressLogist: от заявки на сайте до первой смены. Что происходит на каждом шаге и сколько это занимает.',
    canonical: `${BASE_URL}/baza-znaniy/kak-stat-kurierom/`,
    breadcrumbs: [
      { label: 'Главная', url: '/' },
      { label: 'База знаний для соискателей', url: '/baza-znaniy/' },
      { label: 'Как стать курьером', url: null },
    ],
    sidebar: { section: 'knowledge', current: '/baza-znaniy/kak-stat-kurierom/' },
    faq: KAK_STAT_FAQ,
  })
}

export async function renderDokumentyPage(): Promise<string> {
  return renderContentPage('baza-znaniy/dokumenty-dlya-oformleniya/index.php', {
    pageTitle: 'Какие документы нужны для оформления курьером — ExpressLogist',
    pageDescription:
      'Полный список документов для оформления курьером: для граждан РФ и иностранных граждан. Что нужно принести и что не потребуется.',
    canonical: `${BASE_URL}/baza-znaniy/dokumenty-dlya-oformleniya/`,
    breadcrumbs: [
      { label: 'Главная', url: '/' },
      { label: 'База знаний для соискателей', url: '/baza-znaniy/' },
      { label: 'Документы для оформления', url: null },
    ],
    sidebar: { section: 'knowledge', current: '/baza-znaniy/dokumenty-dlya-oformleniya/' },
    faq: DOKUMENTY_FAQ,
  })
}

export async function renderSkolkoPage(): Promise<string> {
  return renderContentPage('baza-znaniy/skolko-zarabatyvaet-kurier/index.php', {
    pageTitle: 'Сколько зарабатывает курьер в ExpressLogist — доход по маршрутам',
    pageDescription:
      'Разбор дохода курьера ExpressLogist: сдельная ставка по типам маршрутов, бонусы за стаж и что влияет на итоговую сумму в месяц.',
    canonical: `${BASE_URL}/baza-znaniy/skolko-zarabatyvaet-kurier/`,
    breadcrumbs: [
      { label: 'Главная', url: '/' },
      { label: 'База знаний для соискателей', url: '/baza-znaniy/' },
      { label: 'Сколько зарабатывает курьер', url: null },
    ],
    sidebar: { section: 'knowledge', current: '/baza-znaniy/skolko-zarabatyvaet-kurier/' },
    faq: SKOLKO_FAQ,
  })
}

export async function renderGrafikPage(): Promise<string> {
  return renderContentPage('baza-znaniy/grafik-2-2-i-5-2/index.php', {
    pageTitle: 'График 2/2 и 5/2 для курьера: как выбрать — ExpressLogist',
    pageDescription:
      'Сравнение графиков 2/2 и 5/2 для курьера: плюсы, минусы, кому подходит каждый вариант и можно ли поменять график после оформления.',
    canonical: `${BASE_URL}/baza-znaniy/grafik-2-2-i-5-2/`,
    breadcrumbs: [
      { label: 'Главная', url: '/' },
      { label: 'База знаний для соискателей', url: '/baza-znaniy/' },
      { label: 'График 2/2 и 5/2', url: null },
    ],
    sidebar: { section: 'knowledge', current: '/baza-znaniy/grafik-2-2-i-5-2/' },
    faq: GRAFIK_FAQ,
  })
}

export async function renderVacanciesHubPage(): Promise<string> {
  return renderContentPage('vakansii/index.php', VACANCIES_HUB_META)
}

const CITY_SLUGS: CityFaqKey[] = [
  'moskva',
  'sankt-peterburg',
  'novosibirsk',
  'ekaterinburg',
  'kazan',
  'nizhniy-novgorod',
  'rostov-na-donu',
  'krasnodar',
]

export async function renderCityPage(slug: CityFaqKey): Promise<string> {
  const city = CITY_META[slug]
  return renderContentPage(`vakansii/${slug}/index.php`, {
    pageTitle: city.pageTitle,
    pageDescription: city.pageDescription,
    canonical: `${BASE_URL}/vakansii/${slug}/`,
    breadcrumbs: [
      { label: 'Главная', url: '/' },
      { label: 'Вакансии по городам', url: '/vakansii/' },
      { label: `Курьер в ${city.namePrepositional}`, url: null },
    ],
    sidebar: { section: 'vacancies', current: `/vakansii/${slug}/` },
    faq: city.faq,
  })
}

export { CITY_SLUGS }
export type { CityFaqKey }

/** Стандалон-страницы: без сайдбара и без FAQ */
export async function renderKontaktyPage(): Promise<string> {
  return renderContentPage('kontakty/index.php', {
    pageTitle: 'Контакты — ExpressLogist',
    pageDescription:
      'Контакты федеральной службы доставки ExpressLogist: телефон горячей линии, реквизиты компании и форма связи с HR-отделом.',
    canonical: `${BASE_URL}/kontakty/`,
    breadcrumbs: [
      { label: 'Главная', url: '/' },
      { label: 'Контакты', url: null },
    ],
  })
}

export async function renderPolitikaPage(): Promise<string> {
  return renderContentPage('politika-konfidencialnosti/index.php', {
    pageTitle: 'Политика конфиденциальности — ExpressLogist',
    pageDescription: 'Политика обработки персональных данных пользователей сайта ExpressLogist.',
    canonical: `${BASE_URL}/politika-konfidencialnosti/`,
    breadcrumbs: [
      { label: 'Главная', url: '/' },
      { label: 'Политика конфиденциальности', url: null },
    ],
  })
}

/** Эмуляция send.php: та же валидация и тот же формат строки в logs/leads.txt */
export async function handleSend(form: FormData) {
  let name = String(form.get('name') ?? '').trim().replace(/[\x00-\x1F\x7F]/g, '').replace(/\s+/g, ' ')
  name = esc(name)

  let phone = String(form.get('phone') ?? '').replace(/\D/g, '')
  if (phone.length === 11 && phone[0] === '8') phone = '7' + phone.slice(1)

  const city = String(form.get('city') ?? '').trim()
  const agree = String(form.get('agree') ?? '') === '1'

  const errors: Record<string, string> = {}
  if ([...name].length < 2) errors.name = 'Введите имя (минимум 2 символа)'
  else if ([...name].length > 100) errors.name = 'Слишком длинное имя'
  if (!/^7\d{10}$/.test(phone)) errors.phone = 'Телефон должен содержать 11 цифр и начинаться с +7'
  if (!CITIES.includes(city)) errors.city = 'Выберите город из списка'
  if (!agree) errors.agree = 'Необходимо согласие на обработку персональных данных'

  if (Object.keys(errors).length) {
    return { status: 422, body: { success: false, message: 'Проверьте правильность заполнения полей', errors } }
  }

  // [2026-02-09 15:30:45] | Имя: Иван | Телефон: 79261234567 | Город: Москва
  const ts = new Date()
    .toLocaleString('sv-SE', { timeZone: 'Europe/Moscow', hour12: false })
    .replace('T', ' ')
  const line = `[${ts}] | Имя: ${name} | Телефон: ${phone} | Город: ${esc(city)}\n`

  const logDir = path.join(SITE_DIR, 'logs')
  await fs.mkdir(logDir, { recursive: true })
  await fs.appendFile(path.join(logDir, 'leads.txt'), line, 'utf8')

  return { status: 200, body: { success: true, message: 'Заявка успешно отправлена' } }
}
