(function ($) {
    $('button[data-url]').on('click', function() {
        var url = $(this).attr('data-url');
        location.href = url;
    });
})(jQuery);