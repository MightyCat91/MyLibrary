(function ($) {
    $('.status-btn')
        .focus(function () {
            var content = $('#status-list').clone().removeClass('hidden'),
                currStatus = $(this).attr('data-status');

            content.find('.status-option.' + currStatus).remove();
            $(this).popover({
                'placement': 'bottom',
                'content': content,
                'html': true,
                delay: {"show": 100, "hide": 100}
            });
        })
        .blur(function () {
            $("[data-toggle='popover']").popover('hide');
        });


    $(document).on('click', ".status-option", function () {
        var clickedBtn = $(this),
            statusBtn = $('.status-btn[aria-describedby]'),
            newStatus = clickedBtn.data('status'),
            data = {
                'oldStatus': statusBtn.attr('data-status'),
                'newStatus': newStatus
            };
        console.log(data);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: window.location.pathname + '/changeStatus',
            data: data,
            type: 'POST'
        })
            .done(function (data) {
                statusBtn.attr('data-status', newStatus).text(clickedBtn.text());
            });

        $('.user-item-rating').removeClass('hidden');
    });
})(jQuery);