(function ($) {
    $(function () {
        deleteInit();
    });

    function deleteInit() {
        $('#delete-form').on('submit', function () {
            return confirm('Are you sure you want to delete this survey?');
        });
    }
})(jQuery);