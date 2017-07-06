/**
 * Created by muzhilkin on 14.06.2017.
 */
(function($){
    var backToTopBtn = $('#back-to-top');
    $(window).on('scroll', function() {
        this.scrollY > 30 ? backToTopBtn.addClass('visible') : backToTopBtn.removeClass('visible');
    });
    backToTopBtn.on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({scrollTop: 0}, 500);
        $(this).blur();
    });

    $('#add-to-favorite').on('click', function (e) {
        e.preventDefault();
        $.post(window.location);
    })
})(jQuery);