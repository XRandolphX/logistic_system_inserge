$(document).ready(function () {
    // Cargamos las tablas
    CargarTablaConvocatorias();
    // Cargamos los Resumens
    CargarConvocatoriasResume();
    // Cargamos los formularios
    CargarFormulariosConvocatoria();
    // Cargamos otros

});

function CargarFormulariosConvocatoria() {
    $("#frmregConvocatoria").submit(function () {
        var formData = new FormData($('#frmregConvocatoria')[0]);
        $.ajax({
            url: ruta + '/administracion/doSaveConvocatoria',
            type: 'post',
            select: {
                items: 'cell',
                info: false
            },
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            success: function (data) {
                if (data.error == "") {
                    $('#frmregConvocatoria')[0].reset();
                    CargarTablaConvocatorias();
                    CargarConvocatoriasResume();
                }
                showMenssage(data);
            }
        });
        return false;
    });
    $("#frmeditConvocatoria").submit(function () {
        var formData = new FormData($('#frmeditConvocatoria')[0]);
        $.ajax({
            url: ruta + '/administracion/doUpdateConvocatoria',
            type: 'post',
            select: {
                items: 'cell',
                info: false
            },
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            success: function (data) {
                console.log(data);
                if (data.error == "") {
                    $('#frmeditConvocatoria')[0].reset();
                    CargarTablaConvocatorias();
                    CargarConvocatoriasResume();
                    bootstrap.Modal.getInstance(id('exampleModal')).hide();
                }
                showMenssage(data);
            }
        });
        return false;
    });
}

function Clean() {
    id('conv').value = null;
    id('desc').value = null;
    id('ini').value = null;
    id('fin').value = null;
}

function SendToModalConvocatoria() {
    $('#exampleModal').modal('show');
    id('id').value = (GlobalData['v1']);
    id('editConv').value = (GlobalData['v2']);
    id('editDesc').value = (GlobalData['v3']);
    id('editIni').value = (GlobalData['v4']);
    id('editFin').value = (GlobalData['v5']);
    $("#estado_modal").val((GlobalData['v9']));
    $("#estado_modal").change();
}

// Copiar al Portapapeles
function toClipboard() {
    GlobalData['vString'] =
        GlobalData['v2'] + '\n' +
        GlobalData['v3'] + '\n' +
        GlobalData['v4'] + '\n' +
        GlobalData['v5'] + '\n' +
        GlobalData['v6'];
    navigator.clipboard.writeText(GlobalData['vString']);
}

// Llamado por medio de Ajax a Controlador para insertar en Tablas.
function CargarTablaConvocatorias() {
    $('#Table_Convocatoria').DataTable().destroy();
    $.ajax({
        type: "POST",
        url: ruta + '/administracion/doListConvocatoria',
        dataType: "json",
        contentType: "application/json; charset=utf-8",
    }).done(function (lista) {
        $('#Table_Convocatoria').DataTable({
            data: lista.datos,
            // Traduce al todo al español
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.12.0/i18n/es-ES.json"
            },
            dom: "<'row'<'col-md-6'B><'col-sm-6 my-auto'f>>rt<'row'<'col-md-6'l><'col-sm-6 my-auto'p>>",
            buttons: [
                {
                    extend: "excelHtml5",
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    titleAttr: "Exportal a excel",
                    className: "btn btn-success p-2",
                },
                {
                    extend: "pdfHtml5",
                    text: '<i class="fas fa-file-pdf"></i> Pdf',
                    titleAttr: "Exportal a pdf",
                    className: "btn btn-danger p-2",
                },
                {
                    extend: "print",
                    text: '<i class="fas fa-print"></i> Imprimir',
                    titleAttr: "Imprimir",
                    className: "btn btn-info p-2",
                },
            ],
            // Muestra la información en Modal
            responsive: {
                details: {
                    type: 'column',
                    target: 'tr',
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            GlobalData = row.data();
                            return 'Detalles de ' + data['v2'];
                        }
                    }),
                    renderer: $.fn.dataTable.Responsive.renderer.tableAll(),
                }
            },
            paging: true,
            columns: [
                {
                    data: 'v2',
                    width: "15%"
                },
                {
                    data: 'v10',
                    width: "15%",
                    className: 'text-center',
                    render: function (data, type, row) {
                        if (data == 'Activo') {
                            return '<i class="text-success bi bi-square-fill"></i> Activo';
                        } else {
                            return '<i class="text-danger bi bi-square-fill"></i> Inactivo';
                        }
                    }
                },
                { data: 'v3' },
                {
                    data: 'v4',
                    class: 'none'
                },
                {
                    data: 'v5',
                    render: function (data, type, row) {
                        if (data == '0000-00-00') {
                            return 'Hasta la actualidad';
                        } else {
                            return data;
                        }
                    }
                },
                {
                    data: 'v6',
                    class: 'none'
                },
                {
                    data: 'v8',
                    class: 'none'
                },
                {
                    data: null,
                    defaultContent: '<div class="text-black text-end"><button data-bs-dismiss="modal" id="Edit_row" onClick="SendToModalConvocatoria()" class="btn btn-outline-primary bi bi-pencil mr-2"> Editar </button><a tabindex="0" class="btn btn-outline-dark bi bi-clipboard" role="button" data-bs-container="body" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="right" data-bs-content="¡Copiado al Clipboard!" onClick="toClipboard()"> Copiar</a>',
                    className: 'text-white none',
                    orderable: false
                }
            ],
            select: false,
            search: {
                return: true,
            }
        });
    });
}

function CargarConvocatoriasResume() {
    $.ajax({
        type: "POST",
        url: ruta + '/administracion/doResumeConvocatoria',
        dataType: "json",
        contentType: "application/json; charset=utf-8",
    }).done(function (lista) {
        console.log(lista);
        if (lista[0]['Total'] == '0') {
            id("Resumen").classList.add('d-none');
            id("TitleResumen").classList.remove('d-none');
        } else {
            id("Resumen").classList.remove('d-none');
            id("TitleResumen").classList.add('d-none');
            $("#TotalResumeConv").html(lista[0]['Total']);
            $("#LastResumeConv").html(lista[0]['last']);
            $("#VigenteResumeConv").html(lista[0]['Vigente %'] + '%');
            $("#CaducadaResumeConv").html(lista[0]['Caducada %'] + '%');
            $("#VigenteResumeConv").css("width", lista[0]['Vigente %'] + '%');
            $("#CaducadaResumeConv").css("width", lista[0]['Caducada %'] + '%');
            $("#ActiveResumeConv").html(lista[0]['Activo %'] + '%');
            $("#InactiveResumeConv").html(lista[0]['Inactivo %'] + '%');
            $("#ActiveResumeConv").css("width", lista[0]['Activo %'] + '%');
            $("#InactiveResumeConv").css("width", lista[0]['Inactivo %'] + '%');
        }
    });
}
