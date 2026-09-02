// Превью site/baza-znaniy/dokumenty-dlya-oformleniya/index.php в v0 (см. lib/php-preview.ts)
import { renderDokumentyPage } from '@/lib/php-preview'

export const dynamic = 'force-dynamic'

export async function GET() {
  const html = await renderDokumentyPage()
  return new Response(html, {
    headers: { 'Content-Type': 'text/html; charset=utf-8', 'Cache-Control': 'no-store' },
  })
}
