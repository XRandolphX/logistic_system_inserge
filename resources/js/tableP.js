$(document).ready(function () {
  $("#Table_usuario_resumen").DataTable({
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.12.0/i18n/es-ES.json",
    },
    //Para los botones
    responsive: true,
    dom: "frtilp",
  });

  //----------------------------------------------------------//

  $("#Table_Proveedor_Resume").DataTable({
    sPaginationType: "full_numbers",
    bProcessing: true,
    bAutoWidth: false,
    // Traduce al todo al español
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.12.0/i18n/es-ES.json",
    },

    // Activa el modo responsive
    responsive: true,

    /* Leyenda de DOM
      B = Botones de Conversion a Archivo.
      Q = Filtro por condicional.
      f = Busqueda.
      t = Tabla.
      r = Mensaje de proceso.
      i = Mensaje de Información.
      l = Tamaño de tabla
      p = Paginación.
    */

    dom:
      '<"d-grid gap-2 d-md-flex justify-content-md-end"B>' +
      '<"d-grid gap-2 d-md-flex justify-content-md"f>rti<lp>',

    // Botones funcionales
    buttons: [
      {
        extend: "excelHtml5",
        text: '<i class="fas fa-file-excel"></i>  Excel',
        titleAttr: "Exportal a excel",
        className: "btn btn-success",
      },
      {
        extend: "pdfHtml5",
        text: '<i class="fas fa-file-pdf">pdf</i> Pdf',
        titleAttr: "Exportal a pdf",
        className: "btn btn-danger",
      },
      {
        extend: "print",
        text: '<i class="fas fa-print">imprimir</i> Imprimir',
        titleAttr: "Imprimir",
        className: "btn btn-info",
      },
    ],
  });
});

$("#Table_Modulos").DataTable({
  sPaginationType: "full_numbers",
  bProcessing: true,
  bAutoWidth: false,
  // Traduce al todo al español
  language: {
    url: "https://cdn.datatables.net/plug-ins/1.12.0/i18n/es-ES.json",
  },

  // Activa el modo responsive
  responsive: true,

  /* Leyenda de DOM
    B = Botones de Conversion a Archivo.
    Q = Filtro por condicional.
    f = Busqueda.
    t = Tabla.
    r = Mensaje de proceso.
    i = Mensaje de Información.
    l = Tamaño de tabla
    p = Paginación.
  */

  dom:
    '<"d-grid gap-2 d-md-flex justify-content-md-end"B>' +
    '<"d-grid gap-2 d-md-flex justify-content-md"f>rti<lp>',

  // Botones funcionales
  buttons: [
    {
      extend: "excelHtml5",
      text: '<i class="fas fa-file-excel"></i>  Excel',
      titleAttr: "Exportal a excel",
      className: "btn btn-success",
    },
    {
      extend: "pdfHtml5",
      text: '<i class="fas fa-file-pdf">pdf</i> Pdf',
      titleAttr: "Exportal a pdf",
      className: "btn btn-danger",
    },
    {
      extend: "print",
      text: '<i class="fas fa-print">imprimir</i> Imprimir',
      titleAttr: "Imprimir",
      className: "btn btn-info",
    },
  ],
});

function cargarUsuario() {
  $("#Table_usuario_resumen").DataTable().destroy();
  $.ajax({
    type: "POST",
    url: ruta + "/UsuarioControlador/doListUsuario",
    dataType: "json",
    contentType: "application/json; charset=utf-8",
  }).done(function (lista) {
    $("#Table_usuario_resumen").DataTable({
      data: lista.datos,
      // Traduce al todo al español
      language: {
        url: "https://cdn.datatables.net/plug-ins/1.12.0/i18n/es-ES.json",
      },
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
        { data: "v3" },
        {
          data: "v7",
          render: function (data, type, row) {
            if (data == "1") {
              return '<i class="text-success bi bi-square-fill">Activo</i>';
            } else {
              return '<i class="text-danger bi bi-square-fill">Inactivo</i>';
            }
          },
        },
        { data: "v5" },
        { data: "v8" },
      ],
      select: false,
      search: {
        return: true,
      },
    });
  });
}
