(function ($) {
    var commentsController = $('#comments-block-container'),
        commentsTextEditor = $('#comments-text-editor-wrapper'),
        remainingLetter = $('.remainingLetter'),
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
    commentsTextEditor.summernote({
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
            onKeyup: function() {
                checkRemainingLetter();
            },
            onPaste: function() {
                checkRemainingLetter();
            }
        }
    });

    $('.add-comment').not('.disabled').on('click', function () {
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
                commentsTextEditor.summernote('reset');
                // вывод алерта
                if (response.type) {
                    Alert(response.type, response.message);
                } else {
                    Alert('success', 'Спасибо за оценку');
                }
            })
            .fail(function (response) {
                commentsController.html(response);
                //вывод алерта
                Alert('danger', response.responseJSON.message, 0);
            });
    });

    $('.comment-add-vote').on('click', function (e) {
        $.ajax({
            url: $(this).closest().attr("data-url"),
            data: {
                'type': $(this).attr('class').replace('/comment-add-vote/g',''),
                'id': $(this).attr('data-comId')
            },
            type: 'POST'
        })
            .done(function (response) {
                commentsTextEditor.summernote('reset');
                // вывод алерта
                if (response.type) {
                    Alert(response.type, response.message);
                } else {
                    Alert('success', 'Спасибо за оценку');
                }
            })
            .fail(function (response) {
                commentsController.html(response);
                //вывод алерта
                Alert('danger', response.responseJSON.message, 0);
            });
    });


    /**
     *
     */
    function checkRemainingLetter() {
        var curCount = $('<div>').html(commentsTextEditor.summernote('code')).text().replace(/\s*/g,"").length,
            remainingCount = letterCount - curCount;
        if (remainingCount > 0) {
            $('.add-comment.blocked').removeClass('disabled');
            remainingLetter.text(remainingCount).removeClass('excess');
        } else {
            remainingLetter.text(remainingCount).addClass('excess');
            $('.add-comment').addClass('disabled');
            if (!hasAlert()) {
                Alert('warning', 'Количество символов для комментария достигло максимального значения', 6000);
            }
        }
    }

})(jQuery);