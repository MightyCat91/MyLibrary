(function ($) {

    //контейнер алерта
    var alert = $("#alert-container");
    //отображение алерта
    alert.addClass('visible');
    //установка делея перед закрытием алерта
    console.log(1,$.now());
    setTimeout(function () {
        //закрытие алерта
        // alert.removeClass('visible');
        console.log(2,$.now());
    }, alert.data("lifetime"))
})(jQuery);