$(document).ready(function () {
  // Cargamos las tablas
  cargarPermisos();
});

function cargarPermisos() {
  $.ajax({
    url: ruta + "/UsuarioControlador/doListRoles",
    type: "POST",
    dataType: "json",
    contentType: "application/json; charset=utf-8",
  }).done(function (resp) {
    var cadena = "";

    if (resp.length > 0) {
      for (var i = 0; i < resp.length; i++) {
        cadena +=
          '<div class="col-md-6"><div class="mb-3"><label class="form-label"><strong>' +
          resp[i]["v2"] +
          '</strong></label><select class="form-select" id="' +
          resp[i]["v1"] +
          '" aria-label="Floating label select example">' +
          '</option><option value="1">Activo</option><option value="0">Inactivo</option></select></div></div>';
        //console.log(etique);
      }
    } else {
      cadena =
        "<div class='text-secondary'> No hay datos suficientes para mostrar</div>";
    }

    $("#rolees").html(cadena);
  });
}
