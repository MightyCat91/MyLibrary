(function ($) {
    //контейнер алерта
    var alert = $("#alert-container");
    //отображение алерта
    alert.addClass('visible');
    //установка делея перед закрытием алерта
    setTimeout(function () {
        //закрытие алерта
        alert.removeClass('visible');
    }, alert.data("lifetime"))
})(jQuery);