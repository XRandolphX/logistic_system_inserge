<?php
if (isset($_SESSION['usuario']) && $_SESSION['status_usuario'] == 1) {
?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion shadow-sm" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">

                        
                        <?php
                        if ($_SESSION['Inicio'] == 1) {
                            echo '<!-- Produccion-->
                            <div class="sb-sidenav-menu-heading">Producción</div>';

                            if ($_SESSION['Inventario'] == 1) {
                                echo '<a class="nav-link" href="' . base_url('/inventario') . '">
                                <div class="sb-nav-link-icon"><i class="bi bi-bookmark-check-fill"></i></div>Inventario
                                </a>';
                            }

                            if ($_SESSION['Proyectos'] == 1) {
                                echo '<a class="nav-link" href="' . base_url('/proyectos') . '">
                                <div class="sb-nav-link-icon"><i class="bi bi-building"></i></div>Proyectos
                                </a>';
                            }

                            if ($_SESSION['Movimientos'] == 1) {
                                echo '<a class="nav-link" href="' . base_url('/movimientos') . '">
                                <div class="sb-nav-link-icon"><i class="bi bi-bezier2"></i></div>Movimientos
                                </a>';
                            }
                        }
                        ?>

                        
                        <?php
                        if ($_SESSION['Administracion'] == 1) {
                            echo '<!-- Administración-->
                            <div class="sb-sidenav-menu-heading">Administración</div>';
                            if ($_SESSION['Gerencia'] == 1) {
                                echo '<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseGestion" aria-expanded="false" aria-controls="pagesCollapseGestion">
                                <div class="sb-nav-link-icon">
                                    <i class="bi bi-kanban-fill"></i>
                                </div> Gerencia
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseGestion" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">';

                                if ($_SESSION['Proveedores'] == 1) {
                                    echo '<a class="nav-link" href="' . base_url('/proveedores') . '">
                                    <div class="sb-nav-link-icon"><i class="bi bi-person-video2"></i></div> Proveedores
                                    </a>';
                                }

                                if ($_SESSION['Talento'] == 1) {
                                    echo '<a class="nav-link" href="' . base_url('/talento') . '">
                                    <div class="sb-nav-link-icon"><i class="bi bi-people-fill"></i></div> Talento
                                    </a>';
                                }

                                if ($_SESSION['Modulos'] == 1) {
                                    echo '<a class="nav-link" href="' . base_url('/modulos') . '">
                                    <div class="sb-nav-link-icon"><i class="bi bi-house-fill"></i></div> Módulos
                                    </a>';
                                }

                                if ($_SESSION['Convocatoria'] == 1) {
                                    echo '<a class="nav-link" href="' . base_url('/convocatoria') . '">
                                    <div class="sb-nav-link-icon"><i class="bi bi-paint-bucket"></i></div> Convocatoria
                                    </a>';
                                }

                                if ($_SESSION['Categorias'] == 1) {
                                    echo ' <a class="nav-link" href="' . base_url('/categoria') . '">
                                    <div class="sb-nav-link-icon"><i class="bi bi-code-square"></i></div> Categorías
                                    </a>';
                                }

                                if ($_SESSION['Medidas'] == 1) {
                                    echo '<a class="nav-link" href="' . base_url('/medida') . '">
                                    <div class="sb-nav-link-icon"><i class="bi bi-menu-up"></i></div> Unid Medidas
                                    </a>';
                                }

                                echo '</nav>
                                </div>';
                            }

                            if ($_SESSION['Evidencia'] == 1) {
                                echo '<a class="nav-link" href="' . base_url('/documentacion') . '">
                                <div class="sb-nav-link-icon"><i class="bi bi-camera-fill"></i></i>
                                </div> Evidencias
                                </a>';
                            }
                        }
                        ?>

                        
                        <?php
                        if ($_SESSION['Configuraciondelsistema'] == 1) {

                            echo '<!-- Configuracion -->
                            <div class="sb-sidenav-menu-heading">Configuración del sistema</div>
                            ';

                            if ($_SESSION['Usuarios'] == 1) {
                                echo '<!-- Submenu de administración -->
                               <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUser" aria-expanded="false" aria-controls="collapseUser">
                                   <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                   Usuarios
                                   <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                               </a>
                               <div class="collapse" id="collapseUser" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                   <nav class="sb-sidenav-menu-nested nav">';

                                if ($_SESSION['Resumen'] == 1) {
                                    echo ' <a class="nav-link" href="' . base_url('/resumen-usuarios') . '">
                                    Resumen
                                    </a>  <a class="nav-link" href="' . base_url('/registrar-fireuser') . '">
                                    Registrar
                                    </a>';
                                }

                                echo ' </nav>
                                   </div>';
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Sesión Iniciada:</div>
                    <?php echo $_SESSION['rol']; ?>
                </div>
            </nav>
        </div>


        <div id="layoutSidenav_content">
        <?php
    } else {
        header('Location:' . base_url() . '/');
        die();
        ob_end_flush();
    }
        ?>