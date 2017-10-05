(function ($) {
    $('.status-btn').on('click', function () {
        var currStatus = $(this).attr('data-status'),
            content = $('#status-list').clone().removeClass('hidden');

        content.find('.status-option.' + currStatus).remove();
        $(this).popover({
            'placement': 'bottom',
            'content': content,
            'html': true,
            delay: {"show": 100, "hide": 100},
            trigger: 'manual'
        }).popover('show');

    });
        $(document).click(function () {
        // console.log($(this).attr('class'));
        // if (!$(this).hasClass('status-option') || !$(this).hasClass('status-btn')) {
            console.log($(':focus').class());
            $(".status-option").on('click', function () {
                console.log('2');
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
            });
            if ($("[aria-describedby]").length > 0) {
                $("[aria-describedby]").popover('hide');
            }
            // $("[data-toggle='popover']").
        // }
    });


})(jQuery);