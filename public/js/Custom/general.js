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

    body.on('click', '#wrap-btn-control', function () {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $('.user-profile-btn-control').removeClass('visible');
        } else {
            $(this).addClass('active');
            $('.user-profile-btn-control').addClass('visible');
        }
    });
})(jQuery);