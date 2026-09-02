<?php
require __DIR__ . '/../inc/config.php';
require __DIR__ . '/../inc/nav-data.php';

$pageTitle       = 'Калькулятор стоимости доставки груза по СНГ — ExpressLogist';
$pageDescription = 'Онлайн-калькулятор ориентировочной стоимости перевозки груза по России и СНГ. Рассчитайте цену сборной, отдельной машины или негабарита по расстоянию и весу за минуту.';
$pageUrl         = '/kalkulyator/';
$assetsPrefix    = '../';
$navActive       = 'services';

$crumbs = [
    ['title' => 'Главная', 'url' => '/'],
    ['title' => 'Калькулятор доставки', 'url' => null],
];

require __DIR__ . '/../inc/head.php';
require __DIR__ . '/../inc/header.php';
?>
<main id="main">
    <section class="page-hero">
        <div class="container">
            <h1>Калькулятор стоимости доставки</h1>
            <p>Оцените стоимость перевозки груза по СНГ за минуту. Точную цену с учётом маршрута, загрузки и документов рассчитает менеджер.</p>
        </div>
    </section>

    <div class="container"><?php require INC . '/breadcrumbs.php'; ?></div>

    <section class="section section--tight">
        <div class="container">
            <div class="calc" id="calc">
                <form class="calc__form" id="calc-form" novalidate>
                    <div class="calc__row">
                        <div class="field">
                            <label class="field__label" for="c-service">Тип перевозки</label>
                            <select class="select" id="c-service" name="service">
                                <option value="ltl">Сборный груз (LTL)</option>
                                <option value="ftl">Отдельная машина (FTL)</option>
                                <option value="oversized">Крупногабарит / негабарит</option>
                            </select>
                        </div>
                        <div class="field">
                            <label class="field__label" for="c-distance">Расстояние, км</label>
                            <input class="input" type="number" id="c-distance" name="distance" min="1" step="10" placeholder="Например, 1200" list="c-routes">
                            <datalist id="c-routes">
                                <option value="720" label="Москва — Минск ≈ 720 км"></option>
                                <option value="1470" label="Москва — Кишинёв ≈ 1470 км"></option>
                                <option value="2280" label="Москва — Баку ≈ 2280 км"></option>
                                <option value="2700" label="Москва — Астана ≈ 2700 км"></option>
                                <option value="3400" label="Москва — Ташкент ≈ 3400 км"></option>
                                <option value="3700" label="Москва — Бишкек ≈ 3700 км"></option>
                            </datalist>
                        </div>
                    </div>

                    <div class="calc__row" data-role="cargo">
                        <div class="field">
                            <label class="field__label" for="c-weight">Вес груза, кг</label>
                            <input class="input" type="number" id="c-weight" name="weight" min="1" step="1" placeholder="Например, 500">
                        </div>
                        <div class="field">
                            <label class="field__label" for="c-volume">Объём, м³ <span class="field__hint">(необязательно)</span></label>
                            <input class="input" type="number" id="c-volume" name="volume" min="0" step="0.1" placeholder="Например, 2.5">
                        </div>
                    </div>

                    <p class="calc__note" id="calc-error" role="alert" hidden></p>
                    <button type="submit" class="btn btn--accent btn--block">Рассчитать стоимость</button>
                </form>

                <aside class="calc__result" id="calc-result" aria-live="polite">
                    <div class="calc__placeholder" id="calc-placeholder">
                        <p>Заполните параметры груза слева — и мы покажем ориентировочную стоимость перевозки.</p>
                    </div>
                    <div class="calc__output" id="calc-output" hidden>
                        <span class="calc__label">Ориентировочная стоимость</span>
                        <span class="calc__price" id="calc-price">—</span>
                        <ul class="calc__breakdown" id="calc-breakdown"></ul>
                        <p class="calc__disclaimer">Расчёт предварительный. Итоговая стоимость зависит от точного маршрута, характера груза, срочности и оформления документов.</p>
                        <a href="/#form" class="btn btn--accent btn--block">Получить точный расчёт</a>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <section class="section section--mist">
        <div class="container">
            <div class="section__head">
                <span class="eyebrow">Как это работает</span>
                <h2 class="section__title">От оценки до доставленного груза</h2>
            </div>
            <div class="steps steps--row">
                <div class="step">
                    <div class="step__num"></div>
                    <h3 class="step__title">Предварительная оценка</h3>
                    <p class="step__text">Калькулятор даёт ориентир по стоимости на основе расстояния, веса и типа перевозки.</p>
                </div>
                <div class="step">
                    <div class="step__num"></div>
                    <h3 class="step__title">Заявка менеджеру</h3>
                    <p class="step__text">Оставляете заявку — уточняем маршрут, загрузку и сроки, готовим точную цену.</p>
                </div>
                <div class="step">
                    <div class="step__num"></div>
                    <h3 class="step__title">Договор и подача</h3>
                    <p class="step__text">Фиксируем условия в договоре и подаём подходящий транспорт к отправителю.</p>
                </div>
                <div class="step">
                    <div class="step__num"></div>
                    <h3 class="step__title">Доставка</h3>
                    <p class="step__text">Везём груз с контролем на всех этапах и закрываем перевозку документами.</p>
                </div>
            </div>
        </div>
    </section>
</main>
<?php require INC . '/footer.php'; ?>
