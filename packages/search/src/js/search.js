(function ($) {
    //контейнер панели поиска
    var searchContainer = $('#search-container'),
        //контейнер результатов поиска
        searchResultContainer = $('#search-result-container');

    //открытие поля ввода поиска
    $('#search-icon-wrapper').on('click', function () {
        searchContainer.toggleClass('active');
        searchResultContainer.addClass('hidden');
    });

    //поиск
    $('#search-input-wrapper').find('input').keyup(function () {
        //искомое значение
        var searchedText = $(this).val();
        //ищем только если введено 3 и более символов
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
                    //если результат поиска пустой, то выводим заглушку
                    if (!response.length) {
                        searchResultContainer.removeClass('hidden').find('#empty-search-result').removeClass('hidden');
                    } else {
                        //выводим ссылки на страницы соответсвующие найденным результатам
                        $.each(response, function (index, resultString) {
                            var href = window.location.origin + '/' + resultString.type + '/' + resultString.id;
                            searchResultContainer.removeClass('hidden').find("#search-result-wrapper").append('<li><a href="' + href + '">' + resultString.name + '</a></li>');
                        });
                    }
                });
        }
    })
})(jQuery);