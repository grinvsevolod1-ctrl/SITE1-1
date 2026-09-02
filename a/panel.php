<?php
/**
 * ExpressLogist — админка first-party аналитики.
 *
 * Показывает статистику из logs/analytics.jsonl: посетители, просмотры,
 * конверсии, источники рекламы (UTM), кампании, страницы и последние события.
 * Защищена логином/паролем из config.php ($analytics['user'/'password']).
 *
 * Доступ: https://ваш-домен/a/panel.php
 * Фильтр по периоду: ?days=7 (по умолчанию 30).
 */

declare(strict_types=1);

require __DIR__ . '/../inc/config.php';

/* ---------------- Авторизация (HTTP Basic) ---------------- */
$authUser = $analytics['user'] ?? 'admin';
$authPass = $analytics['password'] ?? '';

$givenUser = $_SERVER['PHP_AUTH_USER'] ?? '';
$givenPass = $_SERVER['PHP_AUTH_PW'] ?? '';

$ok = ($authPass !== '')
    && hash_equals($authUser, $givenUser)
    && hash_equals($authPass, $givenPass);

if (!$ok) {
    header('WWW-Authenticate: Basic realm="ExpressLogist Analytics"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Требуется авторизация.';
    exit;
}

/* ---------------- Чтение и агрегация ---------------- */
$days = isset($_GET['days']) ? max(1, min(365, (int) $_GET['days'])) : 30;
$since = strtotime('-' . $days . ' days');

$logFile = __DIR__ . '/../logs/analytics.jsonl';

$stats = [
    'pageviews' => 0,
    'leads'     => 0,
    'vacancy'   => 0,
    'phone'     => 0,
    'events'    => 0,
];
$visitors = [];        // vid => true (уникальные)
$leadVisitors = [];    // vid => true (кто оставил заявку)
$bySource   = [];      // utm_source => count pageviews
$byCampaign = [];      // utm_campaign => ['pv'=>, 'leads'=>]
$byPage     = [];      // path => count
$byDay      = [];      // Y-m-d => ['pv'=>, 'leads'=>]
$byDevice   = ['desktop' => 0, 'mobile' => 0, 'tablet' => 0];
$recent     = [];      // последние события

if (is_file($logFile) && is_readable($logFile)) {
    $fh = fopen($logFile, 'r');
    if ($fh) {
        while (($line = fgets($fh)) !== false) {
            $line = trim($line);
            if ($line === '') { continue; }
            $r = json_decode($line, true);
            if (!is_array($r)) { continue; }

            $ts = isset($r['ts']) ? strtotime($r['ts']) : false;
            if ($ts === false || $ts < $since) { continue; }
            if (!empty($r['bot'])) { continue; } // боты не считаем

            $e   = $r['e'] ?? 'other';
            $vid = $r['vid'] ?? '';
            $src = ($r['utm_source'] ?? '') !== '' ? $r['utm_source'] : '(прямой/без метки)';
            $cmp = ($r['utm_campaign'] ?? '') !== '' ? $r['utm_campaign'] : '(без кампании)';
            $day = date('Y-m-d', $ts);
            $dev = $r['device'] ?? 'desktop';

            $stats['events']++;
            if ($vid !== '') { $visitors[$vid] = true; }

            if ($e === 'pageview') {
                $stats['pageviews']++;
                $bySource[$src]   = ($bySource[$src] ?? 0) + 1;
                $byPage[$r['path'] ?? '/'] = ($byPage[$r['path'] ?? '/'] ?? 0) + 1;
                $byCampaign[$cmp]['pv'] = ($byCampaign[$cmp]['pv'] ?? 0) + 1;
                $byDay[$day]['pv']      = ($byDay[$day]['pv'] ?? 0) + 1;
                if (isset($byDevice[$dev])) { $byDevice[$dev]++; }
            } elseif ($e === 'lead' || $e === 'vacancy') {
                $stats[$e === 'vacancy' ? 'vacancy' : 'leads']++;
                if ($vid !== '') { $leadVisitors[$vid] = true; }
                $byCampaign[$cmp]['leads'] = ($byCampaign[$cmp]['leads'] ?? 0) + 1;
                $byDay[$day]['leads']      = ($byDay[$day]['leads'] ?? 0) + 1;
            } elseif ($e === 'phone') {
                $stats['phone']++;
            }

            $recent[] = $r;
        }
        fclose($fh);
    }
}

$uniqueVisitors = count($visitors);
$totalLeads = $stats['leads'] + $stats['vacancy'];
$conv = $stats['pageviews'] > 0 ? round($totalLeads / $stats['pageviews'] * 100, 1) : 0;

/* Сортировки */
arsort($bySource);
arsort($byPage);
uasort($byCampaign, static function ($a, $b) {
    return ($b['pv'] ?? 0) <=> ($a['pv'] ?? 0);
});
ksort($byDay);
$recent = array_slice(array_reverse($recent), 0, 50);

/* Максимум для графика по дням */
$maxDayPv = 1;
foreach ($byDay as $d) { $maxDayPv = max($maxDayPv, $d['pv'] ?? 0); }

$h = static function ($v): string {
    return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
};
?>
<!doctype html>
<html lang="ru">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>Аналитика — <?php echo $h($siteName); ?></title>
<style>
  :root{
    --bg:#0f1622; --panel:#18212f; --panel2:#1e2a3a; --line:#2b394d;
    --ink:#e8edf4; --muted:#93a3b8; --accent:#ff7a1a; --accent2:#3aa0ff; --ok:#37c26b;
  }
  *{box-sizing:border-box}
  body{margin:0;background:var(--bg);color:var(--ink);font:15px/1.5 system-ui,-apple-system,Segoe UI,Roboto,sans-serif}
  a{color:var(--accent2)}
  .wrap{max-width:1100px;margin:0 auto;padding:24px 20px 60px}
  header.top{display:flex;flex-wrap:wrap;gap:12px;align-items:center;justify-content:space-between;margin-bottom:22px}
  h1{font-size:20px;margin:0;font-weight:700}
  h1 span{color:var(--accent)}
  h2{font-size:15px;text-transform:uppercase;letter-spacing:.05em;color:var(--muted);margin:28px 0 12px}
  .periods{display:flex;gap:6px}
  .periods a{padding:6px 12px;border-radius:8px;background:var(--panel);text-decoration:none;color:var(--muted);font-size:13px;border:1px solid var(--line)}
  .periods a.active{background:var(--accent);color:#111;border-color:var(--accent);font-weight:600}
  .cards{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:12px}
  .card{background:var(--panel);border:1px solid var(--line);border-radius:12px;padding:16px}
  .card .val{font-size:28px;font-weight:700;letter-spacing:-.02em}
  .card .lbl{color:var(--muted);font-size:13px;margin-top:2px}
  .card .val.accent{color:var(--accent)}
  .card .val.ok{color:var(--ok)}
  .grid2{display:grid;grid-template-columns:1fr 1fr;gap:20px}
  @media(max-width:820px){.grid2{grid-template-columns:1fr}}
  table{width:100%;border-collapse:collapse;background:var(--panel);border:1px solid var(--line);border-radius:12px;overflow:hidden}
  th,td{padding:9px 12px;text-align:left;border-bottom:1px solid var(--line);font-size:13px}
  th{color:var(--muted);font-weight:600;background:var(--panel2)}
  tr:last-child td{border-bottom:none}
  td.num,th.num{text-align:right;font-variant-numeric:tabular-nums}
  .bar{display:flex;align-items:center;gap:8px}
  .bar__track{flex:1;height:8px;background:var(--panel2);border-radius:99px;overflow:hidden}
  .bar__fill{height:100%;background:var(--accent);border-radius:99px}
  .chart{display:flex;align-items:flex-end;gap:3px;height:120px;background:var(--panel);border:1px solid var(--line);border-radius:12px;padding:14px}
  .chart__col{flex:1;display:flex;flex-direction:column;justify-content:flex-end;align-items:center;gap:4px;min-width:0}
  .chart__bar{width:100%;background:var(--accent2);border-radius:4px 4px 0 0;min-height:2px}
  .chart__bar.lead{background:var(--ok)}
  .chart__lbl{font-size:10px;color:var(--muted);white-space:nowrap;transform:rotate(-45deg);transform-origin:top;margin-top:6px}
  .tag{display:inline-block;padding:2px 8px;border-radius:6px;font-size:11px;font-weight:600}
  .tag.pv{background:rgba(58,160,255,.15);color:var(--accent2)}
  .tag.lead{background:rgba(55,194,107,.15);color:var(--ok)}
  .tag.vacancy{background:rgba(255,122,26,.15);color:var(--accent)}
  .tag.phone{background:rgba(147,163,184,.15);color:var(--muted)}
  .empty{color:var(--muted);padding:24px;text-align:center;background:var(--panel);border:1px solid var(--line);border-radius:12px}
  .note{color:var(--muted);font-size:12px;margin-top:8px}
</style>
</head>
<body>
<div class="wrap">
  <header class="top">
    <h1><?php echo $h($siteName); ?> <span>· Аналитика</span></h1>
    <div class="periods">
      <?php foreach ([7 => '7 дней', 30 => '30 дней', 90 => '90 дней'] as $d => $lbl): ?>
      <a href="?days=<?php echo $d; ?>" class="<?php echo $days === $d ? 'active' : ''; ?>"><?php echo $lbl; ?></a>
      <?php endforeach; ?>
    </div>
  </header>

  <!-- KPI -->
  <div class="cards">
    <div class="card"><div class="val"><?php echo number_format($uniqueVisitors, 0, '.', ' '); ?></div><div class="lbl">Уникальных посетителей</div></div>
    <div class="card"><div class="val"><?php echo number_format($stats['pageviews'], 0, '.', ' '); ?></div><div class="lbl">Просмотров страниц</div></div>
    <div class="card"><div class="val accent"><?php echo number_format($totalLeads, 0, '.', ' '); ?></div><div class="lbl">Заявок (лид + вакансия)</div></div>
    <div class="card"><div class="val ok"><?php echo $conv; ?>%</div><div class="lbl">Конверсия в заявку</div></div>
    <div class="card"><div class="val"><?php echo number_format($stats['phone'], 0, '.', ' '); ?></div><div class="lbl">Кликов по телефону</div></div>
  </div>

  <!-- График по дням -->
  <h2>Динамика по дням</h2>
  <?php if ($byDay): ?>
  <div class="chart">
    <?php foreach ($byDay as $day => $d):
      $pv = $d['pv'] ?? 0; $ld = $d['leads'] ?? 0;
      $hPv = (int) round(($pv / $maxDayPv) * 88);
      $hLd = $ld > 0 ? max(4, (int) round(($ld / $maxDayPv) * 88)) : 0;
    ?>
    <div class="chart__col" title="<?php echo $h($day); ?>: <?php echo $pv; ?> просмотров, <?php echo $ld; ?> заявок">
      <?php if ($hLd > 0): ?><div class="chart__bar lead" style="height:<?php echo $hLd; ?>px"></div><?php endif; ?>
      <div class="chart__bar" style="height:<?php echo $hPv; ?>px"></div>
      <div class="chart__lbl"><?php echo $h(date('d.m', strtotime($day))); ?></div>
    </div>
    <?php endforeach; ?>
  </div>
  <p class="note">Синий — просмотры, зелёный — заявки.</p>
  <?php else: ?>
  <div class="empty">Пока нет данных за выбранный период.</div>
  <?php endif; ?>

  <div class="grid2">
    <!-- Источники -->
    <div>
      <h2>Источники трафика</h2>
      <?php if ($bySource): ?>
      <table>
        <thead><tr><th>Источник (utm_source)</th><th class="num">Просмотры</th></tr></thead>
        <tbody>
        <?php $maxSrc = max($bySource); foreach (array_slice($bySource, 0, 10, true) as $src => $cnt): ?>
          <tr>
            <td>
              <div class="bar">
                <span><?php echo $h($src); ?></span>
              </div>
              <div class="bar__track" style="margin-top:6px"><div class="bar__fill" style="width:<?php echo (int) round($cnt / $maxSrc * 100); ?>%"></div></div>
            </td>
            <td class="num"><?php echo $cnt; ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
      <?php else: ?><div class="empty">Нет данных.</div><?php endif; ?>
    </div>

    <!-- Устройства -->
    <div>
      <h2>Устройства</h2>
      <?php $devTotal = array_sum($byDevice); if ($devTotal > 0): ?>
      <table>
        <thead><tr><th>Тип</th><th class="num">Просмотры</th><th class="num">Доля</th></tr></thead>
        <tbody>
        <?php
          $devNames = ['desktop' => 'Компьютер', 'mobile' => 'Смартфон', 'tablet' => 'Планшет'];
          foreach ($byDevice as $dev => $cnt):
        ?>
          <tr>
            <td><?php echo $h($devNames[$dev] ?? $dev); ?></td>
            <td class="num"><?php echo $cnt; ?></td>
            <td class="num"><?php echo $devTotal ? round($cnt / $devTotal * 100) : 0; ?>%</td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
      <?php else: ?><div class="empty">Нет данных.</div><?php endif; ?>
    </div>
  </div>

  <!-- Кампании -->
  <h2>Рекламные кампании (utm_campaign)</h2>
  <?php if ($byCampaign): ?>
  <table>
    <thead><tr><th>Кампания</th><th class="num">Просмотры</th><th class="num">Заявки</th><th class="num">Конверсия</th></tr></thead>
    <tbody>
    <?php foreach (array_slice($byCampaign, 0, 15, true) as $cmp => $d):
      $pv = $d['pv'] ?? 0; $ld = $d['leads'] ?? 0;
      $c = $pv > 0 ? round($ld / $pv * 100, 1) : 0;
    ?>
      <tr>
        <td><?php echo $h($cmp); ?></td>
        <td class="num"><?php echo $pv; ?></td>
        <td class="num"><?php echo $ld; ?></td>
        <td class="num"><?php echo $c; ?>%</td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <?php else: ?><div class="empty">Нет данных по кампаниям.</div><?php endif; ?>

  <!-- Популярные страницы -->
  <h2>Популярные страницы</h2>
  <?php if ($byPage): ?>
  <table>
    <thead><tr><th>Страница</th><th class="num">Просмотры</th></tr></thead>
    <tbody>
    <?php foreach (array_slice($byPage, 0, 15, true) as $path => $cnt): ?>
      <tr><td><?php echo $h($path); ?></td><td class="num"><?php echo $cnt; ?></td></tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <?php else: ?><div class="empty">Нет данных.</div><?php endif; ?>

  <!-- Последние события -->
  <h2>Последние события</h2>
  <?php if ($recent): ?>
  <table>
    <thead><tr><th>Время</th><th>Событие</th><th>Страница</th><th>Источник</th><th>Устройство</th></tr></thead>
    <tbody>
    <?php foreach ($recent as $r):
      $e = $r['e'] ?? 'other';
      $tagClass = in_array($e, ['lead','vacancy','phone'], true) ? $e : 'pv';
    ?>
      <tr>
        <td><?php echo $h(date('d.m H:i', strtotime($r['ts'] ?? 'now'))); ?></td>
        <td><span class="tag <?php echo $h($tagClass); ?>"><?php echo $h($e); ?></span></td>
        <td><?php echo $h($r['path'] ?? ''); ?></td>
        <td><?php echo $h(($r['utm_source'] ?? '') !== '' ? $r['utm_source'] : '—'); ?></td>
        <td><?php echo $h($r['device'] ?? ''); ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <?php else: ?><div class="empty">Пока нет событий. Данные появятся после первых визитов с согласием на cookie.</div><?php endif; ?>

  <p class="note">
    Данные собираются только после согласия посетителя на обработку cookie (152-ФЗ).
    IP-адреса не хранятся — только необратимый хэш. Боты исключены из статистики.
  </p>
</div>
</body>
</html>
