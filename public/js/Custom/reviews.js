(function ($) {
    var textReviewContainer = $('.review-item-body'),
        maxLineCount = 7;

    textReviewContainer.each(function () {
        clampText($(this));
    });

    $('.review-show-full .show').on('click', function (el) {
        el.preventDefault();
        $(this).parents('.review-show-full').prev().css('max-height', '100rem');
        $(this).addClass('hidden').siblings().removeClass('hidden');
    });

    $('.review-show-full .hide').on('click', function (el) {
        el.preventDefault();
        clampText($(this).parents('.review-show-full').prev());
        $(this).addClass('hidden').siblings().removeClass('hidden');
    });

    $('.access-wrapper').on('click', function () {
        var reviewContainer = $(this),
            id = reviewContainer.parents('.review-item-container').attr('data-id');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: $('#reviews-container').attr("data-url"),
            data: reviewContainer.hasClass('positive') ? {'vote': 'positive', 'id': id} : {'vote': 'negative', 'id': id},
            type: 'POST'
        })
            .done(function (response) {
                console.log(reviewContainer.attr('class'));
                if (response.scoreType === 'positive') {
                    reviewContainer.parents('.review-item-container').find('.review-positive-count').text('+' + response.score)
                } else {
                    reviewContainer.parents('.review-item-container').find('.review-negative-count').text('-' + response.score)
                }
                if (response.type) {
                    Alert(response.type, response.message);
                } else {
                    // вывод алерта
                    Alert('success', 'Спасибо за оценку');
                }
            })
            .fail(function (response) {
                //вывод алерта
                Alert('danger', response.responseJSON.message, 0);
            });
    });


    function clampText(el) {
        var heightTextContainer = el.height(),
            lineHeightTextContainer = parseInt(el.css('font-size').replace('px', '')) * 1.3,
            lineCountTextContainer = Math.floor(heightTextContainer / lineHeightTextContainer);

        if (lineCountTextContainer > maxLineCount) {
            el.css('max-height', lineHeightTextContainer * maxLineCount + 'px');
        } else {
            el.find('.review-show-full').addClass('hidden');
        }
    }
})(jQuery);