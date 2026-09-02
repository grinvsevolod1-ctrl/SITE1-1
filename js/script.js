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
        // Собственная first-party аналитика: определяем тип формы по скрытому полю form_type
        try {
            var ftEl = document.querySelector('#lead-form [name="form_type"]');
            var ft = ftEl ? ftEl.value : 'lead';
            document.dispatchEvent(new CustomEvent('elg:lead', { detail: { type: ft, label: ft } }));
        } catch (e) {}
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
            if (!item) return;
            var open = item.classList.toggle('is-open');
            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    });

    /* ---------------- Калькулятор стоимости ---------------- */
    var calcForm = document.getElementById('calc-form');

    if (calcForm) {
        // Ориентировочные ставки (рубли). Точную цену считает менеджер.
        var RATES = {
            ltl:       { perKgKm: 0.06, base: 3000, min: 3000, density: 250, label: 'Сборный груз (LTL)' },
            ftl:       { perKm: 55, base: 5000, min: 25000, label: 'Отдельная машина (FTL)' },
            oversized: { perKm: 88, base: 20000, min: 45000, label: 'Крупногабарит / негабарит' }
        };

        var errEl    = document.getElementById('calc-error');
        var placeholder = document.getElementById('calc-placeholder');
        var output   = document.getElementById('calc-output');
        var priceEl  = document.getElementById('calc-price');
        var breakdownEl = document.getElementById('calc-breakdown');
        var serviceEl = document.getElementById('c-service');
        var cargoRow = calcForm.querySelector('[data-role="cargo"]');

        function fmt(n) {
            return Math.round(n).toLocaleString('ru-RU') + ' ₽';
        }

        function showError(msg) {
            if (!errEl) return;
            errEl.textContent = msg;
            errEl.hidden = false;
        }
        function clearError() { if (errEl) errEl.hidden = true; }

        // Вес/объём нужны только для сборных грузов
        function syncCargoVisibility() {
            if (!cargoRow) return;
            cargoRow.style.display = serviceEl.value === 'ltl' ? '' : 'none';
        }
        serviceEl.addEventListener('change', syncCargoVisibility);
        syncCargoVisibility();

        calcForm.addEventListener('submit', function (evt) {
            evt.preventDefault();
            clearError();

            var service = serviceEl.value;
            var distance = parseFloat(document.getElementById('c-distance').value);
            var rate = RATES[service];

            if (!distance || distance <= 0) {
                showError('Укажите расстояние в к��лометрах.');
                return;
            }

            var rows = [];
            var total;

            if (service === 'ltl') {
                var weight = parseFloat(document.getElementById('c-weight').value);
                var volume = parseFloat(document.getElementById('c-volume').value) || 0;
                if (!weight || weight <= 0) {
                    showError('Для сборного груза укажите вес в килограммах.');
                    return;
                }
                var volumetric = volume * rate.density;
                var chargeable = Math.max(weight, volumetric);
                total = rate.base + chargeable * rate.perKgKm * (distance / 1000);
                total = Math.max(total, rate.min);

                rows.push(['Тип перевозки', rate.label]);
                rows.push(['Расстояние', Math.round(distance).toLocaleString('ru-RU') + ' км']);
                rows.push(['Расчётный вес', Math.round(chargeable).toLocaleString('ru-RU') + ' кг' + (volumetric > weight ? ' (по объёму)' : '')]);
                if (chargeable > 5000) {
                    rows.push(['Рекомендация', 'При таком весе выгоднее отдельная машина (FTL)']);
                }
            } else {
                total = rate.base + distance * rate.perKm;
                total = Math.max(total, rate.min);
                rows.push(['Тип перевозки', rate.label]);
                rows.push(['Расстояние', Math.round(distance).toLocaleString('ru-RU') + ' км']);
                if (service === 'oversized') {
                    rows.push(['Учтено', 'Спецтранспорт, разрешения и сопровождение']);
                }
            }

            // Диапазон ±12%
            var low = total * 0.88;
            var high = total * 1.12;
            priceEl.textContent = fmt(low) + ' — ' + fmt(high);

            breakdownEl.innerHTML = '';
            rows.forEach(function (r) {
                var li = document.createElement('li');
                var k = document.createElement('span');
                k.textContent = r[0];
                var v = document.createElement('b');
                v.textContent = r[1];
                li.appendChild(k);
                li.appendChild(v);
                breakdownEl.appendChild(li);
            });

            if (placeholder) placeholder.hidden = true;
            if (output) output.hidden = false;

            // Цель в аналитику
            if (typeof window.ym === 'function' && window.YM_ID) window.ym(window.YM_ID, 'reachGoal', 'calc_use');
            if (typeof window.gtag === 'function') window.gtag('event', 'calc_use', { event_category: 'calculator', event_label: service });
        });
    }

    /* ---------------- Куки-уведомление (152-ФЗ) ---------------- */
    var cookieBar = document.getElementById('cookie-bar');
    var cookieAccept = document.getElementById('cookie-accept');

    if (cookieBar && cookieAccept) {
        var accepted = document.cookie.indexOf('cookie_consent=1') !== -1;
        if (!accepted) {
            cookieBar.hidden = false;
            // Плавное появление после отрисовки
            requestAnimationFrame(function () {
                requestAnimationFrame(function () { cookieBar.classList.add('is-visible'); });
            });
            cookieAccept.addEventListener('click', function () {
                var d = new Date();
                d.setFullYear(d.getFullYear() + 1);
                document.cookie = 'cookie_consent=1; expires=' + d.toUTCString() + '; path=/; SameSite=Lax';
                cookieBar.classList.remove('is-visible');
                setTimeout(function () { cookieBar.hidden = true; }, 400);
            });
        }
    }
})();
