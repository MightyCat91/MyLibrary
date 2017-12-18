(function ($) {
    //получение значение параметра filter из адресной строки
    var urlParameter = GetURLParameter('filter');
    //буква, по которой осуществляется фильтрация
    var filterLetter = $('.letter-filter');
    //прилипающий родительский блок-контейнер
    var filterContainer = $('#alphabet-sticky-block');
    //значение смещения, при наступлении которого происходит прилипание контейнера
    var limit = $('.footer').offset().top - filterContainer.height() - 30;
    $(window).scroll(function () {
        //текущее значение смещения верхней границы страницы относительно верхней границы окна
        var windowTop = $(window).scrollTop();
        //пока верхняя границы страницы не совпадает с верхней границей окна
        if (windowTop != 0) {
            //устанавливаем прилипающему контейнеру фиксированную позицию
            filterContainer.css({position: 'fixed', top: '0em'});
        }
        //если совпадает
        else {
            //устанавливаем статическое позиционирование
            filterContainer.css('position', 'static');
        }
        //пока значение граничного смещения меньше значения текущего скролла
        if (limit < windowTop) {
            //устанавливаем верхнию границу прилипающему блоку равную разнице между текущим скролом и граничным
            // значением
            var diff = limit - windowTop;
            filterContainer.css({top: diff});
        }
    });

    //установка и снятие стилей на выбранную букву(и соседние) при наведении на нее курсора
    filterLetter.hover(
        function () {
            $(this).addClass('hover');
            $(this).next().addClass('adjacent');
            $(this).prev().addClass('adjacent');
        },
        function () {
            $(this).removeClass('hover');
            $(this).next().removeClass('adjacent');
            $(this).prev().removeClass('adjacent');
        }
    );

    /*
    * функция получения параметров из адресной строки
     */
    function GetURLParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        if (results === null) {
            results = '';
        } else {
            results = decodeURIComponent(results[1].replace(/\+/g, ' '));
        }
        return results;
    }

    //если при загрузке страницы в адресе присутствует параметр, то букве соответствующей его значению вешаем класс
    // active
    if (urlParameter) {
        $('.letter-filter:contains("' + urlParameter + '")').addClass('active');
    }

    filterLetter.on('click', function (e) {
        e.preventDefault();
        var letter = $(this).html(),
            ajaxData = {
                'filterLetter': letter,
                'type': $('#alphabet-sticky-block').attr('class'),
                'isCurrent': $(this).hasClass('active')
            };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/alphabetFilter',
            data: ajaxData,
            type: 'GET'
            // beforeSend: function () {
            //     changeBtn.addClass('saving').children('.dflt-text').addClass('hidden').nextAll('.load-text')
            //         .removeClass('hidden');
            // }
        })
            .done(function (data) {
                $('#main-container').html(data);
                var filterHeader = $('#filter-header');
                console.log($(data).find('.item-container-link').length);
                if($(data).find('.item-container-link').length) {
                    if(ajaxData.isCurrent) {
                        console.log('1');
                        filterHeader.text('').addClass('hidden')
                    } else {
                        filterHeader.text('Отфильтровано по букве "' + letter + '"').removeClass('hidden');
                    }
                } else {
                    filterHeader.text('К сожалению ничего не найдено').removeClass('hidden');
                }
            });

        //если выбранная буква не является текущей, по которой происходит фильтрация
        if (!$(this).hasClass('active')) {
            //снимаем с других букв класс активной
            $('.letter-filter').removeClass('active');
            //текущей букве устанавливаем класс активной
            $(this).addClass('active');
        } else {
            //иначе убираем с текущей буквы класс активной
            $(this).removeClass('active');
            $('.item-container-link').removeClass('hidden');
        }
    });
})(jQuery);