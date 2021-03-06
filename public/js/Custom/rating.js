(function ($) {
    //тело страницы
    var body = $('body'),
        //контейнер блока рейтинга
        ratingContainer = $('.user-item-rating'),
        //имеющийся рейтинг у книги(автора)
        rating = ratingContainer.data('rating');

    //если у книги/автора уже есть оценка, то отображаем блок рейтинга и соответствующее количество звезд
    if (rating) {
        var selected = ratingContainer.find('.star-icon[data-rating=' + rating + ']'),
            currContainer = selected.closest('.rating-star-container');

        selected.addClass('selected active').siblings().removeClass('active');
        currContainer.prevAll('.rating-star-container').find('.full-star').addClass('active').siblings().removeClass('active');
    }

    //наведение на левую половину звезды
    $('.left-half').mouseenter(function () {
        //убираем подсветку со всех звезд
        iconStarOut();
        //устанавливаем подсветку текущей
        iconStarIn(this, '.half-star');
    });

    //наведение на правую половину звезды
    $('.right-half').mouseenter(function () {
        //убираем подсветку со всех звезд
        iconStarOut();
        //устанавливаем подсветку текущей
        iconStarIn(this, '.full-star');
    });

    //возвращаем блоку рейтинга состояние, которое было до наведения на него курсора
    ratingContainer.mouseleave(function () {
        //звезда, соответствующая оценке книги/автора
        var selected = $('.star-icon.selected');

        //если такая звезда есть(книга/автор были оценены ранее)
        if (selected.length) {
            //убираем подсветку со всех звезд
            iconStarOut();
            //подсвечиваем текущую звезду и всех, которые расположены перед ней
            selected.addClass('active').siblings().removeClass('active').closest('.rating-star-container')
                .prevAll('.rating-star-container').find('.full-star').addClass('active').siblings().removeClass('active');
        } else {
            //иначе убираем подсветку со всех звезд
            iconStarOut();
        }
    });

    //подветка звезды на которую наведен курсор и всех, которые расположены перед ней
    function iconStarIn(el, iconClass) {
        //контейнер звезды на которую наведен курсор
        var currContainer = $(el).closest('.rating-star-container'),
            //иконка звезды на которую наведен курсор
            currRatingIcon = currContainer.find(iconClass);

        //подсвечиваем текущую звезду, с других снимаем этот соответствующий класс
        currRatingIcon.addClass('active').siblings().removeClass('active');
        //подсвечиваем все предыдущие звезды
        currContainer.prevAll('.rating-star-container').find('.full-star').addClass('active').siblings().removeClass('active');
    }

    //возврат звезд в дефолтное состояние
    function iconStarOut() {
        ratingContainer.find('.empty-star').addClass('active').siblings().removeClass('active');
    }

    //обновление рейтинга книги/автора по клику на звезду
    $('.hover-rating-container > div').on('click', function () {
        //текущая иконка звезды, которой соответствует область, по которой произошел клик
        var currIcon = $(this).closest('.rating-star-container').find('.active');

        //убираем со старой звезды статус выбранной
        $('.user-item-rating .selected').removeClass('selected');
        //текущей звезде добавляем статус выбранной
        currIcon.addClass('selected');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: window.location.pathname + '/changeRating',
            data: {
                //новая оценка рейтинга
                'rating': currIcon.data('rating'),
                //тип элемента(книга или автор)
                'type': $(this).closest('.user-item-rating').data('type')
            },
            type: 'POST'
        })
            .done(function (data) {
                //вывод алерта
                Alert('success', 'Ваша оценка обновлена');
                //обновление значения среднего рейтинга
                $('#avg-rating > span').text(data.avgRating);
                //обновление значения количества оценок
                $('#rating-quantity > span').text(data.quantityRating);
            });
    });
})(jQuery);