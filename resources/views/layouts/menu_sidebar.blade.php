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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Launch demo modal
                </button>
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ...
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <form id="login-form" role="form" method="POST" action="{{  route('loginPost') }}" autocomplete="off">
                    {{ csrf_field() }}
                    <div id="authLinks">
                        <a href="{{ route('register') }}" id="registerLink">Регистрация</a>
                        <a href="{{ route('password.request') }}" id="resetPassLink">Забыли пароль?</a>
                    </div>
                    <div id="login-form-container">
                        <input type="email" name="email" id="email" placeholder="Email">
                        <input type="password" name="password" id="password" placeholder="Пароль">

                        <div id="login-button">
                            <button type="submit">
                                <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <div id="remember-checkbox">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>Запомнить меня
                        </label>
                    </div>
                </form>
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
            <div class="side-bottom">
                <div class="copyright">
                    <p>Copyright © 2017 MyLibrary</p>

                    <p>All Rights Reserved | Design by</p>
                    <a href="{{ route('developers') }}">M.A.&Co</a>
                </div>
            </div>
        </section>
    </div>
</aside>