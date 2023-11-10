$(document).ready(function () {
    CargarTablaProductos();
    CargarTablaProductosDRP();
    CargarTablaProductosIST();
    ComboMaterial("#SelectMateriales", "#SelectMotivo", "#Descrip", "#Stock", "#Cantidad", "#SelectProveedor2", "#Fllegada", "#Hllegada", "#Obs");
    ComboMaterial("#SelectMateriales2", "#SelectMotivo2", "#Descrip2", "#Stock2", "#Cantidad2", "#SelectProveedor3", "#Fllegada2", "#Hllegada2", "#Obs2");
    $("#frmregProducto").submit(function () {
        var formData = new FormData($("#frmregProducto")[0]);
        $.ajax({
            url: ruta + "/produccion/doSaveProducto",
            type: "post",
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.error == "") {
                    $('#frmregProducto')[0].reset();
                    CargarTablaProductos();
                    ComboMaterial("#SelectMateriales", "#SelectMotivo", "#Descrip", "#Stock", "#Cantidad", "#SelectProveedor2", "#Fllegada", "#Hllegada", "#Obs");
                    ComboMaterial("#SelectMateriales2", "#SelectMotivo2", "#Descrip2", "#Stock2", "#Cantidad2", "#SelectProveedor3", "#Fllegada2", "#Hllegada2", "#Obs2");
                }
                showMenssage(data);
            },
        });
        return false;
    });
    $("#frmnewProducto").submit(function () {
        var formData = new FormData($("#frmnewProducto")[0]);
        $.ajax({
            url: ruta + "/produccion/doSaveProductoDetalleINS",
            type: "post",
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.error == "") {
                    $('#frmnewProducto')[0].reset();
                    CargarTablaProductos();
                    CargarTablaProductosIST();
                    ComboMaterial("#SelectMateriales", "#SelectMotivo", "#Descrip", "#Stock", "#Cantidad", "#SelectProveedor2", "#Fllegada", "#Hllegada", "#Obs");
                    ComboMaterial("#SelectMateriales2", "#SelectMotivo2", "#Descrip2", "#Stock2", "#Cantidad2", "#SelectProveedor3", "#Fllegada2", "#Hllegada2", "#Obs2");
                }
                showMenssage(data);
            },
        });
        return false;
    });
    $("#frmdropProducto").submit(function () {
        var formData = new FormData($("#frmdropProducto")[0]);
        $.ajax({
            url: ruta + "/produccion/doSaveProductoDetalleDROP",
            type: "post",
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.error == "") {
                    $('#frmdropProducto')[0].reset();
                    CargarTablaProductos();
                    CargarTablaProductosDRP();
                    ComboMaterial("#SelectMateriales", "#SelectMotivo", "#Descrip", "#Stock", "#Cantidad", "#SelectProveedor2", "#Fllegada", "#Hllegada", "#Obs");
                    ComboMaterial("#SelectMateriales2", "#SelectMotivo2", "#Descrip2", "#Stock2", "#Cantidad2", "#SelectProveedor3", "#Fllegada2", "#Hllegada2", "#Obs2");
                }
                showMenssage(data);
            },
        });
        return false;
    });
});

var GlobalDataMaterial = Array();

function ComboMaterial(idSelectUI, Motivo, Descrip, Stock, Cantidad, Proveedor, FLlega, HLlega, Observ) {
    $(idSelectUI).change(function () {
        var idprovincia = $(idSelectUI).val();
        if (idprovincia == '') {
            $(Motivo).val('');
            $(Descrip).val('');
            $(Stock).val('');
            $(Cantidad).attr("readonly", true);
            $(Proveedor).attr("disabled", true);
            $(FLlega).attr("readonly", true);
            $(HLlega).attr("readonly", true);
            $(Motivo).attr("disabled", true);
            $(Proveedor).val('');
            $(Observ).attr("readonly", true);
        } else if (GlobalDataMaterial.length > 0) {
            for (var i = 0; i < GlobalDataMaterial.length; i++) {
                if (GlobalDataMaterial[i]['v1'] == idprovincia) {
                    $(Cantidad).attr("readonly", false);
                    $(Observ).attr("readonly", false);
                    $(FLlega).attr("readonly", false);
                    $(Proveedor).attr("disabled", false);
                    $(Motivo).attr("disabled", false);
                    $(HLlega).attr("readonly", false);
                    $(Descrip).val(GlobalDataMaterial[i]['v3']);
                    $(Stock).val(GlobalDataMaterial[i]['v4']);
                    $(Proveedor).val(GlobalDataMaterial[i]['v5']);
                }
            }
        }
    });
    $.ajax({
        url: ruta + '/produccion/doComboProducto',
        type: 'POST',
        dataType: "json",
        contentType: "application/json; charset=utf-8"
    }).done(function (resp) {
        var data = resp.datos;
        GlobalDataMaterial = data;
        var cadena = "<option value=''>Selecciona</option>";
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i]['v1'] + "'>" + data[i]['v2'] + "</option>";
            }
        } else {
            cadena += "<option value=''>'Sin información'</option>";
        }
        $(idSelectUI).html(cadena);
    })
}

function CargarTablaProductos() {
    $('#Tabla_products').DataTable().destroy();
    $.ajax({
        type: "POST",
        url: ruta + '/produccion/doListProducto',
        dataType: "json",
        contentType: "application/json; charset=utf-8",
    }).done(function (lista) {
        $('#Tabla_products').DataTable({
            data: lista.datos,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.12.0/i18n/es-ES.json"
            },
            dom: "<'row'<'col-md-6'B><'col-sm-6 my-auto'f>>rt<'row'<'col-sm-6 d-none d-sm-inline'l><'col-sm-6'p>>",
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
                    data: "v1",
                    defaultContent: "",
                    className: "",
                    orderable: false,
                },
                {
                    data: 'v5',
                    width: "10%",
                    render: function (data, type, row) {
                        if (data == 'Activo') {
                            return '<i class="text-success bi bi-square-fill"></i> Activo';
                        } else {
                            return '<i class="text-danger bi bi-square-fill"></i> ' + data;
                        }
                    }
                },
                { data: "v2" },
                { data: "v4" },
                { data: "v6" },
                {
                    data: "v7",
                    className: 'none'
                },
                { data: "v8" },
                {
                    data: "v9",
                    className: 'none'
                },
                { data: "v11" },
                {
                    data: "v12",
                    className: 'none'
                },
                {
                    data: "v14",
                    className: 'none'
                }
            ],
            select: false,
            search: {
                return: true,
            }
        });
    });
}

function CargarTablaProductosDRP() {
    $('#Tabla_products_drop').DataTable().destroy();
    $.ajax({
        type: "POST",
        url: ruta + '/produccion/doListProductoDROP',
        dataType: "json",
        contentType: "application/json; charset=utf-8",
    }).done(function (lista) {
        $('#Tabla_products_drop').DataTable({
            data: lista.datos,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.12.0/i18n/es-ES.json"
            },
            dom: "rt<'row'<'text-end'B>>",
            buttons: [
                {
                    extend: "print",
                    text: '<i class="fas fa-print"></i> Imprimir',
                    titleAttr: "Imprimir",
                    className: "btn btn-info p-2",
                },
            ],
            responsive: {
                details: {
                    type: 'column',
                    target: 'tr',
                    renderer: $.fn.dataTable.Responsive.renderer.tableAll()
                    /*
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            GlobalData = row.data();
                            return 'Detalles de ' + data['v2'];
                        }
                    }),
                    ,
                */}
            },
            paging: true,
            aaSorting: [],
            columns: [
                {
                    data: "v2",
                    defaultContent: "",
                    className: "",
                    orderable: false,
                },
                { data: 'v5' },
                { data: 'v6' },
                {
                    data: "v3",
                    className: 'none',
                    render: function (data, type, row) {
                        if (data == '') {
                            return 'Sin observaciones';
                        } else {
                            return data;
                        }
                    }
                },
                {
                    data: "v7",
                    className: 'none'
                },
                {
                    data: "v8",
                    className: 'none'
                },
                {
                    data: "v10",
                    className: 'none'
                },
                {
                    data: "v11",
                    className: 'none'
                },
                {
                    data: "v13",
                    className: 'none'
                }
            ],
            select: false,
            search: {
                return: true,
            }
        });
    });
}

function CargarTablaProductosIST() {
    $('#Tabla_products_insert').DataTable().destroy();
    $.ajax({
        type: "POST",
        url: ruta + '/produccion/doListProductoINST',
        dataType: "json",
        contentType: "application/json; charset=utf-8",
    }).done(function (lista) {
        $('#Tabla_products_insert').DataTable({
            data: lista.datos,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.12.0/i18n/es-ES.json"
            },
            dom: "rt<'row'<'text-end'B>>",
            buttons: [
                {
                    extend: "print",
                    text: '<i class="fas fa-print"></i> Imprimir',
                    titleAttr: "Imprimir",
                    className: "btn btn-info p-2",
                },
            ],
            responsive: {
                details: {
                    type: 'column',
                    target: 'tr',
                    renderer: $.fn.dataTable.Responsive.renderer.tableAll()
                }
            },
            paging: true,
            aaSorting: [],
            columns: [
                {
                    data: "v2",
                    defaultContent: "",
                    className: "",
                    orderable: false,
                },
                { data: 'v5' },
                { data: 'v6' },
                {
                    data: "v3",
                    className: 'none',
                    render: function (data, type, row) {
                        if (data == '') {
                            return 'Sin observaciones';
                        } else {
                            return data;
                        }
                    }
                },
                {
                    data: "v7",
                    className: 'none'
                },
                {
                    data: "v8",
                    className: 'none'
                },
                {
                    data: "v10",
                    className: 'none'
                },
                {
                    data: "v11",
                    className: 'none'
                },
                {
                    data: "v13",
                    className: 'none'
                }
            ],
            select: false
        });
    });
}

function showMenssage(data) {
    const Toast = Swal.mixin({
        toast: true,
        position: "bottom-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        }
    });
    if (data.error == "") {
        Toast.fire({
            title: '<i class="bi bi-check-lg"></i> ¡Los datos han sido registrados con éxito!',
        });
    } else {
        Toast.fire({
            title: '<i class="bi bi-exclamation-triangle"></i> ¡Error al registrar!',
            html: data.error,
        });
    }
}

function Clean() {
    var inputs, index;
    inputs = document.getElementsByTagName("input");
    for (index = 0; index < inputs.length; ++index) {
        $(inputs[index]).val("");
    }
    inputs = document.getElementsByTagName("select");
    for (index = 0; index < inputs.length; ++index) {
        $(inputs[index]).val("");
    }
}
