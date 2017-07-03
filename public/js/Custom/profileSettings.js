(function ($) {
    //элемент body
    var body = $("body");
    var emailPassForm = $('#edit-email-pass-form');
    var changeBtn = $('.saveEmailPass');

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
            type: 'POST',
            //отображение спиннера
            beforeSend: function () {
                changeBtn.addClass('saving').children('.dflt-text').addClass('hidden').nextAll('.load-text')
                    .removeClass('hidden');
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
                changeBtn.removeClass('saving').children('.dflt-text').removeClass('hidden')
                    .nextAll('.load-text').addClass('hidden');
            });
    });

    $('#openDialog').on('click', function () {
        clearValidateErrors();
    });

    $("#changeEmailPass").on('show.bs.modal', function () {
        emailPassForm.find(".form-control").map(function(indx, element){
            var input = $(element);
            if (input.val()) {
                input.next('.input-label').addClass('active');
            }
        });
    });

    function clearValidateErrors() {
        $('.form-control-feedback').text('');
        $('.form-group').removeClass('has-danger');
    }
})(jQuery);
