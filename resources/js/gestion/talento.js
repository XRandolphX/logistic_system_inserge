$(document).ready(function () {
    // Cargamos las tablas
    CargarTablaPerson();
    // Cargamos los Resumens
    CargarPersonResume();
    // Cargamos los formularios
    CargarFormulariosPerson();
    // Cargamos otros

});

function CargarFormulariosPerson() {
    $("#frmregPersona").submit(function () {
        var formData = new FormData($('#frmregPersona')[0]);
        $.ajax({
            url: ruta + '/administracion/doSavePerson',
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
                    $('#frmregPersona')[0].reset();
                    CargarTablaPerson();
                    CargarPersonResume();
                }
                showMenssage(data);
            }
        });
        return false;
    });
    $("#frmeditPerson").submit(function () {
        var formData = new FormData($('#frmeditPerson')[0]);
        $.ajax({
            url: ruta + '/administracion/doUpdatePerson',
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
                    $('#frmeditPerson')[0].reset();
                    CargarTablaPerson();
                    CargarPersonResume();
                    bootstrap.Modal.getInstance(id('exampleModal')).hide();
                }
                showMenssage(data);
            }
        });
        return false;
    });
}

function Clean() {
    var inputs, index;
    inputs = document.getElementsByTagName('input');
    console.log(inputs);
    for (index = 0; index < inputs.length; ++index) {
        $(inputs[index]).val('');
    }
}

function SendToModalPerson() {
    $('#exampleModal').modal('show');
    id('id').value = (GlobalData['v1']);
    id('editdni').value = (GlobalData['v2']);
    id('editnombre').value = (GlobalData['v3']);
    id('editapelPAT').value = (GlobalData['v4']);
    id('editapelMAT').value = (GlobalData['v5']);
    id('editDir').value = (GlobalData['v8']);
    id('editCorreo').value = (GlobalData['v12']);
    id('editTel').value = (GlobalData['v11']);
    id('editNacimi').value = (GlobalData['v26']);
    id('editProfe').value = (GlobalData['v13']);
    $("#status_modal").val((GlobalData['v9']));
    $("#status_modal").change();
    $("#sexo_modal").val((GlobalData['v6']));
    $("#sexo_modal").change();
    $("#estado_modal").val((GlobalData['v24']));
    $("#estado_modal").change();
    $("#sel_departamento_modal").val((GlobalData['v20']));
    $("#sel_departamento_modal").change();
    $("#sel_provincia_modal").val((GlobalData['v18']));
    $("#sel_provincia_modal").change();
    $("#sel_distrito_modal").val((GlobalData['v16']));
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
function CargarTablaPerson() {
    $('#Table_Personas').DataTable().destroy();
    $.ajax({
        type: "POST",
        url: ruta + '/administracion/doListPerson',
        dataType: "json",
        contentType: "application/json; charset=utf-8",
    }).done(function (lista) {
        $('#Table_Personas').DataTable({
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
                { data: 'v2' },
                {
                    data: 'v25',
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
                { data: 'v5' },
                {
                    data: 'v7',
                    className: 'none'
                },
                {
                    data: 'v8',
                    className: 'none',
                    render: function (data, type, row) {
                        if (data == '') {
                            return 'No especifica';
                        } else {
                            return data;
                        }
                    }
                },
                {
                    data: 'v11',
                    className: 'none',
                    render: function (data, type, row) {
                        if (data == '' || data == null) {
                            return 'No especifica';
                        } else {
                            return data;
                        }
                    }
                },
                {
                    data: 'v12',
                    className: 'none',
                    render: function (data, type, row) {
                        if (data == '') {
                            return 'No especifica';
                        } else {
                            return data;
                        }
                    }
                },
                {
                    data: 'v13',
                    className: 'none',
                    render: function (data, type, row) {
                        if (data == '') {
                            return 'No especifica';
                        } else {
                            return data;
                        }
                    }
                },
                {
                    data: 'v21',
                    className: 'none'
                },
                {
                    data: 'v19',
                    className: 'none'
                },
                {
                    data: 'v17',
                    className: 'none'
                },
                {
                    data: 'v26',
                    className: 'none',
                    render: function (data, type, row) {
                        if (data == '' || data == null) {
                            return 'No especifica';
                        } else {
                            return data;
                        }
                    }
                },
                {
                    data: 'v23',
                    className: 'none'
                },
                {
                    data: 'v14',
                    className: 'none'
                },
                {
                    data: null,
                    defaultContent: '<div class="text-black text-end"><button data-bs-dismiss="modal" id="Edit_row" onClick="SendToModalPerson()" class="btn btn-outline-primary bi bi-pencil mr-2"> Editar </button><a tabindex="0" class="btn btn-outline-dark bi bi-clipboard" role="button" data-bs-container="body" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="right" data-bs-content="¡Copiado al Clipboard!" onClick="toClipboard()"> Copiar</a>',
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

function CargarPersonResume() {
    $.ajax({
        type: "POST",
        url: ruta + '/administracion/doResumePerson',
        dataType: "json",
        contentType: "application/json; charset=utf-8",
    }).done(function (lista) {
        if (lista[0]['Total'] == '0') {
            id("Resumen").classList.add('d-none');
            id("TitleResumen").classList.remove('d-none');
        } else {
            id("Resumen").classList.remove('d-none');
            id("TitleResumen").classList.add('d-none');
            $("#TotalResumePerson").html(lista[0]['Total']);
            $("#TodayResumePerson").html(lista[0]['Registrados Hoy']);
            $("#CompleteResumePerson").html(lista[0]['Completo %'] + '%');
            $("#IncompleteResumePerson").html(lista[0]['Incompleto %'] + '%');
            $("#CompleteResumePerson").css("width", lista[0]['Completo %'] + '%');
            $("#IncompleteResumePerson").css("width", lista[0]['Incompleto %'] + '%');
            $("#ActiveResumePerson").html(lista[0]['Activo %'] + '%');
            $("#InactiveResumePerson").html(lista[0]['Inactivo %'] + '%');
            $("#ActiveResumePerson").css("width", lista[0]['Activo %'] + '%');
            $("#InactiveResumePerson").css("width", lista[0]['Inactivo %'] + '%');
            $("#AvgEdadResumePerson").html(lista[0]['Edad_Promedio']);
            $("#LastResumePerson").html(lista[0]['last']);
            $("#MResumePerson").html(lista[0]['Masculino %'] + '%');
            $("#FResumePerson").html(lista[0]['Femenino %'] + '%');
            $("#NResumePerson").html(lista[0]['No especifica %'] + '%');
            $("#MResumePerson").css("width", lista[0]['Masculino %'] + '%');
            $("#FResumePerson").css("width", lista[0]['Femenino %'] + '%');
            $("#NResumePerson").css("width", lista[0]['No especifica %'] + '%');
        }
    });
}

