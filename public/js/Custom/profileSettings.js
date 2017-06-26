(function ($){
    //элемент body
    var body = $("body");

    $('.btn-switch-label').on('click', function() {
        $(this).addClass('active').children('options').prop( "checked", true );
        $(this).siblings('label').removeClass('active').children('options').prop( "checked", false );
    })
})(jQuery);
