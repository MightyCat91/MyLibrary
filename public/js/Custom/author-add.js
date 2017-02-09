(function ($) {
     $('#imageInput').change(function() {
         //var data = new FormData();
         //$.each( $(this).files, function( key, value ){
         //    data.append( key, value );
         //});
         //console.log(data);
         $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
         });
         $.ajax({
             url: 'add/ajaxImg',
             data: $(this).val(),
             processData: false,
             contentType: false,
             type: 'POST',
             beforeSend: function() {
                 $('.page-content').addClass('spinner');
             },
             success: function (data) {
                 $('.add-img-data').prepend('<img src="' + data + '" class="img-thumbnail image-preview">');
                 $('.page-content').removeClass('spinner');
             }
         })
     })
})(jQuery);