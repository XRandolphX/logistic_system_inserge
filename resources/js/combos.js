function AnidarUbigeo(idSelectDepart, idSelectProv, idSelectDist) {
  $(idSelectDepart).change(function () {
    var iddepartamento = $(idSelectDepart).val();
    listar_pronvincia(iddepartamento, idSelectProv, idSelectDist);
  });
  $(idSelectProv).change(function () {
    var idprovincia = $(idSelectProv).val();
    listar_distrito(idprovincia, idSelectDist);
  });
  $.ajax({
    url: ruta + "/ubigeo/doListDepart",
    type: "POST",
    dataType: "json",
    contentType: "application/json; charset=utf-8",
  }).done(function (resp) {
    var data = resp.datos;
    var cadena = "";
    if (data.length > 0) {
      for (var i = 0; i < data.length; i++) {
        cadena +=
          "<option value='" +
          data[i]["v1"] +
          "'>" +
          data[i]["v2"] +
          "</option>";
      }
      $(idSelectDepart).html(cadena);

      var iddepartamento = $(idSelectDepart).val();
      listar_pronvincia(iddepartamento, idSelectProv, idSelectDist);
    } else {
      cadena += "<option value=''>'NO SE ENCONTRARON REGISTROS'</option>";
      $(idSelectDepart).html(cadena);
    }
  });
}

function listar_pronvincia(iddepartamento, idSelectProv, idSelectDist) {
  createCookie("departamento", iddepartamento, "1");
  $.ajax({
    url: ruta + "/ubigeo/doListProvin",
    type: "POST",
    dataType: "json",
    contentType: "application/json; charset=utf-8",
  }).done(function (resp) {
    var data = resp.datos;
    var cadena = "";
    if (data.length > 0) {
      for (var i = 0; i < data.length; i++) {
        cadena +=
          "<option value='" +
          data[i]["v1"] +
          "'>" +
          data[i]["v2"] +
          "</option>";
      }
      $(idSelectProv).html(cadena);
      var idprovincia = $(idSelectProv).val();
      listar_distrito(idprovincia, idSelectDist);
    } else {
      cadena += "<option value=''>'NO SE ENCONTRARON REGISTROS'</option>";
      $(idSelectProv).html(cadena);
    }
  });
}

function listar_distrito(idprovincia, idSelectDist) {
  createCookie("provincia", idprovincia, "1");
  $.ajax({
    url: ruta + "/ubigeo/doListDistrito",
    type: "POST",
    dataType: "json",
    contentType: "application/json; charset=utf-8",
  }).done(function (resp) {
    var data = resp.datos;
    var cadena = "";
    if (data.length > 0) {
      for (var i = 0; i < data.length; i++) {
        cadena +=
          "<option value='" +
          data[i]["v1"] +
          "'>" +
          data[i]["v2"] +
          "</option>";
      }
      $(idSelectDist).html(cadena);
    } else {
      cadena += "<option value=''>'NO SE ENCONTRARON REGISTROS'</option>";
      $(idSelectDist).html(cadena);
    }
  });
}

function GenerateCombo(idSelectUI, Controller) {
  $.ajax({
    url: ruta + "/" + Controller,
    type: "POST",
    dataType: "json",
    contentType: "application/json; charset=utf-8",
  }).done(function (resp) {
    var data = resp.datos;
    var cadena = "<option value=''>Selecciona</option>";
    if (data.length > 0) {
      for (var i = 0; i < data.length; i++) {
        cadena +=
          "<option value='" +
          data[i]["v1"] +
          "'>" +
          data[i]["v2"] +
          "</option>";
      }
    } else {
      cadena += "<option value=''>'NO SE ENCONTRARON REGISTROS'</option>";
    }
    $(idSelectUI).html(cadena);
  });
}

$(document).ready(function () {
  $(".js-example-basic-single").select();
  AnidarUbigeo("#sel_departamento", "#sel_provincia", "#sel_distrito");
  AnidarUbigeo(
    "#sel_departamento_modal",
    "#sel_provincia_modal",
    "#sel_distrito_modal"
  );
  GenerateCombo("#SelectProveedor", "administracion/doComboProveedor");
  GenerateCombo("#SelectProveedor2", "administracion/doComboProveedor");
  GenerateCombo("#SelectProveedor3", "administracion/doComboProveedor");
  GenerateCombo("#SelectPerson", "administracion/doComboPerson");
  GenerateCombo("#SelectModule", "administracion/doComboModule");
  GenerateCombo("#SelectModule2", "administracion/doComboModule");
  GenerateCombo("#SelectConvocatoria", "administracion/doComboConvocatoria");
  GenerateCombo("#SelectCategory", "administracion/doComboCategory");
  GenerateCombo("#SelectMedida", "administracion/doComboMedida");
});