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
        //responsive:{
        //    0:{
        //        items:1,
        //        nav: false,
        //    },
        //    300:{
        //        items:3
        //    },
        //    900:{
        //        items:4
        //    },
        //    1400:{
        //        items:5
        //    }
        //}
    });
})(jQuery);