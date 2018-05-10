(function ($) {
    var searchContainer = $('#search-container'),
        searchResultContainer = $('#search-result-container');

    $('#search-icon-wrapper').on('click', function () {
        searchContainer.toggleClass('active');
        searchResultContainer.addClass('hidden');
    });

    $('#search-input-wrapper').find('input').keyup(function () {
        var searchedText = $(this).val();
        if (searchedText.length > 2) {
            $('#search-result-wrapper').children(':not(#empty-search-result)').remove();
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
                    var response = $.parseJSON(data);
                    if (!response.length) {
                        searchResultContainer.removeClass('hidden').find('#empty-search-result').removeClass('hidden');
                    } else {
                        $.each(response, function (index, resultString) {
                            var href = window.location.origin + '/' + resultString.type + '/' + resultString.id;
                            searchResultContainer.removeClass('hidden').find("#search-result-wrapper").append('<li><a href="' + href + '">' + resultString.name + '</a></li>');
                        });
                    }
                });
        }
    })
})(jQuery);