(function ($) {
    // контейнер блока комментариев
    var commentsController = $('#comments-block-container'),
        // максимальное количество допустимых символов
        letterCount = 1000,
        // рендер "кнопки" оставшегося количества символов для комментария
        LetterCountFunc = function (context) {
            // инициализация кнопки
            var button = $.summernote.ui.button({
                contents: letterCount,
                className: 'remainingLetter',
                tooltip: 'Количество оставшихся символов'
            });
            // возврат кнопки как объект jquery
            return button.render();
        },
        // опции текстового редактора
        options = {
            height: 150,
            disableResizeEditor: true,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['link'],
                ['remaining-letter', ['letterCountBtn']]
            ],
            buttons: {
                letterCountBtn: LetterCountFunc
            },
            lang: 'ru-RU',
            disableDragAndDrop: true,
            callbacks: {
                onKeyup: function () {
                    checkRemainingLetter($(this));
                },
                onPaste: function () {
                    checkRemainingLetter($(this));
                }
            }
        };

    // инициализация текстового редактора при рендере страницы
    summernoteInit($('.comments-text-editor-wrapper:not(.inner)'), false);

    // добавление комментария
    $(document).on('click', '.add-comment:not(.disabled)', function () {
        if (window.Laravel.user) {
            // кнопка добавления комментария, по которой произошел клик
            var btn = $(this),
                // враппер родительского комментария
                parentComment = btn.closest('.comment-wrapper'),
                // текст комментария
                text = btn.closest('.comments-editor-container').find('.comments-text-editor-wrapper').summernote('code');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: commentsController.attr("data-url"),
                data: {
                    // текст комментария
                    'text': text,
                    // идентификатор пользователя оставившего комментарий
                    'user_id': commentsController.attr('data-id'),
                    // идентификатор комментируемой сущности(книга, автор и т.д.)
                    'com_id': commentsController.attr('data-comId'),
                    // имя таблицы комментируемой сущности
                    'com_table': commentsController.attr('data-comTable'),
                    // идентификатор родительского комментария
                    'parent_id': parentComment.length ? parentComment.attr('data-id') : null
                },
                type: 'POST',
                beforeSend: function () {
                    // добавление спинера в кнопку добавления комментария
                    btn.addClass('disabled').append("<i class=\"fas fa-spinner fa-pulse\"></i>");

                }
            })
                .done(function (response) {
                    // очистка текстового редактора
                    $('.comments-text-editor-wrapper:not(.inner)').summernote('reset');
                    // удаление текстового редактора вложенного комментария
                    innerSummernoteDestroy();
                    // возврат кнопки в дефолтное состояние
                    btn.removeClass('disabled').find(".fa-spinner").remove();
                    // вывод алерта
                    Alert(response.type, response.message);
                    // если ответ содержит html комментария, то добавляем либо в конец всех комментариев, либо после
                    // родительского
                    if (response.comment) {
                        $(response.comment).insertAfter(parentComment.length ? parentComment : $('.comment-wrapper').last());
                    }
                })
                .fail(function (response) {
                    //вывод алерта
                    Alert('danger', response.responseJSON.message, 0);
                });
        } else {
            //вывод алерта
            Alert('danger', 'Доступно только зарегистрированным пользователям', 0);
        }

    })
    // отображение всех комментариев
        .on('click', '#show-all-comments-btn-wrapper>button', function () {
            $('.comment-wrapper.hidden').removeClass('hidden');
            $(this).addClass('active').text('Скрыть комментарии').blur();
        })
        // скрытие большей части комментариев
        .on('click', '#show-all-comments-btn-wrapper>button.active', function () {
            $('.comment-wrapper').slice(commentsController.attr('data-dispComCount')).addClass('hidden');
            $(this).removeClass('active').text('Показать все комментарии').blur();
        })
        .on('click', '.dropdown-item', function () {
            var text = $(this).text(),
                type = $(this).attr('data-type'),
                direction,
                ids = [];
            switch (type) {
                case 'rating':
                    direction = "desc";
                    break;
                case 'ndate':
                    direction = "desc";
                    break;
                case 'odate':
                    direction = "asc";
                    break;
            }
            $('.comment-wrapper').each(function () {
                ids.push($(this).attr('data-id'));
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: $(this).parent().attr("data-filterUrl"),
                data: {
                    // идентификатор комментируемой сущности(книга, автор и т.д.)
                    'com_id': commentsController.attr('data-comId'),
                    // имя таблицы комментируемой сущности
                    'com_table': commentsController.attr('data-comTable'),
                    'filterType': type !== 'rating' ? 'date' : type,
                    'direction': direction,
                    'ids': ids
                },
                type: 'POST',
                beforeSend: function () {
                    // добавление спинера в кнопку сортировки комментариев
                    $('#comments-sort-menu').append("<i class=\"fas fa-spinner fa-pulse\"></i>");

                }
            })
                .done(function (response) {
                    $('.comments-load-wrapper').addClass('hidden');
                    $('#comments-block-container').replaceWith(response);
                    // инициализация текстового редактора
                    summernoteInit($('.comments-text-editor-wrapper:not(.inner)'), false);
                    $('#comments-sort-menu').text(text).find(".fa-spinner").remove();
                })
                .fail(function (response) {
                    //вывод алерта
                    Alert('danger', response.responseJSON.message, 0);
                })
        })
        // подгрузка текстового редактора под родительским комментарием
        .on('click', '.comment-reply-btn', function (e) {
            // если текстовый редактор ответа не инициализирован, то инициализируем его
            if (!$(this).hasClass('active')) {
                // враппер родительского комментария
                var parent = $(this).closest('.comment-content-wrapper').find('.inner.comments-text-editor-wrapper');
                // удаление текстового редактора вложенного комментария
                innerSummernoteDestroy();
                // очистка враппера вложенного текстового редактора
                $('.inner.comments-text-editor-wrapper').empty();
                // кнопка ответа в родительском комментарии в дефолтное состояние
                $('.comment-reply-btn').removeClass('active');
                // инициализация вложенного текстового редактора
                summernoteInit(parent, true);
                // отображаем кнопку добавления комментария под новым текстовым редактором
                parent.siblings(".inner.add-comment-btn-wrapper").removeClass('hidden');
                // флаг активного комментария на враппере
                parent.addClass('active');
                // блокировка кнопки ответа
                $(this).addClass('active');
            }
            e.preventDefault();
        })
        // добавление оценки комментарию
        .on('click', '.comment-add-vote', function (e) {
            // контейнер оценки
            var ratingContainer = $(this).closest('.comment-wrapper').find('.comment-rating'),
                // тип ценки(положительный, отрицательный)
                type = $(this).attr('class').split(' ')[1];
            $.ajax({
                url: commentsController.attr("data-url-addVote"),
                data: {
                    // тип оценки
                    'type': type,
                    // идентификатор комментария
                    'id': $(this).closest('.comment-wrapper').attr('data-id'),
                    // текущий рейтинг
                    'rating': ratingContainer.length ? parseInt(ratingContainer.text()) : 0
                },
                type: 'POST'
            })
                .done(function (response) {
                    // делаем соответствующие изменения, в зависимости от новый оценки
                    if (response.rating > 0) {
                        ratingContainer.addClass('positive').removeClass('negative');
                    } else {
                        ratingContainer.addClass('negative').removeClass('positive');
                    }
                    // отображаем новую оценку
                    ratingContainer.text(response.rating);
                    // вывод алерта
                    Alert('success', 'Спасибо за оценку');
                })
                .fail(function (response) {
                    //вывод алерта
                    Alert('danger', response.responseJSON.message, 0);
                });
        });


    /**
     * инициализация текстового редактора
     *
     * @param element враппер
     * @param focusState состояние автофокуса на поле ввода редактора
     */
    function summernoteInit(element, focusState) {
        // добавление состояние автофокуса в массив опций
        $(options).extend({
            focus: focusState
        });
        // инициализация текстового редактора
        element.summernote(options);
    }

    /**
     * удаление вложенного текстового редактора
     */
    function innerSummernoteDestroy() {
        // враппер активного вложенного текстового редактора
        var oldActiveTextWrapper = $('.inner.comments-text-editor-wrapper.active');
        // если такие присутствуют на странице
        if (oldActiveTextWrapper.length) {
            // уничтожаем объект текстового редактора
            oldActiveTextWrapper.summernote('reset');
            oldActiveTextWrapper.removeClass('active').summernote('destroy');
            // подчищаем остатки
            oldActiveTextWrapper.html('');
            // скрываем кнопку добавления под враппером
            oldActiveTextWrapper.siblings(".inner.add-comment-btn-wrapper").addClass('hidden');
            // разблокируем кнопку ответа в родительском комментарии
            $('.comment-reply-btn').removeClass('active');
        }
    }

    /**
     * проверка количества доступных для ввода символов
     *
     * @param el элемент текстового редактора
     */
    function checkRemainingLetter(el) {
        // текущее количество введенных символов
        var curCount = $('<div>').html(el.summernote('code')).text().replace(/\s*/g, "").length - 1,
            // оставшееся количество
            remainingCount = letterCount - curCount,
            // контейнер отображающий количество оставшихся символов
            remainingLetter = $('.remainingLetter');
        // если осталось больше 0
        if (remainingCount > 0) {
            // разблокируем кнопку добавления комментария
            el.siblings('.add-comment-btn-wrapper').find('.add-comment').removeClass('disabled');
            // возврат кнопки оставшихся символов в дефолтное состояние
            remainingLetter.text(remainingCount).removeClass('excess');
        } else {
            // меняем текст и устанавлием стили превышения количества
            remainingLetter.text(remainingCount).addClass('excess');
            // блокируем кнопку добавления комментария
            el.siblings('.add-comment-btn-wrapper').find('.add-comment').addClass('disabled');
            // отображаем алерт если он отсутсвует на странице
            if (!hasAlert()) {
                Alert('warning', 'Количество символов для комментария достигло максимального значения', 6000);
            }
        }
    }

})(jQuery);