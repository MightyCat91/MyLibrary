<div class="footer align-self-end">
    <div class="footer-grids">
        <div class="footer-top">
            <div class="footer-top-nav">
                <ul>
                    <li><a href="privacy.html">Пользовательское соглашение</a></li>
                    <li><a href="terms.html">Правила</a></li>
                    <li><a href="copyright.html">Для правообладателей</a></li>
                </ul>
            </div>
            <div class="footer-bottom-nav">
                <ul>
                    <li><a href="about.html">О проекте</a></li>
                    <li><a href="developers.html">Контакты</a></li>
                    <li><a href="faq.html">FAQ</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <ul>
                <li><a href="#small-dialog3" class="play-icon popup-with-zoom-anim">Свяжись с нами</a></li>
                <li><a href="#small-dialog4" class="f-history">Подписаться</a></li>
                <li><a href="#small-dialog5" class="play-icon popup-with-zoom-anim f-history f-help">Карта сайта</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('/js/Library/jQuery/jquery-2.1.4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/Library/Tether/tether.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/Library/Bootstrap/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/Custom/general.js') }}"></script>
@if (Auth::guest())
    <script type="text/javascript" src="{{ asset('/js/Custom/authentication.js') }}"></script>
@endif
@stack('scripts')
</body>
</html>