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
                statusBtn.attr('data-status', newStatus).val(clickedBtn.text());
                statusBtn.closest('tr').find('.status_color').attr('data-status', newStatus);
                console.log('2');

            })
            .then(function () {
                ждать обновления страницы
                var booksWithOldStatusCount = $('.table-row .status-color[data-status="' + olsStatus + '"]').length,
                    booksWithNewStatusCount = $('.table-row .status-color[data-status="' + newStatus + '"]').length;
                if (booksWithOldStatusCount === 0) {
                    $('.book-status.' + olsStatus).addClass('hidden');
                }
                console.log('1');
                if (booksWithNewStatusCount === 1) {
                    var statusTab = $('.book-status.' + newStatus);
                    if (statusTab.length > 0) {
                        statusTab.removeClass('hidden');
                    } else {
                        var newStatusTab = $('.book-status:not(.active):first').clone().attr('data-status', newStatus)
                            .children('span').text(clickedBtn.text());
                        $('.book-status-container').append(newStatusTab);
                    }
                }
                console.log($('.table-row .status-color[data-status="' + newStatus + '"]').length);
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