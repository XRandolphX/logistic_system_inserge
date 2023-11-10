//FUNCIÓN DE CARGA INICIAL
$(document).ready(function () {
  inicio();
});

function inicio() {
  CargarResumenMovimientos();
  BuscarMaterial();
  BuscarProyecto();
  $("#Card_Proyecto_Material").hide();
  $("#panelMateriales").hide();
  $("#panelProyecto").hide();
}

//CARGA DE LOS RESUMENES SUERIORES
function CargarResumenMovimientos() {
  $.ajax({
    url: ruta + "/produccion/ResumenMovimientos",
    cache: true,
    type: "post",
    dataType: "json",
    data: {},
    success: function (a) {
      if (a.datos.length > 0) {
        $("#resumen_movimientos").show();
        console.log(a);
        $(function () {
          $("#date_M").text(a.datos[0]["FechaUltimoM"]);
          $("#NMD").text(a.datos[0]["MovimientosHoy"]);
          $("#total_materiales").text(a.datos[0]["TotalStock"]);
          $("#data_disponible").text(a.datos[0]["%Disponibles"]);
          $("#data_disponible").css("width", a.datos[0]["%Disponibles"] + "%");
          $("#data_agotado").text(a.datos[0]["%Agotados"]);
          $("#data_agotado").css("width", a.datos[0]["%Agotados"] + "%");
        });
      } else {
        alert("No hay datos para mostrar");
      }
    },
  });
}

//REGISTRAR EL MOVIMIENTO
$("#frmMovimiento").submit(function () {
  var formData = new FormData($("#frmMovimiento")[0]);
  $.ajax({
    url: ruta + "/produccion/registar_PM",
    type: "post",
    data: formData,
    dataType: "json",
    cache: false,
    contentType: false,
    processData: false,
    data1: {},
    success: function (a) {
      if (a.error == "") {
        //console.log(a.datos);
        CargarTablaProyectoMaterial();
        CargarResumenMovimientos();
        $("#panelMateriales").hide();
        $("#panelProyecto").hide();
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
          title: "<strong class='text-success'>Mensaje del Sistema</strong>",
          text: "Movimiento Realizado con éxito",
        });
      } else {
        Swal.fire("Mensaje del Sistema", a.error, "warning");
      }
    },
  });
  return false;
});

//CARGA DE LA TABLA DE REGISTRO DE LOS MOVIMIENTOS
function CargarTablaProyectoMaterial() {
  $("#Tabla_Proyecto_Material").DataTable().destroy();
  $.ajax({
    url: ruta + "/produccion/listar_PM",
    type: "post",
    dataType: "json",
    data: {},
    success: function (a) {
      if (a.datos.length > 0) {
        $("#Card_Proyecto_Material").show();
        console.log(a);
        $(function () {
          $("#Tabla_Proyecto_Material").DataTable({
            data: a.datos,
            sPaginationType: "full_numbers",
            bProcessing: true,
            bAutoWidth: false,
            columns: [
              { data: "v1" },
              { data: "v2" },
              { data: "v3" },
              { data: "v4" },
              { data: "v5" },
            ],
            // Traduce todo al español
            language: {
              url: "https://cdn.datatables.net/plug-ins/1.12.0/i18n/es-ES.json",
            },
            // Activa el modo responsive
            responsive: true,
          });
        });
      } else {
        alert("No hay datos para mostrar");
      }
    },
  })
    .done(function () {
      console.log("success");
    })
    .fail(function () {
      console.log("error");
    })
    .always(function () {
      console.log("complete");
    });
}
//Búsqueda del Material
function BuscarMaterial() {
  $("#frmMaterial").submit(function () {
    var formData = new FormData($("#frmMaterial")[0]);
    $.ajax({
      url: ruta + "/produccion/search_material",
      type: "post",
      data: formData,
      dataType: "json",
      cache: false,
      contentType: false,
      processData: false,
      data1: {},
      success: function (a) {
        if (a.error == "") {
          if (a.datos.length > 0) {
            // Aqui va la accion
            $("#panelMateriales").show();
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
              title:
                "<strong class='text-success'>Mensaje del Sistema</strong>",
              text: "Búsqueda realizada con éxito",
            });
            //v3,v4,v5,v7 --> variables a mostrar
            document.getElementById("txt_codeM").value = a.datos[0]["v2"];
            document.getElementById("txt_NM").value = a.datos[0]["v4"];
            document.getElementById("txt_stock").value = a.datos[0]["v7"];
            document.getElementById("txt_Proveedor").value = a.datos[0]["v10"];
            document.getElementById("result_M").value = a.datos[0]["v2"];
          } else {
            //Mensaje de error
            Clean();
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
              icon: "warning",
              title:
                "<strong class='text-warning'>Mensaje del Sistema</strong>",
              text: "El código del Material no existe",
              
            });
          }
        } else {
          Swal.fire("Mensaje del Sistema", a.error, "warning");
        }
      },
    });
    return false;
  });
}
//Búsqueda del Proyecto
function BuscarProyecto(){
  $("#frmProyecto").submit(function () {
    var formData = new FormData($("#frmProyecto")[0]);
    $.ajax({
      url: ruta + "/produccion/search_proyecto",
      type: "post",
      data: formData,
      dataType: "json",
      cache: false,
      contentType: false,
      processData: false,
      data1: {},
      success: function (a) {
        if (a.error == "") {
          if (a.datos.length > 0) {
            // Aqui va la accion
            $("#panelProyecto").show();
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
              title:
                "<strong class='text-success'>Mensaje del Sistema</strong>",
              text: "Búsqueda realizada con éxito",
            });
            //v3,v4,v5,v7 --> variables a mostrar
            document.getElementById("txt_codeP").value = a.datos[0]["v2"];
            document.getElementById("txt_Persona").value = a.datos[0]["v12"];
            document.getElementById("txt_MP").value = a.datos[0]["v5"];
            document.getElementById("txt_Direccion").value = a.datos[0]["v10"];
            document.getElementById("result_P").value = a.datos[0]["v2"];
          } else {
            //Mensaje de error
            Clean();
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
              icon: "warning",
              title:
                "<strong class='text-warning'>Mensaje del Sistema</strong>",
              text: "El código del Proyecto no Existe",
            });
          }
        } else {
          Swal.fire("Mensaje del Sistema", a.error, "warning");
        }
      },
    });
    return false;
  });
}




function Clean() {
  const inputs = document.querySelectorAll(
    "#result_M, #result_P, #txt_codeM, #txt_NM, #txt_stock, #txt_Proveedor, #txt_codeP, #txt_Persona, #txt_MP, #txt_Direccion"
  );
  inputs.forEach((input) => {
    input.value = "";
  });
}