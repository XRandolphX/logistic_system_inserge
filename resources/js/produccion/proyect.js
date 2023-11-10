var identificador;

$(document).ready(function () {
  CargarModulosResume();
  $("#frmUpdateProyect").hide();
  CargarTablaProyect();
  $("#frmRegProyect").submit(function () {
    var formData = new FormData($("#frmRegProyect")[0]);
    $.ajax({
      url: ruta + "/proyectos/doSaveProyect",
      type: "post",
      data: formData,
      dataType: "json",
      cache: false,
      contentType: false,
      processData: false,
      success: function (data) {
        if (data.error == "") {
          $("#frmRegProyect")[0].reset();
          CargarTablaProyect();
          CargarModulosResume();
        }
        showMenssage(data);
      },
    });
    return false;
  });
  $("#frmConsultaProyect").submit(function () {
    var formData = new FormData($("#frmConsultaProyect")[0]);
    $.ajax({
      url: ruta + "/proyectos/doSearchProyect",
      type: "post",
      data: formData,
      dataType: "json",
      cache: false,
      contentType: false,
      processData: false,
      success: function (data) {
        if (data.length == 0) {
          $("#frmConsultaProyect")[0].reset();
        } else {
          CleanEditProyect();
        }
        showResult(data);
      },
    });
    return false;
  });
  $("#frmUpdateProyect").submit(function () {
    var formData = new FormData($("#frmUpdateProyect")[0]);
    formData.append("ID", identificador);
    $.ajax({
      url: ruta + "/proyectos/doUpdateProyect",
      type: "post",
      data: formData,
      dataType: "json",
      cache: false,
      contentType: false,
      processData: false,
      success: function (data) {
        if (data.error == "") {
          $("#frmUpdateProyect")[0].reset();
          CargarTablaProyect();
          CargarModulosResume();
        }
        showMenssage(data);
      },
    });
    return false;
  });
  $("#frmUpFile").submit(function () {
    var formData = new FormData($("#frmUpFile")[0]);
    formData.append("Cdir", carpetita);
    $.ajax({
      url: ruta + "/proyectos/doUpFile",
      type: "post",
      data: formData,
      dataType: "json",
      cache: false,
      contentType: false,
      processData: false,
      success: function (data) {
        $("#frmUpFile")[0].reset();
        CargarModal(carpetita);
      },
    });
    return false;
  });
});

var carpetita;

function CargarModal(carpeta) {
  cadena = "";
  carpetita = carpeta;
  $.ajax({
    url: ruta + "/proyectos/doOpenDirProyect",
    type: "post",
    data: {
      Cdir: carpeta,
    },
    dataType: "json",
    success: function (data) {
      if (data["Length"] > 0) {
        for (let i = 1; i <= data["Length"]; i++) {
          if (data[i]["Bool"] == 1) {
            cadena +=
              '<div class="py-2 d-flex mh-75">' +
              data[i]["Icon"] +
              "<p onclick=\"CargarModal('" +
              carpeta +
              "/" +
              data[i]["Elemento"] +
              '\')" class="px-2 my-2"> ' +
              data[i]["Elemento"] +
              "</p>" +
              "</div>";
          } else {
            Botones =
              '<ul class="ml-auto navbar-nav"> <li li class="nav-item dropdown" > <a class="nav-link" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></a><ul class="dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="navbarDropdown">' +
              '<li><a class="dropdown-item" onclick="EliminarArchivo(' +
              "'" +
              carpeta +
              "', " +
              "'" +
              carpeta +
              "/" +
              data[i]["Elemento"] +
              "')\">Eliminar</a></li>" +
              "</ul></li></ul> ";
            cadena +=
              '<div class="py-2 d-flex">' +
              data[i]["Icon"] +
              '<p class="px-2 my-2"> ' +
              data[i]["Elemento"] +
              "</p>" +
              Botones +
              "</div>";
          }
        }
        $("#ModalBody").html(cadena);
        $("#UrlModal").val(data["URL"]);
      } else {
        $("#ModalBody").html("No hay informacion disponible en esta carpeta.");
      }
    },
  });
}

function EliminarArchivo(carpeta, file) {
  $.ajax({
    url: ruta + "/proyectos/doDropFile",
    type: "post",
    data: {
      Cdir: file,
    },
    dataType: "json",
    success: function (data) {
      CargarModal(carpeta);
    },
  });
}

function DescargarArchivo(carpeta, file) {
  $.ajax({
    url: ruta + "/proyectos/doDownFile",
    type: "post",
    data: {
      Cdir: file,
    },
    dataType: "json",
    success: function (data) {
      console.log(data);
      CargarModal(carpeta);
    },
  });
}

function CargarTablaProyect() {
  $("#tablaProyects").DataTable().destroy();
  $.ajax({
    type: "POST",
    url: ruta + "/proyectos/doListProyect",
    dataType: "json",
    contentType: "application/json; charset=utf-8",
  }).done(function (lista) {
    $("#tablaProyects").DataTable({
      data: lista,
      language: {
        url: "https://cdn.datatables.net/plug-ins/1.12.0/i18n/es-ES.json",
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
      aaSorting: [],
      columns: [
        {
          data: "v6",
          defaultContent: "",
          className: "",
          orderable: false,
          render: function (data, type, row) {
            switch (data) {
              case "E":
                return '<i class="bi bi-square-fill text-success"></i> Elegible';
                break;
              case "N":
                return '<i class="bi bi-square-fill text-danger"></i> No Elegible';
                break;
              case "D":
                return '<i class="bi bi-square-fill text-secondary"></i> Desembolsado';
                break;
              case "C":
                return '<i class="bi bi-square-fill text-warning"></i> Con Otra E.T.';
                break;
              default:
                return '<i class="bi bi-square-fill text-danger"></i> No Elegible';
                break;
            }
          },
        },
        { data: "v1" },
        { data: "v5", className: "none" },
        { data: "v3" },
        { data: "v4" },
        { data: "v2" },
        {
          data: "v7",
          className: "none",
        },
        {
          data: "v8",
          className: "none",
        },
        {
          data: "v9",
          className: "none",
        },
        {
          data: "v10",
          className: "none",
        },
        {
          data: "v11",
          className: "none",
        },
        {
          data: "v12",
          className: "none",
        },
        {
          data: "v13",
          className: "none",
        },
        {
          data: "v14",
          className: "none",
        },
        {
          data: "v15",
          className: "none",
          render: function (data, type, row) {
            return data + " m²";
          },
        },
        {
          data: "v16",
          className: "none",
        },
        {
          data: "v17",
          className: "none",
          render: function (data, type, row) {
            return data + " m²";
          },
        },

        {
          data: "v18",
          className: "none",
        },
        {
          data: "v19",
          className: "none",
          render: function (data, type, row) {
            return data + " m²";
          },
        },
        {
          data: "v20",
          className: "none",
        },
        {
          data: "v21",
          className: "none",
          render: function (data, type, row) {
            return data + " m²";
          },
        },
        {
          data: "v22",
          className: "none",
          render: function (data, type, row) {
            return data + " m²";
          },
        },
        {
          data: "v23",
          className: "none",
        },
        {
          data: "v24",
          className: "none",
        },
        {
          data: "v25",
          className: "none",
          render: function (data, type, row) {
            return " S/. " + data;
          },
        },
        {
          data: "v27",
          className: "none",
        },
        {
          data: "v28",
          className: "none",
        },
        {
          data: "v29",
          className: "none",
        },
        {
          data: "v30",
          className: "none",
        },
        {
          data: "v31",
          className: "none",
        },
        {
          data: "v32",
          className: "none",
        },
        {
          data: "v33",
          className: "none",
        },
        {
          data: "v34",
          className: "none",
          render: function (data, type, row) {
            if (data == "0") return "Inactivo";
            else return "Activo";
          },
        },
        {
          data: "v35",
          className: "none",
          render: function (data, type, row) {
            if (data == "0") return "Inactivo";
            else return "Activo";
          },
        },
        {
          data: "v36",
          className: "none",
          render: function (data, type, row) {
            if (data == "0") return "Inactivo";
            else return "Activo";
          },
        },
        {
          data: "v37",
          className: "none",
          render: function (data, type, row) {
            if (data == "0") return "Inactivo";
            else return "Activo";
          },
        },
        {
          data: "v39",
          className: "none",
        },
        {
          data: "v40",
          className: "none",
        },
        {
          data: "v38",
          className: "none",
          orderable: false,
          render: function (data, type, row) {
            return (
              '<button type="button" onClick="CargarModal(' +
              "'" +
              data +
              "'" +
              ')" class="btn btn-outline" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="bi bi-folder-fill text-warning"></i> Carpeta de Proyecto</button>'
            );
          },
        },
        {
          data: null,
          className: "none",
          orderable: false,
          render: function (data, type, row) {
            return (
              '<a type="button" class="btn btn-outline" role="button" href="https://www.google.com/maps/search/?api=1&query=' +
              row["v27"] +
              "%2C" +
              row["v28"] +
              '" target="_blank"> <i class="bi bi-geo-alt-fill text-danger"></i> Ubicación</a>'
            );
          },
        },
      ],
      select: false,
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
    },
  });
  if (data.error == "") {
    Toast.fire({
      title:
        '<i class="bi bi-check-lg"></i> ¡Los datos han sido registrados con éxito!',
    });
  } else {
    console.log(data.error.length);
    if (data.error.length > 1100) {
      data.error =
        "¡Muchos campos no han sido completados correctamente! Consulta a soporte si no es el caso.";
    }
    Toast.fire({
      title: '<i class="bi bi-exclamation-triangle"></i> ¡Error al registrar!',
      html: data.error,
    });
  }
}

function showResult(data) {
  const Toast = Swal.mixin({
    toast: true,
    position: "bottom-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener("mouseenter", Swal.stopTimer);
      toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
  });
  if (data.length == 0) {
    Toast.fire({
      title:
        '<i class="bi text-danger bi-exclamation-triangle"> ¡No se encontro un resultado semejante!</i> ',
    });
  } else {
    if (data.length == null) {
      Toast.fire({
        title:
          '<i class="bi text-danger bi-exclamation-triangle"> </i> ¡Completa los campos!',
        html: data.error,
      });
    } else {
      Toast.fire({
        title:
          '<i class="bi text-success bi-check-lg"></i> ¡Semejanza encontrada!',
        html: "Semejanza con el proyecto: " + data[0]["v2"],
      });
      id("editcodigo_beneficiario").value = data[0]["v1"];
      id("editcontrato_beneficiario").value = data[0]["v2"];
      id("editPerson_beneficiario").value = data[0]["v4"];
      $("#editestado_beneficario").val(data[0]["v6"]);
      $("#editestado_beneficario").change();
      $("#SelectModule2").val(data[0]["v7"]);
      $("#SelectModule2").change();
      id("editSector").value = data[0]["v8"];
      $("#editTipoUrb").val(data[0]["v9"]);
      $("#editTipoUrb").change();
      id("editDireccion_proyecto").value = data[0]["v11"];
      id("editManz").value = data[0]["v12"];
      id("editLote").value = data[0]["v13"];
      id("editFrente").value = data[0]["v14"];
      id("editFrenteM").value = data[0]["v15"];
      id("editDerecha").value = data[0]["v16"];
      id("editDerechaM").value = data[0]["v17"];
      id("editIzquierda").value = data[0]["v18"];
      id("editIzquierdaM").value = data[0]["v19"];
      id("editFondo").value = data[0]["v20"];
      id("editFondoM").value = data[0]["v21"];
      id("editArea").value = data[0]["v22"];
      id("editArancel").value = data[0]["v23"];
      id("editCVU").value = data[0]["v24"];
      id("editVObra").value = data[0]["v25"];
      id("editCoorX").value = data[0]["v27"];
      id("editCoorY").value = data[0]["v28"];
      id("editFecha").value = data[0]["v33"];
      if (data[0]["v34"] == "1") {
        id("editLuz").checked = true;
      } else {
        id("editLuz").checked = false;
      }
      if (data[0]["v35"] == "1") {
        id("editAgua").checked = true;
      } else {
        id("editAgua").checked = false;
      }
      if (data[0]["v36"] == "1") {
        id("editDesage").checked = true;
      } else {
        id("editDesage").checked = false;
      }
      if (data[0]["v37"] == "1") {
        id("editSeptico").checked = true;
      } else {
        id("editSeptico").checked = false;
      }
      identificador = data[0]["v39"];
      CalcularPerimetro2();
      CalcularPresupuesto2();
      $("#frmUpdateProyect").show();
    }
  }
}

function CargarModulosResume() {
  $.ajax({
    type: "POST",
    url: ruta + "/proyectos/doResumeProyect",
    dataType: "json",
    contentType: "application/json; charset=utf-8",
  }).done(function (lista) {
    if (lista[0]["Total"] == "0") {
      id("Resumen").classList.add("d-none");
      id("TitleResumen").classList.remove("d-none");
    } else {
      id("Resumen").classList.remove("d-none");
      id("TitleResumen").classList.add("d-none");
      $("#last").html(lista[0]["last"]);
      $("#lastConv").html(lista[0]["lastConv"]);
      $("#EL").html(lista[0]["EL %"] + "%");
      $("#NE").html(lista[0]["NE %"] + "%");
      $("#DE").html(lista[0]["DE %"] + "%");
      $("#CN").html(lista[0]["CN %"] + "%");
      $("#EL").css("width", lista[0]["EL %"] + "%");
      $("#NE").css("width", lista[0]["NE %"] + "%");
      $("#DE").css("width", lista[0]["DE %"] + "%");
      $("#CN").css("width", lista[0]["CN %"] + "%");
    }
  });
}

function Clean() {
  const inputs = document.querySelectorAll(
    "#codigo_beneficiario, #codigo_beneficiario, #SelectConvocatoria, #tipoUrb, #direccion_proyecto, #Manz, #Lote, #Frente, #FrenteM, #Area, #Arancel, #CVU, #Derecha, #DerechaM, #Perimetro, #VObra, #Presupuesto, #Izquierda, #IzquierdaM, #SelectModule, #CoorX, #CoorY, #Fondo, #FondoM, #estado_beneficario, #Luz, #Agua, #Desage, #Septico, #SelectPerson, #fecha"
  );
  inputs.forEach((input) => {
    input.value = "";
  });
}

function CalcularPerimetro() {
  var Frente = 0;
  var Derecha = 0;
  var Izquierda = 0;
  var Fondo = 0;
  if (
    !Number.isNaN(id("FrenteM").value) &&
    id("FrenteM").value != null &&
    id("FrenteM").value != ""
  ) {
    Frente = parseFloat(id("FrenteM").value);
  } else {
    Frente = 0;
  }
  if (
    !Number.isNaN(id("DerechaM").value) &&
    id("DerechaM").value != null &&
    id("DerechaM").value != ""
  ) {
    Derecha = parseFloat(id("DerechaM").value);
  } else {
    Derecha = 0;
  }
  if (
    !Number.isNaN(id("IzquierdaM").value) &&
    id("IzquierdaM").value != null &&
    id("IzquierdaM").value != ""
  ) {
    Izquierda = parseFloat(id("IzquierdaM").value);
  } else {
    Izquierda = 0;
  }
  if (
    !Number.isNaN(id("FondoM").value) &&
    id("FondoM").value != null &&
    id("FondoM").value != ""
  ) {
    Fondo = parseFloat(id("FondoM").value);
  } else {
    Fondo = 0;
  }
  console.log("Frente> " + Frente);
  console.log("Derecha> " + Derecha);
  console.log("Izquierda> " + Izquierda);
  console.log("Fondo> " + Fondo);
  console.log("Perimetro> " + Frente + Derecha + Izquierda + Fondo);
  id("Perimetro").value = Frente + Derecha + Izquierda + Fondo;
}

function CalcularPresupuesto() {
  var Area = 0;
  var CVUs = 0;
  if (
    !Number.isNaN(id("Area").value) &&
    id("Area").value != null &&
    id("Area").value != ""
  ) {
    Area = parseFloat(id("Area").value);
  } else {
    Area = 0;
  }
  if (
    !Number.isNaN(id("CVU").value) &&
    id("CVU").value != null &&
    id("CVU").value != ""
  ) {
    CVUs = parseFloat(id("CVU").value);
  } else {
    CVUs = 0;
  }
  console.log("Frente> " + Area);
  console.log("Derecha> " + CVUs);
  console.log("Presupuesto> " + Area + CVUs);
  id("Presupuesto").value = Area * CVUs;
}

function CalcularPerimetro2() {
  var Frente = 0;
  var Derecha = 0;
  var Izquierda = 0;
  var Fondo = 0;
  if (
    !Number.isNaN(id("editFrenteM").value) &&
    id("editFrenteM").value != null &&
    id("editFrenteM").value != ""
  ) {
    Frente = parseFloat(id("editFrenteM").value);
  } else {
    Frente = 0;
  }
  if (
    !Number.isNaN(id("editDerechaM").value) &&
    id("editDerechaM").value != null &&
    id("editDerechaM").value != ""
  ) {
    Derecha = parseFloat(id("editDerechaM").value);
  } else {
    Derecha = 0;
  }
  if (
    !Number.isNaN(id("editIzquierdaM").value) &&
    id("editIzquierdaM").value != null &&
    id("editIzquierdaM").value != ""
  ) {
    Izquierda = parseFloat(id("editIzquierdaM").value);
  } else {
    Izquierda = 0;
  }
  if (
    !Number.isNaN(id("editFondoM").value) &&
    id("editFondoM").value != null &&
    id("editFondoM").value != ""
  ) {
    Fondo = parseFloat(id("editFondoM").value);
  } else {
    Fondo = 0;
  }
  console.log("Frente> " + Frente);
  console.log("Derecha> " + Derecha);
  console.log("Izquierda> " + Izquierda);
  console.log("Fondo> " + Fondo);
  console.log("Perimetro> " + Frente + Derecha + Izquierda + Fondo);
  id("editPerimetro").value = Frente + Derecha + Izquierda + Fondo;
}

function CalcularPresupuesto2() {
  var Area = 0;
  var CVUs = 0;
  if (
    !Number.isNaN(id("editArea").value) &&
    id("editArea").value != null &&
    id("editArea").value != ""
  ) {
    Area = parseFloat(id("editArea").value);
  } else {
    Area = 0;
  }
  if (
    !Number.isNaN(id("editCVU").value) &&
    id("editCVU").value != null &&
    id("editCVU").value != ""
  ) {
    CVUs = parseFloat(id("editCVU").value);
  } else {
    CVUs = 0;
  }
  console.log("Frente> " + Area);
  console.log("Derecha> " + CVUs);
  console.log("Presupuesto> " + Area + CVUs);
  id("editPresupuesto").value = Area * CVUs;
}

function CleanEditProyect() {
  id("editBuscador").value = null;
  id("editcodigo_beneficiario").value = null;
  id("editcontrato_beneficiario").value = null;
  id("editPerson_beneficiario").value = null;
  $("#editestado_beneficario").val("-1");
  $("#editestado_beneficario").change();
  $("#SelectModule2").val("");
  $("#SelectModule2").change();
  id("editSector").value = null;
  $("#editTipoUrb").val("1");
  $("#editTipoUrb").change();
  id("editDireccion_proyecto").value = null;
  id("editManz").value = null;
  id("editLote").value = null;
  id("editFrente").value = null;
  id("editFrenteM").value = null;
  id("editDerecha").value = null;
  id("editDerechaM").value = null;
  id("editIzquierda").value = null;
  id("editIzquierdaM").value = null;
  id("editFondo").value = null;
  id("editFondoM").value = null;
  id("editArea").value = null;
  id("editArancel").value = null;
  id("editCVU").value = null;
  id("editVObra").value = null;
  id("editCoorX").value = null;
  id("editCoorY").value = null;
  id("editFecha").value = null;
  id("editLuz").checked = false;
  id("editDesage").checked = false;
  id("editAgua").checked = false;
  id("editSeptico").checked = false;
  $("#frmUpdateProyect").hide();
}
