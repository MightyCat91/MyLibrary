(function ($){
    //элемент body
    var body = $("body");

    $('.btn-switch-label').on('click', function() {
        $(this).addClass('active').children('options').prop( "checked", true );
        $(this).siblings('label').removeClass('active').children('options').prop( "checked", false );
    });

    $('.saveEmailPass').on('click', function() {
        $.ajax({
            url: 'user/storeEmailPass',
            data: new FormData($("#edit-email-pass-form")[0]),
            processData: false,
            contentType: false,
            type: 'POST',
            //отображение спиннера, очистка ошибок, скрытие превью
            beforeSend: function () {
                $('.page-content').addClass('spinner');
            }
        })
            .done(function (data) {
            })
            .fail(function (response) {
            })
    })
})(jQuery);
