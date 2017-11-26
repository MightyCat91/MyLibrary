(function ($) {
    var progressIsChanged = false,
        temporaryPercent = null,
        statusTab = $('.book-status-container'),
        statusTabsWidth =  0;

    $('.book-status').each(function(){
        statusTabsWidth += $(this).width();
    });

    if (statusTab.width() < statusTabsWidth) {
        statusTab.addClass('mobile').find('i').removeClass('hidden');
        $('.book-status:not(.active)').addClass('hidden');
    }

    $(window).on('scroll', function () {
        var scroll = $(this).scrollTop();

        if (scroll > $('.table-header').offset().top) {
            statusTab.addClass('fixed');
            $('.user-book-library-table').addClass('statusTabIsFixed');
            statusTab.addClass('animate');
        } else {
            statusTab.removeClass('animate');
            statusTab.removeClass('fixed');
            $('.user-book-library-table').removeClass('statusTabIsFixed');
        }
    })
        .on('resize', function () {
            if (statusTab.width() < statusTabsWidth) {
                statusTab.addClass('mobile').find('i').removeClass('hidden');
                $('.book-status:not(.active)').addClass('hidden');
            } else {
                statusTab.removeClass('mobile').find('i').addClass('hidden');
                $('.book-status:not(.active)').removeClass('hidden');
            }
        });

    $('.book-status-container.mobile > .fa-bars').on('click', function () {
        $('.book-status:not(.active):not(i)').toggleClass('hidden');
    });

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
            oldStatus = statusBtn.attr('data-status'),
            //строка таблицы в которой меняем статус книги
            tableRow = statusBtn.closest('.table-row'),
            //поле прогресса в строке, в которой меняем статус
            progressField = tableRow.find('.book-progress'),
            //количество страниц в книге, у которой меняем статус
            pages = progressField.attr('title').split('/')[1];

        changeStatus(statusBtn, tableRow, oldStatus, newStatus, clickedBtn.text());

        //если статус = "прочитано"
        if (newStatus === 'completed') {
            progressField.val(pages);
            changeProgress(progressField);
            //устанавливаем 100% прогресса и макс. количество прочитанных страниц
            progressField.attr('title', pages + '/' + pages);
            tableRow.find('.progress-short').text('100%');

        }
        //если статус = "в планах"
        if (newStatus === 'inPlans') {
            progressField.val(0);
            changeProgress(progressField);
            //устанавливаем 0% прогресса и 0 прочитанных страниц
            progressField.attr('title', '0/' + pages);
            tableRow.find('.progress-short').text('0%');

        }
    })
    //скрытие попапа по клику вне его или кнопки нового статуса
        .on('click', function (event) {
            //элемент, по которому совершен клик
            var targetClick = $(event.target),
                //поле поиска
                searchField = $('.search-field'),
                //наличие уже открытого попапа
                popupIsShow = $('[aria-describedby]').length,
                //идентификатор книги у кнопок в попапе
                popoverBookId = $('.popover .status-option').attr('data-btnid'),
                //идентификатор книги статус которой меняем
                statusBtnBookId = targetClick.closest('.table-row').attr('data-bookid');

            //если попап открыт и клик произошел по кнопке смены статуса отличной от текущей
            if (popupIsShow && (statusBtnBookId !== popoverBookId)) {
                //скрываем попап
                $('.table-row[data-bookid="' + popoverBookId + '"] .status-btn').popover('hide');
            }

            //скрываем поле поиска если клик произошел не по нему или иконке поиска
            if (!targetClick.hasClass('fa-search') && !targetClick.hasClass('search-field') && searchField.hasClass('show')) {
                searchField.removeClass('show');
            }
        })
        //переключение табов-статусов
        .on('click', '.book-status', function () {
            //статус таба, по которому произошел клик
            var status = $(this).attr('data-tab');

            //устанавливаем данному табу статус активного
            $(this).addClass('active').siblings().removeClass('active');
            if ($('.book-status-container').hasClass('mobile')) {
                $(this).siblings(':not(i)').addClass('hidden');
            }
            //если данный таб соответствует общему "все книги"
            if (status === 'all') {
                //отображаем все книги
                $('.table-body .table-row').removeClass('hidden');
            } else {
                //скрываем все книги
                $('.table-body .table-row').addClass('hidden');
                //отображаем книги соответсвующие статусу нового активного таба
                $('.status_color[data-status="' + status + '"]').closest('.table-row').removeClass('hidden');
            }
        })
        //отображение всех авторов
        .on('click', '.other-authors-controller', function () {
            $(this).prev('.author-link-wrapper').toggleClass('line-height-1-5');
            $(this).find('.fa-arrow-circle-o-down').toggleClass('hidden').siblings('.fa-arrow-circle-o-up').toggleClass('hidden');
            $(this).next('.other-author-wrapper').toggleClass('hidden');
        });

    //смена рейтинга книги
    $('.rating-btn').on('focus', function () {
        //поле рейтинга, который меняем
        var ratingField = $(this),
            //значение рейтинга до изменения
            oldRating = ratingField.val();

        //автовыделение значение в поле ввода
        ratingField.select();
        //применение стилей выделенности к выбранному полю
        ratingField.removeClass('no-focused')
        //открытие списка автокомплита
            .autocomplete({
                source: ratingField.next().find('option').toArray(),
                minLength: 0,
                delay: 500,
                classes: {'ui-autocomplete': 'input-autocomplete'},
                open: function () {
                    //при нажатии клавиши Enter снимаем фокус с поля ввода
                    ratingField.keypress(function (event) {
                        var keycode = (event.keyCode ? event.keyCode : event.which);
                        if (keycode === 13) {
                            ratingField.blur();
                        }
                    })
                },
                //при выборе нового значения из списка
                select: function (event, ui) {
                    //устанавливаем в поле рейтинга новое значение и с нимаем с него фокус
                    ratingField.val(ui.item.innerHTML).blur();
                }
            }).autocomplete('search', '')
        //при снятии фокуса меняем значение рейтинга на сервере
            .blur(function () {
                //новый рейтинг
                var newRating = ratingField.val();

                //если введенное значение - число
                if ($.isNumeric(newRating)) {
                    //и не равно старому рейтингу
                    if (parseInt(oldRating) !== newRating) {
                        //отправляем аякс-запрос на сервер
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: window.location.pathname + '/changeRating',
                            data: {
                                //новая оценка рейтинга
                                'rating': parseInt(newRating),
                                //тип сущности, которому меняем рейтинг(в данном случае всегда книга)
                                'type': 'book',
                                //идентификатор книги, которой меняем рейтинг
                                'id': ratingField.closest('.table-row').attr('data-bookid')
                            },
                            type: 'POST'
                        })
                        //при окончании запроса
                            .done(function (data) {
                                //при ошибке
                                if (data.length) {
                                    //в поле рейтинга устанавливаем старое значение
                                    ratingField.val(oldRating);
                                    //вывод алерта
                                    Alert('danger', data);
                                }
                                $('.mobile-table-row[data-bookid="' + ratingField.closest('.table-row').attr('data-bookid') + '"]').find('.rating-short').text(newRating);
                            });
                    } else {
                        ratingField.val(oldRating);
                    }
                    //если новый рейтинг совпадает со старым
                } else {
                    //оставляем старый
                    ratingField.val(oldRating);
                }
                //снимаем стили выделенности с поля рейтинга
                ratingField.addClass('no-focused');
            });
    });

    //смена прогресса книги
    $('.book-progress').on('focus', function () {
        //поле прогресса, которое меняем
        var input = $(this),
            //старое значение прогресса в процентах
            currPercent = input.val(),
            //старое значение прогресса в формате прочитанные страницы/количество страниц
            currValue = input.attr('title'),
            //старое значение прогресса в страницах
            currProgress = parseInt(currValue.split("/")[0]),
            bookPages = currValue.split("/")[1];

        //временной переменной устанавливаем значение - старый процент
        temporaryPercent = currPercent;
        //устанавливаем стили выбранности, значения-количество прочитанных страниц, и выделяем текст в поле
        input.val(currValue).removeClass('no-focused').select()
            .keydown(function (event) {
                event.stopImmediatePropagation();
                var keycode = (event.keyCode ? event.keyCode : event.which);
                //при нажатии кнопки Enter
                if (keycode === 13) {
                    //устанавливаем флаг того, что значение прогресса изменено
                    progressIsChanged = true;
                    //вызов функции смены прогресса
                    changeProgress($(this));
                    //снимаем фокус с поля
                    input.blur();
                    return false;
                }
            })
    })
    //при снятии фокуса с поля
        .on('blur', function () {
            //если прогресс еще не был изменен
            if (!progressIsChanged) {
                //вызов функции смены прогресса
                changeProgress($(this));
            }
            //снимаем флаг того, что прогресс изменен
            progressIsChanged = false;
        });

    //сортировка таблицы
    $('th.can-sort').on('click', function () {
        //не активные иконки сортировки в выбранном столбце
        var newSortControl = $(this).children('.sort-controls.hidden'),
            //порядок сортировки
            order = null,
            //имя столбца, по которому сортируем таблицу
            field = $(this).attr('class').split(' ')[1];

        //скрываем иконки сортировки в других столбцах
        $(this).siblings().children('.sort-controls').addClass('hidden');
        //если клик произошел по столбцу, по которому уже была установлена сортировка
        if (newSortControl.length < 2) {
            //скрываем старую иконку сортировки и отображаем новую
            newSortControl.removeClass('hidden').siblings('.sort-controls').addClass('hidden');
            //переменной порядка сортировки присваиваем тип соответсвующий отображаемой иконки
            order = newSortControl.attr('data-order')
            //если клик произоел по другому столбцу
        } else {
            //отображаем иконку сортировки по умолчанию(desc)
            $(this).children('.sort-controls:last').removeClass('hidden');
            //переменной сортировки устанавливаем соответсвующий порядок
            order = $(this).children('.sort-controls:last').attr('data-order')
        }
        //перерисовываем таблицу в соответсвии с новой сортировкой
        $('.table-body .table-body').html(sort(field, order));
    });

    //отображение поля ввода поиска при клике по соответствующей иконке
    $('.fa-search').on('click', function () {
        $(this).prev().children().toggleClass('show');
    });

    //поиск по таблице(по полям имя и автор)
    $('.search-field').on('focus', function () {
        $(this).keydown(function (event) {
            //клавиша, которую нажали
            var keycode = (event.keyCode ? event.keyCode : event.which),
                //статус, таб которого активен
                status = $('.book-status.active').attr('data-tab');
            //если нажатая клавиша Enter
            if (keycode === 13) {
                //значение, которое ввели в поле поиска(в нижнем регистре)
                var searchedValue = $(this).val().toLowerCase(),
                    //список имен книг
                    booksNameList = $('.table-body .name a'),
                    //список авторов
                    authorsList = $('.table-body .author'),
                    //результирующий список
                    searchedList = [];

                //для каждого имени из списка имен
                booksNameList.each(function (index, element) {
                    //имя
                    var text = $(element).text().toLowerCase();

                    //если имя содержит искомое значение
                    if (~text.indexOf(searchedValue)) {
                        //помещаем идентификтор книги в результирующий список
                        searchedList.push($(element).closest('.table-row').attr('data-bookid'));
                    }
                });
                //для каждого автора из списка авторов
                authorsList.each(function (index, element) {
                    //автор
                    var text = $(element).text().toLowerCase(),
                        //идентификатор книги
                        rowId = $(element).closest('.table-row').attr('data-bookid');

                    //если автор содержит искомое значение
                    if (~text.indexOf(searchedValue)) {
                        //если идентификатор соответствующей книги не содержится в результирующем списке
                        if ($.inArray(rowId, searchedList) < 0) {
                            //помещаем идентификатор в результирующий список
                            searchedList.push(rowId);
                        }
                    }
                });

                //скрываем все книги
                $('.table-body .table-row').addClass('hidden');
                //для каждого идентификатора книги из результирующего списка
                $.each(searchedList, function (index, element) {
                    //строка соответсвующая текущему идентификатору
                    var currRow = $('.table-row[data-bookid="' + element + '"]');
                    //если активный статус не "Все книги"
                    if (status !== 'all') {
                        //если статус книги соответсвует активному
                        if (currRow.find('.status_color').attr('data-status') === status) {
                            //отображаем данную строку
                            currRow.removeClass('hidden');
                        }
                        //еслиактивный статус соответствует "все книги"
                    } else {
                        //отображаем данную вне зависимоти от статуса
                        currRow.removeClass('hidden');
                    }
                });
            }
        })
    })
    //при снятии фокуса с поля ввода поиска
        .blur(function () {
            //скрываем данное поле ввода
            $(this).removeClass('show');
        });

    //выбор статуса в диалоге фильтров
    $('.modal-status-btn').on('click', function () {
        $(this).toggleClass('selected');
    });

    //инициализация слайдера рейтинга
    $("#rating-slider-range").slider({
        range: true,
        min: 1,
        max: 10,
        values: [1, 10],
        classes: {
            "ui-slider-handle": "rating-range-slider-handler",
            "ui-slider-range": "selected-range-slider"
        },
        slide: function (event, ui) {
            //запись выбранных значенийв соответствующие атрибуты
            $(this).attr('data-min', ui.values[0]).attr('data-max', ui.values[1]);
        }
    });

    //инициализация слайдера прогресса
    $("#progress-slider-range").slider({
        range: true,
        min: 0,
        max: 100,
        values: [0, 100],
        classes: {
            "ui-slider-handle": "progress-range-slider-handler",
            "ui-slider-range": "selected-range-slider"
        },
        slide: function (event, ui) {
            //запись выбранных значений в соответствующие атрибуты
            $(this).attr('data-min', ui.values[0]).attr('data-max', ui.values[1]);
            //подстановка минимального значения в соответствующее поле ввода
            $('#min-progress').val(ui.values[0]).next('.input-label').addClass('active');
            //подстановка максимального значения в соответствующее поле ввода
            $('#max-progress').val(ui.values[1]).next('.input-label').addClass('active');
        }
    });

    //изменение минимального значения прогресса
    $('#min-progress').on('change', function () {
        //новое минимальное значение прогресса
        var newMin = parseInt($(this).val()),
            //элемент слайдера
            progressSlider = $("#progress-slider-range"),
            //элемент сообщения об ошибки
            errorMessage = $('.error-message');

        //если новое минимальное значение больше максимального
        if (newMin > parseInt(progressSlider.attr('data-max'))) {
            //подсвечиваем поля ввода как невалидные
            progressSlider.siblings('.form-group').addClass('has-danger');
            //отображаем текст ошибки
            errorMessage.text('Значение "От" не должно быть больше значения "До"');
        } else {
            //если новое значение меньше 0 и больше 100
            if (0 > newMin || newMin > 100) {
                //подсвечиваем поле минимума как невалидное
                $(this).closest('.form-group').addClass('has-danger');
                //отображаем текст ошибки
                errorMessage.text('Поле должно находиться в диапазоне от 0 до 100');
            } else {
                //снимаем класс невалидности
                $(this).closest('.form-group').removeClass('has-danger');
                //убираем текст ошибки
                errorMessage.text('');
                //меняем минимальную позицию в слайдере и записываем новое значение в соответствующий атрибут
                progressSlider.slider("values", 0, newMin).attr('data-min', newMin);
            }
        }
        //снимаем фокус с поля ввода
        $(this).blur();
    });

    //изменение максимального значения прогресса
    $('#max-progress').on('change', function () {
        //новое максимальное значение прогресса
        var newMax = parseInt($(this).val()),
            //элемент слайдера
            progressSlider = $("#progress-slider-range"),
            //элемент сообщения об ошибки
            errorMessage = $('.error-message');

        //если новое максимальное значение больше максимального
        if (newMax < parseInt(progressSlider.attr('data-min'))) {
            //подсвечиваем поля ввода как невалидные
            progressSlider.siblings('.form-group').addClass('has-danger');
            //отображаем текст ошибки
            errorMessage.text('Значение поля "От" не должно быть больше значения поля "До"');
        } else {
            //если новое значение меньше 0 и больше 100
            if (0 > newMax || newMax > 100) {
                //подсвечиваем поле максимума как невалидное
                $(this).closest('.form-group').addClass('has-danger');
                //отображаем текст ошибки
                errorMessage.text('Поле должно находиться в диапазоне от 0 до 100');
            } else {
                //снимаем класс невалидности
                $(this).closest('.form-group').removeClass('has-danger');
                //убираем текст ошибки
                errorMessage.text('');
                //меняем максимальную позицию в слайдере и записываем новое значение в соответствующий атрибут
                progressSlider.slider("values", 1, newMax).attr('data-max', newMax);
            }
        }
        //снимаем фокус с поля ввода
        $(this).blur();
    });

    //применение фильтрации
    $('.btn-filter').on('click', function () {
        //слайдер рейтинга
        var ratingSlider = $("#rating-slider-range"),
            //слайдер прогресса
            progressSlider = $("#progress-slider-range"),
            //выбранные для фильтрации статусы
            statusElem = $('.modal-status-btn.selected'),
            //минимальное значение рейтинга
            ratingMin = parseInt(ratingSlider.attr('data-min')),
            //максимальное значение рейтинга
            ratingMax = parseInt(ratingSlider.attr('data-max')),
            //минимальное значение прогресса
            progressMin = parseInt(progressSlider.attr('data-min')),
            //максимальное значение прогресса
            progressMax = parseInt(progressSlider.attr('data-max')),
            //массив значений рейтинга
            rating = [],
            //массив значений прогресса
            progress = [];

        //если граничные значения рейтинга и пргоресса не соответсвуют дефолтным и не выбран ни один статус
        if ((ratingMin == 1 && ratingMax == 10) && (progressMin == 0 && progressMax == 100) && statusElem.length == 0) {
            //удаляем из адресной строки атрибуты
            history.pushState(null, null, location.href.split('?')[0]);
            //устанавливаем таб "все книги" как активный
            $('.book-status[data-tab="all"]').addClass('active');
            //отображаем все строки таблицы
            $('.table-body .table-row').removeClass('hidden');
        } else {
            //формируем массив всех значений рейтинга между выбранными граничными
            for (var i = ratingMin; i <= ratingMax; i++) {
                rating.push(i);
            }
            //формируем массив всех значений прогресса между выбранными граничными
            for (i = progressMin; i <= progressMax; i++) {
                progress.push(i);
            }

            //применяем выбранные фильтры к таблице(возвращаем выбранные статусы)
            status = setFilter(rating, progress, statusElem);

            //записываем выбранные фильтры в атрибуты адресной строки
            setURLParameter({rating: rating, progress: progress, status: status});

            //убираем со всех табов статус активного
            $('.book-status').removeClass('active');
        }

        //скрываем диалог фильтров
        $('#filterForm').modal('hide');
    });

    //сброс фильтров в диалоге в дефолтное состояние
    $('.btn-filter-clear').on('click', function () {
        $('.modal-status-btn').removeClass('selected');
        $("#rating-slider-range").slider("values", [1, 10]).attr('data-min', 1).attr('data-max', 10);
        $("#progress-slider-range").slider("values", [0, 100]).attr('data-min', 0).attr('data-max', 100);
    });

    //формирование диалога фильтров при наличии их в адресной строке
    if (location.search) {
        //рейтинг из адресной строки
        var rating = getURLParameter('rating'),
            //минимальное значение рейтинга
            ratingFirst = rating[0],
            //максимальное значение рейтинга
            ratingLast = rating[rating.length - 1],
            //массив статусов
            status = getURLParameter('status').split(','),
            //массив значений прогресса
            progress = getURLParameter('progress').split(','),
            //минимальное значение прогресса
            progressFirst = progress[0],
            //максимальное значение прогресса
            progressLast = progress[progress.length - 1];

        //делаем выбранными кнопки статусов соответствующие тем, что в адресной строке
        $.each(status, function (index, value) {
            $('.modal-status-btn[data-status="' + value + '"]').addClass('selected');
        });

        //устанавливаем минимальное и максимальное значения в слайдере рейтинга
        $("#rating-slider-range").slider("values", [ratingFirst, ratingLast]).attr('data-min', ratingFirst).attr('data-max', ratingLast);
        //устанавливаем минимальное и максимальное значения в слайдере прогресса
        $("#progress-slider-range").slider("values", [progressFirst, progressLast]).attr('data-min', progressFirst).attr('data-max', progressLast);
        //устанавливаем минимальное значение прогресса в соответствующее поле ввода
        $('#min-progress').val(progressFirst);
        //устанавливаем максимальное значение прогресса в соответствующее поле ввода
        $('#max-progress').val(progressLast);
        //делаем поля ввода активными
        $('.input-label').addClass('active');

        //применяем фильтры в соответсвии с атрибутами в адресной строке
        setFilter(rating.split(','), progress, status)
    }

    $('.show-full-controller > .show').on('click', function () {
        var row = $(this).closest('.mobile-table-row');

        if ($('.mobile-full-info-wrapper.show').length) {
            $('.mobile-full-info-wrapper').collapse('hide');
            $('.show').removeClass('hidden');
            $('.hide').addClass('hidden');
        }

        row.find('.mobile-full-info-wrapper').collapse('show');
        row.removeClass('opacity').siblings().addClass('opacity');
        row.find('.show').toggleClass('hidden');
        row.find('.hide').toggleClass('hidden');
    });

    $('.show-full-controller > .hide').on('click', function () {
        var row = $(this).closest('.mobile-table-row');

        row.find('.mobile-full-info-wrapper').collapse('hide');
        row.siblings().removeClass('opacity');
        row.find('.show').toggleClass('hidden');
        row.find('.hide').toggleClass('hidden');
    });





    /*
    * отображение таблицы в соответсвии с фильтрами
    * @array rating рейтинг
    * @array progress прогресс
    * @object|@array statusElem список элементов статусов
     */
    function setFilter(rating, progress, statusElem) {
        //массив статусов
        var status = [];

        //скрываем все строки таблицы
        $('.table-body .table-row').addClass('hidden');

        //отображаем строки таблицы рейтинг которых входит в диапазон фильтра рейтинга
        $.each(rating, function (index, value) {
            $('.rating-btn[value="' + value + '"]').closest('.table-row').removeClass('hidden');
        });
        //отмечаем среди уже видимых строк таблицы те строки, прогресс которых входит в диапазон фильтра прогресса
        $.each(progress, function (index, value) {
            $('.table-body .table-row:not(.hidden)').find('.book-progress[value="' + value + '%"]')
                .closest('.table-row').addClass('filtered');
        });

        //скрываем те строки, которые не помечены как отфильтрованные
        $('.table-body .table-row:not(.filtered)').addClass('hidden');
        //отображаем отфильтрованные строки и удаляем флаг фильтрации
        $('.table-body .filtered').removeClass('hidden').removeClass('filtered');

        //если список статусов это массив значений
        if ($.isArray(statusElem)) {
            //отмечаем среди уже видимых строк таблицы те строки, статус которых входит в диапазон фильтра статусов
            $.each(statusElem, function (index, value) {
                $('.table-body .table-row:not(.hidden)').find('.status_color[data-status="' + value + '"]')
                    .closest('.table-row').addClass('filtered');
            });
            //скрываем те строки, которые не помечены как отфильтрованные
            $('.table-body .table-row:not(.filtered)').addClass('hidden');
            //отображаем отфильтрованные строки и удаляем флаг фильтрации
            $('.table-body .filtered').removeClass('hidden').removeClass('filtered');
            //если список статусов это список элементов
        } else {
            //если был выбран хоть один статус для фильтрации
            if (statusElem.length) {
                //отмечаем среди уже видимых строк таблицы те строки, статус которых входит в диапазон фильтра статусов
                statusElem.each(function (index, value) {
                    $('.table-body .table-row:not(.hidden)')
                        .find('.status-btn[data-status="' + $(value).attr('data-status') + '"]')
                        .closest('.table-row').addClass('filtered');
                    //помещаем текущий статус в массив статусов
                    status.push($(value).attr('data-status'))
                });
                //скрываем те строки, которые не помечены как отфильтрованные
                $('.table-body .table-row:not(.filtered)').addClass('hidden');
                //отображаем отфильтрованные строки и удаляем флаг фильтрации
                $('.table-body .filtered').removeClass('hidden').removeClass('filtered');
                //возвращаем массив статусов
                return status;
            }
        }

    }

    /*
    * смена прогресса
    * @object input поле ввода прогресса
     */
    function changeProgress(input) {
        //занчение прогресса в формате "количество прочитанных страниц/количество страниц в книге"
        var currValue = input.attr('title'),
            //текущий прогресс в странице
            currProgress = parseInt(currValue.split("/")[0]),
            //количество страниц в книге
            bookPages = parseInt(currValue.split("/")[1]),
            //новое значение прогресса
            newProgress = input.val();

        //если новое значение прогресса - число
        if ($.isNumeric(newProgress)) {
            // и не совпадает со старым прогрессом
            if (parseInt(newProgress) != currProgress) {
                //отправляем соответствующий аякс-запрос с новым значением прогресса
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: input.attr('data-route') + '/changeProgress',
                    data: {'progress': newProgress},
                    type: 'POST'
                })
                //после выполнения аякс-запроса
                    .done(function (data) {
                        //если вернулась ошибка
                        if (data.type === 'danger') {
                            //в поле прогресса устанавливаем старое значение
                            input.val(temporaryPercent);
                            //вывод алерта
                            Alert(data.type, data.message);
                        } else {
                            //строка таблицы в которой меняем статус книги
                            var tableRow = input.closest('.table-row'),
                                //кнопка со старым статусом
                                statusBtn = tableRow.find('.status-btn'),
                                //старый статус
                                oldStatus = statusBtn.attr('data-status'),
                                //новый прогресс в процентах
                                newPercent = Math.round((newProgress / bookPages) * 100) + '%';

                            //записываем новый прогресс в страницах в title
                            input.attr('title', newProgress + '/' + bookPages);
                            input.attr('value', newPercent);
                            //записываем новый прогресс в процентах в значение поля прогресса
                            input.val(newPercent);
                            //записываем новый прогресс в краткую мобильную таблицу
                            $('.mobile-table-row[data-bookid="' + tableRow.attr('data-bookid') + '"]').find('.progress-short').text(newPercent);

                            //если новый прогресс равен 0
                            if (newProgress == 0) {
                                //меняем соответствующей книге статус на "В планах"
                                // changeStatus(statusBtn, tableRow, oldStatus, 'inPlans', 'В планах');
                            }

                            //если новый прогресс равен количеству страниц в книге
                            if (newProgress == bookPages) {
                                //меняем соответствующей книге статус на "Прочитано"
                                // changeStatus(statusBtn, tableRow, oldStatus, 'completed', 'Прочитано');
                            }
                        }
                    });
            }
            //если новый прогресс совпадает со старым
            else {
                //устанавливаем в поле прогресса старое значение
                input.val(temporaryPercent);
            }
            //если новое значение не число
        } else {
            //устанавливаем в поле прогресса старое значение
            input.val(temporaryPercent);
        }

        //снимаем фокус с поля ввода прогресса
        input.addClass('no-focused');
    }

    /*
    * смена статуса
    * @object statusBtn кнопка статуса
    * @object tableRow строка таблицы, в которой меняем статус
    * @string oldStatus старый статус
    * @string newStatus новый статус
    * @string statusName имя нового статуса отображаемое пользователю
     */
    function changeStatus(statusBtn, tableRow, oldStatus, newStatus, statusName) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: statusBtn.closest('.table-row').find('.name > a').attr('href') + '/changeStatus',
            data: {
                'oldStatus': oldStatus,
                'newStatus': newStatus
            },
            type: 'POST'
        })
            .done(function (data) {
                //количество книг с старым статусом
                var booksWithOldStatusCount = $('.status-btn[data-status="' + oldStatus + '"]').length,
                    //количество книг с новым статусом
                    booksWithNewStatusCount = $('.status-btn[data-status="' + newStatus + '"]').length,
                    activeTab = $('.book-status.active');

                //меняем у кнопки статус(цвет) и текст соответсвенно выбранному
                statusBtn.attr('data-status', newStatus).val(statusName);
                //меняем цвет в блоке-индикаторе соответственно новому статусу
                tableRow.find('.status_color').attr('data-status', newStatus);
                //меняем текст статуса в краткой информации в мобильной таблице
                $('.mobile-table-row[data-bookid="' + tableRow.attr('data-bookid') + '"]').find('.status-short').text(statusName);


                //если в момент переключения количество книг со старым статусом на текущей вкладке было более одной
                if (booksWithOldStatusCount > 2 && activeTab.attr('data-tab') !== 'all') {
                    //скрываем строку с которой установили новый статус
                    tableRow.addClass('hidden');
                }

                //если в момент переключения статуса была одна книга со старым статусом
                if (booksWithOldStatusCount === 2) {
                    //скрываем таб остающийся без книг
                    $('.book-status[data-tab="' + oldStatus + '"]').detach().siblings().removeClass('hidden');
                    //если текущий таб не "все книги"
                    if (activeTab.attr('data-tab') !== 'all') {
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
                        newStatusTab.attr('data-tab', newStatus).children('span').text(statusName);
                        //добавляем блок нового таба
                        $('.book-status-container').append(newStatusTab);
                    }
                }
            })
    }

    /*
    * сортировка строк таблицы
    * @string field имя столбца, по которому осуществляется сортировка
    * @string order направление сортировки
     */
    function sort(field, order) {
        //строки таблицы
        var sortingTable = $('.table-body .table-row');

        //поиск соответсвия имени столбца одному из вариантов
        switch (field) {
            //если сортировка по имени
            case 'name':
                //сортируем строки таблицы по имени по алфавиту
                sortingTable.sort(function (firstRow, secondRow) {
                    var value1 = $(firstRow).find('.name a').text(),
                        value2 = $(secondRow).find('.name a').text();

                    //взависимости от направления возвращаем таблицу в необходимом порядке
                    if (order === 'desc') {
                        return value2.localeCompare(value1)
                    } else {
                        return value1.localeCompare(value2)
                    }
                });
                break;

            //если сортировка по статусу
            case 'status':
                //сортируем строки таблицы по статусу по алфавиту
                sortingTable.sort(function (firstRow, secondRow) {
                    var value1 = $(firstRow).find('.status-btn').val(),
                        value2 = $(secondRow).find('.status-btn').val();

                    //взависимости от направления возвращаем таблицу в необходимом порядке
                    if (order === 'desc') {
                        return value2.localeCompare(value1)
                    } else {
                        return value1.localeCompare(value2)
                    }
                });
                break;

            //если сортировка по рейтингу
            case 'rating':
                //сортируем строки таблицы по рейтингу
                sortingTable.sort(function (firstRow, secondRow) {
                    var value1 = parseInt($(firstRow).find('.rating-btn').val()),
                        value2 = parseInt($(secondRow).find('.rating-btn').val());

                    //взависимости от направления возвращаем таблицу в необходимом порядке
                    if (order === 'desc') {
                        return (value1 < value2) ? 1 : (value1 > value2) ? -1 : 0
                    } else {
                        return (value1 > value2) ? 1 : (value1 < value2) ? -1 : 0
                    }
                });
                break;

            //если сортировка по авторам
            case 'authors':
                //сортируем строки таблицы по авторам по алфавиту
                sortingTable.sort(function (firstRow, secondRow) {
                    var value1 = $(firstRow).find('.author-link-wrapper a').text(),
                        value2 = $(secondRow).find('.author-link-wrapper a').text();

                    //взависимости от направления возвращаем таблицу в необходимом порядке
                    if (order === 'desc') {
                        return value2.localeCompare(value1)
                    } else {
                        return value1.localeCompare(value2)
                    }
                });
                break;

            //если сортировка по прогрессу
            case 'pages':
                //сортируем строки таблицы по прогрессу
                sortingTable.sort(function (firstRow, secondRow) {
                    var value1 = parseInt($(firstRow).find('.book-progress').attr('title').split("%")[0]),
                        value2 = parseInt($(secondRow).find('.book-progress').attr('title').split("%")[0]);

                    //взависимости от направления возвращаем таблицу в необходимом порядке
                    if (order === 'desc') {
                        return (value1 < value2) ? 1 : (value1 > value2) ? -1 : 0
                    } else {
                        return (value1 > value2) ? 1 : (value1 < value2) ? -1 : 0
                    }
                });
                break;
        }

        //меняем порядковые номера строк таблицы с учетом новой сортировки
        sortingTable.each(function (key, value) {
            $(value).find('.number-wrapper > span:last').text(++key);
        });

        //возвращаем отсортированную страницу
        return sortingTable;
    }

    /*
    * функция получения параметров из адресной строки
    * @string name искомый отрибут в адресной строке
     */
    function getURLParameter(name) {
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

    /*
    * запись параметров в адресную строку
    * @object param объект с параметрами
     */
    function setURLParameter(param) {
        //строка записываемая в адресную строку
        var paramStr = '',
            //url без параметров
            href = location.href.split('?')[0];

        //если переданный параметр объект
        if ($.isPlainObject(param)) {
            //для каждого параметра в объекте
            $.each(param, function (name, value) {
                //если строка еще пустая
                if (paramStr.length == 0) {
                    //записываем новый параметр и его значение
                    paramStr += (name + '=' + value)
                    //если не пустая
                } else {
                    //дописываем параметр и егозанчение через амперсанд
                    paramStr += ('&' + name + '=' + value)
                }
            });

            //записываем в адресную строку новый урл с параметрами
            history.pushState(null, null, href + '?' + paramStr);
            //если не объект, то бросаем исключение
        } else {
            throw new TypeError("Передаваемый параметр должен быть объектом");
        }
    }

})(jQuery);