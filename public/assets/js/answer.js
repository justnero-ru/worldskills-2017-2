(function ($) {
    $(function () {
        answerInit();
    });

    function answerInit() {
        var form = $('#answer-form'),
            route = form.attr('action'),
            error_container = form.find('.error-container'),
            success_container = form.find('.success-container');
        form.on('submit', function (e) {
            e.preventDefault();
            error_container.slideUp();
            success_container.slideUp();
            $.post(route, form.serialize())
                .done(function (result) {
                    if (result.status === 200) {
                        success_container.text(result.message)
                            .slideDown();
                    } else if (result.status === 403) {
                        location.href = result.redirect;
                    } else {
                        error_container.text(result.message)
                            .slideDown();
                    }
                });
        });
    }
})(jQuery);