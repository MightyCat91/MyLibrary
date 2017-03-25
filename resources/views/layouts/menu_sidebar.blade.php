<aside class="sidebar">
    <div class="navigation">
        <section class="menu-content">
            <a href="{{ route('home') }}" class="nav-item {{ active('home') }}">
                <i class="fa fa-home fa-lg fa-fw nav-item-icon" aria-hidden="true"></i>
                <div class="nav-item-name">Домой</div>
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
            {{--<li><a href="{{ route('login') }}" class="nav-item">--}}
            {{--<i class="fa fa-users fa-lg fa-fw nav-item-icon" aria-hidden="true"></i>Логин</a>--}}
            {{--</li>--}}
        </section>
        <div class="side-bottom">
            <div class="copyright">
                <p>Copyright © 2017 MyLibrary</p>

                <p>All Rights Reserved | Design by</p>
                <a href="{{ route('developers') }}">M.A.&Co</a>
            </div>
        </div>
    </div>
</aside>