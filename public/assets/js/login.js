(function ($) {
    $(function () {
        loginInit();
    });

    function loginInit() {
        var form = $('#login-form'),
            route = form.attr('action'),
            error_container = form.find('.error-container');
        form.on('submit', function (e) {
            e.preventDefault();
            error_container.slideUp();
            $.post(route, form.serialize())
                .done(function (result) {
                    if (result.status === 200) {
                        location.href = result.redirect;
                    } else {
                        error_container.text(result.message)
                            .slideDown();
                    }
                });
        });
    }
})(jQuery);