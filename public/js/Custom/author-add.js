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
                data: new FormData($("#author-add")[0]),
                processData: false,
                contentType: false,
                type: 'POST',
                beforeSend: function () {
                    $('.page-content').addClass('spinner');
                    fileError.html('');
                    imgLink.addClass('hidden');
                },
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
                    console.log(response.responseJSON['imageInput']);
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

})(jQuery);