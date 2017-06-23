<section id="user-profile-container">
    <figure id="user-profile-img-wrapper">
        {{--переделать на использование getpublicfiles--}}
        {{\Debugbar::info(File::exists(asset('/storage/users/' . Auth::id())) ?: asset('images/no_avatar.jpg'))}}
        <img src="{{ File::exists(asset('/storage/users/' . Auth::id())) ?: asset('images/no_avatar.jpg') }}"
             alt="{{ Auth::getUser()->login }}">
        {{--<img src="{{ asset('img/no_avatar.jpg') }}">--}}
    </figure>
    <span id="user-nickname">{{ Auth::getUser()->login }}</span>

    <div class="user-profile-btn-control">
        <a class="btn-control" href="{{ route('userProfile') }}">
            <i class="fa fa-user fa-fw" aria-hidden="true"></i></a>
        <a class="btn-control" href="{{ route('userCollections', ['id' => Auth::id()]) }}">
            <i class="fa fa-archive fa-fw" aria-hidden="true"></i></a>
        <a class="btn-control" href="{{ route('userBooks', ['id' => Auth::id()]) }}">
            <i class="fa fa-book fa-fw" aria-hidden="true"></i></a>
        <a class="btn-control" href="{{ route('userEditProfile', ['id' => Auth::id()]) }}">
            <i class="fa fa-cogs fa-fw" aria-hidden="true"></i></a>
    </div>
</section>