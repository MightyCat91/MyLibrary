(function ($) {
    //элемент body
    var body = $("body");
    var emailPassForm = $('#edit-email-pass-form');
    var changeBtn = $('.saveEmailPass');
    var modalDialog = $("#changeEmailPass");

    $('.btn-switch-label').on('click', function () {
        $(this).addClass('active').children('options').prop("checked", true);
        $(this).siblings('label').removeClass('active').children('options').prop("checked", false);
    });

    changeBtn.on('click', function (e) {
        e.preventDefault();
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
            async: true,
            type: 'POST',
            //отображение спиннера
            beforeSend: function () {
                changeBtn.addClass('saving').children('.dflt-text').addClass('hidden').nextAll('.load-text')
                    .removeClass('hidden');
            }
        })
            .done(function (data) {
                changeBtn.removeClass('saving').children('.dflt-text').removeClass('hidden').nextAll('.load-text')
                    .addClass('hidden');
                modalDialog.modal('hide');
                //сделать по красоте плюс возможно добавить проверку на отправку аякса при неизменности данных(возм
                // валидацией отопнуть)
                console.log(data);
                body.append('<div id="test"></div>');
                $('#test').html(data);
            })
            .fail(function (response) {
                var errors, input, key;
                for (key in response.responseJSON) {
                    input = $('#' + key);
                    input.parent().addClass('has-danger');
                    errors = response.responseJSON[key];
                    $.each(errors, function (index, error) {
                        input.nextAll('.form-control-feedback').text(error);
                    });
                }
                changeBtn.removeClass('saving').children('.dflt-text').removeClass('hidden')
                    .nextAll('.load-text').addClass('hidden');
            });
    });

    modalDialog.on('hide.bs.modal', function ()
    {
        clearValidateErrors();
        $(this).find('.form-control[name != email]').val('').next('.input-label').removeClass('active');

    });

    function clearValidateErrors() {
        $('.form-control-feedback').text('');
        $('.form-group').removeClass('has-danger');
    }
})(jQuery);
