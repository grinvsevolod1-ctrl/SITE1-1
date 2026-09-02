// Отдаёт site/robots.txt как есть — статический файл, без PHP-обработки.
import { promises as fs } from 'node:fs'
import path from 'node:path'
import { SITE_DIR } from '@/lib/php-preview'

export async function GET() {
  const txt = await fs.readFile(path.join(SITE_DIR, 'robots.txt'), 'utf8')
  return new Response(txt, {
    headers: { 'Content-Type': 'text/plain; charset=utf-8', 'Cache-Control': 'no-cache' },
  })
}
