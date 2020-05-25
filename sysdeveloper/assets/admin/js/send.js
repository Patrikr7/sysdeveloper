BASE = $('link[rel="base"]').attr('href');

//Login
$('#form_login').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);

    form.ajaxSubmit({
        url: form.attr('action'),
        data: form,
        dataType: 'json',
        beforeSend: function() {
            form.find('.form_load').fadeIn(1000);
        },
        success: function(data) {
            if (data.success) {
                toastr.success(data.success, data.title, {
                    "closeButton": true,
                    "positionClass": "toast-top-right",
                    "progressBar": true,
                    "showDuration": "400",
                    "hideDuration": "1000",
                    "timeOut": "3500",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
                form.find('.form_load').fadeOut(1000);

                //REDIRECIONA
                if (data.redirect) {
                    window.setTimeout(function() {
                        window.location.href = data.redirect;
                    }, 3600);
                }

            } else if (data.error) {
                toastr.error(data.error, data.title, {
                    "closeButton": true,
                    "positionClass": "toast-top-right",
                    "progressBar": true,
                    "showDuration": "400",
                    "hideDuration": "1000",
                    "timeOut": "7000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
                form.find('.form_load').fadeOut(1000);
            } else {
                toastr.warning(data.warning, data.title, {
                    "closeButton": true,
                    "positionClass": "toast-top-right",
                    "progressBar": true,
                    "showDuration": "400",
                    "hideDuration": "1000",
                    "timeOut": "30000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
                form.find('.form_load').fadeOut(1000);
            }
        }
    });
});

// ATUALIZAÇÃO CONFIG
$(function() {
    //AUTOSAVE ACTION *CONFIG*
    $('form.auto_save').change(function(e) {
        e.preventDefault();
        var form = $(this);

        form.ajaxSubmit({
            url: form.attr('action'),
            data: form,
            dataType: 'json',

            success: function(data) {
                if (data.success) {
                    toastr.success(data.success, "", {
                        "closeButton": true,
                        "positionClass": "toast-top-right",
                        "progressBar": true,
                        "showDuration": "400",
                        "hideDuration": "1000",
                        "timeOut": "7000",
                        "extendedTimeOut": "1000"
                    });
                } else {
                    toastr.error(data.error, "", {
                        "closeButton": true,
                        "positionClass": "toast-top-right",
                        "progressBar": true,
                        "showDuration": "400",
                        "hideDuration": "1000",
                        "timeOut": "7000",
                        "extendedTimeOut": "1000"
                    });
                }
            }
        });
    });
});

// CREATE/UPDATE
$('#form').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);

    //Configuração para salvar campo textarea com plugin tinyMCE
    if (typeof tinyMCE !== 'undefined') {
        tinyMCE.triggerSave();
    }

    form.ajaxSubmit({
        url: form.attr('action'),
        data: form,
        dataType: 'json',
        beforeSend: function() {
            form.find('.form_load').fadeIn(1000);
        },
        success: function(data) {
            if (data.success) {
                toastr.success(data.success, "", {
                    "closeButton": true,
                    "positionClass": "toast-top-right",
                    "progressBar": true,
                    "showDuration": "400",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000"
                });

                form.find('.form_load').fadeOut(1000);

                //REDIRECIONA
                if (data.redirect) {
                    window.setTimeout(function() {
                        window.location.href = data.redirect;
                    }, 5100);
                }

            } else {
                toastr.error(data.error, "", {
                    "closeButton": true,
                    "positionClass": "toast-top-right",
                    "progressBar": true,
                    "showDuration": "400",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000"
                });
                $("#" + data.focus).focus();
                $("#" + data.focus).addClass("is-invalid");
                form.find('.form_load').fadeOut(1000);
            }
        }
    });
});

$(".form-control").focusout(function() {
    $(".form-control").removeClass("is-invalid")
});

// FILTRO PARA PESQUISA
$('#form_filter').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);

    form.ajaxSubmit({
        url: BASE + form.attr('action'),
        data: form,
        dataType: 'json',
        beforeSend: function() {
            form.find('.form_load').fadeIn(1000);
        },
        success: function(data) {
            if (data.success) {
                form.find('.form_load').fadeOut(1000);
                //REDIRECIONA
                if (data.redirect) {
                    window.setTimeout(function() {
                        window.location.href = BASE + data.redirect;
                    }, 50);
                }

            } else {
                toastr.error(data.error, "", {
                    "closeButton": true,
                    "positionClass": "toast-top-right",
                    "progressBar": true,
                    "showDuration": "400",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000"
                });
                form.find('.form_load').fadeOut(1000);
            }
        }
    });
});