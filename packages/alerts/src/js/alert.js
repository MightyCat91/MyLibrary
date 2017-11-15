(function ($) {

    //контейнер алерта
    var alert = $(".alert");
    //установка делея перед закрытием алерта
    var a = $.now();
    console.log(1,$.now());


    $.each(alert, function () {
        setTimeout(function () {
            //закрытие алерта
            // $(this).addClass('hidden');
        }, alert.data("lifetime"));
    });

    alert.on('click', '.fa-times', function () {
        $(this).closest('.alert').remove();
    })
})(jQuery);