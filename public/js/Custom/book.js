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
                //добавление ответа сервера(алерт)
                body.append(data);
            });

        $('.user-item-rating').removeClass('hidden');
    });

    $('.left-half').hover(
        function () {
            iconStarIn(this, '.fa-star-half-o');
            доб очистку
        },
        function () {
            iconStarOut();
        }
    );

    $('.right-half').hover(
        function () {
            iconStarIn(this, '.fa-star');
            доб очистку
        },
        function () {
            iconStarOut();
        }
    );

    $('.user-item-rating')
        .on('load', function () {
            var rating = $(this).data('rating'),
                selected = $(this).find('.star-icon[data-rating=' + rating + ']'),
                currContainer = selected.closest('.rating-star-container');

            selected.addClass('selected active');
            currContainer.prevAll('.rating-star-container').find('.fa-star').addClass('active').siblings().removeClass('active');
        })
        .mouseleave(function () {
            var selected = $('.star-icon.selected');
            if (selected.length) {
                selected.addClass('active').siblings().removeClass('active').closest('.rating-star-container')
                    .prevAll('.rating-star-container').find('.fa-star').addClass('active').siblings().removeClass('active');
            }
        });

    function iconStarIn(el, iconClass) {
        var currContainer = $(el).closest('.rating-star-container'),
            currRatingIcon = currContainer.find(iconClass);

        currRatingIcon.addClass('active').siblings().removeClass('active');
        currContainer.prevAll('.rating-star-container').find('.fa-star').addClass('active').siblings().removeClass('active');
    }

    function iconStarOut() {
        $('.rating-star-container').find('.fa-star-o').addClass('active').siblings().removeClass('active');
    }


    $('.hover-rating-container > div').on('click', function () {
        var currIcon = $(this).closest('.rating-star-container').find('.active');

        $('.user-item-rating .selected').removeClass('selected');
        currIcon.addClass('selected');
        console.log(currIcon.data('rating'), $(this).closest('.user-item-rating').data('type'));
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: window.location.pathname + '/changeRating',
            data: {
                'rating': currIcon.data('rating'),
                'type': $(this).closest('.user-item-rating').data('type')
            },
            type: 'POST'
        })
            .done(function (data) {
                console.log('123');
                //добавление ответа сервера(алерт)
                body.append(data);
            });
    });
})(jQuery);

