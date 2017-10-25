(function ($) {
    var progressIsChanged = false,
        temporaryPercent = null;

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
            //устанавливаем 100% прогресса и макс. количество прочитанных страниц
            progressField.val('100%').attr('title', pages + '/' + pages)
        }
        //если статус = "в планах"
        if (newStatus === 'inPlans') {
            //устанавливаем 0% прогресса и 0 прочитанных страниц
            progressField.val('0%').attr('title', '0/' + pages)
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
            //todo: не скрывается по клику по другим контролам
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
        //отображение всех авторов
        .on('click', '.other-authors-controller', function () {
            $(this).prev('.author-link-wrapper').toggleClass('line-height-1-5');
            $(this).find('.fa-arrow-circle-o-down').toggleClass('hidden').siblings('.fa-arrow-circle-o-up').toggleClass('hidden');
            $(this).next('.other-author-wrapper').toggleClass('hidden');
        });

    $('.rating-btn').on('focus', function () {
        var ratingField = $(this),
            oldRating = ratingField.val();

        ratingField.select();
        ratingField.removeClass('no-focused')
            .autocomplete({
                source: ratingField.next().find('option').toArray(),
                minLength: 0,
                delay: 500,
                classes: {'ui-autocomplete': 'input-autocomplete'},
                open: function () {
                    ratingField.keypress(function (event) {
                        var keycode = (event.keyCode ? event.keyCode : event.which);
                        if (keycode === 13) {
                            ratingField.blur();
                        }
                    })
                },
                select: function (event, ui) {
                    ratingField.val(ui.item.innerHTML).blur();
                }
            }).autocomplete('search', '')
            .blur(function () {
                var newRating = ratingField.val();

                if ($.isNumeric(newRating)) {
                    if (parseInt(oldRating) !== newRating) {
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
                                'type': 'book',
                                'id': ratingField.closest('.table-row').attr('data-bookid')
                            },
                            type: 'POST'
                        })
                            .done(function (data) {
                                if (data.error) {
                                    ratingField.val(oldRating);
                                    //добавление ответа сервера(алерт)
                                    $('body').append(data.alert);
                                }
                            });
                    } else {
                        ratingField.val(oldRating);
                    }
                } else {
                    ratingField.val(newRating);
                }
                ratingField.addClass('no-focused');
            });
    });

    $('.book-progress').on('focus', function () {
        var input = $(this),
            currPercent = input.val(),
            currValue = input.attr('title'),
            currProgress = parseInt(currValue.split("/")[0]);

        temporaryPercent = currPercent;
        input.removeClass('no-focused').val(currProgress).select()
            .keydown(function (event) {
                event.stopImmediatePropagation();
                var keycode = (event.keyCode ? event.keyCode : event.which);
                if (keycode === 13) {
                    progressIsChanged = true;
                    changeProgress($(this));
                    input.blur();
                    return false;
                }
            })
    })
        .on('blur', function () {
            if (!progressIsChanged) {
                changeProgress($(this));
            }
            progressIsChanged = false;
        });

    $('th.can-sort').on('click', function () {
        var newSortControl = $(this).children('.sort-controls.hidden'),
            order = newSortControl.attr('data-order'),
            field = $(this).attr('class').split(' ')[1];

        $(this).siblings().children('.sort-controls').addClass('hidden');
        if (newSortControl.length < 2) {
            newSortControl.removeClass('hidden').siblings('.sort-controls').addClass('hidden');
            order = newSortControl.attr('data-order')
        } else {
            $(this).children('.sort-controls:last').removeClass('hidden');
            order = $(this).children('.sort-controls:last').attr('data-order')
        }
        $('.table-body tbody').html(sort(field, order));
    });

    function changeProgress(input) {
        var currValue = input.attr('title'),
            currProgress = parseInt(currValue.split("/")[0]),
            bookPages = parseInt(currValue.split("/")[1]),
            newProgress = input.val();

        if ($.isNumeric(newProgress)) {
            if (parseInt(newProgress) != currProgress) {
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
                    .done(function (data) {
                        if (data.error) {
                            input.val(temporaryPercent);
                            //добавление ответа сервера(алерт)
                            $('body').append(data.alert);
                        } else {
                            //строка таблицы в которой меняем статус книги
                            var tableRow = input.closest('.table-row'),
                                //кнопка со старым статусом
                                statusBtn = tableRow.find('.status-btn'),
                                //старый статус
                                oldStatus = statusBtn.attr('data-status');

                            input.attr('title', newProgress + '/' + bookPages);
                            input.val(Math.round((newProgress / bookPages) * 100) + '%');

                            if (newProgress == 0) {
                                changeStatus(statusBtn, tableRow, oldStatus, 'inPlans', 'В планах');
                            }

                            if (newProgress == bookPages) {
                                changeStatus(statusBtn, tableRow, oldStatus, 'completed', 'Прочитано');
                            }
                        }
                    });
            }
            else {
                input.val(temporaryPercent);
            }
        } else {
            input.val(temporaryPercent);
        }

        input.addClass('no-focused');
    }

    $('.fa-search').on('click', function () {
        $(this).prev().children().toggleClass('show');
    });

    $('.search-field').on('focus', function () {
        $(this).keydown(function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which),
                status = $('.book-status.active').attr('data-tab');
            if (keycode === 13) {
                var searchedValue = $(this).val().toLowerCase(),
                    booksNameList = $('tbody .name a'),
                    authorsList = $('tbody .author'),
                    searchedList = [];

                booksNameList.each(function (index, element) {
                    var text = $(element).text().toLowerCase();

                    if (~text.indexOf(searchedValue)) {
                        searchedList.push($(element).closest('.table-row').attr('data-bookid'));
                    }
                });
                authorsList.each(function (index, element) {
                    var text = $(element).text().toLowerCase(),
                        rowId = $(element).closest('.table-row').attr('data-bookid');
                    if (~text.indexOf(searchedValue)) {
                        if ($.inArray(rowId, searchedList) < 0) {
                            searchedList.push(rowId);
                        }
                    }
                });

                $('tbody .table-row').addClass('hidden');
                $.each(searchedList, function (index, element) {
                    var currRow = $('.table-row[data-bookid="' + element + '"]');
                    if (status !== 'all') {
                        if (currRow.find('.status_color').attr('data-status') === status) {
                            currRow.removeClass('hidden');
                        }
                    } else {
                        currRow.removeClass('hidden');
                    }
                });
            }
        })
    })
        .blur(function () {
            $(this).removeClass('show');
        });

    $('.modal-status-btn').on('click', function () {
        $(this).toggleClass('selected');
    });

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
            $(this).attr('data-min', ui.values[0]).attr('data-max', ui.values[1]);
        }
    });

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
            $(this).attr('data-min', ui.values[0]).attr('data-max', ui.values[1]);
            $('#min-progress').val(ui.values[0]).next('.input-label').addClass('active');
            $('#max-progress').val(ui.values[1]).next('.input-label').addClass('active');
        }
    });

    $('#min-progress').on('change', function () {
        var newMin = parseInt($(this).val()),
            progressSlider = $("#progress-slider-range"),
            errorMessage = $('.error-message');

        if (newMin > parseInt(progressSlider.attr('data-max'))) {
            progressSlider.siblings('.form-group').addClass('has-danger');
            errorMessage.text('Значение "От" не должно быть больше значения "До"');
        } else {
            if (0 > newMin || newMin > 100) {
                $(this).closest('.form-group').addClass('has-danger');
                errorMessage.text('Поле должно находиться в диапазоне от 0 до 100');
            } else {
                $(this).closest('.form-group').removeClass('has-danger');
                errorMessage.text('');
                progressSlider.slider("values", 0, newMin).attr('data-min', newMin);
            }
        }
        $(this).blur();
    });

    $('#max-progress').on('change', function () {
        var newMax = parseInt($(this).val()),
            progressSlider = $("#progress-slider-range"),
            errorMessage = $('.error-message');

        if (newMax < parseInt(progressSlider.attr('data-min'))) {
            progressSlider.siblings('.form-group').addClass('has-danger');
            errorMessage.text('Значение поля "От" не должно быть больше значения поля "До"');
        } else {
            if (0 > newMax || newMax > 100) {
                $(this).closest('.form-group').addClass('has-danger');
                errorMessage.text('Поле должно находиться в диапазоне от 0 до 100');
            } else {
                $(this).closest('.form-group').removeClass('has-danger');
                errorMessage.text('');
                progressSlider.slider("values", 1, newMax).attr('data-max', newMax);
            }
        }
        $(this).blur();
    });

    $('.btn-filter').on('click', function () {
        var ratingSlider = $("#rating-slider-range"),
            progressSlider = $("#progress-slider-range"),
            rating = [],
            progress = [],
            status = $('.modal-status-btn.selected');

        for(var i = parseInt(ratingSlider.attr('data-min')); i <= parseInt(ratingSlider.attr('data-max')); i++) {
            rating.push(i);
        }

        for(i = parseInt(progressSlider.attr('data-min')); i <= parseInt(progressSlider.attr('data-max')); i++) {
            progress.push(i);
        }

        $('tbody .table-row').addClass('hidden');

        $.each(rating, function (index, value) {
            $('.rating-btn[value="' + value + '"]').closest('.table-row').removeClass('hidden');
        });
        $.each(progress, function (index, value) {
            $('tbody .table-row:not(.hidden)').find('.book-progress[value="' + value + '%"]').closest('.table-row').addClass('filtered');
        });
        $('tbody .table-row:not(.filtered)').addClass('hidden');
        $('tbody .filtered').removeClass('filtered');

        if (status.length) {
            status.each(function (index, value) {
                $('tbody .table-row:not(.hidden)').find('.status-btn[data-status="' + $(value).attr('data-status') + '"]').closest('.table-row').addClass('filtered');
            });
            $('tbody .table-row:not(.filtered)').addClass('hidden');
            $('tbody .filtered').removeClass('filtered');
        }

        $('#filterForm').modal('hide');
    });



    function changeStatus(statusBtn, tableRow, oldStatus, newStatus, statusName) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: statusBtn.parent('.table-column').prev('.name.value').find('a').attr('href') + '/changeStatus',
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


                //если в момент переключения количество книг со старым статусом на текущей вкладке было более одной
                if (booksWithOldStatusCount > 1 && activeTab.attr('data-tab') !== 'all') {
                    //скрываем строку с которой установили новый статус
                    tableRow.addClass('hidden');
                }

                //если в момент переключения статуса была одна книга со старым статусом
                if (booksWithOldStatusCount === 1) {
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

    function sort(field, order) {
        var sortingTable = $('tbody .table-row');

        switch (field) {
            case 'name':
                sortingTable.sort(function (firstRow, secondRow) {
                    var value1 = $(firstRow).find('.name a').text(),
                        value2 = $(secondRow).find('.name a').text();

                    if (order === 'desc') {
                        return value2.localeCompare(value1)
                    } else {
                        return value1.localeCompare(value2)
                    }
                });
                break;

            case 'status':
                sortingTable.sort(function (firstRow, secondRow) {
                    var value1 = $(firstRow).find('.status-btn').val(),
                        value2 = $(secondRow).find('.status-btn').val();

                    if (order === 'desc') {
                        return value2.localeCompare(value1)
                    } else {
                        return value1.localeCompare(value2)
                    }
                });
                break;

            case 'rating':
                sortingTable.sort(function (firstRow, secondRow) {
                    var value1 = parseInt($(firstRow).find('.rating-btn').val()),
                        value2 = parseInt($(secondRow).find('.rating-btn').val());

                    if (order === 'desc') {
                        return (value1 < value2) ? 1 : (value1 > value2) ? -1 : 0
                    } else {
                        return (value1 > value2) ? 1 : (value1 < value2) ? -1 : 0
                    }
                });
                break;

            case 'authors':
                sortingTable.sort(function (firstRow, secondRow) {
                    var value1 = $(firstRow).find('.author-link-wrapper a').text(),
                        value2 = $(secondRow).find('.author-link-wrapper a').text();

                    if (order === 'desc') {
                        return value2.localeCompare(value1)
                    } else {
                        return value1.localeCompare(value2)
                    }
                });
                break;

            case 'pages':
                sortingTable.sort(function (firstRow, secondRow) {
                    var value1 = parseInt($(firstRow).find('.book-progress').attr('title').split("%")[0]),
                        value2 = parseInt($(secondRow).find('.book-progress').attr('title').split("%")[0]);

                    if (order === 'desc') {
                        return (value1 < value2) ? 1 : (value1 > value2) ? -1 : 0
                    } else {
                        return (value1 > value2) ? 1 : (value1 < value2) ? -1 : 0
                    }
                });
                break;
        }

        sortingTable.each(function (key, value) {
            $(value).find('.number-wrapper > span:last').text(++key);
        });

        return sortingTable;
    }

})(jQuery);