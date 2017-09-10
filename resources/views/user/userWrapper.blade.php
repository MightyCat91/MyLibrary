<section id="user-profile-container">
    <figure id="user-profile-img-wrapper">
        <img src="{{ empty($file = getStorageFile('users', Auth::id())) ? asset('images/no_avatar.jpg') : asset($file) }}"
             alt="{{ Auth::getUser()->login ?? Auth::getUser()->name }}">
    </figure>
    <span id="user-nickname">{{ Auth::getUser()->login ?? Auth::getUser()->name }}</span>
    <div class="user-profile-btn-control">
        <a class="btn-control" href="{{ route('userProfile', ['id' => Auth::id()]) }}" title="Профиль">
            <i class="fa fa-user fa-fw" aria-hidden="true"></i></a>
        <a class="btn-control" href="{{ route('userCollections', ['id' => Auth::id()]) }}" title="Мои коллекции">
            <i class="fa fa-archive fa-fw" aria-hidden="true"></i></a>
        <a class="btn-control" href="{{ route('userLibrary', ['id' => Auth::id()]) }}" title="Моя библиотека">
            <i class="fa fa-book fa-fw" aria-hidden="true"></i></a>
        <a class="btn-control" href="{{ route('userHistory', ['id' => Auth::id()]) }}" title="Моя история">
            <i class="fa fa-history fa-fw" aria-hidden="true"></i></a>
        <a class="btn-control" href="{{ route('userEditProfile', ['id' => Auth::id()]) }}" title="Настройки">
            <i class="fa fa-cogs fa-fw" aria-hidden="true"></i></a>
    </div>
</section>