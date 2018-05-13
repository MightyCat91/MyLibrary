(function ($) {
    $('#list-view-filter-container').find('div').on('click', function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: window.location.href + '/changeViewType',
            data: {
                'viewType': $(this).attr('data-type')
            },
            type: 'GET'
        })
            .done(function (data) {

                var mainContainer = $('.main-container');
                mainContainer.find('#list-view-filter-container').siblings().remove();
                mainContainer.append(data);
                $('#list-view-filter-container').children().toggleClass('active');
            });
    })
})(jQuery);