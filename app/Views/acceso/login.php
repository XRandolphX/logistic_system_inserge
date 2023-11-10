<?php
if (isset($_SESSION['usuario'])) {
    header('Location:' . base_url() . '/dashboard');
    die();
} else {
?>
    <!doctype html>
    <html lang="es">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" href="https://imgur.com/uamN3MW.png" sizes="32x32">
        <!-- Bootstrap CSS v5.0.2 -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400&amp;display=swap" rel="stylesheet">

        <link rel="stylesheet" href="<?php echo base_url(); ?>/resources/css/style_login.css">
        <link href="<?php echo base_url(); ?>/resources/css/preload.css" rel="stylesheet">

        <title><?php echo $titulo ?></title>

    </head>

    <body class="bd-gradiant-whithe">

        <div id="contedor_carga" class="contedor_carga">
            <div class="carga"></div>
        </div>

        <div class="container">
            <!--- Inicio interfaz de Login --->
            <!--- Centrando el login--->
            <div class="row align-items-center justify-content-center vh-100">
                <div class="col-xl-10 col-lg-12 col-md-9">
                    <!--- Asignando border --->
                    <div class="card o-hidden border-0 shadow-lg my-4">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block p-5">
                                    <img src="<?php echo base_url(); ?>/resources/img/team_image.svg">
                                </div>
                                <div class="col-lg-6">
                                    <!--- centrando el formulario --->
                                    <div class="p-5">
                                        <div class="card">
                                            <!--- Inicio de formulario --->
                                            <!--- centrando el formulario --->

                                            <div class="p-3">
                                                <div class="py-2">
                                                    <h4 class="fw-bold p-1">Bienvenido a INSERGE</h4>
                                                    
                                                    <p class="p-1"> Ingrese su usuario y contraseña para acceder al sistema.</p>
                                                </div>

                                                <?= form_open_multipart('#', array('id' => 'frmlogin', 'name' => 'frmlogin')) ?>

                                                <div class="p-3">
                                                    <label class="form-label fw-bolder">Usuario:</label>
                                                    <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Ingresa tu usuario">
                                                    <small class="text-danger">
                                                    </small>
                                                </div>

                                                <div class="p-3">
                                                    <label class="form-label fw-bolder">Contraseña:</label>
                                                    <input type="password" name="contrasenia" id="contrasenia" class="form-control" placeholder="Ingresa tu contraseña">
                                                    <small class="text-danger" id="mensaje_error">
                                                    </small>
                                                </div>

                                                <?php $validation = \Config\Services::validation(); ?>

                                                <div class="p-3">
                                                    <div class="d-grid">
                                                        <button type="submit" class="btn btn-primary">Acceder</button>
                                                    </div>
                                                </div>

                                                <?= form_close(); ?>

                                                <div class="col-md text-center py-3">
                                                    <hr>
                                                    ©2022 Inserge || Todos los derechos reservados.
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <!--- Fin de formulario --->
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!--- Fin interfaz de Login --->
            </div>
        </div>

        <!-- Bootstrap JavaScript Libraries -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="<?php echo base_url(); ?>/resources/js/login/jlogin.js"></script>

        <script>
            ruta = '<?= base_url() ?>';
            window.addEventListener("load", () => {
                const contenedor_loader = document.querySelector(".contedor_carga");
                $("#contedor_carga").fadeOut();
                contenedor_loader.style.opacity = "0";
                contenedor_loader.style.visibility = "hidden";
            });
        </script>

    </body>

    </html>
<?php
}
?>