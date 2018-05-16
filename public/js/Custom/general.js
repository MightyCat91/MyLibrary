(function ($) {
    //элемент body
    var body = $("body");
    //кнопка BackToTop
    var backToTopBtn = $('#back-to-top');

    //отображение кнопки BackToTop
    $(window).on('scroll', function () {
        this.scrollY > 30 ? backToTopBtn.addClass('visible') : backToTopBtn.removeClass('visible');
    });

    //скролл при клике по кнопке BackToTop
    backToTopBtn.on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({scrollTop: 0}, 500);
        $(this).blur();
    });

    //анимация лейбла при фокусе на поле ввода
    body.on('focus', '.form-control', function () {
        $(this).next('label').addClass('active');
    });

    //удаление анимации при удалении фокуса с поля ввода
    body.on('focusout', '.form-control', function () {
        if (!$(this).val()) {
            $(this).next('label').removeClass('active');
        }
    });

    //отображение списка контролов профиля на малом разрешении
    body
        .on('click', '#user-profile-img-wrapper', function () {
            if ($(window).width() < 859) {
                $('.user-profile-btn-control').toggleClass('visible');
            }
        })
        .on('click', '.add-to-favorite', function (e) {
            var favoriteBtn = $(this),
                action = favoriteBtn.hasClass('active'),
                type = favoriteBtn.data('type'),
                id = favoriteBtn.closest('.item-container-link').data('id');
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //формирование передаваемых параметров
            var data = 'type=' + type + '&delete=' + action;
            if (typeof id !== "undefined") {
                data += '&id=' + id;
            } else {
                data += '&id=' + window.location.pathname.split('/').pop();
            }
            $.ajax({
                url: window.location.origin + '/changeFavoriteStatus',
                data: data,
                type: 'POST'
            })
                .done(function (data) {
                    //вывод алерта
                    if (favoriteBtn.hasClass('active')) {
                        Alert('success', ((type === 'book') ? 'Книга удалена' : 'Автор  удален') + ' из избранного');
                    } else {
                        Alert('success', ((type === 'book') ? 'Книга добавлена' : 'Автор  добавлен') + ' в избранное');
                    }
                    //изменение тайтла тултипа
                    favoriteBtn.toggleClass('active')
                        .attr('title', action ? 'Добавить в избранное' : 'Удалить из избранного');
                    //если меняется на странице с гридом
                    if ($('.container-link')) {
                        //если текущая страница - список любимых книг/авторов
                        if ($.inArray('favorite', window.location.pathname.split('/')) > 0) {
                            //удаляем со страницы данную книгу/автора
                            favoriteBtn.closest('.item-container-link').remove();
                        }
                        //иначе меняем иконку
                        favoriteBtn.children().toggleClass('hidden');
                    }
                })
        })
        .on('mouseleave', '.item-container-link', function () {
            var checkbox = $(this).find('.check-with-label');
            if (checkbox.is(":checked")) {
                checkbox.prop("checked", false);
            }
        })
})
(jQuery);

