$(document).ready(function () {
  // Cargamos las tablas
  CargarGridEvidencia();
  // Cargamos los Resumens
  CargarEvidenciaResume();
  // Cargamos los formularios
  CargarFormulariosEvidencia();
  // Cargamos otros
});

function Clean() {
  id('editUnid').value = null;
  id('fotitos').value = null;
  id('editNacimi').value = null;
  $("#pax").attr("src", null);
  $('#SelectModule').val(null);
  $('#SelectModule').change();
  $('#SelectPerson').val(null);
  $('#SelectPerson').change();
  $('#SelectMedida').val(null);
  $('#SelectMedida').change();
  $('#SelectConvocatoria').val(null);
  $('#SelectConvocatoria').change();
  $('#SelectCategory').val(null);
  $('#SelectCategory').change();
  $('#SelectProveedor').val(null);
  $('#SelectProveedor').change();
  $('#status_modal').val('1');
  $('#status_modal').change();
}

function CargarFormulariosEvidencia() {
  $("#frmregEvidencia").submit(function () {
    var formData = new FormData($("#frmregEvidencia")[0]);
    $.ajax({
      url: ruta + "/evidencia/doSaveImagen",
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
          $("#frmregEvidencia")[0].reset();
          CargarGridEvidencia();
          CargarEvidenciaResume();
          $("#pax").attr("src", "");
        }
        showMenssage(data);
      },
    });
    return false;
  });
  $("#fotitos").change(function () {
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        selectedImage = e.target.result;
        $("#pax").attr("src", selectedImage);
      };
      reader.readAsDataURL(this.files[0]);
    }
  });
}

function Borrar(Miau) {
  var id = GlobalData[Miau]["v1"];
  var Url = GlobalData[Miau]["v2"];
  $.ajax({
    url: ruta + "/evidencia/doDropImage",
    type: "post",
    dataType: "json",
    data: {
      gatou: id,
      file: Url,
    },
  }).done(function (resp) {
    if (resp.error == "") {
      $("#frmregEvidencia")[0].reset();
      CargarGridEvidencia();
      $("#pax").attr("src", "");
      CargarEvidenciaResume();
    }
    showMenssage(resp);
  });
}

function CargarGridEvidencia() {
  $.ajax({
    url: ruta + "/evidencia/doListImagen",
    type: "POST",
    dataType: "json",
    contentType: "application/json; charset=utf-8",
  }).done(function (resp) {
    var cadena = "";
    if (resp.length > 0) {
      GlobalData = resp;
      for (var i = 0; i < resp.length; i++) {
        var etique = "<ol >";
        var color = "";
        var Tipo = "";
        if (i > 10) {
          break;
        } else {
          switch (resp[i]["v20"]) {
            case "1":
              color = "success";
              Tipo = "Archivo";
              break;
            case "2":
              color = "danger";
              Tipo = "Fotografia";
              break;
            case "3":
              color = "warning";
              Tipo = "Render";
              break;
            case "4":
              color = "info";
              Tipo = "Documentación";
              break;
            case "5":
              color = "primary";
              Tipo = "Perfil";
              break;
            case "0":
              color = "secondary";
              Tipo = "Otros";
              break;
          }
          if (resp[i]["v6"] != null) {
            etique +=
              "<li class='' > <strong>Modulo:</strong> " + resp[i]["v7"] + "</li>";
          }
          if (resp[i]["v8"] != null) {
            etique +=
              "<li class=''> <strong>Persona:</strong> " + resp[i]["v9"] + "</li>";
          }
          if (resp[i]["v10"] != null) {
            etique +=
              "<li class=''> <strong>Proyecto:</strong> " + resp[i]["v11"] + "</li>";
          }
          if (resp[i]["v12"] != null) {
            etique +=
              "<li class=''> <strong>Convocatoria:</strong> " + resp[i]["v13"] + "</li>";
          }
          if (resp[i]["v14"] != null) {
            etique +=
              "<li class=''> <strong>Producto:</strong> " + resp[i]["v15"] + "</li>";
          }
          if (resp[i]["v16"] != null) {
            etique +=
              "<li class=''> <strong>Proveedor:</strong> " + resp[i]["v17"] + "</li>";
          }
          etique += "</ol>";
          cadena +=
            '<div class="card border-1 shadow p-2 border-' + color +
            '"><img id="' + resp[i]["v1"] + '" src="' + ruta + "/resources/files/" +
            resp[i]["v2"] +
            '" class="card-img-top rounded-3 ">' +
            '<div class="card-body">' +
            '<h5 class="card-title fw-bolder">' +
            resp[i]["v3"] +
            "</h5>" +
            '<p class="card-text mb-0"> <strong>Tipo de Imagen: </strong> '+Tipo +
            etique +
            "</p>" +'<p class="card-text">' +
            "<strong>Fecha: </strong>" + resp[i]["v4"] + '</p>' + '<div class="text-end"><small class="text-muted pr-3 fst-italic"> ' + resp[i]["v5"] +
            '</small>' + '<button type="text" class="btn btn-success" onClick="Borrar(' +
            i +
            ')"><i class="bi bi-trash"></i> Borrar</button>' +
            "</div>" +
            "</div>" +
            "</div>";
          console.log(etique);
        }
      }
    } else {
      cadena =
        "<div class='text-secondary'> No hay datos suficientes para cargar el visualizador</div>";
    }

    $("#Pepito").html(cadena);
  });
}

function CargarEvidenciaResume() {
  $.ajax({
    type: "POST",
    url: ruta + "/evidencia/doResumeImage",
    dataType: "json",
  }).done(function (lista) {
    console.log(lista);
    if (lista[0]["Total"] == "0") {
      id("Resumen").classList.add("d-none");
      id("TitleResumen").classList.remove("d-none");
    } else {
      id("Resumen").classList.remove("d-none");
      id("TitleResumen").classList.add("d-none");
      $("#TotalResumeEvid").html(lista[0]["Total"]);
      $("#ArchivoResumeEvid").html(lista[0]["Archivo"] + "%");
      $("#ArchivoResumeEvid").css("width", lista[0]["Archivo"] + "%");
      $("#FotografiaResumeEvid").html(lista[0]["Fotografia"] + "%");
      $("#FotografiaResumeEvid").css("width", lista[0]["Fotografia"] + "%");
      $("#RenderResumeEvid").html(lista[0]["Render"] + "%");
      $("#RenderResumeEvid").css("width", lista[0]["Render"] + "%");
      $("#DocumentaciónResumeEvid").html(lista[0]["Documentación"] + "%");
      $("#DocumentaciónResumeEvid").css(
        "width",
        lista[0]["Documentación"] + "%"
      );
      $("#PerfilResumeEvid").html(lista[0]["Perfil"] + "%");
      $("#PerfilResumeEvid").css("width", lista[0]["Perfil"] + "%");
      $("#OtroResumeEvid").html(lista[0]["Otro"] + "%");
      $("#OtroResumeEvid").css("width", lista[0]["Otro"] + "%");
    }
  });
}
