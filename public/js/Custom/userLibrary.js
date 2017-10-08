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
            url = statusBtn.parent('.table-column').prev('.name.value').find('a').attr('href'),
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
                var booksWithOldStatusCount = $('.status-btn[data-status="' + olsStatus + '"]').length,
                    booksWithNewStatusCount = $('.status-btn[data-status="' + newStatus + '"]').length;

                if (booksWithOldStatusCount === 1) {
                    $('.book-status[data-tab="' + olsStatus + '"]').addClass('hidden');
                    $('.book-status[data-tab="' + newStatus + '"]').addClass('active')
                        .siblings().removeClass('active');
                    // $('.status_color[data-status="' + newStatus + '"]').closest('.table-row').removeClass('hidden')
                    //     .siblings().addClass('hidden');
                }

                if (booksWithNewStatusCount === 0) {
                    var statusTab = $('.book-status[data-tab="' + newStatus + '"]');
                    if (statusTab.length > 0) {
                        statusTab.removeClass('hidden');
                    } else {
                        var newStatusTab = $('.book-status:not(.active):first').clone();
                        newStatusTab.attr('data-tab', newStatus).children('span').text(clickedBtn.text());
                        $('.book-status-container').append(newStatusTab);
                    }
                }

                statusBtn.attr('data-status', newStatus).val(clickedBtn.text());
                statusBtn.closest('tr').find('.status_color').attr('data-status', newStatus);
            })
    })
        .on('click', function (event) {
            var popupIsShow = $('[aria-describedby]').length,
                popoverBookId = $('.popover .status-option').attr('data-btnid'),
                statusBtnBookId = $(event.target).closest('.table-row').attr('data-bookid');

            if (popupIsShow && (statusBtnBookId !== popoverBookId)) {
                $('.table-row[data-bookid="' + popoverBookId + '"] .status-btn').popover('hide');
            }
        })
        .on('click', '.book-status', function () {
            var status = $(this).attr('data-tab');

            $(this).addClass('active').siblings().removeClass('active');
            if (status === 'all') {
                $('tbody .table-row').removeClass('hidden');
            } else {
                $('.status_color[data-status="' + status + '"]').closest('.table-row').removeClass('hidden')
                    .siblings().addClass('hidden');
            }

        })
})(jQuery);