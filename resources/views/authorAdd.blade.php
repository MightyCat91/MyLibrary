@extends('layouts.main')
@section('content')
    <div class="container">
        <form id="author-add">
            <div class="form-group">
                <label for="nameInput">Имя автора:</label>
                <input type="text" id="nameInput" class="form-control" placeholder="Александр Сергеевич Пушкин">
            </div>
            <div class="form-group">
                <label for="biographyInput">Биография:</label>
                <textarea id="biographyInput" class="form-control" placeholder="Краткая информация из биографии
                автора"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" id="submit-author-add">Добавить</button>
            </div>
        </form>
    </div>
@endsection