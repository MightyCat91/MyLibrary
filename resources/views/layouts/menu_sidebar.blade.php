<aside class="sidebar">
    @if (Auth::check())
        @include('user.userWrapper')
    @endif
    <div id="navigation">
        <section id="menu-content">
            <a href="{{ route('home') }}" class="nav-item {{ active('home') }}">
                <i class="fa fa-home fa-lg fa-fw nav-item-icon" aria-hidden="true"></i>

                <div class="nav-item-name">Главная</div>
            </a>
            <a href="{{ route('authors') }}" class="nav-item {{ active('authors') }}">
                <i class="fa fa-users fa-lg fa-fw nav-item-icon" aria-hidden="true"></i>

                <div class="nav-item-name">Авторы</div>
            </a>
            <a href="{{ route('books') }}" class="nav-item {{ active('books') }}">
                <i class="fa fa-book fa-lg fa-fw nav-item-icon" aria-hidden="true"></i>

                <div class="nav-item-name">Книги</div>
            </a>
            <a href="{{ route('categories') }}" class="nav-item {{ active('categories') }}">
                <i class="fa fa-list fa-lg fa-fw nav-item-icon" aria-hidden="true"></i>

                <div class="nav-item-name">Жанры</div>
            </a>
            <a href="{{ route('reviews') }}" class="nav-item {{ active('reviews') }}">
                <i class="fa fa-list fa-lg fa-fw nav-item-icon" aria-hidden="true"></i>

                <div class="nav-item-name">Рецензии</div>
            </a>
            @if (Auth::check())
                <a href="{{ route('author-add-get') }}" class="nav-item {{ active('author-add-get') }}">
                    <div class="icon-stack fa-fw nav-item-icon">
                        <i class="fa fa-user"></i>
                        <i class="fa fa-plus"></i>
                    </div>
                    <div class="nav-item-name">Добавить автора</div>
                </a>
                <a href="{{ route('book-add-get') }}" class="nav-item {{ active('book-add-get') }}">
                    <div class="icon-stack fa-fw nav-item-icon">
                        <i class="fa fa-book"></i>
                        <i class="fa fa-plus"></i>
                    </div>
                    <div class="nav-item-name">Добавить книгу</div>
                </a>
                <a href="{{ route('createSelections') }}" class="nav-item {{ active('createSelections') }}">
                    <div class="icon-stack fa-fw nav-item-icon">
                        <i class="fa fa-book"></i>
                        <i class="fa fa-plus"></i>
                    </div>
                    <div class="nav-item-name">Создать подборку</div>
                </a>
            @endif
        </section>
    </div>
    <div id="bottom-container">
        @if (Auth::guest())
            <div id="login-form-wrapper"
                 class="{{ isset($errors) and $errors->hasAny(['email', 'password']) ? 'active' : '' }}">
                <form id="login-form" role="form" method="POST" action="{{  route('login') }}">
                    {{ csrf_field() }}
                    <div id="authLinks">
                        <a href="#" id="registerLink">Регистрация</a>
                        <a href="#" id="resetPassLink">Забыли пароль?</a>
                    </div>
                    <div id="login-form-container">
                        <div class="form-group {{ isset($errors) and $errors->has('email') ? 'has-danger' : '' }}">

                            <input id="email" type="email" name="email" placeholder="Email"
                                   value="{{ old('email') }}"
                                   required>
                        </div>
                        <div class="form-group {{ isset($errors) and $errors->has('password') ? 'has-danger' : '' }}">
                            <input id="password" type="password" name="password" placeholder="Пароль" required>
                        </div>

                        <div id="login-button">
                            <button type="submit">
                                <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <div id="remember-checkbox" class="auth-checkbox">
                        <label>
                            <input type="checkbox"
                                   name="remember" {{ (old('remember') ? 'checked' : '') }}>
                            Запомнить меня
                        </label>
                    </div>
                </form>
                <button type="button" class="close close-btn" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <a href="#" id="login" class="nav-item hidden">
                <i class="fa fa-sign-in fa-lg fa-fw nav-item-icon" aria-hidden="true"></i>

                <div class="nav-item-name">Войти</div>
            </a>
        @else
            <a href="{{ route('logout') }}" class="nav-item"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt fa-lg nav-item-icon" aria-hidden="true"></i>

                <div class="nav-item-name">Выйти</div>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                {{ csrf_field() }}
            </form>
        @endif
        @if (Auth::guest())
            <div id="register-form-container" class="{{ isset($errors) and $errors->hasAny(['name', 'registerEmail', 'registerPassword',
    'privacyPolicy', 'emailReset']) ? 'active' : '' }}">
                <form id="register-form" method="POST" action="{{ route('register') }}" class="signup-form
              {{ isset($errors) and $errors->hasAny(['name', 'registerEmail', 'registerPassword', 'privacyPolicy']) ?
               '' : 'hidden' }}">
                    {{ csrf_field() }}
                    <section id="auth-signup">
                        <div>
                            <div class="form-group {{ isset($errors) and $errors->has('name') ? 'has-danger' : '' }}">
                                <input id="name" type="text" name="name" placeholder="Имя"
                                       value="{{ old('name') ?? '' }}" required>
                            </div>
                            <div class="form-group {{ isset($errors) and $errors->has('registerEmail') ? 'has-danger' : '' }}">
                                <input id="registerEmail" type="email" name="registerEmail" placeholder="Email"
                                       value="{{ old('registerEmail') ?? ''}}" required>
                            </div>
                            <div class="form-group {{ isset($errors) and $errors->has('registerPassword') ? 'has-danger' : '' }}">
                                <input id="registerPassword" type="password" name="registerPassword"
                                       placeholder="Пароль"
                                       required>
                            </div>
                            <div class="form-group auth-checkbox">
                                <label>
                                    <input type="checkbox"
                                           name="subscribe[]" {{ old('subscribe') ? 'checked' : '' }}>
                                    Присылайте мне на почту важные уведомления
                                </label>
                            </div>
                            <div class="form-group auth-checkbox {{ isset($errors) and $errors->has('privacyPolicy') ? 'has-danger' : '' }}">
                                <label>
                                    <input type="checkbox" name="privacyPolicy"
                                           {{ old('privacyPolicy') ? 'checked' : '' }}
                                           required>Я принимаю пользовательское соглашение
                                    <a href="{{ route('privacyPolicy') }}" id="privacyPolicy"> Прочитать</a>
                                </label>
                            </div>
                            <button type="submit" id="register-btn" class="btn submit-btn auth-btn">
                                Зарегистрироваться
                            </button>
                        </div>
                        <div id="open-social-btn" class="chg-auth-type">
                            <i class="fas fa-arrow-circle-right fa-lg"></i>
                        </div>
                    </section>
                    <section id="auth-signup-social">
                        <div id="open-register-form" class="chg-auth-type">
                            <i class="fa fa-lg fa-arrow-circle-left" aria-hidden="true"></i>
                        </div>
                        <div>
                            <div class="social-column">
                                <a class="btn btn-social-icon btn-twitter">
                                    <span><i class="fab fa-twitter"></i></span>

                                </a>
                                <a class="btn btn-social-icon btn-vk">
                                    <span><i class="fab fa-vk"></i></span>
                                </a>
                                <a class="btn btn-social-icon btn-odnoklassniki">
                                    <span><i class="fab fa-odnoklassniki"></i></span>
                                </a>
                            </div>
                            <div class="social-column">
                                <a class="btn btn-social-icon btn-facebook">
                                    <span><i class="fab fa-facebook-f"></i></span>
                                </a>
                                <a class="btn btn-social-icon btn-google">
                                    <span><i class="fab fa-google-plus-g"></i></span>
                                </a>
                                <a class="btn btn-social-icon btn-instagram">
                                    <span><i class="fab fa-instagram"></i></span>
                                </a>
                            </div>
                        </div>
                    </section>
                </form>
                <form id="pass-reset-form"
                      class="signup-form {{ isset($errors) and $errors->has('emailReset') ? '' : 'hidden' }}"
                      method="POST" action="{{  route('password.email') }}">
                    {{ csrf_field() }}
                    <section id="pass-reset">
                        <label for="emailReset">Восстановление пароля</label>
                        <div class="form-group {{ isset($errors) and $errors->has('emailReset') ? 'has-danger' : '' }}">
                            <input id="emailReset" type="email" name="email" placeholder="Email"
                                   value="{{ old('emailReset') }}" required>
                        </div>
                        <span><i class="fa fa-lg fa-info-circle" ></i>На указанную почту будет
                            отправлено письмо с инструкциями для восстановления пароля</span>
                        <button type="submit" id="reset-psw-btn" class="btn auth-btn">
                            Восстановить пароль
                        </button>
                    </section>
                </form>
                <button type="button" class="close close-btn" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            @if (isset($errors) and $errors->any())
                @foreach ($errors->all() as $error)
                    {{ alert('danger', $error, 0) }}
                @endforeach
            @endif
        @endif
        <div id="side-bottom">
            <span>Copyright © 2017 MyLibrary</span>
            <span>All Rights Reserved | Design by</span>
            <a href="{{ route('developers') }}">M.A.&Co</a>
        </div>
    </div>
</aside>
<a href="#" id="back-to-top"><i class="fa fa-angle-double-up fa-2x"></i></a>