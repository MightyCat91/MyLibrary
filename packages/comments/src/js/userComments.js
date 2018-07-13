(function ($) {
    var showAllCommBtn = $('#show-all-comments-btn-wrapper');

    // открытие большей части комментариев
    showAllCommBtn.find('button').on('click', function () {
        $('.comment-wrapper.hidden').removeClass('hidden');
        $(this).addClass('active').text('Скрыть комментарии').blur();
    });

    // скрытие большей части комментариев
    showAllCommBtn.find('>button.active').on('click', function () {
        $('.comment-wrapper').slice(window.Laravel.displayedCommentsCount).addClass('hidden');
        $(this).removeClass('active').text('Показать все комментарии').blur();
    });

    // добавление оценки комментарию
    $('.comment-add-vote').on('click', function () {
        if ($(this).closest('.comment-wrapper').attr('data-authorID') === window.Laravel.user_id) {
            Alert('warning', 'Нельзя оценивать свои же комментарии');
            return;
        }
        // контейнер оценки
        var ratingContainer = $(this).closest('.comment-wrapper').find('.comment-rating'),
            // тип ценки(положительный, отрицательный)
            type = $(this).attr('class').split(' ')[1];
        $.ajax({
            url: window.Laravel.addVoteUrl,
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
                Alert(response.type, response.message);
            })
            .fail(function (response) {
                //вывод алерта
                Alert('danger', response.responseJSON.message, 0);
            });
    });
    console.log(window.Laravel.deleteCommentUrl);
    // удаление комментария
    $('.comment-delete-btn').on('click', function (e) {
        // контейнер комментария
        var commentWrapper = $(this).closest('.comment-wrapper');
        $.ajax({
            url: window.Laravel.deleteCommentUrl,
            data: {
                // идентификатор комментария
                'id': commentWrapper.attr('data-id')
            },
            type: 'POST'
        })
            .done(function (response) {
                // удаление комментария
                commentWrapper.remove();
                // вывод алерта
                Alert(response.type, response.message);
            })
            .fail(function (response) {
                //вывод алерта
                Alert('danger', response.responseJSON.message, 0);
            });
        e.preventDefault();
    })
})(jQuery);