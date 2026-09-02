/* ==========================================================================
   ExpressLogist — клиентские скрипты (без зависимостей).
   1. Мобильное меню (бургер).
   2. Отправка формы заявки на send.php с валидацией и статусами.
   3. Отправка целей в Яндекс.Метрику и Google Analytics.
   4. Аккордеон FAQ.
   ========================================================================== */
(function () {
    'use strict';

    /* ---------------- Мобильное меню ---------------- */
    var burger = document.getElementById('burger');
    var nav = document.getElementById('nav');

    if (burger && nav) {
        burger.addEventListener('click', function () {
            var open = nav.classList.toggle('is-open');
            burger.setAttribute('aria-expanded', open ? 'true' : 'false');
            burger.setAttribute('aria-label', open ? 'Закрыть меню' : 'Открыть меню');
        });

        // Закрываем меню при клике по ссылке
        nav.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                nav.classList.remove('is-open');
                burger.setAttribute('aria-expanded', 'false');
            });
        });
    }

    /* ---------------- Отправка цели в аналитику ---------------- */
    function trackLead() {
        // Яндекс.Метрика
        if (typeof window.ym === 'function' && window.YM_ID) {
            window.ym(window.YM_ID, 'reachGoal', 'lead_submit');
        }
        // Google Analytics 4
        if (typeof window.gtag === 'function') {
            window.gtag('event', 'lead_submit', { event_category: 'form', event_label: 'request' });
        }
    }

    /* ---------------- Форма заявки ---------------- */
    var form = document.getElementById('lead-form');

    if (form) {
        var statusEl = form.querySelector('.form-status');
        var submitBtn = form.querySelector('[type="submit"]');

        function clearErrors() {
            form.querySelectorAll('.is-invalid').forEach(function (el) { el.classList.remove('is-invalid'); });
            form.querySelectorAll('.field__error').forEach(function (el) {
                el.classList.remove('is-visible');
                el.textContent = '';
            });
        }

        function showError(name, message) {
            var input = form.querySelector('[name="' + name + '"]');
            var box = form.querySelector('[data-error="' + name + '"]');
            if (input) input.classList.add('is-invalid');
            if (box) { box.textContent = message; box.classList.add('is-visible'); }
        }

        function setStatus(type, message) {
            if (!statusEl) return;
            statusEl.className = 'form-status is-' + type;
            statusEl.textContent = message;
        }

        form.addEventListener('submit', function (evt) {
            evt.preventDefault();
            clearErrors();
            if (statusEl) statusEl.className = 'form-status';

            if (submitBtn) { submitBtn.disabled = true; submitBtn.dataset.label = submitBtn.textContent; submitBtn.textContent = 'Отправляем…'; }

            var data = new FormData(form);

            fetch(form.getAttribute('action') || '/send.php', {
                method: 'POST',
                body: data,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(function (res) { return res.json().then(function (json) { return { ok: res.ok, json: json }; }); })
                .then(function (result) {
                    var json = result.json || {};
                    if (result.ok && json.success) {
                        form.reset();
                        setStatus('success', json.message || 'Заявка отправлена.');
                        trackLead();
                    } else {
                        if (json.errors) {
                            Object.keys(json.errors).forEach(function (key) { showError(key, json.errors[key]); });
                        }
                        setStatus('error', json.message || 'Не удалось отправить заявку. Попробуйте позже.');
                    }
                })
                .catch(function () {
                    setStatus('error', 'Ошибка сети. Проверьте соединение и попробуйте снова.');
                })
                .finally(function () {
                    if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = submitBtn.dataset.label || 'Отправить заявку'; }
                });
        });
    }

    /* ---------------- Клики по телефону как цель ---------------- */
    document.querySelectorAll('a[href^="tel:"]').forEach(function (el) {
        el.addEventListener('click', function () {
            if (typeof window.ym === 'function' && window.YM_ID) window.ym(window.YM_ID, 'reachGoal', 'phone_click');
            if (typeof window.gtag === 'function') window.gtag('event', 'phone_click', { event_category: 'contact' });
        });
    });

    /* ---------------- FAQ аккордеон ---------------- */
    document.querySelectorAll('.faq__q').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var item = btn.closest('.faq__item');
            if (item) item.classList.toggle('is-open');
        });
    });
})();
