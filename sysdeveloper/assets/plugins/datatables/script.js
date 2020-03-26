$(document).ready(function() {
    $('.dataTables-example').DataTable({
        order: [
            [0, "asc"]
        ],
        pageLength: 30,
        pagingType: "simple",
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
        }
    });

    $('.dataTables-routers').DataTable({
        order: [
            [2, "asc"]
        ],
        pageLength: 30,
        pagingType: "simple",
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
        }
    });
});