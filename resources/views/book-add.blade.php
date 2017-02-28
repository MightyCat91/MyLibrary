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
            <div class="form-group {{ ($errors->has('nameInput')) ? 'has-danger' : '' }}">
                <label for="nameInput">Название книги:</label>
                <input type="text" id="nameInput" name="nameInput" class="form-control"
                       placeholder="Евгений Онегин" value="{{ old('nameInput') }}" maxlength="64" required>
                @if($errors->has('nameInput'))
                    <div class="form-control-feedback">
                        {{ $errors->first('nameInput') }}
                    </div>
                @endif
            </div>

            <div class="form-group {{ ($errors->has('authorInput.*')) ? 'has-danger' : '' }}">
                <label for="authorInput[]">Автор:</label>
                <div id="authors" class="multiple-input-add-container">
                    <input type="text" name="authorInput[]" class="form-control form-add-input author-input"
                           placeholder="Автор" title="Добавить еще одного автора" list="author-list" maxlength="128"
                           required>
                    <span class="append-form-add-input">
                        <i class="fa fa-plus-circle fa-2x"></i>
                    </span>
                </div>
                <datalist id="author-list">
                    @foreach($authors as $author)
                        <option>{{ $author->name }}</option>
                    @endforeach
                </datalist>
                @if($errors->has('authorInput.*'))
                    <div class="form-control-feedback">
                        {{ $errors->first('authorInput.*') }}
                    </div>
                @endif
            </div>

            <div class="form-group {{ ($errors->has('categoryInput.*')) ? 'has-danger' : '' }}">
                <label for="categoryInput[]">Жанр:</label>
                <div id="categories" class="multiple-input-add-container">
                    <input type="text" name="categoryInput[]" class="form-control form-add-input category-input"
                           placeholder="Жанр" title="Добавить еще один жанр" list="category-list" maxlength="128">
                    <span class="append-form-add-input">
                        <i class="fa fa-plus-circle fa-2x"></i>
                    </span>
                </div>
                <datalist id="category-list">
                    @foreach($categories as $category)
                        <option>{{ $category->name }}</option>
                    @endforeach
                </datalist>
                @if($errors->has('categoryInput.*'))
                    <div class="form-control-feedback">
                        {{ $errors->first('categoryInput.*') }}
                    </div>
                @endif
            </div>

            <div class="form-group {{ ($errors->has('publisherInput.*')) ? 'has-danger' : '' }}">
                <label for="publisherInput[]">Издательство:</label>
                <div id="publishers" class="multiple-input-add-container">
                    <input type="text" name="publisherInput[]" class="form-control form-add-input publisher-input"
                           placeholder="Издательство" title="Добавить еще одно издательство" list="publisher-list"
                           maxlength="128">
                    <span class="append-form-add-input">
                        <i class="fa fa-plus-circle fa-2x"></i>
                    </span>
                </div>
                <datalist id="publisher-list">
                    @foreach($publishers as $publisher)
                        <option>{{ $publisher->name }}</option>
                    @endforeach
                </datalist>
                @if($errors->has('publisherInput.*'))
                    <div class="form-control-feedback">
                        {{ $errors->first('publisherInput.*') }}
                    </div>
                @endif
            </div>

            <div class="form-group {{ ($errors->has('isbnInput')) ? 'has-danger' : '' }}">
                <label for="isbnInput">ISBN:</label>
                <input type="text" id="isbnInput" name="isbnInput" class="form-control"
                       placeholder="978-5-389-04903-1" value="{{ old('isbnInput') }}" maxlength="20">
                @if($errors->has('isbnInput'))
                    <div class="form-control-feedback">
                        {{ $errors->first('isbnInput') }}
                    </div>
                @endif
            </div>

            <div class="form-group {{ ($errors->has('yearInput')) ? 'has-danger' : '' }}">
                <label for="yearInput">Год издания:</label>
                <input type="text" id="yearInput" name="yearInput" class="form-control"
                       placeholder="2014" value="{{ old('yearInput') }}" maxlength="4">
                @if($errors->has('yearInput'))
                    <div class="form-control-feedback">
                        {{ $errors->first('yearInput') }}
                    </div>
                @endif
            </div>

            <div class="form-group {{ ($errors->has('pageCountsInput')) ? 'has-danger' : '' }}">
                <label for="pageCountsInput">Количество страниц:</label>
                <input type="text" id="pageCountsInput" name="pageCountsInput" class="form-control"
                       placeholder="486" value="{{ old('pageCountsInput') }}" maxlength="5" required>
                @if($errors->has('pageCountsInput'))
                    <div class="form-control-feedback">
                        {{ $errors->first('pageCountsInput') }}
                    </div>
                @endif
            </div>

            <div class="form-group {{ ($errors->has('descriptionInput')) ? 'has-danger' : '' }}">
                <label for="descriptionInput">Аннотация:</label>
                <textarea id="descriptionInput" name="descriptionInput" class="form-control"
                          placeholder="Аннотация книги" rows="6" maxlength="2048" required>
                    {{ old('descriptionInput') }}
                </textarea>
                @if($errors->has('descriptionInput'))
                    <div class="form-control-feedback">
                        {{ $errors->first('descriptionInput') }}
                    </div>
                @endif
            </div>

            <div class="form-group file-upload-group {{ ($errors->has('imageInput')) ? 'has-danger' : '' }}">
                <label for="imageInput">Фотографии:</label>

                <div class="img-add-container">
                    <div class="input-group add-img-btn">
                    <span class="btn btn-success btn-file">
                        <i class="icon-plus"> </i><span>Выберите изображения...</span>
                        <input type="file" name="imageInput" id="imageInput" accept="image/jpeg,image/png,image/gif"/>
                    </span>
                    </div>
                    <div class='img-name'>
                        @if($errors->has('imageInput'))
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
                <button type="submit" id="submit-book-add" class="btn btn-primary">Добавить</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{ asset('/js/Custom/addForm.js') }}"></script>
@endpush