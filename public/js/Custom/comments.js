(function ($) {
    var commentsController = $('#comments-block-container'),
        commentsTextEditor = $('.comments-text-editor-wrapper'),
        remainingLetter = $('.remainingLetter'),
        letterCount = 1000,
        LetterCountFunc = function () {
            // create button
            var button = $.summernote.ui.button({
                contents: letterCount,
                className: 'remainingLetter',
                tooltip: 'Количество оставшихся символов'
            });

            return button.render();   // return button as jquery object
        },
        options = {
            height: 150,
            disableResizeEditor: true,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['link'],
                ['remaining-letter', ['letterCount']]
            ],
            buttons: {
                letterCount: LetterCountFunc
            },
            lang: 'ru-RU',
            disableDragAndDrop: true,
            callbacks: {
                onKeyup: function() {
                    checkRemainingLetter($(this));
                },
                onPaste: function() {
                    checkRemainingLetter($(this));
                }
            }
        };

    summernoteInit(commentsTextEditor, false);

    $(document).on('click', '.add-comment:not(.disabled)', function () {
        var parentComment = $(this).closest('.comment-wrapper'),
            text = $(this).closest('.comments-editor-container').find('.comments-text-editor-wrapper').summernote('code');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: commentsController.attr("data-url"),
            data: {
                'text': text,
                'user_id': commentsController.attr('data-id'),
                'com_id': commentsController.attr('data-comId'),
                'com_table': commentsController.attr('data-comTable'),
                'parent_id': parentComment.length ? parentComment.attr('data-id') : null
            },
            type: 'POST'
        })
            .done(function (response) {
                commentsTextEditor.summernote('reset');
                $('.comments-editor-container.inner').summernote('destroy');
                // вывод алерта
                if (response.type) {
                    Alert(response.type, response.message);
                } else {
                    Alert('success', 'Комментарий будет добавлен после одобрения модератором');
                }
            })
            .fail(function (response) {
                commentsController.html(response);
                //вывод алерта
                Alert('danger', response.responseJSON.message, 0);
            });
    });

    $('.comment-reply-btn').on('click', function (e) {
        if (!$(this).hasClass('active')) {
            var parent = $(this).closest('.comment-content-wrapper').find('.inner-text-wrapper');
            $('.inner-text-wrapper.active').removeClass('active').summernote('destroy');
            $('.inner-text-wrapper').empty();
            $('.comment-reply-btn').removeClass('active');
            summernoteInit(parent, true);
            parent.addClass('active');
            $(this).addClass('active');
        }
        e.preventDefault();
    });

    $('.comment-add-vote').on('click', function (e) {
        var ratingContainer = $(this).closest('.comment-wrapper').find('.comment-rating'),
            type = $(this).attr('class').split(' ')[1];
        $.ajax({
            url: $(this).parent().attr("data-url"),
            data: {
                'type': type,
                'id': $(this).closest('.comment-wrapper').attr('data-id'),
                'rating': ratingContainer.length ? parseInt(ratingContainer.text()) : 0
            },
            type: 'POST'
        })
            .done(function (response) {
                if (response.rating > 0) {
                    ratingContainer.addClass('positive').removeClass('negative');
                } else {
                    ratingContainer.addClass('negative').removeClass('positive');
                }
                ratingContainer.text(response.rating);
                // вывод алерта
                Alert('success', 'Спасибо за оценку');
            })
            .fail(function (response) {
                //вывод алерта
                Alert('danger', response.responseJSON.message, 0);
            });
    });


    function summernoteInit(element, focusState) {
        $(options).extend({
            focus:focusState
        });
        // инициализация текстового редактора
        element.summernote(options);
    }

    /**
     *
     */
    function checkRemainingLetter(el) {
        var curCount = $('<div>').html(el.summernote('code')).text().replace(/\s*/g,"").length,
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