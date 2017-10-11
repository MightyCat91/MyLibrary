(function ($) {
    //открытие попапа с статусами отличными от текущего
    $('.status-btn').on('focus', function () {
        //текущий статус
        var currStatus = $(this).attr('data-status'),
            //выводимый список статусов
            content = $('#status-list').clone().removeClass('hidden');

        //удаление кнопки с текущим статусом
        content.find('.status-option.' + currStatus).remove();
        //установка кнопкам идентификатора книги, статус которой меняем
        content.find('.status-option').attr('data-btnid', $(this).closest('.table-row').attr('data-bookid'));
        //показ попапа с отредактированным списком кнопок статусов
        $(this).attr('data-content', content.html()).popover('show');
    })
        .popover({
            'placement': 'bottom',
            'html': true,
            delay: {"show": 100, "hide": 100},
            trigger: 'manual'
        });

    //смена статуса книги
    $(document).on('click', '.status-option', function () {
        //кнопка из попапа с новым устанавливаемым статусом
        var clickedBtn = $(this),
            //кнопка со старым статусом
            statusBtn = $('.table-row[data-bookid="' + $(this).attr('data-btnid') + '"] .status-btn'),
            //новый статус
            newStatus = clickedBtn.data('status'),
            //старый статус
            olsStatus = statusBtn.attr('data-status'),
            //урл, по которому отправится аякс
            url = statusBtn.parent('.table-column').prev('.name.value').find('a').attr('href') + '/changeStatus',
            //данные передаваемые через аякс
            data = {
                'oldStatus': olsStatus,
                'newStatus': newStatus
            };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            data: data,
            type: 'POST'
        })
            .done(function (data) {
                //количество книг с старым статусом
                var booksWithOldStatusCount = $('.status-btn[data-status="' + olsStatus + '"]').length,
                    //количество книг с новым статусом
                    booksWithNewStatusCount = $('.status-btn[data-status="' + newStatus + '"]').length;

                //меняем у кнопки статус(цвет) и текст соответсвенно выбранному
                statusBtn.attr('data-status', newStatus).val(clickedBtn.text());
                //меняем цвет в блоке-индикаторе соответственно новому статусу
                statusBtn.closest('tr').find('.status_color').attr('data-status', newStatus);

                //если в момент переключения количество книг со старым статусом на текущщей вкладке было более одной
                if (booksWithOldStatusCount > 1) {
                    //скрываем строку с которой установили новый статус
                    $('.status_color[data-status="' + newStatus + '"]').closest('.table-row').addClass('hidden');
                }

                //если в момент переключения статуса была одна книга со старым статусом
                if (booksWithOldStatusCount === 1) {
                    //скрываем таб остающийся без книг
                    $('.book-status[data-tab="' + olsStatus + '"]').addClass('hidden').siblings().removeClass('hidden');
                    //если текущий таб не "все книги"
                    if ($('.book-status.active').attr('data-tab') !== 'all') {
                        //переключаем таб на другой, соответствующий новому статусу
                        $('.book-status[data-tab="' + newStatus + '"]').addClass('active').siblings().removeClass('active');
                        //отображаем книги соответствующие новому статусу и скрываем остальные
                        $('.status_color[data-status="' + newStatus + '"]').closest('.table-row').removeClass('hidden');
                    }
                }

                //если в момент переключения отсутствуют книги с новым статусом
                if (booksWithNewStatusCount === 0) {
                    //таб с новым статусом
                    var statusTab = $('.book-status[data-tab="' + newStatus + '"]');

                    //если таб с новым статусом существует в дереве
                    if (statusTab.length > 0) {
                        //делаем его видимым
                        statusTab.removeClass('hidden');
                    } else {
                        //клонируем первый неактивные таб
                        var newStatusTab = $('.book-status:not(.active):first').clone();
                        //меняем у него статус и текс соответствующие новому статусу
                        newStatusTab.attr('data-tab', newStatus).children('span').text(clickedBtn.text());
                        //добавляем блок нового таба
                        $('.book-status-container').append(newStatusTab);
                    }
                }
            })
    })
    //скрытие попапа по клику вне его или кнопки нового статуса
        .on('click', function (event) {
            //наличие уже открытого попапа
            var popupIsShow = $('[aria-describedby]').length,
                //идентификатор книги у кнопок в попапе
                popoverBookId = $('.popover .status-option').attr('data-btnid'),
                //идентификатор книги статус которой меняем
                statusBtnBookId = $(event.target).closest('.table-row').attr('data-bookid');

            //если попап открыт и клик произошел по кнопке смены статуса отличной от текущей
            if (popupIsShow && (statusBtnBookId !== popoverBookId)) {
                //скрываем попап
                $('.table-row[data-bookid="' + popoverBookId + '"] .status-btn').popover('hide');
            }
        })
        //переключение табов-статусов
        .on('click', '.book-status', function () {
            //статус таба, по которому произошел клик
            var status = $(this).attr('data-tab');

            //устанавливаем данному табу статус активного
            $(this).addClass('active').siblings().removeClass('active');
            //если данный таб соответствует общему "все книги"
            if (status === 'all') {
                //отображаем все книги
                $('tbody .table-row').removeClass('hidden');
            } else {
                //скрываем все книги
                $('tbody .table-row').addClass('hidden');
                //отображаем книги соответсвующие статусу нового активного таба
                $('.status_color[data-status="' + status + '"]').closest('.table-row').removeClass('hidden');
            }
        })
        .on('click', '.other-authors-controller', function () {
            $(this).find('.fa-arrow-circle-o-down').toggleClass('hidden').siblings('.fa-arrow-circle-o-up').toggleClass('hidden');
            $('.other-author-wrapper').toggleClass('hidden');
        });

    $('.rating-btn').on('click', function () {
        console.log($(this).next().find('option').toArray());
        $(this).toggleClass('no-focused')
            .autocomplete({
                source: $(this).next().find('option').toArray(),
                minLength: 0,
                delay: 500,
                classes: {'ui-autocomplete': 'input-autocomplete'},
                //удаление автокомплита
                close: function () {
                    // $(this).autocomplete('destroy');
                }
            }).autocomplete('search', '');
    })
        .blur(function () {
            $(this).toggleClass('no-focused');
        })
        
    $('.input-autocomplete').width($(this).width() - 50);
})(jQuery);