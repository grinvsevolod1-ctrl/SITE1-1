// Отдаёт site/sitemap.xml как есть — статический файл, без PHP-обработки.
import { promises as fs } from 'node:fs'
import path from 'node:path'
import { SITE_DIR } from '@/lib/php-preview'

export async function GET() {
  const xml = await fs.readFile(path.join(SITE_DIR, 'sitemap.xml'), 'utf8')
  return new Response(xml, {
    headers: { 'Content-Type': 'application/xml; charset=utf-8', 'Cache-Control': 'no-cache' },
  })
}
