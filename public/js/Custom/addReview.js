(function ($) {
    var reviewForm = $('#add-review-form'),
        textEditorWrapper = $('#text-editor-wrapper');

    // $('#editormd').find('textarea').ckeditor();

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

    //сабмит формы смены email и пароля
    reviewForm.on('submit', function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        console.log($('#item-container-link').length ? $('#item-container-link').attr('data-id') : reviewForm.attr('data-id'));
        $.ajax({
            url: reviewForm.attr("data-url"),
            data: {
                'id': $('#item-container-link').length ? $('#item-container-link').attr('data-id') : reviewForm.attr('data-id'),
                'review': textEditorWrapper.summernote('code')
            },
            type: 'POST'
        })
            .done(function (response) {
                //скрытие модального окна
                $('#review-dialog-container').modal('hide');
                //вывод алерта
                Alert('success', 'Изменения сохранены.');
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