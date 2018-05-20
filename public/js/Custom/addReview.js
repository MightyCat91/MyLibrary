(function ($) {
    var reviewForm = $('#add-review-form');

    // $('#editormd').find('textarea').ckeditor();

    $('#text-editor-wrapper').summernote({
        height: 550,
        placeholder: 'Текст рецензии',
        disableResizeEditor: true,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ],
        lang: 'ru-RU'
    });

    //сабмит формы смены email и пароля
    reviewForm.on('submit', function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: reviewForm.attr("data-url"),
            data: {'id': reviewForm.attr("data-id")},
            processData: false,
            contentType: false,
            type: 'POST'
        })
            .done(function (data) {
                // //скрытие анимации кнопки
                // changeBtn.removeClass('saving').children('.dflt-text').removeClass('hidden').nextAll('.load-text')
                //     .addClass('hidden');
                // //скрытие модального окна
                // modalDialog.modal('hide');
                // //вывод алерта
                // Alert('success', 'Изменения сохранены.');
            })
    });
})(jQuery);