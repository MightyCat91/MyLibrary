
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
        if ($(window).width() < 768) {
            $('.user-profile-btn-control').toggleClass('visible');
        }
    });

    $('#add-to-favorite').on('click', function (e) {
        var favoriteBtn = $(this);
        var action = favoriteBtn.hasClass('active');
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: window.location.pathname,
            data: 'type=' + $(this).data('type') + '&delete=' + action,
            type: 'POST'
        })
            .done(function () {
                favoriteBtn.toggleClass('active')
                    .attr('title', action ? 'Добавить в избранное' : 'Удалить из избранного');
            })
    })
})
(jQuery);

