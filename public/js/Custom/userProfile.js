(function ($) {
    $('.owl-carousel').owlCarousel({
        nav: true,
        lazyLoad: true,
        dots: false,
        navText: [
            "<i class='fa fa-lg fa-arrow-circle-left' aria-hidden='true'></i>",
            "<i class='fa fa-lg fa-arrow-circle-right' aria-hidden='true'></i>"
        ],
        margin:40,
        stagePadding: 30,
        loop: true,
        responsive:{
            0:{
                items:1
            },
            450:{
                items:2,
                margin: 30
            },
            550:{
                items:3,
                margin: 30
            },
            900:{
                items:4
            },
            1400:{
                items:5
            },
            1600:{
                items:6
            }
        }
    });
})(jQuery);