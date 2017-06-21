<aside class="sidebar">
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
            <a href="{{ route('publishers') }}" class="nav-item {{ active('publishers') }}">
                <i class="fa fa-pencil fa-lg fa-fw nav-item-icon" aria-hidden="true"></i>

                <div class="nav-item-name">Издатели</div>
            </a>
            @if (Auth::check())
                <a href="{{ route('author-add-get') }}" class="nav-item {{ active('author-add-get') }}">
                    <div class="icon-stack fa-fw nav-item-icon">
                        <i class="fa fa-user-o"></i>
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
            @endif
        </section>
        <section id="bottom-container">
            @if (Auth::guest())
                <div id="login-form-wrapper" class="{{ !empty($errors) and $errors->hasAny(['email', 'password']) ? 'active' : '' }}">
                    <form id="login-form" role="form" method="POST" action="{{  route('login') }}">
                        {{ csrf_field() }}
                        <div id="authLinks">
                            <a href="#" id="registerLink">Регистрация</a>
                            <a href="#" id="resetPassLink">Забыли пароль?</a>
                        </div>
                        <div id="login-form-container">
                            <div class="form-group {{ !empty($errors) and $errors->has('email') ? 'error' : '' }}">

                                <input id="email" type="email" name="email" placeholder="Email"
                                       value="{{ old('email') }}"
                                       required>
                            </div>
                            <div class="form-group {{ !empty($errors) and $errors->has('password') ? 'error' : '' }}">
                                <input id="password" type="password" name="password" placeholder="Пароль" required>
                                @if (!empty($errors) and $errors->has('email'))
                                    <div class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif
                                @if (!empty($errors) and $errors->has('password'))
                                    <div class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div id="login-button">
                                <button type="submit">
                                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div id="remember-checkbox" class="auth-checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                Запомнить меня
                            </label>
                        </div>
                    </form>
                    <button type="button" class="close form-close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <a href="#" id="login" class="nav-item hidden">
                    <i class="fa fa-sign-in fa-lg fa-fw nav-item-icon" aria-hidden="true"></i>

                    <div class="nav-item-name">Войти</div>
                </a>
            @else
                <a href="{{ route('userProfile') }}" class="nav-item {{ active('userProfile') }}">
                    <i class="fa fa-user-circle fa-lg fa-fw nav-item-icon" aria-hidden="true"></i>

                    <div class="nav-item-name">Личный кабинет</div>
                </a>
                <a href="{{ route('logout') }}" class="nav-item"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out fa-lg fa-fw nav-item-icon" aria-hidden="true"></i>

                    <div class="nav-item-name">Выйти</div>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    {{ csrf_field() }}
                </form>
            @endif
            <hr>
            <div id="side-bottom">
                <div class="copyright">
                    <p>Copyright © 2017 MyLibrary</p>

                    <p>All Rights Reserved | Design by</p>
                    <a href="{{ route('developers') }}">M.A.&Co</a>
                </div>
            </div>
        </section>
    </div>
</aside>
<a href="#" id="back-to-top"><i class="fa fa-angle-double-up fa-2x" aria-hidden="true"></i></a>
@if (Auth::guest())
    <section id="register-form-container" class="{{ !empty($errors) and $errors->hasAny(['name', 'registerEmail', 'registerPassword',
    'privacyPolicy', 'emailReset']) ? 'active' : '' }}">
        <form id="register-form" role="form" method="POST" action="{{ route('register') }}" class="signup-form
              {{ !empty($errors) and $errors->hasAny(['name', 'registerEmail', 'registerPassword', 'privacyPolicy']) ? '' : 'hidden' }}">
            {{ csrf_field() }}
            <section id="auth-signup">
                <div>
                    <div class="form-group {{ !empty($errors) and $errors->has('name') ? 'error' : '' }}">
                        <input id="name" type="text" name="name" placeholder="Имя" value="{{ old('name') }}" required>
                        @if (!empty($errors) and $errors->has('name'))
                            <div class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="form-group {{ !empty($errors) and $errors->has('registerEmail') ? 'error' : '' }}">
                        <input id="registerEmail" type="email" name="registerEmail" placeholder="Email"
                               value="{{ old('registerEmail')}}" required>
                        @if (!empty($errors) and $errors->has('registerEmail'))
                            <div class="help-block">
                                <strong>{{ $errors->first('registerEmail') }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="form-group {{ !empty($errors) and $errors->has('registerPassword') ? 'error' : '' }}">
                        <input id="registerPassword" type="password" name="registerPassword" placeholder="Пароль"
                               required>
                        @if (!empty($errors) and $errors->has('registerPassword'))
                            <div class="help-block">
                                <strong>{{ $errors->first('registerPassword') }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="form-group auth-checkbox">
                        <label>
                            <input type="checkbox" name="subscribe[]" {{ old('subscribe') ? 'checked' : '' }}>
                            Присылайте мне на почту важные уведомления
                        </label>
                    </div>
                    <div class="form-group auth-checkbox {{ !empty($errors) and $errors->has('privacyPolicy') ? 'error' : '' }}">
                        <label>
                            <input type="checkbox" name="privacyPolicy" {{ old('privacyPolicy') ? 'checked' : '' }}
                            required>Я принимаю пользовательское соглашение
                            <a href="{{ route('privacyPolicy') }}" id="privacyPolicy"> Прочитать</a>
                        </label>
                    </div>
                    <button type="submit" id="register-btn" class="btn btn-primary auth-btn">
                        Зарегистрироваться
                    </button>
                </div>
                <div id="open-social-btn" class="chg-auth-type">
                    <i class="fa fa-lg fa-arrow-circle-right" aria-hidden="true"></i>
                </div>
            </section>
            <section id="auth-signup-social">
                <div id="open-register-form" class="chg-auth-type">
                    <i class="fa fa-lg fa-arrow-circle-left" aria-hidden="true"></i>
                </div>
                <div>
                    <div class="social-column">
                        <a class="btn btn-social-icon btn-twitter">
                            <span class="fa fa-twitter"></span>
                        </a>
                        <a class="btn btn-social-icon btn-vk">
                            <span class="fa fa-vk"></span>
                        </a>
                        <a class="btn btn-social-icon btn-odnoklassniki">
                            <span class="fa fa-odnoklassniki"></span>
                        </a>
                    </div>
                    <div class="social-column">
                        <a class="btn btn-social-icon btn-facebook">
                            <span class="fa fa-facebook"></span>
                        </a>
                        <a class="btn btn-social-icon btn-google">
                            <span class="fa fa-google"></span>
                        </a>
                        <a class="btn btn-social-icon btn-instagram">
                            <span class="fa fa-instagram"></span>
                        </a>
                    </div>
                </div>
            </section>
        </form>
        <form id="pass-reset-form" class="signup-form {{ !empty($errors) and $errors->has('emailReset') ? '' : 'hidden' }}" role="form"
              method="POST" action="{{  route('password.email') }}">
            {{ csrf_field() }}
            <section id="pass-reset">
                <label for="emailReset">Восстановление пароля</label>

                <div class="form-group {{ !empty($errors) and $errors->has('emailReset') ? 'error' : '' }}">
                    <input id="emailReset" type="email" name="emailReset" placeholder="Email"
                           value="{{ old('emailReset') }}" required>
                    @if (!empty($errors) and $errors->has('emailReset'))
                        <div class="help-block">
                            <strong>{{ $errors->first('emailReset') }}</strong>
                        </div>
                    @endif
                </div>
                <span><i class="fa fa-info-circle" aria-hidden="true"></i>На указанную почту будет отправлено письмо с
                    инструкциями для восстановления пароля</span>
                <button type="submit" id="reset-psw-btn" class="btn btn-primary auth-btn">
                    Восстановить пароль
                </button>
            </section>
        </form>
        <button type="button" class="close form-close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </section>
@endif