@push('styles')
<link href="{{ asset('/css/Custom/addForm.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@extends('layouts.main')
@section('content')
    <div class="container reset">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form id="reset-form" method="post" method="POST" action="{{ route('password.reset') }}">
            {{ csrf_field() }}
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}"
                       required autofocus>
                <label for="email" class="input-label">Email</label>
                @if($errors->has('email'))
                    <div class="form-control-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>
            <div class="form-group {{ ($errors->has('password')) ? 'has-error' : '' }}">
                <input id="password" type="password" class="form-control" name="password" required>
                <label for="password" class="input-label">Новый пароль</label>
                @if($errors->has('password'))
                    <div class="form-control-feedback">
                        {{ $errors->first('password') }}
                    </div>
                @endif
            </div>
            <div class="form-group {{ ($errors->has('password_confirmation')) ? 'has-error' : '' }}">
                <input id="password-confirm" type="password" class="form-control" name="password-confirm" required>
                <label for="password-confirm" class="input-label">Подтвердите пароль</label>
                @if($errors->has('password_confirmation'))
                    <div class="form-control-feedback">
                        {{ $errors->first('password_confirmation') }}
                    </div>
                @endif
            </div>

            <div class="form-group submit-btn">
                <button type="submit" class="btn submit-btn">Добавить</button>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
<script type="text/javascript" src="{{ asset('/js/Custom/addForm.js') }}"></script>
@endpush