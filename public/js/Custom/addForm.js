(function ($) {
    //элемент body
    var body = $("body");

    // аякс-загрузка изображений
    $('#imageInput').change(function () {
        //контейнер для отображения превью и ошибок валидации
        var imgWrapper = $('#img-name');
        //превью с ссылкой на файл
        var imgLink = $('.img-link');
        //ошибки валидации загруженных файлов
        var fileError = $('.file-errors');
        //изображение для вставки в поповер-превью
        var imgPreview = $('.img-preview');
        //если файлы выбраны, то происходит загрузка
        if ($(this).val()) {
            //добвление в форму csrf-токена
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'add/ajaxImg',
                data: new FormData($("#add-form")[0]),
                processData: false,
                contentType: false,
                type: 'POST',
                //отображение спиннера, очистка ошибок, скрытие превью
                beforeSend: function () {
                    $('.page-content').addClass('spinner');
                    fileError.html('');
                    imgLink.addClass('hidden');
                }
            })
                .done(function (data) {
                    //если ответ = массив(несколько файлов), удаляются ссылки-превью и изображения для него
                    if (typeof data != 'string') {
                        imgLink.remove();
                        imgPreview.remove();
                        //каждый урл в массиве
                        $.each(data, function (key, value) {
                            //добавляем урл сслыке в последнем превью
                            var lastImg = imgLink.last();
                            lastImg.children().attr('href', value);
                            //клонируем последний превью, добавляем в контейнер для превью и делаем видимым
                            lastImg.clone().appendTo(imgWrapper).removeClass('hidden');
                            //добавляем урл последнему изображению для поповера и добавляем его в контейнер фалов
                            imgPreview.last().attr('src', value).clone().appendTo('.file-upload-group');
                        });
                    }
                    //если ответ строка(один файл)
                    else {
                        //добавляем урл сслыке в превью и делаем само превью видимым
                        imgLink.children().attr('href', data).parent().removeClass('hidden');
                        //добавляем урл изображению для поповера
                        imgPreview.attr('src', data);
                    }
                    //скрываем спинер и инициализируем поповер содержащий изображение для него
                    $('.page-content').removeClass('spinner');
                    $('.preview-link').popover({
                        'placement': 'top',
                        'content': function () {
                            return $('.img-preview[src="' + $(this).attr('href') + '"]').clone()
                                .removeClass('hidden').css('height', 'auto');
                        },
                        'html': true,
                        delay: {"show": 300, "hide": 100},
                        trigger: 'hover'
                    });
                })
                .fail(function (response) {
                    console.log(response);
                    //получаем все ошибки для первого невалидного файла
                    for (var key in response.responseJSON) break;
                    var errors = response.responseJSON[key];
                    //выводим каждую полученную ошибку для файла в в соответствуюзий контейнер
                    $.each(errors, function (index, error) {
                        fileError.append($("<p></p>").text(error));
                    });
                    //скрываем и удаляем поповер
                    imgWrapper.popover('dispose');
                    //отображаем контейнер с ошибками и скрываем спинер
                    fileError.removeClass('hidden');
                    $('.file-upload-group').addClass('has-danger');
                    $('.page-content').removeClass('spinner');
                })
        }
    });

    // Добавление на форму поля ввода при нажатии на "плюс"
    body.on('click', '.append-form-add-input', function () {
        //общий контейнер с полями ввода
        var container = $(this).closest('.multiple-input-add-container');
        //последний контейнер с полем ввода, кнопкой добавления и кнопкой удаления
        var inputContainer = container.children().last();
        //поле ввода в контейнере
        var input = inputContainer.find('.form-add-input');
        //идентификатор типа контейнера
        var id = container.attr('id');
        //иконка удаления поля ввода
        var closeIcon = inputContainer.find('.input-close');
        switch (id) {
            case 'categories':
                /*
                 клонирутся контейнер с полем ввода и кнопками, у клона очищается значение в инпуте, вставляется в конец
                 контейнера соответствующего типа, удаляется кнопка добавления из клонируемого контейнера
                 */
                inputContainer.clone().appendTo('#' + id).children().val('').next().removeClass('active');
                $(this).remove();
                closeIcon.removeClass('hidden');
                break;
            case 'series':
                /*
                 клонирутся контейнер с полем ввода и кнопками, у клона очищается значение в инпуте, вставляется в конец
                 контейнера соответствующего типа, удаляется кнопка добавления из клонируемого контейнера
                 */
                inputContainer.clone().appendTo('#' + id).children().val('').next().removeClass('active');
                $(this).remove();
                closeIcon.removeClass('hidden');
                break;
            case 'authors':
                //проверка наличия значения клонируемого поля ввода
                if (!input.val()) {
                    //отображение тултипа с предупреждением невозможности клонирования пустого поля ввода
                    $(this).addClass('danger-icon').attr({
                        'title': 'Поле не может быть пустым',
                        'data-toggle': 'tooltip'
                    }).tooltip('show')
                        .mouseleave(function () {
                            $(this).removeClass('danger-icon');
                        });
                }
                else {
                    /*
                     клонирутся контейнер с полем ввода и кнопками, у клона очищается значение в
                     инпуте, вставляется в конец контейнера соответствующего типа, удаляется кнопка добавления из
                     клонируемого контейнера
                     */
                    inputContainer.clone().appendTo('#' + id).children().val('').next().removeClass('active');
                    $(this).tooltip('dispose').remove();
                    closeIcon.removeClass('hidden');
                }
                break;
            case 'publishers':
                /*
                 клонирутся контейнер с полем ввода и кнопками, у клона очищается значение в инпуте, вставляется в конец
                 контейнера соответствующего типа, удаляется кнопка добавления из клонируемого контейнера
                 */
                inputContainer.clone().appendTo('#' + id).children().val('').next().removeClass('active');
                $(this).remove();
                closeIcon.removeClass('hidden');
                break;
        }
    });

    function customAutocomplete(elem, source) {
        //отображение списка значений при клике на пустой инпут
        $(elem).autocomplete({
            source: $(source).children().toArray(),
            minLength: 0,
            delay: 500,
            classes: {'ui-autocomplete': 'input-autocomplete'},
            //удаление автокомплита
            close: function () {
                $(this).autocomplete('destroy');
            }
        })
            .on('focus', function () {
                $(this).autocomplete('search', '');
            });
    }

    //отображение автокомплита полей автор, жанр, издательство при фокусе на поле
    body.on("focus", ".author-input", function () {
        customAutocomplete(this, '#author-list');
    })
        .on("focus", ".category-input", function () {
            customAutocomplete(this, '#category-list');
        })
        .on("focus", ".publisher-input", function () {
            customAutocomplete(this, '#publisher-list');
        })
        .on("focus", ".series-input", function () {
            customAutocomplete(this, '#series-list');
        });

    //удаление контейнера содержащего кнопку по которой был совершен клик
    body.on('click', '.input-close', function () {
        $(this).parent().remove();
    });

    //анимация лейбла при фокусе на поле ввода
    body.on('focus', '.form-control', function () {
        $(this).next('label').addClass('active');
    });

    //удаление анимации при удалении фокуса с поля ввода
    body.on('focusout', '.form-control', function () {
        if (!$(this).val()) {
            $(this).next('label').removeClass('active');
        }
    });

})(jQuery);