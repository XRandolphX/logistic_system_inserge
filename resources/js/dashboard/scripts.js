/*!
 * Start Bootstrap - SB Admin v7.0.5 (https://startbootstrap.com/template/sb-admin)
 * Copyright 2013-2022 Start Bootstrap
 * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
 */
//
// Scripts
//

window.onload = function () {
  $("#contedor_carga").fadeOut(1000);
};

/*
document.getElementById("page-top").onmousemove = movingMyMouse;

function movingMyMouse() {
  alert('hola')
}

*/

window.addEventListener("DOMContentLoaded", (event) => {
  // Toggle the side navigation
  const sidebarToggle = document.body.querySelector("#sidebarToggle");
  if (sidebarToggle) {
    // Uncomment Below to persist sidebar toggle between refreshes
    // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
    //     document.body.classList.toggle('sb-sidenav-toggled');

    sidebarToggle.addEventListener("click", (event) => {
      event.preventDefault();
      document.body.classList.toggle("sb-sidenav-toggled");
      localStorage.setItem(
        "sb|sidebar-toggle",
        document.body.classList.contains("sb-sidenav-toggled")
      );
    });
  }
});

var timeout;

document.onmousemove = function () {
  clearTimeout(timeout);
  contadorSesion(); //aqui cargamos la funcion de inactividad
};

function contadorSesion() {
  timeout = setTimeout(function () {
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: "btn btn-success m-2",
        cancelButton: "btn btn-danger",
      },
      buttonsStyling: false,
    });

    swalWithBootstrapButtons
      .fire({
        title: "Mensaje del sistema",
        text: "Se ha detectado inactividad en tu sesión. ¿Deseas continuar?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, deseo continuar",
        cancelButtonText: "No, cerrar sesión",
        reverseButtons: true,

        timer: 10000,
        timerProgressBar: true,

        didOpen: (toast) => {
          toast.addEventListener("mouseenter", Swal.stopTimer);
          toast.addEventListener("mouseleave", Swal.resumeTimer);
        },

        didClose: () => {
          salir();
        },
      })
      .then((result) => {
        if (result.isConfirmed) {
          swalWithBootstrapButtons.fire(
            "Mensaje del sistema",
            "Se ha reanudado tu sesión",
            "success"
          );
        } else if (
          /* Read more about handling dismissals below */
          result.dismiss === Swal.DismissReason.cancel
        ) {
          swalWithBootstrapButtons.fire(
            "Mensaje del sistema",
            "Se ha cerrado la sesión con éxito",
            "success"
          );
          salir();
        }
      });
  }, 600000); // 10 = 600000 minutos para cerrar sesión
}

function salir() {
  window.location = ruta + "/cerrar-sesion";
} //esta función cierra sesión

/*
window.addEventListener("load", () => {
  const contenedor_loader = document.querySelector(".contedor_carga");
  $('#contedor_carga').fadeOut();
  contenedor_loader.style.opacity = "0";
  contenedor_loader.style.visibility = "hidden";
});*/

function cambiara() {
  $.ajax({
    url: ruta + "/UsuarioControlador/doUpdateTheme",
    type: "POST",
    dataType: "json",
  }).done(function (resp) {
    if (resp.datos[0]["teme"] == "0") {
      id("page-top").classList.remove("dark-mode");
      id("modeTheme").classList.replace("bi-moon-stars-fill", "bi-moon-stars");
    } else {
      id("page-top").classList.add("dark-mode");
      id("modeTheme").classList.replace("bi-moon-stars", "bi-moon-stars-fill");
    }
  });
}

function cerrar() {
  window.location = ruta + "/cerrar-sesion";
}

$("#cambiar_contrasenia").on("show.bs.modal", function (event) {
  $("#cambiar_contrasenia input").val("");
});

$("#frmactcontrasenia").submit(function () {
  var formData = new FormData($("#frmactcontrasenia")[0]);
  $.ajax({
    url: ruta + "/DashboardControlador/doUpdatePass",
    type: "post",
    dataType: "json",
    cache: false,
    contentType: false,
    processData: false,
    data: formData,

    success: function (data) {
      if (data.error == "") {
        $("#frmactcontrasenia")[0].reset();
        Swal.fire({
          title: "Mensaje del sistema",
          text: "Su contraseña se actualizó con éxito. Debe volver a iniciar su sesión.",
          icon: "success",
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
      } else {
        Swal.fire("Mensaje del sistema", data.error, "warning");
      }
    },
  });
  return false;
});
