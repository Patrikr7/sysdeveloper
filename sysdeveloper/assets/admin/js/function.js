BASE = $('link[rel="base"]').attr('href');

//////////////////////// INATIVIDADE
var timeout = "";

$(function() { //onload
    setEvent();
});

$(document).on('mousemove', function() { //mouse move
    if (timeout !== null) {
        clearTimeout(timeout); //clear no timer
    }
    setEvent(); //seta ele novamente para caso aja inatividade faça o evento
});

function setEvent() {
    timeout = setTimeout(function() {
        swal({
                title: "Sem atividade!",
                text: "O tempo se esgota em 10 segundos",
                timer: 10000,
                showCancelButton: true,
                showConfirmButton: true
            },
            function() {
                window.location.href = BASE + "reset";
            });
    }, 1000000);
}
////////////////////// FIM INATIVIDADE