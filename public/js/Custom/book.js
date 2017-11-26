(function ($) {
    var body = $('body'),
        progressInput = $('.progress-input-wrapper input'),
        bookPages = parseInt($("#book-pages").text());

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
                $('.user-book-progress').removeClass('hidden');
                if (newStatus === 'completed') {
                    changeProgress(bookPages);
                    progressInput.val(bookPages + '/' + bookPages);
                }
                if (newStatus === 'inPlans') {
                    changeProgress(0);
                    progressInput.val('0/' + bookPages);
                }
                //вывод алерта
                Alert('success', 'Статус книги изменен.');
            });

        $('.user-item-rating').removeClass('hidden');
    });

    progressInput.on('focus', function () {
        var progressContainer = $('.user-book-progress'),
            errorMessage = $('.error-message'),
            currValue = progressInput.val(),
            currProgress = parseInt(currValue.split("/")[0]);

        progressInput.removeClass('no-focused').val(currProgress).select()
            .keypress(function (event) {
                var keycode = (event.keyCode ? event.keyCode : event.which);
                if (keycode === 13) {
                    progressInput.blur();
                }
            })
            .blur(function () {
                var newProgress = progressInput.val();

                if (newProgress > bookPages) {
                    progressContainer.addClass('error');
                    errorMessage.removeClass('hidden');
                } else {
                    if (newProgress === bookPages) {
                        progressInput.val(currValue);
                    } else {
                        changeProgress(newProgress);
                    }
                }
                $(this).addClass('no-focused');
            });
    });
    
    function changeProgress(newProgress) {
        var progressContainer = $('.user-book-progress'),
            errorMessage = $('.error-message');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: window.location.pathname + '/changeProgress',
            data: {'progress': newProgress},
            type: 'POST'
        })
            .done(function (data) {
                progressContainer.removeClass('error');
                errorMessage.addClass('hidden');
                progressInput.val(newProgress + '/' + bookPages);
                //вывод алерта
                Alert(data.type, data.message);
            });
    }
})(jQuery);

