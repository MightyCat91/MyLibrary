@push('styles')
    <link href="{{ asset('/css/Library/jQuery/jquery-ui.min.css')  }} " rel='stylesheet' type='text/css' media="all"/>
    <link href="{{ asset('/css/Custom/addForm.css') }}" rel='stylesheet' type='text/css' media="all"/>
@endpush
@extends('layouts.main',['title'=>'Добавить автора'])
@section('content')
    {{Breadcrumbs::render()}}
    <div class="container main-container">
        <form id="add-form" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div id="fields-wrapper">
                <div class="form-group {{ ($errors->has('nameInput')) ? 'has-danger' : '' }}">
                    <input type="text" id="nameInput" name="nameInput" class="form-control"
                           value="{{ old('nameInput') }}"
                           maxlength="128" required>
                    <label for="nameInput"
                           class="input-label {{ (empty(old('nameInput'))) ? '' : 'active' }}">Имя автора</label>
                    @if($errors->has('nameInput'))
                        <div class="form-control-feedback">
                            {{ $errors->first('nameInput') }}
                        </div>
                    @endif
                </div>

                <div class="form-group multiple {{ ($errors->has('seriesInput.*')) ? 'has-danger' : '' }}">
                    <div id="series" class="multiple-input-add-container">
                        <div class="input-container">
                            <input type="text" id="seriesInput" name="seriesInput[]"
                                   class="form-control form-add-input series-input"
                                   title="Добавить еще одну серию книг" maxlength="128" autocomplete="off">
                            <label for="seriesInput" class="input-label">Серия книг</label>
                            <button type="button" class="close hidden close-btn" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <span class="append-form-add-input">
                            <i class="fa fa-plus-circle fa-2x"></i>
                        </span>
                        </div>
                    </div>
                    @if($errors->has('seriesInput.*'))
                        <div class="form-control-feedback">
                            {{ $errors->first('seriesInput.*') }}
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
            </div>

            <div class="form-group file-upload-group {{ ($errors->has('imageInput.*')) ? 'has-danger' : '' }}">
                <figure id="add-img-wrapper">
                </figure>
                <img class="book-img" src="{{ asset('images/add-books.png') }}" alt="Добавить изображения книги">
                <div id="img-add-btn-wrapper">
                    <div class="img-add-btn update-btn">
                        <input class="hidden" type="file" name="imageInput" id="imageInput"
                               accept="image/jpeg,image/png,image/gif"/>
                        <label for="imageInput" class="image-btn">
                            <i class="far fa-image"></i>
                        </label>
                        <div class="img-delete-btn image-btn hidden">
                            <i class="far fa-trash-alt"></i>
                        </div>
                    </div>
                </div>
                @if($errors->has('imageInput.*'))
                    {{ alert('danger', $errors->first('imageInput.*')) }}
                @endif
            </div>

            <div class="form-group submit-btn">
                <button type="submit" id="submit-book-add" class="btn submit-btn">Добавить</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/Library/jQuery/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/Custom/addForm.js') }}"></script>
@endpush