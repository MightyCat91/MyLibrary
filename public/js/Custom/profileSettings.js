(function ($) {
    //элемент body
    var body = $("body");

    $('.btn-switch-label').on('click', function () {
        $(this).addClass('active').children('options').prop("checked", true);
        $(this).siblings('label').removeClass('active').children('options').prop("checked", false);
    });

    $('.saveEmailPass').on('click', function () {
        clearValidateErrors();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: 'saveEmailPass',
            data: new FormData($("#edit-email-pass-form")[0]),
            processData: false,
            contentType: false,
            type: 'POST',
            //отображение спиннера
            beforeSend: function () {
                //TODO: заменить спинер на анимацию в кнопке
                //$('.page-content').addClass('spinner');
            }
        })
            .done(function (data) {
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
                //$('.page-content').removeClass('spinner');
            });
    });

    $('#openDialog').on('click', function () {
        clearValidateErrors();
    });

    function clearValidateErrors() {
        $('.form-control-feedback').text('');
        $('.form-group').removeClass('has-danger');
        $('.modal-body label[for!=email]').removeClass('active');
    }
})(jQuery);
