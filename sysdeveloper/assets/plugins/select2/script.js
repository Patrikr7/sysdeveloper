$(document).ready(function() {
    $('.client').select2({
        placeholder: 'Escolha um Cliente',
        allowClear: true
    });

    $('.book').select2({
        placeholder: 'Escolha um Livro',
        allowClear: true
    });
});