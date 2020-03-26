BASE = $('link[rel="base"]').attr('href');

$(function() {
    //TAB
    $('.sis_tab').click(function() {
        if (!$(this).hasClass('sis_active')) {
            var SisTab = $(this).attr('href');

            $('.sis_tab').removeClass('sis_active');
            $(this).addClass('sis_active');

            $('.sis_tab_target.sis_active').fadeOut(200, function() {
                $(SisTab).fadeIn(300).addClass('sis_active');
            }).removeClass('sis_active');
        }

        if (!$(this).hasClass('sis_active_go')) {
            return false;
        }
    });

});

// INPUT FILE
$('.custom-file-input').on('change', function() {
    let fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(fileName);
});

// REGEX PASSWORD
$('.regex_password').on('keyup', function() {
    var value = $(this).val();
    var regex = /(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W+)(?=^.{6,10}$).*$/;

    if (regex.test(value)) {
        $('.trigger_password').removeClass("text-danger").addClass("text-success").html("Correto");
    } else {
        $('.trigger_password').removeClass("text-success").addClass("text-danger").html("A Senha deve ter: Letras minúsculas, maiúsculas, números e caracteres especiais!");
    }
});

// REGEX EMAIL
$('.regex_email').on('keyup', function() {
    var value = $(this).val();
    var regex = /[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/;

    if (regex.test(value)) {
        $('.trigger_email').removeClass("text-danger").addClass("text-success").html("Correto");
    } else {
        $('.trigger_email').removeClass("text-success").addClass("text-danger").html("Digite seu email corretamente!");
    }
});

$(document).ready(function() {
    "use strict";
    $('#characterLeft').text('160 caracteres restantes');
    $('.text-area').keydown(function() {
        var max = 160;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft').text('Você atingiu o limite');
            $('#characterLeft').addClass('text-danger');
            $('#btnSubmit').addClass('disabled');
        } else {
            var ch = max - len;
            $('#characterLeft').text(ch + ' caracteres restantes');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft').removeClass('text-danger');
        }
    });

    /* TINYMCE */
    if ($(".tiny-content").length) {
        tinymce.init({
            selector: ".tiny-content",
            theme: "modern",
            language: "pt_BR",
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
            ],
            toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
            toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
            image_advtab: true,

            relative_urls: false,
            remove_script_host: false,
            external_filemanager_path: BASE + "../assets/plugins/filemanager/",
            filemanager_title: "Upload",
            external_plugins: {
                "filemanager": BASE + "../assets/plugins/filemanager/plugin.min.js"
            }
        });
    }

    if ($(".tiny_content").length) {
        tinymce.init({
            selector: ".tiny_content",
            theme: "modern",
            language: "pt_BR",
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tiny.cloud/css/codepen.min.css'
            ]
        });
    }


    /* FUNÇÃO VIACEP */
    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#addr_street").val("");
        $("#addr_number").val("");
        $("#addr_comp").val("");
        $("#addr_district").val("");
        $("#addr_city").val("");
        $("#addr_state").val("");
        $("#addr_country").val("");
    }

    //Quando o campo cep perde o foco.
    $("#addr_zipcode").blur(function() {

        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if (validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                $("#addr_street").val("...");
                $("#addr_district").val("...");
                $("#addr_city").val("...");
                $("#addr_state").val("...");

                //Consulta o webservice viacep.com.br/
                $.getJSON("//viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#addr_street").val(dados.logradouro);
                        $("#addr_district").val(dados.bairro);
                        $("#addr_city").val(dados.localidade);
                        $("#addr_state").val(dados.uf);
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();

                        //$(".trigger").html("<div class=\"col-md-12\"><div class=\"alert alert-danger alert-dismissable\"><button aria-hidden=\"true\" data-dismiss=\"alert\" class=\"close\" type=\"button\">×</button><i class=\"fa fa-info-circle\"></i> CEP não encontrato!</div></div>");

                        toastr.error("Digite novamente o CEP, pois, esse é inválido.", "Formato de CEP inválido!", {
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
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                //$(".trigger").html("<div class=\"col-md-12\"><div class=\"alert alert-danger alert-dismissable\"><button aria-hidden=\"true\" data-dismiss=\"alert\" class=\"close\" type=\"button\">×</button><i class=\"fa fa-info-circle\"></i> Formato de CEP inválido!</div></div>");

                toastr.error("Digite novamente o CEP, pois, esse é inválido.", "Formato de CEP inválido!", {
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
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    });
});

// upload de image
$(document).ready(function(e) {
    // Função para visualização da imagem após a validação
    $(function() {
        $("#img").change(function() {
            var file = this.files[0];
            var imagefile = file.type;
            var match = ["image/jpeg", "image/png", "image/jpg"];
            if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
                $('#previewing').attr('src', '../../img/img.jpg');
                swal("", "Selecione uma imagem válida!", "error");
                return false;
            } else {
                var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
            }
        });
    });

    function imageIsLoaded(e) {
        $("#img").css("color", "green");
        $('#previewing').attr('src', e.target.result);
    };
});

// MASCARAS
$(function() {
    $(".price").maskMoney({ allowNegative: true, thousands: '.', decimal: ',', affixesStay: false });
    $(".date").mask("99/99/9999");
    $(".date_price").mask("99/99/9999 99:99");
    $(".timestamp").mask("99/99/9999 99:99:99");
    $(".addr_zipcode").mask("99999-999");
    $(".tl").mask("(99) 9999-9999");
    $(".cnpj").mask("99.999.999/9999-99");

    $('.tel').focusout(function() {
        var phone, element;
        element = $(this);
        element.unmask();
        phone = element.val().replace(/\D/g, '');
        if (phone.length > 10) {
            element.mask("(99) 99999-999?9");
        } else {
            element.mask("(99) 9999-9999?9");
        }
    }).trigger('focusout');
});

function mask_cpf(mascara, documento) {
    var i = documento.value.length;
    var saida = mascara.substring(0, 1);
    var texto = mascara.substring(i);
    if (texto.substring(0, 1) != saida) {
        documento.value += texto.substring(0, 1);
    }
};

//DELETE/LOGOUT/STATUS
$(function() {
    $('.button_action').on("click", function() {
        var Id = $(this).attr('id');
        var RelTitle = $(this).attr('rel');
        var Callback = $(this).attr('callback');
        var Callback_action = $(this).attr('callback_action');
        swal({
                title: RelTitle,
                text: "Você não será capaz de recuperar novamente!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sim",
                closeOnConfirm: false
            },
            function() {
                $.post(Callback + '/' + Callback_action, {
                        callback: Callback,
                        callback_action: Callback_action,
                        id: Id
                    },
                    function(data) {
                        if (data.error) {
                            swal("", data.error, data.type)
                        } else {
                            swal({
                                    title: "",
                                    text: data.success,
                                    type: "success",
                                    confirmButtonClass: "btn-success",
                                    closeOnButtonText: "Ok",
                                    closeOnConfirm: true
                                },
                                function() {
                                    location.reload();
                                });
                        }
                    }, 'json');
            });
    });
});

$(function() {
    $('.comment').on('click', '.comments_open', function() {
        $(".form_" + $(this).attr('rel')).slideDown().find('#c_name').focus();
        return false;
    });

    $('.comment').on('click', '.comments_close', function() {
        $(".form_" + $(this).attr('id')).slideUp();
    });
});