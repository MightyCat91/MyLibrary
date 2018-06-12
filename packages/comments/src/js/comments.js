(function ($) {
    var commentsController = $('#comments-container'),
        commentsTextEditor = $('.commetns-text-editor');

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
                    url: commentsController.attr("data-url"),
                    data: {
                        'text': commentsTextEditor.summernote('code'),
                        'user_id': commentsController.attr('data-id'),
                        'com_id': commentsController.attr('data-comId'),
                        'com_table': commentsController.attr('data-comTable')
                    },
                    type: 'POST'
                })
                    .done(function (response) {
                        console.log(1);
                        commentsTextEditor.summernote('code', '');
                        // вывод алерта
                            Alert(response.type, response.message);
                    })
                    .fail(function (response) {
                        $('#comments-container').html(response);
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