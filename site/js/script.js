/**
 * ExpressLogist — клиентская логика лендинга
 *  1. Бургер-меню на мобильных
 *  2. Маска телефона +7 (___) ___-__-__
 *  3. Валидация формы на клиенте
 *  4. AJAX-отправка на send.php без перезагрузки
 *  5. Всплывающее сообщение об успехе + цель Яндекс.Метрики
 *  6. Плавное появление блоков при скролле
 */
(function () {
    'use strict';

    /* ------------------------------------------------------------------
       1. Бургер-меню
    ------------------------------------------------------------------ */
    var burger = document.getElementById('burger');
    var nav = document.getElementById('nav');

    function closeMenu() {
        nav.classList.remove('is-open');
        burger.classList.remove('is-open');
        burger.setAttribute('aria-expanded', 'false');
        burger.setAttribute('aria-label', 'Открыть меню');
    }

    if (burger && nav) {
        burger.addEventListener('click', function () {
            var open = nav.classList.toggle('is-open');
            burger.classList.toggle('is-open', open);
            burger.setAttribute('aria-expanded', open ? 'true' : 'false');
            burger.setAttribute('aria-label', open ? 'Закрыть меню' : 'Открыть меню');
        });

        // Закрываем меню после перехода по ссылке
        nav.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', closeMenu);
        });
    }

    /* ------------------------------------------------------------------
       2. Маска телефона: +7 (___) ___-__-__
       Хранит только цифры, форматирует при каждом вводе.
    ------------------------------------------------------------------ */
    var phoneInput = document.getElementById('phone');

    /** Возвращает 10 цифр номера без кода страны */
    function getPhoneDigits(value) {
        var digits = value.replace(/\D/g, '');
        // Нормализуем начало: 8xxx / 7xxx -> xxx
        if (digits.length && (digits[0] === '7' || digits[0] === '8')) {
            digits = digits.slice(1);
        }
        return digits.slice(0, 10);
    }

    /** Форматирует 10 цифр в маску */
    function formatPhone(digits) {
        if (!digits.length) return '';
        var out = '+7 (' + digits.slice(0, 3);
        if (digits.length >= 3) out += ') ';
        if (digits.length > 3) out += digits.slice(3, 6);
        if (digits.length > 6) out += '-' + digits.slice(6, 8);
        if (digits.length > 8) out += '-' + digits.slice(8, 10);
        return out;
    }

    if (phoneInput) {
        phoneInput.addEventListener('input', function () {
            var digits = getPhoneDigits(phoneInput.value);
            phoneInput.value = formatPhone(digits);
        });

        // При фокусе на пустом поле сразу ставим +7 (
        phoneInput.addEventListener('focus', function () {
            if (!phoneInput.value) phoneInput.value = '+7 (';
        });

        // Если пользователь ничего не ввёл — очищаем поле
        phoneInput.addEventListener('blur', function () {
            if (getPhoneDigits(phoneInput.value).length === 0) phoneInput.value = '';
        });

        // Backspace не должен «застревать» на скобке/дефисе
        phoneInput.addEventListener('keydown', function (e) {
            if (e.key === 'Backspace') {
                var digits = getPhoneDigits(phoneInput.value);
                var pos = phoneInput.selectionStart;
                if (pos === phoneInput.value.length && digits.length) {
                    e.preventDefault();
                    phoneInput.value = formatPhone(digits.slice(0, -1));
                }
            }
        });
    }

    /* ------------------------------------------------------------------
       3. Валидация
    ------------------------------------------------------------------ */
    var form = document.getElementById('leadForm');
    if (!form) return;

    var submitBtn = document.getElementById('submitBtn');
    var statusEl = document.getElementById('formStatus');

    function setError(name, message) {
        var field = form.querySelector('[name="' + name + '"]').closest('.form__field');
        var errorEl = field.querySelector('.form__error');
        if (message) {
            field.classList.add('is-invalid');
            errorEl.textContent = message;
        } else {
            field.classList.remove('is-invalid');
            errorEl.textContent = '';
        }
    }

    /** Проверяет форму, расставляет ошибки, возвращает true если всё ок */
    function validate() {
        var ok = true;

        var name = form.name.value.trim();
        if (name.length < 2) {
            setError('name', 'Введите имя (минимум 2 символа)');
            ok = false;
        } else {
            setError('name', '');
        }

        var digits = getPhoneDigits(form.phone.value);
        if (digits.length !== 10) {
            setError('phone', 'Введите телефон полностью: +7 (___) ___-__-__');
            ok = false;
        } else {
            setError('phone', '');
        }

        if (!form.city.value) {
            setError('city', 'Выберите город из списка');
            ok = false;
        } else {
            setError('city', '');
        }

        if (!form.agree.checked) {
            setError('agree', 'Необходимо согласие на обработку данных');
            ok = false;
        } else {
            setError('agree', '');
        }

        return ok;
    }

    // Сбрасываем ошибку поля, как только пользователь начал его исправлять
    ['name', 'phone', 'city', 'agree'].forEach(function (n) {
        form[n].addEventListener('input', function () { setError(n, ''); });
        form[n].addEventListener('change', function () { setError(n, ''); });
    });

    function showStatus(message) {
        statusEl.textContent = message || '';
        statusEl.classList.toggle('is-visible', !!message);
    }

    /* ------------------------------------------------------------------
       4. AJAX-отправка
    ------------------------------------------------------------------ */
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        showStatus('');

        if (!validate()) {
            // Фокус на первое поле с ошибкой
            var first = form.querySelector('.is-invalid .form__input, .is-invalid input');
            if (first) first.focus();
            return;
        }

        var data = new FormData();
        data.append('name', form.name.value.trim());
        data.append('phone', '7' + getPhoneDigits(form.phone.value)); // 11 цифр
        data.append('city', form.city.value);
        data.append('agree', '1');

        submitBtn.disabled = true;
        submitBtn.classList.add('is-loading');

        fetch(form.getAttribute('action'), {
            method: 'POST',
            body: data,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
            .then(function (res) { return res.json(); })
            .then(function (json) {
                if (json && json.success) {
                    form.reset();
                    openModal();
                    // Цель Яндекс.Метрики «lead» (см. настройку в index.php)
                    if (typeof window.ym === 'function' && window.YM_ID) {
                        window.ym(window.YM_ID, 'reachGoal', 'lead');
                    }
                } else {
                    // Сервер вернул ошибки валидации по полям
                    if (json && json.errors) {
                        Object.keys(json.errors).forEach(function (key) {
                            setError(key, json.errors[key]);
                        });
                    }
                    showStatus((json && json.message) || 'Не удалось отправить заявку. Попробуйте ещё раз.');
                }
            })
            .catch(function () {
                showStatus('Ошибка соединения. Проверьте интернет и попробуйте снова.');
            })
            .finally(function () {
                submitBtn.disabled = false;
                submitBtn.classList.remove('is-loading');
            });
    });

    /* ------------------------------------------------------------------
       5. Модальное окно успеха
    ------------------------------------------------------------------ */
    var modal = document.getElementById('successModal');

    function openModal() {
        modal.hidden = false;
        document.body.style.overflow = 'hidden';
        var btn = modal.querySelector('.btn');
        if (btn) btn.focus();
    }

    function closeModal() {
        modal.hidden = true;
        document.body.style.overflow = '';
    }

    modal.querySelectorAll('[data-close]').forEach(function (el) {
        el.addEventListener('click', closeModal);
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !modal.hidden) closeModal();
    });

    /* ------------------------------------------------------------------
       6. Появление блоков при скролле
    ------------------------------------------------------------------ */
    if ('IntersectionObserver' in window) {
        var targets = document.querySelectorAll('.feature, .stat, .lead__card, .cities__list');
        targets.forEach(function (el) { el.classList.add('reveal'); });

        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });

        targets.forEach(function (el) { io.observe(el); });
    }
})();
