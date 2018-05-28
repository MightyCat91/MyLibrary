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
        var id = $('.review-item-container').attr('data-id');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: $('#reviews-container').attr("data-url"),
            data: $(this).hasClass('positive') ? {'vote': true, 'id': id} : {'vote': false, 'id': id},
            type: 'POST'
        })
            .done(function (response) {

                // вывод алерта
                Alert('success', 'Спасиюо за оценку');
            })
            .fail(function (response) {
                //получаем все ошибки для первого невалидного файла
                for (var key in response.responseJSON) ;
                var errors = response.responseJSON[key];
                $.each(errors, function (index, fileWithError) {
                    $.each(fileWithError, function (index, error) {
                        //вывод алерта
                        Alert('warning', error, 0);
                    });
                });
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