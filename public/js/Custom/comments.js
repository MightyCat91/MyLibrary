(function ($) {
    var commentsController = $('#comments-container'),
        commentsTextEditor = $('.commetns-text-editor'),
        letterCount = 1000;

    var LetterCount = function (context) {
        // create button
        var button = $.summernote.ui.button({
            contents: letterCount,
            className: 'remainingLetter',
            tooltip: 'Количество оставшихся символов'
        });

        return button.render();   // return button as jquery object
    };

    // инициализация текстового редактора
    $('#comments-text-editor-wrapper').summernote({
        height: 150,
        placeholder: 'Текст комментария',
        disableResizeEditor: true,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['link'],
            ['remaining-letter', ['letterCount']]
        ],
        buttons: {
            letterCount: LetterCount
        },
        lang: 'ru-RU',
        disableDragAndDrop: true,
        callbacks: {
            onKeyup: function(e) {
                var text = $.trim($(this).summernote('code').replace(/<[^>]+>\s+/g, '')),
                    curCount = text.length,
                    remainingCount = letterCount - curCount;
                if (remainingCount) {
                    $('.remainingLetter').text(remainingCount);
                } else {
                    $('.remainingLetter').text(remainingCount);
                    $(this).summernote('code', text);
                    Alert('warning', 'Количество символов для комментария достигло максимального значения');
                }

            },
            onPaste: function(e) {
                $('.remainingLetter').text(letterCount - $(this).summernote('code').length());
            }
        }
    });

    $('.add-comment').on('click', function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: commentsController.attr("data-url"),
            data: {
                'text': $('#comments-text-editor-wrapper').summernote('code'),
                'user_id': commentsController.attr('data-id'),
                'com_id': commentsController.attr('data-comId'),
                'com_table': commentsController.attr('data-comTable')
            },
            type: 'POST'
        })
            .done(function (response) {
                $('#comments-text-editor-wrapper').summernote('reset');
                // вывод алерта
                if (response.type) {
                    Alert(response.type, response.message);
                } else {
                    Alert('success', 'Спасибо за оценку');
                }
            })
            .fail(function (response) {
                $('#comments-container').html(response);
                //вывод алерта
                Alert('danger', response.responseJSON.message, 0);
            });
    })

})(jQuery);