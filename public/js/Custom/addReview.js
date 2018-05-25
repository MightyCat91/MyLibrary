(function ($) {
    // форма текстового редактора
    var reviewForm = $('#add-review-form'),
        // textarea текстового редактора
        textEditorWrapper = $('#text-editor-wrapper'),
        // контейнер элемента(книги) в гриде или списке
        gridOrListItemContainer = $('.item-container-link'),
        // идентификатор книги
        bookId = null;

    // инициализация текстового редактора
    textEditorWrapper.summernote({
        minHeight: 550,
        maxHeight: 750,
        placeholder: 'Текст рецензии',
        disableResizeEditor: true,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['link']
        ],
        lang: 'ru-RU',
        disableDragAndDrop: true
    });

    $("body").on('click', '.add-review', function () {
        bookId =  $(this).closest('.item-container-link').attr('data-id')
    });

    //сабмит формы добавления рецензии
    reviewForm.on('submit', function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: reviewForm.attr("data-url"),
            data: {
                // идентификатор книги
                'id': bookId ? bookId : reviewForm.attr('data-id'),
                // текст рецензии
                'review': textEditorWrapper.summernote('code')
            },
            type: 'POST'
        })
            .done(function (response) {
                // скрытие модального окна
                $('#review-dialog-container').modal('hide');
                // очистка textarea текстового редактора
                textEditorWrapper.summernote('code', '');
                // вывод алерта
                Alert('success', 'Рецензия добавлена');
            })
            .fail(function (response) {
                //получаем все ошибки для первого невалидного файла
                for (var key in response.responseJSON) ;
                var errors = response.responseJSON[key];
                $.each(errors, function (index, fileWithError) {
                    $.each(fileWithError, function (index, error) {
                        //вывод алерта
                        Alert('warning', error, 0);
                    });
                });
            });
    });
})(jQuery);