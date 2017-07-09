/**
 * Created by muzhilkin on 14.06.2017.
 */
(function ($) {
    var backToTopBtn = $('#back-to-top');
    $(window).on('scroll', function () {
        this.scrollY > 30 ? backToTopBtn.addClass('visible') : backToTopBtn.removeClass('visible');
    });
    backToTopBtn.on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({scrollTop: 0}, 500);
        $(this).blur();
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