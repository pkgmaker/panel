var send = function (parameters) {
    $.ajax({
        url: parameters.url || '/ajax/actions.php',
        data: parameters.data || {},
        dataType: parameters.dataType || 'json',
        method: parameters.method || 'POST',
        success: parameters.success,
        error: parameters.error
    });
};

var notification = function (params) {
    action = params.error ? 'error' : 'success';
    new PNotify({
        title: params.title || 'Global',
        type: action,
        text: params.msg || '',
        addclass: 'dark',
        icon: false,
        delay: 3000
    });
};

var loadCategories = function () {
    var section = $('#type').val();

    if (section)
        send({
            data: {action: 'get-category', section: section},
            success: function (data) {
                if (data.error)
                    notification({
                        title: 'Section',
                        error: data.error,
                        msg: data.msg
                    });
                else {
                    $('#choose-category').empty();
                    $.when($.each(data.values, function (key, category) {
                        $('#choose-category').append($('<option></option>')
                            .attr('value', category.id)
                            .text(category.category));
                    })).done(function () {
                        $('#choose-category').trigger("chosen:updated");
                    });
                }
            },
            error: function () {
                notification({
                    title: 'Seccion',
                    error: true,
                    msg: 'Server error.'
                });
            }
        });
};

jQuery(document).ready(function () {
    $(".chosen-select").chosen({});
    loadCategories();

    $('#type').on('change', function () {
        loadCategories();
    });

    $('.login-form input[type="text"], .login-form input[type="password"], .login-form textarea').on('focus', function () {
        $(this).removeClass('input-error');
    });

    $('.login-form').on('submit', function (e) {

        $(this).find('input[type="text"], input[type="password"], textarea').each(function () {
            if ($(this).val() == "") {
                e.preventDefault();
                $(this).addClass('input-error');
            }
            else {
                $(this).removeClass('input-error');
            }
        });

    });

    $('.main-sidebar').css('height', '100%');

    $('#add_section').on('submit', function (event) {
        event.preventDefault();
        var sectionName = $('#section_name').val();

        if (sectionName) {
            send({
                data: {action: 'add-section', name: sectionName},
                success: function (data) {
                    notification({
                        title: 'Seccion',
                        error: data.error,
                        msg: data.msg
                    });
                    setTimeout(function () {
                        window.location.reload();
                    }, 1500)
                },
                error: function () {
                    notification({
                        title: 'Seccion',
                        error: true,
                        msg: 'Server error.'
                    });
                }
            });
        }
    });

    $('li[data-remove]').on('click', function () {
        var item = $(this).attr('data-remove');

        send({
            data: {action: 'rm-section', id: item},
            success: function (data) {
                notification({
                    title: 'Seccion',
                    error: data.error,
                    msg: data.msg
                });
                setTimeout(function () {
                    window.location.reload();
                }, 1500)
            },
            error: function () {
                notification({
                    title: 'Seccion',
                    error: true,
                    msg: 'Server error.'
                });
            }
        });
    });

    $('#add_category').on('submit', function (event) {
        event.preventDefault();
        var categoryName = $('#category_name').val();
        var section = $('select#section').val();

        if (categoryName) {
            send({
                data: {action: 'add-category', name: categoryName, section: section},
                success: function (data) {
                    notification({
                        title: 'Categoria',
                        error: data.error,
                        msg: data.msg
                    });
                    setTimeout(function () {
                        window.location.reload();
                    }, 1500)
                },
                error: function () {
                    notification({
                        title: 'Categoria',
                        error: true,
                        msg: 'Server error.'
                    });
                }
            });
        }
    });

    $('li[data-delete]').on('click', function () {
        var item = $(this).attr('data-delete');

        send({
            data: {action: 'rm-category', id: item},
            success: function (data) {
                notification({
                    title: 'Categoria',
                    error: data.error,
                    msg: data.msg
                });
                setTimeout(function () {
                    window.location.reload();
                }, 1500)
            },
            error: function () {
                notification({
                    title: 'Categoria',
                    error: true,
                    msg: 'Server error.'
                });
            }
        });
    });
});