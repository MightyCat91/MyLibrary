(function ($) {

    //контейнер алерта
    var alert = $(".alert");
    //отображение алерта
    // alert.addClass('visible');
    //установка делея перед закрытием алерта
    var a = $.now();
    console.log(1,$.now());
    setTimeout(function () {
        //закрытие алерта
        // alert.removeClass('visible');
        console.log(2,$.now()-a);
    }, alert.data("lifetime"));

    alert.on('click', '.fa-times', function () {
        console.log('click');
        $(this).closest('.alert').remove();
    })
})(jQuery);