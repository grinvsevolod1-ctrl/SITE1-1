// Превью site/o-kompanii/oformlenie-i-socgarantii/index.php в v0 (см. lib/php-preview.ts)
import { renderOformlениеPage } from '@/lib/php-preview'

export const dynamic = 'force-dynamic'

export async function GET() {
  const html = await renderOformlениеPage()
  return new Response(html, {
    headers: { 'Content-Type': 'text/html; charset=utf-8', 'Cache-Control': 'no-store' },
  })
}
