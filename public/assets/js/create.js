(function ($) {
    $(function () {
        typeInit();
        filterInit();
        previewInit();
        questionInit();
    });

    function typeInit() {
        var filters_card = $('.filters_card');
        $('#type')
            .on('change', function () {
                if ($(this).val() == 1) {
                    filters_card.slideUp();
                } else {
                    filters_card.slideDown();
                }
            })
            .trigger('change');
    }

    function filterInit() {
        var filters = $('.create_filters');
        filters.find('input')
            .on('change keyup', function () {
                filtersTrigger(filters);
            });
        filtersTrigger(filters);
    }

    function filtersTrigger(filters) {
        var list = $('.filters_list'),
            items = list.find('.item'),
            by_name = filters.find('#filter_name').val(),
            by_company = filters.find('#filter_company').val();
        items.hide();
        if (by_name) {
            items = items.filter('[data-name*="' + by_name.toLowerCase() + '"]');
        }
        if (by_company) {
            items = items.filter('[data-company*="' + by_company.toLowerCase() + '"]');
        }
        items.show();
    }

    function previewInit() {
        var preview = $('#attachment_preview'),
            image = preview.find('img');
        preview.slideUp();
        $('#attachment').on('change', function () {
            console.log(this, this.files);
            preview.slideUp();
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    image.attr('src', e.target.result);
                    preview.slideDown();
                };
                reader.readAsDataURL(this.files[0]);
            }
        })
    }

    function questionInit() {
        var i = 0,
            questions = $('.question_list');
        if (questions.find('.question').length === 0) {
            questionNew(questions, i++);
        }
        $('.new-question')
            .on('click', function (e) {
                e.preventDefault();
                questionNew(questions, i++);
            });
        questions.on('click', '.remove-question', function (e) {
            e.preventDefault();
            if (questions.find('.question').length === 0) {
                alert('At least one questions should be set');
            } else {
                $(this).closest('.question').remove();
            }
        });
    }

    function questionNew(questions, i) {
        var select;
        questions.append(
            $('<div></div>', {class: 'three fields question'})
                .append(
                    $('<div></div>', {class: 'field'})
                        .append(
                            $('<label></label>', {for: 'question_' + i + '_question'})
                                .text('Question'),
                            $('<input/>', {
                                type: 'text',
                                name: 'question[' + i + '][question]',
                                placeholder: 'Question',
                                id: 'question_' + i + '_question'
                            })
                        ),
                    $('<div></div>', {class: 'field'})
                        .append(
                            $('<label></label>', {for: 'question_' + i + '_type'})
                                .text('Type of Answer'),
                            select = $('<select></select>', {
                                name: 'question[' + i + '][type]',
                                placeholder: 'Type of Answer',
                                id: 'question_' + i + '_type'
                            })
                        ),
                    $('<div></div>', {class: 'field'})
                        .append(
                            $('<label></label>', {for: 'question_' + i + '_options'})
                                .text('Options List'),
                            $('<input/>', {
                                type: 'text',
                                name: 'question[' + i + '][options]',
                                placeholder: 'Options List',
                                id: 'question_' + i + '_options'
                            })
                        ),
                    $('<div></div>', {class: 'field'})
                        .append(
                            $('<button></button>', {class: 'ui red button remove-question'})
                                .html('<i class="remove icon"></i> Remove')
                        )
                )
        );
        $.each(questions.data('types'), function (k, v) {
            select.append($('<option></option>', {value: k}).text(v));
        });
    }

})(jQuery);