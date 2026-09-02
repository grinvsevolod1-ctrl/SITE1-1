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

  // 2. Условие Яндекс.Метрики: оставляем ветку else (ID пустой)
  html = html.replace(
    /<\?php if \(\$yandexMetrikaId !== ''\): \?>[\s\S]*?<\?php else: \?>([\s\S]*?)<\?php endif; \?>/,
    '$1',
  )

  // 3. Циклы foreach по городам
  html = html.replace(
    /<\?php foreach \(\$cities as \$city\): \?>([\s\S]*?)<\?php endforeach; \?>/g,
    (_m, body: string) =>
      CITIES.map((c) =>
        body.replace(/<\?php echo htmlspecialchars\(\$city, ENT_QUOTES, 'UTF-8'\); \?>/g, esc(c)),
      ).join(''),
  )

  return html
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
