(function ($) {
    $('.input_upload').on('change', function(){
        var filename = $(this).val();
        $(this).parent().find('.upload_btn span').text(filename);
    });
    
    
})(jQuery);

