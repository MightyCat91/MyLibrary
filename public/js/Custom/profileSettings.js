(function ($) {
    //элемент body
    var body = $("body");

    $('.btn-switch-label').on('click', function () {
        $(this).addClass('active').children('options').prop("checked", true);
        $(this).siblings('label').removeClass('active').children('options').prop("checked", false);
    });

    $('.saveEmailPass').on('click', function () {
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
                $('.page-content').addClass('spinner');
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
                        input.after("<div class='form-control-feedback'>" + error + "</div>");
                    });
                }
                $('.page-content').removeClass('spinner');
            });
    });

    $('#openDialog').on('click', function () {
        $('.form-control-feedback').remove();
        $('.form-group').removeClass('has-danger');
        //$('.form-group > input[name != email]').removeClass('active');
    })
})(jQuery);
