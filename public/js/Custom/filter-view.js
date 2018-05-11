(function ($) {
    $('#list-view-filter-container').find('div').on('click', function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        console.log(window.location.href + '/changeViewType');
        console.log($(this).attr('data-type'));
        $.ajax({
            url: window.location.href + '/changeViewType',
            data: {
                'viewType': $(this).attr('data-type')
            },
            type: 'GET'
        })
            .done(function (data) {
                console.log(data);
                var mainContainer = $('.main-container');
                mainContainer.find('#filter-header').remove().next().remove();
                mainContainer.append(data);
                $('#list-view-filter-container').children().toggleClass('active');
            });
    })
})(jQuery);