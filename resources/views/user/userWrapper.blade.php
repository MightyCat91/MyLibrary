<section id="user-profile-container">
    <figure id="user-profile-img-wrapper">
        {{--<img src="{{ asset($user->id) or asset('img/no_avatar.jpg') }}" alt="{{ $user->login }}">--}}
        {{--<img src="{{ asset('img/no_avatar.jpg') }}">--}}
    </figure>
    {{--<span id="user-nickname">{{ $user->login }}</span>--}}

    <div class="user-profile-btn-control">
        <a id="user-profile" href="{{ route('userProfile') }}">
            <i class="fa fa-user" aria-hidden="true"></i>
        </a>
        <a id="user-collections" href="{{--{{ route('userCollections') }}--}}">
            <i class="fa fa-archive" aria-hidden="true"></i>
        </a>
        <a id="user-books" href="{{--{{ route('userBooks') }}--}}">
            <i class="fa fa-book" aria-hidden="true"></i>
        </a>
        <a id="user-profile-edit" href="{{ route('userEditProfile') }}">
            <i class="fa fa-cogs" aria-hidden="true"></i>
        </a>
    </div>
</section>