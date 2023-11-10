$(document).ready(function () {
    // Cargamos las tablas
    CargarTablaProveedor();
    // Cargamos los Resumens
    CargarProveedorResume();
    // Cargamos los formularios
    CargarFormulariosProveedor();
    // Cargamos otros

});

function CargarFormulariosProveedor() {
    $("#frmregProveedor").submit(function () {
        var formData = new FormData($('#frmregProveedor')[0]);
        $.ajax({
            url: ruta + '/administracion/doSaveProveedor',
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
                    $('#frmregProveedor')[0].reset();
                    CargarTablaProveedor();
                    CargarProveedorResume();
                }
                showMenssage(data);
            }
        });
        return false;
    });
    $("#frmeditProveedor").submit(function () {
        var formData = new FormData($('#frmeditProveedor')[0]);
        $.ajax({
            url: ruta + '/administracion/doUpdateProveedor',
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
                    bootstrap.Modal.getInstance(id('exampleModal')).hide();
                    $('#frmeditProveedor')[0].reset();
                    CargarTablaProveedor();
                    CargarProveedorResume();
                }
                showMenssage(data);
            }
        });
        return false;
    });
}

function Clean() {
    id('ruc').value = null;
    id('razon').value = null;
    id('correo').value = null;
    id('tel').value = null;
    id('dir').value = null;
    $("#sel_departamento").val('01');
    $("#sel_departamento").change();
}

function SendToModalProveedor() {
    $('#exampleModal').modal('show');
    id('id').value = (GlobalData['v1']);
    id('editRUC').value = (GlobalData['v2']);
    id('editRazon').value = (GlobalData['v3']);
    id('editEmail').value = (GlobalData['v4']);
    id('editTel').value = (GlobalData['v5']);
    id('editDir').value = (GlobalData['v6']);
    $("#estado_modal").val((GlobalData['v16']));
    $("#estado_modal").change();
    $("#sel_departamento_modal").val((GlobalData['v11']));
    $("#sel_departamento_modal").change();
    $("#sel_provincia_modal").val((GlobalData['v9']));
    $("#sel_provincia_modal").change();
    $("#sel_distrito_modal").val((GlobalData['v7']));
    $("#sel_distrito_modal").change();
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
function CargarTablaProveedor() {
    $('#Table_Proveedor').DataTable().destroy();
    $.ajax({
        type: "POST",
        url: ruta + '/administracion/doListProveedor',
        dataType: "json",
        contentType: "application/json; charset=utf-8",
    }).done(function (lista) {
        $('#Table_Proveedor').DataTable({
            data: lista.datos,
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
            // Traduce al todo al español
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.12.0/i18n/es-ES.json"
            },
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
                { data: 'v2' },
                {
                    data: 'v17',
                    width: "15%",
                    render: function (data, type, row) {
                        if (data == 'Activo') {
                            return '<i class="text-success bi bi-square-fill"></i> Activo';
                        } else {
                            return '<i class="text-danger bi bi-square-fill"></i> Inactivo';
                        }
                    }
                },
                { data: 'v3' },
                { data: 'v4' },
                {
                    data: 'v5',
                    className: 'none'
                },
                {
                    data: 'v8',
                    className: 'none'
                },
                {
                    data: 'v10',
                    className: 'none'
                },
                {
                    data: 'v12',
                    className: 'none'
                },
                {
                    data: 'v6',
                    className: 'none'
                },
                {
                    data: 'v13',
                    className: 'none'
                },
                {
                    data: 'v15',
                    className: 'none'
                },
                {
                    data: null,
                    defaultContent: '<div class="text-black text-end"><button data-bs-dismiss="modal" id="Edit_row" onClick="SendToModalProveedor()" class="btn btn-outline-primary bi bi-pencil mr-2"> Editar </button><a tabindex="0" class="btn btn-outline-dark bi bi-clipboard" role="button" data-bs-container="body" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="right" data-bs-content="¡Copiado al Clipboard!" onClick="toClipboard()"> Copiar</a>',
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

function CargarProveedorResume() {
    $.ajax({
        type: "POST",
        url: ruta + '/administracion/doResumeProveedor',
        dataType: "json",
        contentType: "application/json; charset=utf-8",
    }).done(function (lista) {
        if (lista[0]['Total'] == '0') {
            id("Resumen").classList.add('d-none');
            id("TitleResumen").classList.remove('d-none');
        } else {
            id("Resumen").classList.remove('d-none');
            id("TitleResumen").classList.add('d-none');
            $("#TotalResumeProveedores").html(lista[0]['Total']);
            $("#LastResumeProveedores").html(lista[0]['last']);
            $("#StarResumeProveedores").html(lista[0]['pepe']);
            $("#ActiveResumeProveedores").html(lista[0]['Activo %'] + '%');
            $("#InactiveResumeProveedores").html(lista[0]['Inactivo %'] + '%');
            $("#ActiveResumeProveedores").css("width", lista[0]['Activo %'] + '%');
            $("#InactiveResumeProveedores").css("width", lista[0]['Inactivo %'] + '%');
        }
    });
}

