@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ Session::get('success') }}
        </div>
        <form id="author-add" method="post" action="{{ route('author-add-post') }}">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="nameInput">Имя автора:</label>
                <input type="text" id="nameInput" name="nameInput" class="form-control"
                       placeholder="Александр Сергеевич Пушкин">
            </div>
            <div class="form-group">
                <label for="biographyInput">Биография:</label>
                <textarea id="biographyInput" name="biographyInput" class="form-control"
                          placeholder="Краткая информация из биографии автора"></textarea>
            </div>
            <div class="form-group">
                <label for="imageInput">Фотографии:</label>
                <div class="input-group add-img-btn">
                    <span class="btn btn-success btn-file">
                        <i class="icon-plus"> </i><span>Выберите изображения...</span>
                        <input type="file" name="imageInput" id="imageInput" accept="image/jpeg,image/png,image/gif"/>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" id="submit-author-add" class="btn btn-primary">Добавить</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{ asset('/js/custom/author-add.js') }}"></script>
@endpush