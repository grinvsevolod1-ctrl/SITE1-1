// Превью send.php в v0 (см. lib/php-preview.ts)
import { handleSend } from '@/lib/php-preview'

export const dynamic = 'force-dynamic'

export async function POST(req: Request) {
  const form = await req.formData()
  const { status, body } = await handleSend(form)
  return Response.json(body, { status })
}

export function GET() {
  return Response.json({ success: false, message: 'Метод не поддерживается' }, { status: 405 })
}
