(function ($) {
    var SaveButton = function (context) {
        // create button
        var button = $.summernote.ui.button({
            contents: 'Добавить',
            className: 'submit-btn',
            click: function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: $('#reviews-container').attr("data-url"),
                    data: {
                        'text': $('.commetns-text-editor').summernote('code'),
                        'id': id
                    },
                    type: 'POST'
                })
                    .done(function (response) {
                        // вывод алерта
                        if (response.type) {
                            Alert(response.type, response.message);
                        } else {
                            Alert('success', 'Спасибо за оценку');
                        }
                    })
                    .fail(function (response) {
                        //вывод алерта
                        Alert('danger', response.responseJSON.message, 0);
                    });
            }
        });

        return button.render();   // return button as jquery object
    };

    // инициализация текстового редактора
    $('.commetns-text-editor').summernote({
        height: 150,
        placeholder: 'Текст комментария',
        disableResizeEditor: true,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['link'],
            ['save-comment-btn', ['save']]
        ],
        buttons: {
            save: SaveButton
        },
        lang: 'ru-RU',
        disableDragAndDrop: true
    });
})(jQuery);