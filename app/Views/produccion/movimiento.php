<?php
if (isset($_SESSION['usuario']) && $_SESSION['Movimientos'] == 1 && $_SESSION['status_usuario'] == 1) {
?>
    <div class="layoutSidenav_content py-4">
        <main>
            <div class="container-fluid px-4">
                <h1 class="h4 mb-0 text-gray-800">Asignar material al Proyecto</h1>
                <!--RESUMENES DE LOS MOVIMIENTOS-->

                <div id="resumen_movimientos" class=" mt-4 row">
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Último movimiento</div>
                                        <div id="date_M" class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Número de Movimientos del Día</div>
                                        <div id="NMD" class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-megaphone-fill fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Porcentaje de Materiales</div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col">
                                                <div class="progress mr-2">
                                                    <div id="data_disponible" class="progress-bar bg-success" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div id="data_agotado" class="progress-bar bg-danger" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-1">
                                            <div class="text-xs text-success"> <i class="bi bi-square-fill"></i> Disponibles</div>
                                            <div class="text-xs text-danger"> <i class="bi bi-square-fill"></i> Agotados </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Número Total de Materiales</div>
                                        <div id="total_materiales" class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-list-columns-reverse fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--OPERACION DE MOVIMIENTOS-->

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header text-center">
                                <b>Material-Proyecto</b>
                            </div>
                            <!--BÚSQUEDA DEL MATERIAL-->
                            <div class="p-2 overflow-auto">
                                <div class="row col-12">
                                    <b class="pb-3 w-100 align-middle text-center">Buscar Material</b>
                                    <div class="d-flex flex-row justify-content-center">

                                        <?= form_open_multipart('#', array('id' => 'frmMaterial', 'name' => 'frmMaterial')) ?>
                                        <div class="ml-3 d-flex flex-row">
                                            <input id="txt_buscarM" name="txt_buscarM" type="text" class="form-control" placeholder="Código del Material">
                                            <?php $validation = \Config\Services::validation(); ?>
                                            <button class=" ml-2 btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                        </div>
                                        <?= form_close(); ?>
                                    </div>
                                </div>
                                <div class="card p-2 mt-3 mb-3">
                                    <div class="p-4 collapse multi-collapse" id="panelMateriales">
                                        <div class="d-flex">
                                            <b class="w-100 align-middle text-center">Material</b>
                                        </div>
                                        <div class="row p-3">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label"><strong>Código del Producto</strong></label>
                                                    <input id="txt_codeM" name="txt_codeM" type="text" class="form-control" placeholder="" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label"><strong>Nombre del Material</strong></label>
                                                    <input id="txt_NM" name="txt_NM" type="text" class="form-control" placeholder="" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label"><strong>Cantidad</strong></label>
                                                    <input id="txt_stock" name="txt_stock" type="text" class="form-control" placeholder="" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label"><strong>Proveedor</strong></label>
                                                    <input id="txt_Proveedor" name="txt_Proveedor" type="text" class="form-control" placeholder="" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--BÚSQUEDA DEL PROYECTO-->
                                <div class="row col-12">
                                    <b class="pb-3 w-100 align-middle text-center">Buscar Proyecto</b>
                                    <div class="d-flex flex-row justify-content-center">
                                        <?= form_open_multipart('#', array('id' => 'frmProyecto', 'name' => 'frmProyecto')) ?>
                                        <div class="ml-3 d-flex flex-row">
                                            <input id="txt_buscarP" name="txt_buscarP" type="text" class="form-control" placeholder="Código del Proyecto">
                                            <?php $validation = \Config\Services::validation(); ?>
                                            <button class=" ml-2 btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                        </div>
                                        <?= form_close(); ?>
                                    </div>
                                </div>
                                <div class="card p-2 mt-3 mb-3">
                                    <div class="p-4 collapse multi-collapse" id="panelProyecto">
                                        <div class="d-flex">
                                            <b class="w-100 align-middle text-center">Proyecto</b>
                                        </div>
                                        <div class="row p-3">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label"><strong>Código del Proyecto</strong></label>
                                                    <input id="txt_codeP" name="txt_codeP" type="text" class="form-control" placeholder="" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label"><strong>Módulo Asignado</strong></label>
                                                    <input id="txt_MP" name="txt_MP" type="text" class="form-control" placeholder="" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label"><strong>Beneficiario</strong></label>
                                                    <input id="txt_Persona" name="txt_Persona" type="text" class="form-control" placeholder="" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label"><strong>Dirección</strong></label>
                                                    <input id="txt_Direccion" name="txt_Direccion" type="text" class="form-control" placeholder="" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--REALIZACIÓN DEL MOVIMIENTO-->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header text-center">
                                <b>Asignación del Material</b>
                            </div>
                            <div class="container">
                                <?= form_open_multipart('#', array('id' => 'frmMovimiento', 'name' => 'frmMovimiento')) ?>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label"><strong>Material</strong></label>
                                        <input id="result_M" name="result_M" type="text" class="form-control" placeholder="" readonly>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label"><strong>Proyecto</strong></label>
                                        <input id="result_P" name="result_P" type="text" class="form-control" placeholder="" readonly>
                                    </div>

                                    <div class="col-4">
                                        <label class="form-label"><strong>Cantidad</strong></label>
                                        <div class="d-flex">
                                            <input id="cantidad" name="cantidad" type="number" min="1" class="form-control" placeholder=""></input>
                                            <?php $validation = \Config\Services::validation(); ?>
                                            <button class="ml-2 btn btn-primary" type="submit"><i class="bi bi-plus-lg"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <?= form_close(); ?>
                                <!--BOTÓN PARA MOSTRAR LA TABLA-->
                                <button class="mt-3 btn btn-outline-primary btn-md btn-block" onclick="CargarTablaProyectoMaterial()" type="submit"><i class=""></i>Mostrar Tabla</button>
                            </div>
                            <!--TABLA PROYECTO-MATERIAL(REGISTRO DEL MOVIMIENTO)-->
                            <div id="Card_Proyecto_Material" class="card p-2 mt-3 mb-3">
                                <div class="table-responsive">
                                    <div class="card-header text-center">
                                        <b>Tabla de Materiales</b>
                                    </div>
                                    <table id="Tabla_Proyecto_Material" name="Tabla_Proyecto_Material" class="table table-sm w-100">
                                        <thead class="text-center bg-primary text-white">
                                            <tr>
                                                <th scope="col">Código del Proyecto</th>
                                                <th scope="col">Código del Material</th>
                                                <th scope="col">Descripción</th>
                                                <th scope="col">Cantidad Asignada</th>
                                                <th scope="col">Fecha de Registro</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

<?php
} else {
    header('Location:' . base_url() . '/');
    ob_end_flush();
    die();
}
?>