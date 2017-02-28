(function ($) {
    $('#imageInput').change(function () {
        var imgWrapper = $('.img-name');
        var imgLink = imgWrapper.children();
        var fileError = $('.file-errors');
        if ($(this).val()) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'add/ajaxImg',
                data: new FormData($("#add-form")[0]),
                processData: false,
                contentType: false,
                type: 'POST',
                beforeSend: function () {
                    $('.page-content').addClass('spinner');
                    fileError.html('');
                    imgLink.addClass('hidden');
                }
            })
                .done(function (url) {
                    var imgPreview = $('.img-preview');
                    imgLink.attr('href', url).removeClass('hidden');
                    imgPreview.attr('src', url);
                    $('.page-content').removeClass('spinner');

                    imgWrapper.popover({
                        'placement': 'top',
                        'content': function () {
                            return imgPreview.clone().removeClass('hidden').css('height', 'auto');
                        },
                        'html': true,
                        delay: {"show": 300, "hide": 100},
                        trigger: 'hover'
                    });
                })
                .fail(function (response) {
                    $.each(response.responseJSON['imageInput'], function (index, error) {
                        fileError.append($("<p></p>").text(error));
                    });
                    imgWrapper.popover('dispose');
                    fileError.removeClass('hidden');
                    $('.file-upload-group').addClass('has-danger');
                    $('.page-content').removeClass('spinner');
                })
        } else {
            imgLink.addClass('hidden');
            imgWrapper.popover('dispose');
        }
    });

    $('.append-form-add-input').click(function() {
        var container = $(this).parent();
        var input = container.find('input:last');
        var id = container.attr('id');
        var name;
        switch (id) {
            case 'categories':
                input.clone().attr('name', 'categoryInput[]').val('').appendTo('#' + id);
                break;
            case 'authors':
                if (!input.val()) {
                    if (!$('span.badge').length) {
                        input.after('<span class="badge badge-pill badge-danger align-middle">Внимание</span>');
                    }
                    $(this).attr({
                        'title': 'Поле не может быть пустым',
                        'data-toggle': 'tooltip',
                        'data-placement': 'bottom',
                        'trigger': 'click hover focus'
                    }).tooltip('show');
                }
                else {
                    container.find('span.badge').remove();
                    $(this).tooltip('dispose');
                    input.clone().attr('name', 'authorInput[]').val('').appendTo('#' + id);
                }
                break;
            case 'publishers':
                input.clone().attr('name', 'publisherInput[]').val('').appendTo('#' + id);
                break;
        }
        $(this).appendTo('#' + id);
    });
})(jQuery);