$(document).ready(function () {
  // Cargamos las tablas
  CargarTablaMedidas();
  // Cargamos los Resumens

  // Cargamos los formularios
  CargarFormulariosMedida();
  // Cargamos otros
});

function CargarFormulariosMedida() {
  $("#frmregMedidas").submit(function () {
    var formData = new FormData($("#frmregMedidas")[0]);
    $.ajax({
      url: ruta + "/administracion/doSaveMedida",
      type: "post",
      select: {
        items: "cell",
        info: false,
      },
      dataType: "json",
      cache: false,
      contentType: false,
      processData: false,
      data: formData,
      success: function (data) {
        if (data.error == "") {
          $("#frmregMedidas")[0].reset();
          CargarTablaMedidas();
        }
        showMenssage(data);
      },
    });
    return false;
  });

  $("#frmeditMedidas").submit(function () {
    var formData = new FormData($("#frmeditMedidas")[0]);
    $.ajax({
      url: ruta + "/administracion/doUpdateMedida",
      type: "post",
      select: {
        items: "cell",
        info: false,
      },
      dataType: "json",
      cache: false,
      contentType: false,
      processData: false,
      data: formData,
      success: function (data) {
        console.log(data);
        if (data.error == "") {
          $("#frmeditMedidas")[0].reset();
          CargarTablaMedidas();
          bootstrap.Modal.getInstance(id("exampleModal")).hide();
        }
        showMenssage(data);
      },
    });
    return false;
  });
}

function Clean() {
  var inputs, index;
  inputs = document.getElementsByTagName("input");
  console.log(inputs);
  for (index = 0; index < inputs.length; ++index) {
    $(inputs[index]).val("");
  }
}

function SendToModalMedida() {
  $("#exampleModal").modal("show");
  id("id").value = GlobalData["v1"];
  id("editUnid").value = GlobalData["v2"];
  id("editPlr").value = GlobalData["v3"];
  id("editSimb").value = GlobalData["v4"];
  $("#estado_modal").val(GlobalData["v8"]);
  $("#estado_modal").change();
}

// Copiar al Portapapeles
function toClipboard() {
  GlobalData["vString"] =
  "Unidad de Medida: "+ "\t" + GlobalData["v2"] + "\n" +
  "Plural de Medida: "+ "\t" +  GlobalData["v3"] + "\n" +
  "Simbolo: "+ "\t" +  GlobalData["v4"] + "\n" +
  "Estado: "+ "\t" +  GlobalData["v9"];
  navigator.clipboard.writeText(GlobalData["vString"]);
}

// Llamado por medio de Ajax a Controlador para insertar en Tablas.
function CargarTablaMedidas() {
  $("#Table_Unidad").DataTable().destroy();
  $.ajax({
    type: "POST",
    url: ruta + "/administracion/doListMedida",
    dataType: "json",
    contentType: "application/json; charset=utf-8",
  }).done(function (lista) {
    $("#Table_Unidad").DataTable({
      data: lista.datos,
      // Traduce al todo al español
      language: {
        url: "https://cdn.datatables.net/plug-ins/1.12.0/i18n/es-ES.json",
      },
      dom: "<'row'<'col-md-6'B><'col-sm-6 my-auto'f>>rt<'row'<'col-md-6'><'col-sm-6 my-auto'p>>",
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
          type: "column",
          target: "tr",
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              GlobalData = row.data();
              return "Detalles de " + data["v2"];
            },
          }),
          renderer: $.fn.dataTable.Responsive.renderer.tableAll(),
        },
      },
      paging: true,
      columns: [
        { data: "v2" },
        {
          data: "v9",
          width: "15%",
          className: "text-center",
          render: function (data, type, row) {
            if (data == "Activo") {
              return '<i class="text-success bi bi-square-fill"></i> Activo';
            } else {
              return '<i class="text-danger bi bi-square-fill"></i> Inactivo';
            }
          },
        },
        { data: "v3" },
        { data: "v4" },
        {
          data: "v5",
          className: "none",
        },
        {
          data: "v7",
          className: "none",
        },
        {
          data: null,
          defaultContent:
            '<div class="text-black text-end"><button data-bs-dismiss="modal" id="Edit_row" onClick="SendToModalMedida()" class="btn btn-outline-primary bi bi-pencil mr-2"> Editar </button><a tabindex="0" class="btn btn-outline-dark bi bi-clipboard" role="button" data-bs-container="body" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="right" data-bs-content="¡Copiado al Clipboard!" onClick="toClipboard()"> Copiar</a>',
          className: "text-white none",
          orderable: false,
        },
      ],
      select: false,
      search: {
        return: true,
      },
    });
  });
}
