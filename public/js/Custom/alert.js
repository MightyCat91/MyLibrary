(function ($) {
    var alert = $("#alert-container");
    alert.addClass('visible');
    setTimeout(function () {
        alert.removeClass('visible');
    }, alert.data("lifetime"));
})(jQuery);