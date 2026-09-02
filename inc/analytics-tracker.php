<?php
/**
 * ExpressLogist — инлайн-трекер first-party аналитики.
 *
 * Подключается перед </body> на страницах, где нужна аналитика:
 *   <?php include INC . '/analytics-tracker.php'; ?>
 *
 * Отправляет события на /a/c.php через navigator.sendBeacon (свой домен —
 * не блокируется антитрекерами). Работает ТОЛЬКО после согласия
 * (cookie_consent=1). UTM-метки берутся из URL и запоминаются на время сессии,
 * чтобы конверсия (отправка формы) корректно связалась с источником рекламы.
 *
 * Требует, чтобы ранее был подключён config.php (нужен $analytics и хелпер e()).
 */

if (empty($analytics['enabled'])) {
    return;
}

/* Абсолютный путь до коллектора от корня сайта. */
$collectorUrl = '/a/c.php';
?>
<script>
(function () {
  'use strict';

  var ENDPOINT = <?php echo json_encode($collectorUrl); ?>;

  /* Сбор только после согласия пользователя. */
  function hasConsent() {
    return document.cookie.indexOf('cookie_consent=1') !== -1;
  }

  /* --- UTM-метки: читаем из URL, запоминаем в sessionStorage --- */
  var UTM_KEYS = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content'];
  function captureUtm() {
    try {
      var params = new URLSearchParams(window.location.search);
      var found = false;
      UTM_KEYS.forEach(function (k) {
        var v = params.get(k);
        if (v) { sessionStorage.setItem('elg_' + k, v.slice(0, 150)); found = true; }
      });
      /* Если пришли по рекламе без utm, но есть внешний реферер — запомним его. */
      if (!found && document.referrer && document.referrer.indexOf(location.host) === -1) {
        if (!sessionStorage.getItem('elg_utm_source')) {
          sessionStorage.setItem('elg_utm_source', 'referral');
        }
      }
    } catch (e) {}
  }
  function utm(key) {
    try { return sessionStorage.getItem('elg_' + key) || ''; } catch (e) { return ''; }
  }

  /* --- Отправка события --- */
  function send(event, label) {
    if (!hasConsent()) return;
    var payload = {
      e: event,
      p: location.pathname,
      r: document.referrer || '',
      us: utm('utm_source'),
      um: utm('utm_medium'),
      uc: utm('utm_campaign'),
      ut: utm('utm_term'),
      un: utm('utm_content'),
      l: label || ''
    };
    var body = JSON.stringify(payload);
    try {
      if (navigator.sendBeacon) {
        navigator.sendBeacon(ENDPOINT, new Blob([body], { type: 'application/json' }));
      } else {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', ENDPOINT, true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.send(body);
      }
    } catch (e) {}
  }

  /* --- Инициализация --- */
  captureUtm();

  /* Просмотр страницы (после согласия; если согласие дадут позже — событие
     уйдёт при первом взаимодействии). */
  function firePageview() {
    if (fired) return;
    if (hasConsent()) { send('pageview'); fired = true; }
  }
  var fired = false;
  if (document.readyState === 'complete' || document.readyState === 'interactive') {
    firePageview();
  } else {
    document.addEventListener('DOMContentLoaded', firePageview);
  }
  /* Если согласие дают в баннере уже после загрузки — ловим клик и шлём pageview. */
  document.addEventListener('click', function (ev) {
    var accept = ev.target && ev.target.id === 'cookie-accept';
    if (accept) { setTimeout(firePageview, 50); }
  });

  /* Клики по телефонам. */
  document.addEventListener('click', function (ev) {
    var a = ev.target.closest && ev.target.closest('a[href^="tel:"]');
    if (a) { send('phone', a.getAttribute('href').replace('tel:', '')); }
  });

  /* Успешная отправка формы — конверсия. Слушаем кастомное событие,
     которое шлёт основной script.js после ответа сервера. */
  document.addEventListener('elg:lead', function (ev) {
    var type = (ev.detail && ev.detail.type) || 'lead';
    send(type === 'vacancy' ? 'vacancy' : 'lead', (ev.detail && ev.detail.label) || '');
  });

  /* Глубина прокрутки (одноразово на 75%). */
  var scrolled = false;
  window.addEventListener('scroll', function () {
    if (scrolled) return;
    var h = document.documentElement;
    var depth = (h.scrollTop + window.innerHeight) / h.scrollHeight;
    if (depth >= 0.75) { scrolled = true; send('scroll', '75'); }
  }, { passive: true });

})();
</script>
