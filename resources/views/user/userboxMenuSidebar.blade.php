<section id="user-profile-container">
    <figure id="user-profile-ig-wrapper">
        <img src="{{ asset($user->id) }}" alt="{{ $user->name }}">
    </figure>
    <a id="user-profile-edit" href="{{ route('userEditProfile') }}">
        <i class="fa fa-pencil" aria-hidden="true"></i>
    </a>
</section>