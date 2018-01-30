
(function($){
    //элемент body
    var body = $("body");

    var backToTopBtn = $('#back-to-top');

    $(window).on('scroll', function() {
        this.scrollY > 30 ? backToTopBtn.addClass('visible') : backToTopBtn.removeClass('visible');
    });

    backToTopBtn.on('click', function(e) {
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
    body.on('click', '#user-profile-img-wrapper', function () {
        if ($(window).width() < 859) {
            $('.user-profile-btn-control').toggleClass('visible');
        }
    });

    $('.add-to-favorite').on('click', function (e) {
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
        var data = 'type=' + type + '&delete=' + action;
        if (typeof id !== "undefined") {
            data += '&id=' + id;
        }
        $.ajax({
            url: window.location.pathname,
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
                favoriteBtn.toggleClass('active')
                    .attr('title', action ? 'Добавить в избранное' : 'Удалить из избранного');
            })
    })
})
(jQuery);

