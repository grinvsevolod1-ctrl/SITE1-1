// Превью site/politika-konfidencialnosti/index.php в v0 (см. lib/php-preview.ts)
import { renderPolitikaPage } from '@/lib/php-preview'

export const dynamic = 'force-dynamic'

export async function GET() {
  const html = await renderPolitikaPage()
  return new Response(html, {
    headers: { 'Content-Type': 'text/html; charset=utf-8', 'Cache-Control': 'no-store' },
  })
}
