$("#contenido_empleado").hide();
$("#contenido_usuario").hide();

let dato, iden, id_perso;

function mensaje(icono, mensaje) {
  var ncolor;

  switch (icono) {
    case "success":
      ncolor = "success";
      break;
    case "error":
      ncolor = "danger";
      break;
    default:
      ncolor = "warning";
  }

  const Toast = Swal.mixin({
    toast: true,
    position: "bottom-end",
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: false,
    didOpen: (toast) => {
      toast.addEventListener("mouseenter", Swal.resumeTimer);
      toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
  });

  Toast.fire({
    icon: icono,
    title: "<strong class='text-" + ncolor + "'>Mensaje del sistema</strong>",
    text: mensaje,
  });
}

$("#frmempleado").submit(function () {
  var formData = new FormData($("#frmempleado")[0]);
  $.ajax({
    url: ruta + "/UsuarioControlador/search_empleado",
    type: "post",
    data: formData,
    dataType: "json",
    cache: false,
    contentType: false,
    processData: false,
    data1: {},
    success: function (a) {
      if (a.error == "") {
        console.log(a.encontrado);

        if (a.encontrado != null) {
          mensaje("warning", a.encontrado);
          Ocultar_informacion();
        } else {
          if (a.noDatos != null) {
            mensaje("error", a.noDatos);
            Ocultar_informacion();
          } else {
            mensaje("success", "Búsqueda realizada con exito");

            document.getElementById("contenido_empleado").style.display = "";
            $("#contenido_empleado").show();
            document.getElementById("contenido_usuario").style.display = "";
            $("#contenido_usuario").show();

            id_perso = a.datos[0]["v1"];

            document.getElementById("identificacion").value = "";
            document.getElementById("nro_doc").value = a.datos[0]["v2"];
            iden = a.datos[0]["v2"];

            document.getElementById("sexo").value = a.datos[0]["v3"];
            document.getElementById("nombre").value = a.datos[0]["v4"];
            dato = a.datos[0]["v4"];

            document.getElementById("apellido").value = a.datos[0]["v5"];
            document.getElementById("celular").value = a.datos[0]["v6"];
            document.getElementById("profesion").value = a.datos[0]["v7"];
            document.getElementById("correo").value = a.datos[0]["v8"];
          }
        }
      } else {
        Swal.fire("Mensaje del sistema", a.error, "warning");
        Ocultar_informacion();
      }
    },
  });
  return false;
});

function Ocultar_informacion() {
  document.getElementById("contenido_empleado").style.display = "none";
  $("#contenido_empleado").hide();
  document.getElementById("contenido_usuario").style.display = "none";
  $("#contenido_usuario").hide();
  Clean();
}

function Clean() {
  var inputs, index;
  inputs = document.getElementsByTagName("input");
  //console.log(inputs);
  for (index = 1; index < 10; ++index) {
    $(inputs[index]).val("");
  }
}

function generar() {
  let palabra = dato.split(" ");
  //document.getElementById("id_pers").value = id_perso;
  document.getElementById("usuario").value = palabra[0] + "_" + iden;
  document.getElementById("contrasenia").value = iden.slice(0, 6);
  mensaje("success", "Se asignó con exito un usuario y contraseña");
}

$("#frmusuario").submit(function () {
  var formData = new FormData($("#frmusuario")[0]);
  formData.append("id_pers", id_perso);
  $.ajax({
    url: ruta + "/UsuarioControlador/doSaveUsuario",
    type: "post",
    data: formData,
    dataType: "json",
    cache: false,
    contentType: false,
    processData: false,

    success: function (resp) {
      if (resp.error == "") {
        document.getElementById("contenido_empleado").style.display = "none";
        $("#contenido_empleado").hide();
        document.getElementById("contenido_usuario").style.display = "none";
        $("#contenido_usuario").hide();

        Clean();
        $("#frmusuario")[0].reset();
        mensaje("success", "Los datos se registraron con éxito");
      } else {
        Swal.fire("Mensaje del sistema", resp.error, "warning");
      }
    },
  });
  return false;
});
