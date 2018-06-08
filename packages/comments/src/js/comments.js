(function ($) {
    // инициализация текстового редактора
    $('.commetns-text-editor').summernote({
        maxHeight: 350,
        placeholder: 'Текст комментария',
        disableResizeEditor: true,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['link']
        ],
        lang: 'ru-RU',
        disableDragAndDrop: true
    });
})(jQuery);