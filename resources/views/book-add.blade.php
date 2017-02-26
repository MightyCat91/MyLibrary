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
                <label for="nameInput">Название книги:</label>
                <input type="text" id="nameInput" name="nameInput" class="form-control"
                       placeholder="Евгений Онегин">
                @if($errors->first('nameInput'))
                    <div class="form-control-feedback">
                        {{ $errors->first('nameInput') }}
                    </div>
                @endif
            </div>

            <div class="form-group {{ ($errors->first('authorInput-1')) ? 'has-danger' : '' }}">
                <label for="authorInput-1">Автор:</label>
                <div id="authors" class="multiple-input-add-container">
                    <input type="text" name="authorInput-1" class="form-control form-add-input author-input"
                           placeholder="Автор" title="Добавить еще одного автора" list="author-list">
                    <span class="append-form-add-input">
                        <i class="fa fa-plus-circle fa-2x"></i>
                    </span>
                </div>
                <datalist id="author-list">
                    @foreach($authors as $author)
                        <option>{{ $author->name }}</option>
                    @endforeach
                </datalist>
                @if($errors->first('authorInput-1'))
                    <div class="form-control-feedback">
                        {{ $errors->first('authorInput-1') }}
                    </div>
                @endif
            </div>

            <div class="form-group {{ ($errors->first('categoryInput-1')) ? 'has-danger' : '' }}">
                <label for="categoryInput-1">Жанр:</label>
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

            <div class="form-group {{ ($errors->first('publisherInput')) ? 'has-danger' : '' }}">
                <label for="publisherInput-1">Издательство:</label>
                <div id="publishers" class="multiple-input-add-container">
                    <input type="text" name="publisherInput-1" class="form-control form-add-input publisher-input"
                           placeholder="Издательство" title="Добавить еще одно издательство" list="publisher-list">
                    <span class="append-form-add-input">
                        <i class="fa fa-plus-circle fa-2x"></i>
                    </span>
                </div>
                <datalist id="publisher-list">
                    @foreach($publishers as $publisher)
                        <option>{{ $publisher->name }}</option>
                    @endforeach
                </datalist>
                @if($errors->first('publisherInput'))
                    <div class="form-control-feedback">
                        {{ $errors->first('publisherInput') }}
                    </div>
                @endif
            </div>

            <div class="form-group {{ ($errors->first('isbnInput')) ? 'has-danger' : '' }}">
                <label for="isbnInput">ISBN:</label>
                <input type="text" id="isbnInput" name="isbnInput" class="form-control"
                       placeholder="978-5-389-04903-1">
                @if($errors->first('isbnInput'))
                    <div class="form-control-feedback">
                        {{ $errors->first('isbnInput') }}
                    </div>
                @endif
            </div>

            <div class="form-group {{ ($errors->first('yearInput')) ? 'has-danger' : '' }}">
                <label for="yearInput">Год издания:</label>
                <input type="text" id="yearInput" name="yearInput" class="form-control"
                       placeholder="2014">
                @if($errors->first('yearInput'))
                    <div class="form-control-feedback">
                        {{ $errors->first('yearInput') }}
                    </div>
                @endif
            </div>

            <div class="form-group {{ ($errors->first('pageCountsInput')) ? 'has-danger' : '' }}">
                <label for="pageCountsInput">Количество страниц:</label>
                <input type="text" id="pageCountsInput" name="pageCountsInput" class="form-control"
                       placeholder="486">
                @if($errors->first('pageCountsInput'))
                    <div class="form-control-feedback">
                        {{ $errors->first('pageCountsInput') }}
                    </div>
                @endif
            </div>

            <div class="form-group {{ ($errors->first('descriptionInput')) ? 'has-danger' : '' }}">
                <label for="descriptionInput">Аннотация:</label>
                <textarea id="descriptionInput" name="descriptionInput" class="form-control"
                          placeholder="Аннотация книги"></textarea>
                @if($errors->first('descriptionInput'))
                    <div class="form-control-feedback">
                        {{ $errors->first('descriptionInput') }}
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
                <button type="submit" id="submit-book-add" class="btn btn-primary">Добавить</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{ asset('/js/Custom/addForm.js') }}"></script>
@endpush