(function ($) {
    $('.owl-carousel').owlCarousel({
        nav: true,
        lazyLoad: true,
        navText: [
            "<i class='fa fa-lg fa-arrow-circle-left' aria-hidden='true'></i>",
            "<i class='fa fa-lg fa-arrow-circle-right' aria-hidden='true'></i>"
        ],
        margin:40,
        stagePadding: 30,
        rewind: true,
        responsive:{
            0:{
                items: 1
            },
            450:{
                items: 2,
                margin: 30
            },
            550:{
                items: 3,
                margin: 30
            },
            900:{
                items: 4
            }
        }
    });

    new Morris.Donut({
        element: 'book-diagram',
        data: [
            {value: $('a.reading').data('books'), label: 'Книг:'},
            {value: $('a.completed').data('books'), label: 'Книг:'},
            {value: $('a.drop').data('books'), label: 'Книг:'},
            {value: $('a.on-hold').data('books'), label: 'Книг:'},
            {value: $('a.inPlans').data('books'), label: 'Книг:'}
        ],
        labelColor: '#292b2c',
        colors: [
            '#0275d8',
            '#009926',
            '#FF3933',
            '#fb990e',
            '#999'
        ]
        // formatter: function (x) { return x + "%"}
    });
})(jQuery);