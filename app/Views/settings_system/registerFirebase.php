<?php
if (isset($_SESSION['usuario']) && $_SESSION['Resumen'] == 1 && $_SESSION['status_usuario'] == 1) {
?>

    <div class="layoutSidenav_content py-4">
        <main>
            <div class="container-fluid px-4">

                <!-- Aqui va el codigo --->

                <div class="d-sm-flex align-items-center justify-content-between mb-3">
                    <h1 class="h4 mb-0 text-gray-800">Registro de Usuarios / Aplicativo movil</h1>
                </div>

                <div>
                    <input id="email" type="email" placeholder="Ingresa email">
                    <input id="contrasena" type="password" placeholder="Ingresa contraseña">
                    <button onclick="registrar()">Send</button>
                </div>
            </div>
        </main>
    </div>
    <script src="<?php echo base_url()?>/resources/js/login/register.js"></script>

                

<?php
} else {
    header('Location:' . base_url() . '/');
    ob_end_flush();
    die();
}
?>