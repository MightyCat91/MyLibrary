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

    //фильтрация по выбранной букве
    filterLetter.on('click', function (e) {
        e.preventDefault();
        var letter = $(this).html(),
            ajaxData = {
                'filterLetter': letter, //буква, по которой фильтруем
                'type': $('#alphabet-sticky-block').attr('class'), //тип фильтруемого контента
                'isCurrent': $(this).hasClass('active') //флаг ранее проведенной фильтрации по выбранной букве
            };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/alphabetFilter',
            data: ajaxData,
            type: 'GET',
            //вешаем спинер
            beforeSend: function () {
                $(".page-content").addClass('spinner');
            }
        })
            .done(function (data) {
                //вставляем отфильтрованный контент
                $('#main-container').html(data);

                //заголовок
                var filterHeader = $('#filter-header');

                //если результат запроса не пустой
                if($(data).find('.item-container-link').length) {
                    //выбранная буква - текущая
                    if(ajaxData.isCurrent) {
                        //снимаем фильтрацию
                        filterHeader.text('').addClass('hidden')
                    } else {
                        //иначе формируем заголовок
                        filterHeader.text('Отфильтровано по букве "' + letter + '"').removeClass('hidden');
                    }
                } else {
                    //иначе формируем заголовок
                    filterHeader.text('К сожалению ничего не найдено').removeClass('hidden');
                }
                //убираем спинер
                $(".page-content").removeClass('spinner');
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