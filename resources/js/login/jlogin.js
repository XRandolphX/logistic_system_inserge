function principal() {
  window.location = ruta + "/dashboard";
}

function cerrar() {
  window.location = ruta + "/cerrar-sesion";
}

$("#frmlogin").submit(function () {
  document.getElementById("contedor_carga").style.display = "";
  var formData = new FormData($("#frmlogin")[0]);
  $.ajax({
    url: ruta + "/LoginControlador/doVerify",
    type: "post",
    data: formData,
    dataType: "json",
    cache: false,
    contentType: false,
    processData: false,
    data1: {},
    success: function (a) {
      if (a.error == "") {
        switch (a.datos.v6) {
          case "1":
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
              icon: "success",
              title: "Bienvenido: " + a.datos.v2,
              text: "Estamos cargando tu configuración",
            });

            principal();

            break;

          case "2":
            Swal.fire({
              title: "Mensaje del sistema",
              text: "Lo sentimos, su usuario ha sido bloqueado temporalmente. Contactese con el administrador",
              icon: "warning",
              timer: 5000,
              timerProgressBar: true,

              didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.resumeTimer);
                toast.addEventListener("mouseleave", Swal.resumeTimer);
              },

              didClose: () => {
                cerrar();
              },
            });

            break;

          default:

            Swal.fire({
              title: "Mensaje del sistema",
              text: "Lo sentimos, su usuario no se encuentra activo. Contactese con el administrador",
              icon: "warning",
              timer: 10000,
              timerProgressBar: true,

              didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.resumeTimer);
                toast.addEventListener("mouseleave", Swal.resumeTimer);
              },
              didClose: () => {
                cerrar();
              },
            });

            break;
        }
      } else {
        Swal.fire("Mensaje del sistema", a.error, "warning");
      }
    },
  });
  return false;
});
