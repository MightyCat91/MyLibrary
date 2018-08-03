@extends('layouts.main',['title'=>'Авторы'])
@push('styles')
    <link href="{{ asset('/css/Custom/selections.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/Custom/selections.js') }}"></script>
@endpush
@section('content')
    <div id="selections-container" class="container main-container">
        <section id="create-selection-info-container">
            <h2>Информация</h2>
            <hr>
            <div id="selection-name-container">
                <v-input name="nameInput" value="{{ old('nameInput') }}" title="Название подборки"
                         errorMessage="{{ !$errors->has('nameInput') ?: $errors->first('nameInput') }}"
                         multiple></v-input>
            </div>
            <div id="selection-description-container">
                <v-input name="descriptionInput" value="{{ old('descriptionInput') }}" title="Описание подборки"
                         errorMessage="{{ !$errors->has('descriptionInput') ?: $errors->first('descriptionInput') }}"
                         rows="5" maxlength="4096"></v-input>
            </div>
        </section>
        <section id="create-selection-books-container">
            <h2>Книги</h2>
            <hr>
            <div id="selection-books-container">
                <v-selection-add></v-selection-add>
            </div>
        </section>
        <section id="create-selection-button-container">
            <div id="create-selection-btn-container">
                <v-button>Создать подборку</v-button>
            </div>
        </section>
    </div>
@endsection
