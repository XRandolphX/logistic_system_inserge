<?php
if (isset($_SESSION['usuario']) && $_SESSION['status_usuario'] == 1) {
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title><?php echo $titulo ?></title>
        <link rel="icon" href="https://imgur.com/uamN3MW.png" sizes="32x32">

        <!-- Bootstrap CSS v5.0.2 -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <!-- Custom fonts for this template-->

        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <link href="<?php echo base_url(); ?>/resources/css/preload.css" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" crossorigin="anonymous">

        <!-- CDN iconos -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
        <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
        <!-- DataTable -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/cr-1.5.5/date-1.1.2/fc-4.0.2/fh-3.2.2/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.2/sp-2.0.0/sl-1.3.4/sr-1.1.0/datatables.min.css" />
        <!-- Latest compiled and minified CSS -->

        <!--
        <link href="</?php echo base_url(); ?>/resources/css/estilos.css" rel="stylesheet">
        -->

        <link href="<?php echo base_url(); ?>/resources/css/styles.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>/resources/css/sb-admin-2.min.css" rel="stylesheet">
        <script src="https://www.gstatic.com/firebasejs/4.3.0/firebase.js"></script>

        <script>
        // TODO: Add SDKs for Firebase products that you want to use
        // https://firebase.google.com/docs/web/setup#available-libraries

        // Your web app's Firebase configuration
        const firebaseConfig = {
            apiKey: "AIzaSyCo_yFCsycK6r5T946sBH1zvwHPkxvIr7c",
            authDomain: "inserge-application.firebaseapp.com",
            projectId: "inserge-application",
            storageBucket: "inserge-application.appspot.com",
            messagingSenderId: "8637942918",
            appId: "1:8637942918:web:a315039c0529af82399507"
        };

        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        </script>

        
    </head>

    <?php
    if ($_SESSION['tema'] == 0) {
        echo '<body id="page-top" class="sb-nav-fixed">';
    } else {
        echo '<body id="page-top" class="sb-nav-fixed dark-mode">';
    }
    ?>

        <div id="contedor_carga" class="contedor_carga">
            <div class="carga"></div>
        </div>

        <nav class="sb-topnav navbar navbar-expand">
            <!-- Navbar Brand-->
            <a class="navbar-brand" href="<?php echo base_url('/'); ?>"><img src="https://imgur.com/uamN3MW.png" class="ml-5" style="height:45px; width:100px;"></a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <ul class="navbar-nav ml-auto">

                <!--
                <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                    <button class="switch" id="switch">
                        <span><i class="fas fa-sun"></i></span>
                        <span><i class="fas fa-moon"></i></span>
                    </button>
                </ul>
                --->

                <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                    <li class="nav-item">
                        <a class="nav-link" onclick="cambiara()" href="#!" role="button">
                            <i id="modeTheme" class="bi bi-moon-stars"></i>
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $_SESSION['Nombres']; ?> <i class="fas fa-user fa-fw"></i></a>

                        <ul class="dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#settingsModal" href="!#">Perfil</a>
                            </li>

                            <li>
                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#cambiar_contrasenia" href="!#">Cambiar contraseña</a>
                            </li>

                            <li>
                                <hr class="dropdown-divider" />
                            </li>

                            <li>
                                <a class="dropdown-item" href="<?php echo base_url('/cerrar-sesion'); ?>">Cerrar Sesión</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </ul>
        </nav>

    <?php
} else {
    header('Location:' . base_url() . '/');
    die();
    ob_end_flush();
}
    ?>