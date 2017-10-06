(function ($) {
    $('.status-btn').on('focus', function () {
        var currStatus = $(this).attr('data-status'),
            content = $('#status-list').clone().removeClass('hidden');

        content.find('.status-option.' + currStatus).remove();
        content.find('.status-option').attr('data-btnid', $(this).closest('.table-row').attr('data-bookid'));
        $(this).attr('data-content', content.html()).popover('show');
    })
        .popover({
            'placement': 'bottom',
            'html': true,
            delay: {"show": 100, "hide": 100},
            trigger: 'manual'
        });

    $(document).on('click', '.status-option', function () {
        var clickedBtn = $(this),
            statusBtn = $('.table-row[data-bookid="' + $(this).attr('data-btnid') + '"] .status-btn'),
            newStatus = clickedBtn.data('status'),
            olsStatus = statusBtn.attr('data-status'),
            url = statusBtn.parent('.table-column').prev('.name-value').find('a').attr('href'),
            data = {
                'oldStatus': olsStatus,
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
                var booksWithOldStatusCount = $('.table-row .status-color[data-status="'+olsStatus+'"]').count(),
                    booksWithNewStatusCount = $('.table-row .status-color[data-status="'+newStatus+'"]').count();

                statusBtn.attr('data-status', newStatus).val(clickedBtn.text());
                statusBtn.closest('tr').find('.status_color').attr('data-status', newStatus);
                if (booksWithOldStatusCount==0 )
            });
    })
        .on('click', function (event) {
            var popupIsShow = $('[aria-describedby]').length,
                popoverBookId = $('.popover .status-option').attr('data-btnid'),
                statusBtnBookId = $(event.target).closest('.table-row').attr('data-bookid');

            if (popupIsShow && (statusBtnBookId !== popoverBookId)) {
                $('.table-row[data-bookid="' + popoverBookId + '"] .status-btn').popover('hide');
            }
        });

})(jQuery);