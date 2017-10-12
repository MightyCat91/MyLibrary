(function ($) {
    var body = $('body');

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
        var statusBtn = $('#status-btn'),
            clickedBtn = $(this),
            newStatus = clickedBtn.data('status'),
            data = {
                'oldStatus': statusBtn.attr('data-status'),
                'newStatus': newStatus
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
                statusBtn.attr('data-status', newStatus).text(clickedBtn.text());
                $('.user-book-progress').toggleClass('hidden');
                //добавление ответа сервера(алерт)
                body.append(data);
            });

        $('.user-item-rating').removeClass('hidden');
    });

    $('.progress-input-wrapper input').on('focus', function () {
        var currValue = $(this).val(),
            currProgress = parseInt(currValue.split("/")[0]),
            bookPages = parseInt(currValue.split("/")[1]);

        $(this).toggleClass('no-focused').val(currProgress)
            .keypress(function (event) {
                var keycode = (event.keyCode ? event.keyCode : event.which);
                if (keycode === 13) {
                    var newProgress = $(this).val();
                    console.log(newProgress > bookPages);
                    if (newProgress > bookPages) {
                        $('.user-book-progress').addClass('error');
                        $('.error-message').removeClass('hidden');
                    } else {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: window.location.pathname + '/changeProgress',
                            data: {'progress' : newProgress},
                            type: 'POST'
                        })
                            .done(function (data) {
                                $('.user-book-progress').removeClass('error');
                                $('.error-message').addClass('hidden');
                                $(this).val(newProgress + '/' + bookPages);
                                //добавление ответа сервера(алерт)
                                body.append(data);
                            });
                        $(this).trigger('blur');
                    }
                }
            });
    })
        .blur(function () {
            $(this).toggleClass('no-focused');
        })
})(jQuery);

