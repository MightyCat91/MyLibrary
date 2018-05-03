(function ($) {
    //элемент body
    var body = $("body");

    // аякс-загрузка изображений
    $('#imageInput').on('change', function () {
        //если файлы выбраны, то происходит загрузка
        if ($(this).val()) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'add/addImg',
                data: new FormData($("#add-form")[0]),
                processData: false,
                contentType: false,
                type: 'POST'
            })
                .done(function (data) {
                    $(".book-img").addClass("hidden");
                    //если ответ = массив(несколько файлов), удаляются ссылки-превью и изображения для него
                    if (typeof data !== 'string') {
                        var owl = $('.owl-carousel');
                        //каждый урл в массиве
                        $.each(data, function (key, value) {
                            $('#add-img-wrapper').append("<img class='new-book-imgs' src='" + value + "'>");
                        });
                        owl.owlCarousel({
                            dots: false,
                            navContainerClass: "owl-nav",
                            rewind: true,
                            items: 1
                        });
                        $('.owl-nav').removeClass("hidden");
                    } else {
                        $('#add-img-wrapper').append("<img class='new-book-imgs' src='" + data + "'>");
                    }
                    $(".img-delete-btn").removeClass('hidden');
                    $(".update-btn label").addClass('hidden');
                })
                .fail(function (response) {
                    //получаем все ошибки для первого невалидного файла
                    for (var key in response.responseJSON) ;
                    var errors = response.responseJSON[key];
                    $.each(errors, function (index, fileWithError) {
                        $.each(fileWithError, function (index, error) {
                            //вывод алерта
                            Alert('danger', error, 0);
                        });
                    });
                });
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
        })
        //удаление контейнера содержащего кнопку по которой был совершен клик
        .on('click', '.close-btn', function () {
            $(this).parent().remove();
        })
        // Добавление на форму поля ввода при нажатии на "плюс"
        .on('click', '.append-form-add-input', function () {
            //общий контейнер с полями ввода
            var container = $(this).closest('.multiple-input-add-container');
            //последний контейнер с полем ввода, кнопкой добавления и кнопкой удаления
            var inputContainer = container.children().last();
            //поле ввода в контейнере
            var input = inputContainer.find('.form-add-input');
            //идентификатор типа контейнера
            var id = container.attr('id');
            //иконка удаления поля ввода
            var closeIcon = inputContainer.find('.close-btn');
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
        })
        .on('click', '.img-delete-btn', function () {
            var itsBookPage = $(".owl-item.active").length;
            var deletedImgName = (itsBookPage ? $(".owl-item.active .new-book-imgs").attr('src') : $(".new-book-imgs").attr('src')).split('/').pop();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'add/deleteImg',
                data: {'imageName': deletedImgName},
                type: 'POST'
            })
                .done(function () {
                    if (itsBookPage) {
                        if ($(".owl-item").length > 1) {
                            $('.owl-carousel').owlCarousel().trigger('remove.owl.carousel',[$(".owl-item.active").index()]).trigger('refresh.owl.carousel');
                        } else {
                            $('.owl-carousel').owlCarousel().trigger('remove.owl.carousel',[$(".owl-item.active").index()]).trigger('destroy.owl.carousel').html('');
                            $(".owl-nav").addClass('hidden');
                            $(".img-delete-btn").addClass('hidden');
                            $(".update-btn label").removeClass('hidden');
                            $(".book-img").removeClass("hidden");
                            $(".img-add-btn input").val('');
                        }
                    } else {
                        $(".img-delete-btn").addClass('hidden');
                        $(".update-btn label").removeClass('hidden');
                        $(".book-img").removeClass("hidden");
                        $('#add-img-wrapper').html('');
                        $(".img-add-btn input").val('');
                    }
                });
        });

    $('.owl-next').click(function () {
        $('.owl-carousel').trigger('next.owl.carousel');
    });
    $('.owl-prev').click(function () {
        $('.owl-carousel').trigger('prev.owl.carousel');
    })
})(jQuery);