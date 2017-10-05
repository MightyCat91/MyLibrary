(function ($) {
    $('.status-btn')
        .focus(function () {
            var content = $('#status-list').clone().removeClass('hidden'),
                currStatus = $(this).attr('data-status');

            content.find('.status-option.' + currStatus).remove();
            console.log(content.html());
            $(this).popover({
                'placement': 'bottom',
                'content': content,
                'html': true,
                delay: {"show": 100, "hide": 100}
            });
        })
        .blur(function () {
            $("[data-toggle='popover']").popover('hide');
            // $(this).removeAttr("data-original-title title")
        });


    $(document).on('click', ".status-option", function () {
        var clickedBtn = $(this),
            statusBtn = $('.status-btn[aria-describedby]'),
            newStatus = clickedBtn.data('status'),
            url = statusBtn.parent('.table-column').prev('.name-value').find('a').attr('href'),
            data = {
                'oldStatus': statusBtn.attr('data-status'),
                'newStatus': newStatus
            };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url + '/changeStatus',
            data: data,
            type: 'POST'
        })
            .done(function (data) {
                statusBtn.attr('data-status', newStatus).val(clickedBtn.text());
                statusBtn.closest('tr').find('.status_color').attr('data-status', newStatus);
            });
    })
})(jQuery);