(function ($) {
    var searchContainer = $('#search-container'),
        searchResultWrapper = $('#search-result-wrapper');

    $('#search-icon-wrapper').on('click', function () {
        searchContainer.toggleClass('active');
        searchResultWrapper.addClass('hidden');
    });

    $('#search-input-wrapper').find('input').keyup(function () {
        var searchedText = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: window.location.origin + '/search',
            data: {
                //искомый текст
                'text': searchedText
            },
            type: 'POST'
        })
            .done(function (data) {
                if (data) {
                    $('#empty-search-result').removeClass('hidden');
                } else {
                    $.forEach(data, function (resultString) {
                        searchResultWrapper.appendChild('<li><a href="' + resultString.href + '">' + resultString.name + '</a></li>').removeClass('hidden');
                    });
                }
            });
    })
})(jQuery);