(function ($) {
    //элемент body
    var body = $("body");

    $('.btn-switch-label').on('click', function () {
        $(this).addClass('active').children('options').prop("checked", true);
        $(this).siblings('label').removeClass('active').children('options').prop("checked", false);
    });

    $('.saveEmailPass').on('click', function (e) {
        var emailPassForm = $('#edit-email-pass-form');

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
            type: 'POST',
            //отображение спиннера
            beforeSend: function () {
                $('.saveEmailPass').addClass('saving').children('.dflt-text').addClass('hidden').nextAll('.load-text')
                    .removeClass('hidden');
                emailPassForm.find(".form-control").map(function(indx, element){
                    var input = $(element);
                    if (input.val()) {
                        console.log(input.attr('id'));
                        input.next('.input-label').addClass('active');
                    }
                });
            }
        })
            .done(function (data) {
                console.log(data);
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
                $('.saveEmailPass').removeClass('saving').children('.dflt-text').removeClass('hidden')
                    .nextAll('.load-text').addClass('hidden');
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
