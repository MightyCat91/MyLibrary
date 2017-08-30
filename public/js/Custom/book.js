(function ($) {
    $('.owl-carousel').owlCarousel({
        nav: true,
        lazyLoad: true,
        dots: false,
        navText: [
            "<i class='fa fa-lg fa-arrow-circle-left' aria-hidden='true'></i>",
            "<i class='fa fa-lg fa-arrow-circle-right' aria-hidden='true'></i>"
        ],
        navContainerClass: "owl-nav hidden",
        items: 1
    });

    $('.slider').hover(
        function () {
            $('.owl-nav').removeClass('hidden');
        },
        function () {
            $('.owl-nav').addClass('hidden');
        }
    );

    $('#status-btn').popover({
            'placement': 'bottom',
            'content': $('#status-list').clone().removeClass('hidden'),
            'html': true,
            delay: {"show": 100, "hide": 100},
            trigger: 'focus'
    });

    $(document).on('click', ".status-option", function () {
        console.log(window.location.pathname);
        var statusBtn = $('#status-btn'),
            data = {
            'oldStatus': statusBtn.data('status'),
            'newStatus': $(this).data('status')
        };
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: window.location.pathname + '/changeStatus',
            data: data,
            type: 'POST'
        })
            .done(function (data) {
                statusBtn.html($(this).html());
                favoriteBtn.toggleClass('active')
                    .attr('title', action ? 'Добавить в избранное' : 'Удалить из избранного');
                //добавление ответа сервера(алерт)
                body.append(data);
            })
    })
})(jQuery);

