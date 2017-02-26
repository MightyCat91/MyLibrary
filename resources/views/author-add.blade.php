@extends('layouts.main')
@section('content')
    <div class="container">
        @if(Session::exists('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ Session::get('success') }}
            </div>
        @endif
        <form id="add-form" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group {{ ($errors->first('nameInput')) ? 'has-danger' : '' }}">
                <label for="nameInput">Имя автора:</label>
                <input type="text" id="nameInput" name="nameInput" class="form-control"
                       placeholder="Александр Сергеевич Пушкин">
                @if($errors->first('nameInput'))
                    <div class="form-control-feedback">
                        {{ $errors->first('nameInput') }}
                    </div>
                @endif
            </div>

            <div class="form-group {{ ($errors->first('biographyInput')) ? 'has-danger' : '' }}">
                <label for="biographyInput">Биография:</label>
                <textarea id="biographyInput" name="biographyInput" class="form-control"
                          placeholder="Краткая информация из биографии автора"></textarea>
                @if($errors->first('biographyInput'))
                    <div class="form-control-feedback">
                        {{ $errors->first('biographyInput') }}
                    </div>
                @endif
            </div>

            <script>console.log({{print_r($errors)}})</script>
            <div class="form-group {{ ($errors->first('categoryInput-1')) ? 'has-danger' : '' }}">
                <label for="categoryInput-1">Жанры:</label>

                <div id="categories" class="multiple-input-add-container">
                    <input type="text" name="categoryInput-1" class="form-control form-add-input category-input"
                           placeholder="Жанр" title="Добавить еще один жанр" list="category-list">
                    <span class="append-form-add-input">
                        <i class="fa fa-plus-circle fa-2x"></i>
                    </span>
                </div>
                <datalist id="category-list">
                    @foreach($categories as $category)
                        <option>{{ $category->name }}</option>
                    @endforeach
                </datalist>
                @if($errors->first('categoryInput-1'))
                    <div class="form-control-feedback">
                        {{ $errors->first('categoryInput-1') }}
                    </div>
                @endif
            </div>

            <div class="form-group file-upload-group {{ ($errors->first('imageInput')) ? 'has-danger' : '' }}">
                <label for="imageInput">Фотографии:</label>

                <div class="img-add-container">
                    <div class="input-group add-img-btn">
                    <span class="btn btn-success btn-file">
                        <i class="icon-plus"> </i><span>Выберите изображения...</span>
                        <input type="file" name="imageInput" id="imageInput" accept="image/jpeg,image/png,image/gif"/>
                    </span>
                    </div>
                    <div class='img-name'>
                        @if($errors->first('imageInput'))
                            <div class="form-control-feedback file-errors">
                                {{ $errors->first('imageInput') }}
                            </div>
                            <a href='' target='_blank' class="hidden preview-link">
                                <i class='fa fa-picture-o fa-fw' aria-hidden='true'></i>preview uploaded image</a>
                        @else
                            <div class="form-control-feedback file-errors hidden"></div>
                            <a href='' target='_blank' class="hidden preview-link">
                                <i class='fa fa-picture-o fa-fw' aria-hidden='true'></i>preview uploaded image</a>
                        @endif
                    </div>
                </div>
                <img src="" class="img-preview hidden">
            </div>
            <div class="form-group">
                <button type="submit" id="submit-author-add" class="btn btn-primary">Добавить</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{ asset('/js/Custom/addForm.js') }}"></script>
@endpush