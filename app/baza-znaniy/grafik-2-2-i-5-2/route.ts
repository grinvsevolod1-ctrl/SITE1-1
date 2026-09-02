// Превью site/baza-znaniy/grafik-2-2-i-5-2/index.php в v0 (см. lib/php-preview.ts)
import { renderGrafikPage } from '@/lib/php-preview'

export const dynamic = 'force-dynamic'

export async function GET() {
  const html = await renderGrafikPage()
  return new Response(html, {
    headers: { 'Content-Type': 'text/html; charset=utf-8', 'Cache-Control': 'no-store' },
  })
}
