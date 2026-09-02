/**
 * Прослойка ТОЛЬКО для превью в v0 (в песочнице нет PHP).
 * На реальном хостинге используется папка site/ напрямую (Apache + PHP).
 *
 * Здесь мы эмулируем минимальную логику index.php:
 *  - вырезаем PHP-блоки,
 *  - разворачиваем цикл по городам,
 *  - подставляем ветку без Яндекс.Метрики (ID не задан).
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
    .replace(/<\?php include __DIR__ \. '\/inc\/header\.php'; \?>/, renderHeaderHtml(true))
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

export const BASE_URL = 'https://expresslogist.ru'

type Crumb = { label: string; url: string | null }
type FaqItem = { q: string; a: string }

function renderHeaderHtml(isHome: boolean): string {
  const prefix = isHome ? '' : '/'
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
            <a href="/o-kompanii/" class="nav__link">О нас</a>
            <a href="${prefix}#jobs" class="nav__link">Вакансии</a>
            <a href="${prefix}#contacts" class="nav__link">Контакты</a>
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
            <a href="/o-kompanii/" class="footer__link">О компании и условия работы</a>
            <a href="#" class="footer__link">Политика конфиденциальности</a>
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

/**
 * Рендерит страницы силоса «О компании и условия работы» (см. site/o-kompanii/).
 * Читает реальный PHP-файл и подставляет только динамические части
 * (мета-теги, breadcrumbs, FAQ) — контент (заголовки, текст, таблицы) общий
 * с продовым PHP-файлом, чтобы не расходовался в двух местах.
 */
async function renderContentPage(
  relPath: string,
  ctx: { pageTitle: string; pageDescription: string; canonical: string; breadcrumbs: Crumb[]; faq: FaqItem[] },
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

  // 3. FAQPage JSON-LD
  html = html.replace(
    /<script type="application\/ld\+json">[\s\S]*?<\?php echo json_encode\(\[[\s\S]*?\], JSON_UNESCAPED_UNICODE \| JSON_UNESCAPED_SLASHES\); \?>\s*<\/script>/,
    `<script type="application/ld+json">\n${renderFaqJsonLd(ctx.faq)}\n</script>`,
  )

  // 4. include header / breadcrumbs / footer (путь может быть ../ или ../../)
  html = html
    .replace(
      /<\?php \$isHome = false; include __DIR__ \. '\/(?:\.\.\/)+inc\/header\.php'; \?>/,
      renderHeaderHtml(false),
    )
    .replace(/<\?php include __DIR__ \. '\/(?:\.\.\/)+inc\/breadcrumbs\.php'; \?>/, renderBreadcrumbsHtml(ctx.breadcrumbs))
    .replace(/<\?php include __DIR__ \. '\/(?:\.\.\/)+inc\/footer\.php'; \?>/, renderFooterHtml())

  // 5. foreach ($faq as $item): ... endforeach; — список <details>
  html = html.replace(/<\?php foreach \(\$faq as \$item\): \?>[\s\S]*?<\?php endforeach; \?>/, renderFaqHtml(ctx.faq))

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
    faq: COMPARISON_FAQ,
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
