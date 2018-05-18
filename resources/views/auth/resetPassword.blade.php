@push('styles')
    <link href="{{ asset('/css/Custom/addForm.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@extends('layouts.main',['title'=>'Сброс пароля'])
@section('content')
    {{Breadcrumbs::render()}}
    <div class="container reset main-container">
        <form id="reset-form" method="post" method="POST" action="{{ route('password.reset') }}">
            {{ csrf_field() }}
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group">
                <input id="resetEmail" type="email" class="form-control" name="email" value="{{ $email or old('email') }}"
                       required autofocus>
                <label for="email" class="input-label">Email</label>
            </div>
            <div class="form-group">
                <input id="resetPassword" type="password" class="form-control" name="password" required>
                <label for="password" class="input-label">Новый пароль</label>
            </div>
            <div class="form-group">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                <label for="password_confirmation" class="input-label">Подтвердите пароль</label>
            </div>

            <div class="form-group submit-btn">
                <button type="submit" class="btn submit-btn">Изменить пароль</button>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/Custom/addForm.js') }}"></script>
@endpush