// Превью site/baza-znaniy/kak-stat-kurierom/index.php в v0 (см. lib/php-preview.ts)
import { renderKakStatPage } from '@/lib/php-preview'

export const dynamic = 'force-dynamic'

export async function GET() {
  const html = await renderKakStatPage()
  return new Response(html, {
    headers: { 'Content-Type': 'text/html; charset=utf-8', 'Cache-Control': 'no-store' },
  })
}
