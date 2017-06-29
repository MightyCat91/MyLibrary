@push('styles')
<link href="{{ asset('/css/Custom/addForm.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@extends('layouts.main',['title'=>'Настройки'])
@section('content')
    <div class="wrapper">
        <form id="edit-form" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group {{ ($errors->has('login')) ? 'has-danger' : '' }}">
                <input type="text" id="login" name="login" class="form-control" value="{{ old('login') ?? $login }}"
                       maxlength="128">
                <label for="login"
                       class="input-label {{ (empty(old('login')) and empty($login)) ? '' : 'active' }}">Логин(никнейм)</label>
                @if($errors->has('login'))
                    <div class="form-control-feedback">
                        {{ $errors->first('login') }}
                    </div>
                @endif
            </div>

            <div class="form-group {{ ($errors->has('name')) ? 'has-danger' : '' }}">
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') ?? $name}}"
                       maxlength="255" required>
                <label for="name"
                       class="input-label {{ (empty(old('name')) and empty($name)) ? '' : 'active' }}">Реальное
                    имя</label>
                @if($errors->has('name'))
                    <div class="form-control-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>

            <div class="gender form-group" data-toggle="buttons">
                <label class="btn-switch-label {{ $gender=='мужской' ? 'active' : '' }}">
                    <input type="radio" name="options" id="option1" autocomplete="off">
                    <i class="fa fa-male" aria-hidden="true"></i>
                </label>
                <label class="btn-switch-label {{ $gender=='женский' ? 'active' : '' }}">
                    <input type="radio" name="options" id="option2" autocomplete="off">
                    <i class="fa fa-female" aria-hidden="true"></i>
                </label>
            </div>

            <a href='#' id="openDialog" data-toggle="modal" data-target="#changeEmailPass">Сменить email или пароль</a>

            <div class="form-group submit-btn">
                <button type="submit" id="submit-edit-form" class="btn btn-primary">Сохранить</button>
            </div>
        </form>

        <!-- The modal -->
        <div class="modal fade" id="changeEmailPass" tabindex="-1" role="dialog" aria-labelledby="modalLabelSmall"
             aria-hidden="true">
            <div class="modal-dialog modal-vertical-centered modal-sm">
                <div class="modal-content">
                    <form id="edit-email-pass-form" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            {{ csrf_field() }}
                            <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div id="changeInfo"><i class="fa fa-info-circle" aria-hidden="true"></i>Для изменения
                                текущих email или пароля необходимо ввести старый пароль
                            </div>

                            <div class="form-group">
                                <input type="text" id="password" name="password" class="form-control"
                                       value="{{ old('password') }}" maxlength="255" required>
                                <label for="password" class="input-label">Пароль</label>
                                <div class='form-control-feedback'></div>
                            </div>
                            <div class="form-group">
                                <input type="text" id="email" name="email" class="form-control" value="{{ $email }}"
                                       maxlength="255" required>
                                <label for="email"
                                       class="input-label {{ empty($email) ? '' : 'active' }}">E-mail</label>
                                <div class='form-control-feedback'></div>
                            </div>
                            <div class="form-group {{ ($errors->has('newPassword')) ? 'has-danger' : '' }}">
                                <input type="text" id="newPassword" name="newPassword" class="form-control"
                                       value="{{ old('newPassword') }}" maxlength="255">
                                <label for="newPassword" class="input-label">Новый пароль</label>
                                <div class='form-control-feedback'></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary saveEmailPass">
                                <span class="dflt-text">Изменить</span>
                                <span class="load-text hidden"><i class="fa fa-circle" aria-hidden="true"></i></span>
                                <span class="load-text hidden"><i class="fa fa-circle" aria-hidden="true"></i></span>
                                <span class="load-text hidden"><i class="fa fa-circle" aria-hidden="true"></i></span>
                                <span class="load-text hidden"><i class="fa fa-circle" aria-hidden="true"></i></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{ asset('/js/Custom/profileSettings.js') }}"></script>
@endpush