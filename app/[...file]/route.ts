// Отдача статики из site/ (css, js, img) для превью в v0.
// Папка logs недоступна — как и на хостинге через .htaccess.
import { promises as fs } from 'node:fs'
import path from 'node:path'
import { SITE_DIR } from '@/lib/php-preview'

const MIME: Record<string, string> = {
  '.css': 'text/css; charset=utf-8',
  '.js': 'application/javascript; charset=utf-8',
  '.webp': 'image/webp',
  '.jpg': 'image/jpeg',
  '.png': 'image/png',
  '.svg': 'image/svg+xml',
}

const ALLOWED_DIRS = new Set(['css', 'js', 'img'])

export async function GET(_req: Request, ctx: { params: Promise<{ file: string[] }> }) {
  const { file } = await ctx.params
  if (!file?.length || !ALLOWED_DIRS.has(file[0])) {
    return new Response('Not found', { status: 404 })
  }

  const target = path.join(SITE_DIR, ...file)
  if (!target.startsWith(SITE_DIR)) return new Response('Forbidden', { status: 403 })

  try {
    const data = await fs.readFile(target)
    const type = MIME[path.extname(target)] ?? 'application/octet-stream'
    return new Response(data, { headers: { 'Content-Type': type, 'Cache-Control': 'no-cache' } })
  } catch {
    return new Response('Not found', { status: 404 })
  }
}
