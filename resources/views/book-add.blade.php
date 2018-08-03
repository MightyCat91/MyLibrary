@push('styles')
    <link href="{{ asset('/css/Library/jQuery/jquery-ui.min.css')  }} " rel='stylesheet' type='text/css' media="all"/>
    <link href="{{ asset('/css/Custom/addForm.css') }}" rel='stylesheet' type='text/css' media="all"/>
    <link href="{{ asset('/css/Library/Owl.Carousel/owl.carousel.min.css') }}" rel='stylesheet' type='text/css'
          media="all"/>
@endpush
@extends('layouts.main',['title'=>'Добавить книгу'])
@section('content')
    {{Breadcrumbs::render()}}
    <div class="container main-container">
        <form id="add-form" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div id="fields-wrapper">
                <div class="form-group {{ ($errors->has('nameInput')) ? 'has-danger' : '' }}">
                    <input type="text" id="nameInput" name="nameInput" class="form-control" value="{{ old('nameInput') }}"
                           maxlength="64" required>
                    <label for="nameInput"
                           class="input-label {{ (empty(old('nameInput'))) ? '' : 'active' }}">Название книги</label>
                    @if($errors->has('nameInput'))
                        <div class="form-control-feedback">
                            {{ $errors->first('nameInput') }}
                        </div>
                    @endif
                </div>

                <div class="form-group multiple {{ ($errors->has('authorInput.*')) ? 'has-danger' : '' }}">
                    <div id="authors" class="multiple-input-add-container">
                        <div class="input-container">
                            <input type="text" id="authorInput" name="authorInput[]"
                                   class="form-control form-add-input author-input"
                                   title="Добавить еще одного автора" maxlength="128" autocomplete="off" required>
                            <label for="authorInput" class="input-label">Автор</label>
                            <button type="button" class="close hidden close-btn" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <span class="append-form-add-input">
                            <i class="fa fa-plus-circle fa-2x"></i>
                        </span>
                        </div>
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
                    <datalist id="series-list">
                        @foreach($bookSeries as $series)
                            <option>{{ $series->name }}</option>
                        @endforeach
                    </datalist>
                    @if($errors->has('seriesInput.*'))
                        <div class="form-control-feedback">
                            {{ $errors->first('seriesInput.*') }}
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
                            <button type="button" class="close hidden close-btn" aria-label="Close">
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

                <div class="form-group multiple {{ ($errors->has('publisherInput.*')) ? 'has-danger' : '' }}">
                    <div id="publishers" class="multiple-input-add-container">
                        <div class="input-container">
                            <input type="text" id="publisherInput" name="publisherInput[]"
                                   class="form-control form-add-input publisher-input"
                                   title="Добавить еще одно издательство" maxlength="128" autocomplete="off">
                            <label for="publisherInput" class="input-label">Издательство</label>
                            <button type="button" class="close hidden close-btn" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <span class="append-form-add-input">
                            <i class="fa fa-plus-circle fa-2x"></i>
                        </span>
                        </div>
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
                    <input type="text" id="isbnInput" name="isbnInput" class="form-control" value="{{ old('isbnInput')}}"
                           maxlength="20">
                    <label for="isbnInput" class="input-label {{ (empty(old('isbnInput'))) ? '' : 'active' }}">ISBN</label>
                    @if($errors->has('isbnInput'))
                        <div class="form-control-feedback">
                            {{ $errors->first('isbnInput') }}
                        </div>
                    @endif
                </div>

                <div class="form-group {{ ($errors->has('yearInput')) ? 'has-danger' : '' }}">
                    <input type="text" id="yearInput" name="yearInput" class="form-control" value="{{ old('yearInput')}}"
                           maxlength="4">
                    <label for="yearInput"
                           class="input-label {{ (empty(old('yearInput'))) ? '' : 'active' }}">Год издания</label>
                    @if($errors->has('yearInput'))
                        <div class="form-control-feedback">
                            {{ $errors->first('yearInput') }}
                        </div>
                    @endif
                </div>

                <div class="form-group {{ ($errors->has('pageCountsInput')) ? 'has-danger' : '' }}">
                    <input type="text" id="pageCountsInput" name="pageCountsInput" class="form-control"
                           value="{{ old('pageCountsInput') }}" maxlength="5" required>
                    <label for="pageCountsInput" class="input-label
                {{ (empty(old('pageCountsInput'))) ? '' : 'active' }}">Количество страниц</label>
                    @if($errors->has('pageCountsInput'))
                        <div class="form-control-feedback">
                            {{ $errors->first('pageCountsInput') }}
                        </div>
                    @endif
                </div>

                <div class="form-group {{ ($errors->has('descriptionInput')) ? 'has-danger' : '' }}">
                <textarea id="descriptionInput" name="descriptionInput" class="form-control" rows="3"
                          maxlength="2048" required>{{ old('descriptionInput') }}</textarea>
                    <label for="descriptionInput"
                           class="input-label {{ (empty(old('descriptionInput'))) ? '' : 'active' }}">Аннотация</label>
                    @if($errors->has('descriptionInput'))
                        <div class="form-control-feedback">
                            {{ $errors->first('descriptionInput') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-group file-upload-group {{ ($errors->has('imageInput.*')) ? 'has-danger' : '' }}">
                <figure id="add-img-wrapper" class="slider owl-carousel owl-theme">
                </figure>
                <div class="owl-nav hidden">
                    <div class="owl-prev"><i class='fa fa-lg fa-arrow-circle-left'></i></div>
                    <div class="owl-next"><i class='fa fa-lg fa-arrow-circle-right'></i></div>
                </div>
                <img class="book-img" src="{{ asset('images/add-books.png') }}" alt="Добавить изображения книги">
                <div id="img-add-btn-wrapper">
                    <div class="img-add-btn update-btn">
                        <input class="hidden" type="file" name="imageInput[]" id="imageInput"
                               accept="image/jpeg,image/png,image/gif" multiple/>
                        <label for="imageInput"  class="image-btn">
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
    <script type="text/javascript" src="{{ asset('/js/Library/Owl.Carousel/owl.carousel.min.js') }}"></script>
@endpush