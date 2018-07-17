@extends('layouts.main',['title'=>'Авторы'])
@push('styles')
    <link href="{{ asset('/css/Custom/reviews.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/Custom/selections.js') }}"></script>
@endpush
@section('content')
    <div class="container main-container">
        <section id="create-selection-container">
            <div id="selection-name-container">
                <div class="form-group {{ ($errors->has('nameInput')) ? 'has-danger' : '' }}">
                    <input type="text" id="nameInput" name="nameInput" class="form-control"
                           value="{{ old('nameInput') }}" maxlength="1024" required>
                    <label for="nameInput"
                           class="input-label {{ (empty(old('nameInput'))) ? '' : 'active' }}">Название подборки</label>
                    @if($errors->has('nameInput'))
                        <div class="form-control-feedback">
                            {{ $errors->first('nameInput') }}
                        </div>
                    @endif
                </div>
            </div>
            <div id="selection-description-container">
                <div class="form-group {{ ($errors->has('descriptionInput')) ? 'has-danger' : '' }}">
                    <input type="text" id="descriptionInput" name="descriptionInput" class="form-control"
                           value="{{ old('descriptionInput') }}" maxlength="1024" required>
                    <label for="nameInput"
                           class="input-label {{ (empty(old('descriptionInput'))) ? '' : 'active' }}">Описание
                        подборки</label>
                    @if($errors->has('nameInput'))
                        <div class="form-control-feedback">
                            {{ $errors->first('nameInput') }}
                        </div>
                    @endif
                </div>
            </div>
            <div id="selection-books-container">
                <div id="added-books-wrapper" class="hidden"></div>
                <div id="add-books-btn-wrapper">
                    <a href="#" id="add-books-btn">Добавить книги</a>
                </div>
            </div>
            <div class="create-selection-btn-container">
                <div class="form-group submit-btn">
                    <button id="create-selection-btn" class="btn submit-btn">Создать подборку</button>
                </div>
            </div>
        </section>
        <ol>
            <!-- Создаём экземпляр компонента todo-item -->
            <todo-item></todo-item>
        </ol>
        <div id="app">
            @{{ message }}
        </div>
    </div>
@endsection
