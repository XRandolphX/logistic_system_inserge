<?php
if (isset($_SESSION['usuario']) && $_SESSION['status_usuario'] == 1) {
?>

    <div class="layoutSidenav_content py-4">
        <main>
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between h-100 py-3">
                    <h1 class="ml-3 h3">Bienvenido <Strong><?php echo $_SESSION['Nombres']; ?></Strong> al sistema de gestión del área de logística de <Strong>Inserge</Strong></h1>
                </div>

                <!--
                <div class="row">

                    <-- Earnings (Monthly) Card Example 
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Solicitudes</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">S/ 0.00</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <-- Earnings (Annual) Card Example
                    <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Venta mensual</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">S/ 0.00</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    -->

                <!-- Tasks Card Example 
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Avance del día (Objetivo)
                                        </div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">0%</div>
                                            </div>
                                            <div class="col">
                                                <div class="progress progress-sm mr-2">
                                                    <div class="progress-bar bg-info" role="progressbar" style="width: 0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <-- Pending Requests Card Example 
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Solicitudes pendientes</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <-- 
                         <h1>Bienvenido: </?php echo $_SESSION['Nombres']; ?></h1>
                                <h3>Ultimo Acceso: </?php echo $_SESSION['ult_acceso']; ?></h3>
                                <h3>Usuario de acceso: </?php echo $_SESSION['usuario']; ?></h3>
                    

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Ultimo acceso</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><small><strong>Fecha y día:</strong> </?php echo $_SESSION['ult_acceso']; ?></small></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row">
                    <-- Area Chart --
                    <div class="col-xl-8 col-lg-7">
                        <div class="card shadow mb-4">
                            <-- Card Header - Dropdown --
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                                <div class="dropdown no-arrow">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                        <div class="dropdown-header">Dropdown Header:</div>
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </div>
                            <-- Card Body 
                            <div class="card-body">
                                <div class="chart-area">
                                    <canvas id="myAreaChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <-- Pie Chart 
                    <div class="col-xl-4 col-lg-5">
                        <div class="card shadow mb-4">
                            <-- Card Header - Dropdown --
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                                <div class="dropdown no-arrow">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                        <div class="dropdown-header">Dropdown Header:</div>
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </div>
                            <-- Card Body 
                            <div class="card-body">
                                <div class="chart-pie pt-4 pb-2">
                                    <canvas id="myPieChart"></canvas>
                                </div>
                                <div class="mt-4 text-center small">
                                    <span class="mr-2">
                                        <i class="fas fa-circle text-primary"></i> En proceso
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle text-success"></i> Atendida
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle text-warning"></i> Pendiente
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <-- Parte de cuerpo 
            -->

                <div class="row align-items-center justify-content-center">
                    <div class="d-sm-flex mb-4 col-md-8">
                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-4 p-3">
                                    <img src="https://www.rkdf.ac.in/images/img/mission.png" style="width:100%" alt="" />
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title"><strong>Misión</strong></h5>
                                        <p class="card-text">Nuestra misión como empresa constructora es colaborar de manera proactiva en el desarrollo de nuestro país y del mundo con la más minuciosa atención al crecimiento y necesidades de nuestros clientes. Desarrollando proyectos, y construcciones con los más exigentes estándares en seguridad, calidad y puntualidad.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row align-items-center justify-content-center">
                    <div class="d-sm-flex mb-4 col-md-8">
                        <div class="card mb-3">
                            <div class="row g-0">

                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title"><strong>Visión</strong></h5>
                                        <p class="card-text"> Ser una empresa líder en construcción y consultoría en la región de Piura, reconocida por su capacidad, calidad y cumplimiento de las más exigentes normas de seguridad; utilizando procedimientos constructivos innovadores que permiten construir obras más confortables, que proporcionan un mejor estándar de vida a la población que confian en nosotros.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4 p-3">
                                    <img src="https://ezoco.org/mkgld/wp-content/uploads/sites/1954/2022/02/vision-1.png" style="width:100%" alt="" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row align-items-center justify-content-center">
                    <div class="d-sm-flex col-md-8">
                        <div class="card">
                            <div class="row g-0">
                                <div class="col-md-2 pt-3 pr-3">
                                    <img class="ml-5" src="https://upload.wikimedia.org/wikipedia/commons/a/ae/Valor_Logo.png" style="width:95px" alt="" />
                                </div>
                                <div class="col-md-10">
                                    <div class="card-body">
                                        <h5 class="card-title"><strong>Valor</strong></h5>
                                        <p class="card-text">El valor que busca la empresa desde su nacimiento es el de la <b>Solidaridad</b> para apoyar a todos los beneficiarios que se nos acerquen en busca de un techo propio.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="<?php echo base_url(); ?>/resources/js/demo/chart-area-demo.js"></script>
    <script src="<?php echo base_url(); ?>/resources/js/demo/chart-pie-demo.js"></script>

<?php
} else {
    header('Location:' . base_url() . '/');
    ob_end_flush();
    die();
}
?>