function id(Element) {
    return document.getElementById(Element);
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
        }
    });
    if (data.error == "") {
        Toast.fire({
            title: '<i class="bi bi-check-lg"></i> ¡Los datos han sido registrados con éxito!',
        });
    } else {
        Toast.fire({
            title: '<i class="bi bi-exclamation-triangle"></i> ¡Error al registrar!',
            html: data.error,
        });
    }
}

function createCookie(name, value, days) {
    var expires;
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    }
    else {
        expires = "";
    }
    document.cookie = escape(name) + "=" +
        escape(value) + expires + "; path=/";
}

// Variable para enviar al Modal (NO ME FUNCIONA EL POST NO SE XQ, LLOROOOOOOOOO)
var GlobalData = Array();

// Cambiar de Colorsitos al estado
function labelcolor() {
    var label = id('labelcol');
    if ($("#estado_modal").val() == '0') {
        label.classList.remove('text-success');
        label.classList.add('text-danger');
    } else {
        label.classList.remove('text-danger');
        label.classList.add('text-success');
    }
}
