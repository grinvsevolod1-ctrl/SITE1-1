<?php
/**
 * Общий футер сайта (используется на главной и во всех страницах силоса).
 * "Контакты" на прочих страницах ведут на секцию контактов главной ("/#contacts"),
 * на самой главной футер выступает и как секция #contacts.
 */
?>
<footer class="footer" id="contacts">
    <div class="container footer__inner">
        <div class="footer__brand">
            <span class="logo__text logo__text--light">Express<span>Logist</span></span>
            <a href="tel:88005553535" class="footer__phone">8 (800) 555-35-35</a>
        </div>
        <p class="footer__copy">© 2026 ExpressLogist. Все права защищены</p>
        <nav class="footer__links" aria-label="Дополнительные ссылки">
            <a href="/o-kompanii/" class="footer__link">О компании и условия работы</a>
            <a href="#" class="footer__link">Политика конфиденциальности</a>
        </nav>
    </div>
</footer>
