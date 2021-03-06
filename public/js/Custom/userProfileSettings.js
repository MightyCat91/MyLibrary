(function ($) {
    //элемент body
    var body = $("body");
    //форма смены email и пароля
    var emailPassForm = $('#edit-email-pass-form');
    //кнопка сабмита формы смены email и пароля
    var changeBtn = $('.saveEmailPass');
    //контейнер модального окна
    var modalDialog = $("#changeEmailPass");

    //переключение toggle-кнопки "Пол"
    $('.btn-switch-label').on('click', function () {
        $(this).addClass('active').children('options').prop("checked", true);
        $(this).siblings('label').removeClass('active').children('options').prop("checked", false);
    });

    //сабмит формы смены email и пароля
    emailPassForm.on('submit', function (e) {
        e.preventDefault();
        //удаление с формы результатов предыдущей неуспешной валидации
        clearValidateErrors();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: emailPassForm.attr("action"),
            data: new FormData(emailPassForm[0]),
            processData: false,
            contentType: false,
            type: 'POST',
            //анимация кнопки в момент отправки аякс-запроса
            beforeSend: function () {
                changeBtn.addClass('saving').children('.dflt-text').addClass('hidden').nextAll('.load-text')
                    .removeClass('hidden');
            }
        })
            .done(function (data) {
                //скрытие анимации кнопки
                changeBtn.removeClass('saving').children('.dflt-text').removeClass('hidden').nextAll('.load-text')
                    .addClass('hidden');
                //скрытие модального окна
                modalDialog.modal('hide');
                //вывод алерта
                Alert('success', 'Изменения сохранены.');
            })
            .fail(function (response) {
                var errors, input, key;
                //вывод ошибок валидации для каждого невалидного поля
                for (key in response.responseJSON.errors) {
                    //селектор невалидного поля
                    input = $('#' + key);
                    //установка стилей невалидного значения
                    input.parent().addClass('has-danger');
                    //получение текста ошибок
                    errors = response.responseJSON.errors[key];

                    //вывод всех ошибок
                    $.each(errors, function (index, error) {
                        input.nextAll('.form-control-feedback').text(error);
                    });
                }
                //скрытие анимации кнопки
                changeBtn.removeClass('saving').children('.dflt-text').removeClass('hidden')
                    .nextAll('.load-text').addClass('hidden');
            });
    });

    //очистка полей ввода формы в момент ее закрытия
    modalDialog.on('hide.bs.modal', function () {
        clearValidateErrors();
        $(this).find('.form-control[name != email]').val('').next('.input-label').removeClass('active');

    });

    //смена аватара пользователя
    $('#imageInput').on('change', function () {
        var updateBtn = $('.update-btn');
        updateProfileImg(false, updateBtn.data('url'), updateBtn.val());
    });

    //удаление ранее загруженного аватара пользователя
    $('.delete-btn').on('click', function () {
        if (!$(this).hasClass('forbidden')) {
            updateProfileImg(true, $(this).data('url'));
            $(this).addClass('forbidden');
        }
    });

    function updateProfileImg(needDelete, url, imgFile) {
        var options = {needDelete: needDelete};
        if (imgFile) {
            options['imageInput'] = imgFile;
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            data: new FormData($("#edit-form")[0]),
            processData: false,
            contentType: false,
            type: 'POST'
        })
            .done(function (response) {
                var src = response + "?" + (new Date()).getTime();
                $('#user-profile-img-change-wrapper').find('img').prop('src', src);
                $('#user-profile-img-wrapper').find('img').prop('src', src);
                $('.delete-btn').removeClass('forbidden');
            })
            .fail(function (response) {
                //получаем все ошибки для первого невалидного файла
                for (var key in response.responseJSON);
                var errors = response.responseJSON[key];
                $.each(errors, function (index, fileWithError) {
                    $.each(fileWithError, function (index, error) {
                        //вывод алерта
                        Alert('danger', error, 0);
                    });
                });
            });
    }

    //удаление с формы результатов предыдущей неуспешной валидации
    function clearValidateErrors() {
        $('.form-control-feedback').text('');
        $('.form-group').removeClass('has-danger');
    }

})(jQuery);
