$(document).ready(function () {
  CargarFormulariosUsuarios();
  /*
  cargarResumenUsuario();
  
  $("#Table_usuario_resumen").DataTable({
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.12.0/i18n/es-ES.json",
    },
    //Para los botones
    responsive: true,
    dom: "frtilp",
  });*/
  cargarUsuario();
  document.getElementById("listado_usuario").style.display = "";
  $("#listado_usuario").show();
});

function CargarFormulariosUsuarios() {
  $("#frmeditusuario").submit(function () {
    var formData = new FormData($("#frmeditusuario")[0]);
    formData.append("id_us", ident);
    $.ajax({
      url: ruta + "/UsuarioControlador/doUpdateUser",
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
          $("#frmeditusuario")[0].reset();
          cargarUsuario();
          cargarResumenUsuario();
        }
        showMenssage(data);
      },
    });
    return false;
  });

  $("#frmactusuario").submit(function () {
    var formData = new FormData($("#frmactusuario")[0]);
    formData.append("id_us", ident);
    $.ajax({
      url: ruta + "/UsuarioControlador/doUpdatePass",
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
          $("#frmactusuario")[0].reset();
          cargarUsuario();
          cargarResumenUsuario();

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
            title: "<strong class='text-success'>Mensaje del sistema</strong>",
            text: "Contraseña restablecida con éxito",
          });
        } else {
          Swal.fire("Mensaje del sistema", data.error, "warning");
        }
      },
    });
    return false;
  });
}

function cargarUsuario() {
  $("#Table_usuario_resumen").DataTable().destroy();
  cargarResumenUsuario();
  $.ajax({
    type: "POST",
    url: ruta + "/UsuarioControlador/doListUsuario",
    dataType: "json",
    contentType: "application/json; charset=utf-8",
  }).done(function (lista) {
    $("#Table_usuario_resumen").DataTable({
      data: lista.datos,
      responsive: true,
      // Traduce al todo al español
      language: {
        url: "https://cdn.datatables.net/plug-ins/1.12.0/i18n/es-ES.json",
      },
      dom: "frtilp",
      columns: [
        { data: "v1", class: "text-center", width: "11%" },
        { data: "v2" },
        { data: "v3", class: "text-center", width: "15%" },
        { data: "v4", class: "text-center", width: "15%" },
        { data: "v5", class: "text-center", width: "15%" },
        {
          data: "v6",
          render: function (data) {
            switch (data) {
              case "1":
                return '<i class="badge rounded-pill bg-success text-black" style="width: 100%;"> Activo </i>';
              case "2":
                return '<i class="badge rounded-pill bg-warning text-black" style="width: 100%;"> Bloqueado </i>';
              default:
                return '<i class="badge rounded-pill bg-danger text-black" style="width: 100%;"> Inactivo </i>';
            }
          },
          class: "text-center",
          width: "5%",
        },
        {
          data: "v7",
          render: function (data) {
            return (
              '<a href="#!" onClick="SendToModalUser(' +
              data +
              ');"><i class="bi bi-pencil"></i></a>'
            );
          },
          class: "text-center",
          width: "5%",
        },
        {
          data: "v7",
          render: function (data) {
            return (
              '<a href="#!" onClick="SendToModalRestablecer(' +
              data +
              ');"><i class="bi bi-key"></i></a>'
            );
          },
          class: "text-center",
          width: "5%",
          
        },
      ],
    });
  });
}

function cargarResumenUsuario() {
  $.ajax({
    url: ruta + "/UsuarioControlador/doListResumenUsuarios",
    cache: true,
    type: "post",
    dataType: "json",
    success: function (a) {
      if (a.datos.length > 0) {
        $(function () {
          $("#UT").text(a.datos[0]["Usuarios_Totales"]);
          $("#UA").text(a.datos[0]["ACTIVOS"]);
          $("#UI").text(a.datos[0]["INACTIVOS"]);
        });
      }
    },
  });
}

var ident;

function SendToModalUser(id) {
  $.ajax({
    url: ruta + "/UsuarioControlador/doSearchUsuarios",
    type: "post",
    dataType: "json",
    data: {
      id_usu: id,
    },
    success: function (a) {
      console.log(a.datos[0]);
      $("#update_user").modal("show");
      ident = id;
      $("#codRol").val(a.datos[0]["v1"]);
      $("#codRol").change();
      $("#estado_modal").val(a.datos[0]["v2"]);
      $("#estado_modal").change();
    },
  });
}

function SendToModalRestablecer(id) {
  document.getElementById("passw").value = "";
  ident = id;
  $("#restablecer_pass").modal("show");
}

function getPassword() {
  document.getElementById("passw").value = autoCreate(6);
  $("#copy").show();
}

function autoCreate(plength) {
  //var chars = "abcdefghijklmnopqrstubwsyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
  var chars = "1234567890";
  var password = "";
  for (i = 0; i < plength; i++) {
    password += chars.charAt(Math.floor(Math.random() * chars.length));
  }

  return password;
}

function toClipboard() {
  if(document.getElementById("passw").value != null && document.getElementById("passw").value != ""){
    navigator.clipboard.writeText(
      "Su nueva contraseña de acceso es: " +
        document.getElementById("passw").value
    );
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
      title: "<strong class='text-success'>Mensaje del sistema</strong>",
      text: "Contraseña copiada en el portapapeles",
    });
  } else{
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
      icon: "danger",
      title: "<strong class='text-danger'>Mensaje del sistema</strong>",
      text: "Genera una contraseña",
    });
  }
  
}
