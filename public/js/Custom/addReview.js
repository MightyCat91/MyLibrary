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
        console.log({'id': reviewForm.attr('data-id'), 'review': textEditorWrapper.summernote('code')});
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: reviewForm.attr("data-url"),
            data: {'id': reviewForm.attr('data-id'), 'review': textEditorWrapper.summernote('code')},
            processData: false,
            contentType: false,
            type: 'POST'
        })
            .done(function (data) {
                //скрытие модального окна
                $('#review-dialog-container').modal('hide');
                //вывод алерта
                Alert('success', 'Изменения сохранены.');
            })
    });
})(jQuery);