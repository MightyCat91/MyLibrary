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
                <input type="text" id="nameInput" name="nameInput" class="form-control" value="{{ old('nameInput') }}"
                       maxlength="128" required>
                <label for="nameInput"
                       class="input-label {{ (empty(old('nameInput'))) ? '' : 'active' }}">Имя автора</label>
                @if($errors->has('nameInput'))
                    <div class="form-control-feedback">
                        {{ $errors->first('nameInput') }}
                    </div>
                @endif
            </div>

            <div class="form-group multiple {{ ($errors->has('categoryInput.*')) ? 'has-danger' : '' }}">
                <div id="categories" class="multiple-input-add-container">
                    <div class="input-container">
                        <input type="text" id="categoryInput" name="categoryInput[]"
                               class="form-control form-add-input category-input"
                               title="Добавить еще один жанр" maxlength="128" autocomplete="off">
                        <label for="categoryInput" class="input-label">Жанр</label>
                        <button type="button" class="close hidden input-close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <span class="append-form-add-input">
                            <i class="fa fa-plus-circle fa-2x"></i>
                        </span>
                    </div>
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

            <div class="form-group {{ ($errors->has('biographyInput')) ? 'has-danger' : '' }}">
                <textarea id="biographyInput" name="biographyInput" class="form-control" rows="3"
                          maxlength="2048" required>{{ old('biographyInput') }}</textarea>
                <label for="biographyInput"
                       class="input-label {{ (empty(old('biographyInput'))) ? '' : 'active' }}">Биография</label>
                @if($errors->has('biographyInput'))
                    <div class="form-control-feedback">
                        {{ $errors->first('biographyInput') }}
                    </div>
                @endif
            </div>

            <div class="form-group file-upload-group {{ ($errors->has('imageInput')) ? 'has-danger' : '' }}">
                <div class="img-add-container">
                    <input type="file" name="imageInput" id="imageInput" accept="image/jpeg,image/png,image/gif"/>

                    <div class="btn-container">
                        <label for="imageInput" class="add-img-btn">
                            <span class="btn btn-success btn-file">
                                <i class="fa fa-upload" aria-hidden="true"></i>
                            </span>
                        </label>

                        <div class="form-group submit-btn">
                            <button type="submit" id="submit-book-add" class="btn btn-primary">Добавить</button>
                        </div>
                    </div>
                    <div class='img-name'>
                        @if($errors->has('imageInput'))
                            <div class="form-control-feedback file-errors">
                                {{ $errors->first('imageInput') }}
                            </div>
                            <div class="img-link hidden">
                                <a href='' target='_blank' class="preview-link">
                                    <i class='fa fa-picture-o fa-fw' aria-hidden='true'></i>preview uploaded image</a>
                            </div>
                        @else
                            <div class="form-control-feedback file-errors hidden"></div>
                            <div class="img-link hidden">
                                <a href='' target='_blank' class="preview-link">
                                    <i class='fa fa-picture-o fa-fw' aria-hidden='true'></i>preview uploaded image</a>
                            </div>
                        @endif
                    </div>
                </div>
                <img src="" class="img-preview hidden">
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{ asset('/js/Library/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/Custom/addForm.js') }}"></script>
@endpush