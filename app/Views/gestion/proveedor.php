<?php
if (isset($_SESSION['usuario']) && $_SESSION['Proveedores'] == 1 && $_SESSION['status_usuario'] == 1) {
?>

    <div class="layoutSidenav_content py-4">
        <main>
            <div class="container-fluid px-4">
                <div id="TitleResumen" class="row d-none">
                    <div class="mb-0 text-center text-secondary">No hay datos suficientes para cargar el resumen</div>
                </div>
                <div id="Resumen" class="row d-none">
                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-2 col-md-4 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total de Proveedores</div>
                                        <div id="TotalResumeProveedores" class="h4 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-box fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Earnings (Annual) Card Example -->
                    <div class="col-xl-3 col-md-4 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Último Proveedor</div>
                                        <div id="LastResumeProveedores" class="h5 mb-0 font-weight-bold text-gray-800">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Pending Requests Card Example -->
                    <div class="col-xl-3 col-md-4 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Proveedor estrella</div>
                                        <div id="StarResumeProveedores" class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-12 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Estado de Proovedores</div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col">
                                                <div class="progress m-2">
                                                    <div id="ActiveResumeProveedores" class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div id="InactiveResumeProveedores" class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <div class="d-flex justify-content-between row mx-2">
                                                    <div class="col-auto">
                                                        <div class="text-xs text-success"> <strong>Activos</strong> </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="text-xs text-danger"> <strong>Inactivos</strong> </div>
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
                        </div>
                    </div>
                </div>
                <div class="row align-items-center justify-content-center">
                    <div class="row justify-content-center">
                        <div class="col-md-5">
                            <div class="card border shadow">
                                <div class="card-body">
                                    <div class="fw-bold text-center pb-3">Administración de Proveedores</div>
                                    <?php $validation = \Config\Services::validation(); ?>
                                    <?= form_open_multipart('#', array('id' => 'frmregProveedor', 'name' => 'frmregProveedor')) ?>
                                    <div>
                                        <div class="form-floating">
                                            <input type="number" min="0" class="form-control" id="ruc" name="ruc" placeholder="-"></input>
                                            <label for="ruc" class="form-label">RUC</label>
                                        </div>
                                    </div>
                                    <div class="pt-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="razon" name="razon" placeholder="-"></input>
                                            <label for="razon" class="form-label">Razón Social</label>
                                        </div>
                                    </div>
                                    <div class="pt-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="correo" name="correo" placeholder="-"></input>
                                            <label for="correo" class="form-label">Correo Electrónico</label>
                                        </div>
                                    </div>
                                    <div class="pt-3">
                                        <div class="form-floating">
                                            <input type="number" min="0" class="form-control" id="tel" name="tel" placeholder="-"></input>
                                            <label for="tel" class="form-label">N° Teléfono</label>
                                        </div>
                                    </div>
                                    <div class="row pt-3">
                                        <div class="col-sm-4 ">
                                            <div class="form-floating">
                                                <select class="form-select js-example-basic-single form-select-sm" name="sel_departamento" id="sel_departamento" aria-label="Floating label select example">
                                                </select>
                                                <label for="sel_departamento">Departamento</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-floating">
                                                <select class="form-select js-example-basic-single form-select-sm" name="sel_provincia" id="sel_provincia" aria-label="Floating label select example">
                                                </select>
                                                <label for="sel_provincia">Provincia</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-floating">
                                                <select class="form-select js-example-basic-single form-select-sm" name="dist" id="sel_distrito" aria-label="Floating label select example">
                                                </select>
                                                <label for="dist">Distrito</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pt-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="dir" id="dir" placeholder="-"></input>
                                            <label for="dir" class="form-label">Dirección</label>
                                        </div>
                                    </div>
                                    <!-- Mientras se desarrolla el POST de usuario pondremos un input escondido -->

                                    <div class="d-grid d-md-flex justify-content-md-end">
                                        <div class="justify-content-md-end flex-wrap pt-4">
                                            <button type="submit" class="btn btn-success bi bi-plus-lg mr-2"> Registrar </button>
                                            <a onClick="Clean()" class="btn btn-info bi bi-clipboard-x"> Limpiar
                                            </a>
                                        </div>
                                    </div>
                                    <?= form_close(); ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="card border shadow">
                                <div class="card-body">
                                <div class="fw-bold text-center pb-3">Listado de los Proveedores</div>
                                    <div class="pt-2">
                                        <div class="table-responsive">
                                            <table id="Table_Proveedor" class="table table-bordered table-sm w-100">
                                                <thead class="text-center bg-primary text-white">
                                                    <tr>
                                                        <th scope="col">RUC</th>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Razón Social</th>
                                                        <th scope="col">Email</th>
                                                        <th scope="col">N° Teléfono</th>
                                                        <th scope="col">Distrito</th>
                                                        <th scope="col">Provincia</th>
                                                        <th scope="col">Departamento</th>
                                                        <th scope="col">Dirección</th>
                                                        <th scope="col">Fecha</th>
                                                        <th scope="col">Usuario que registro</th>
                                                        <th scope="col"> Modificaciones </th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal" id="exampleModal" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <?php $validation = \Config\Services::validation(); ?>
                                    <?= form_open_multipart('#', array('id' => 'frmeditProveedor', 'name' => 'frmeditProveedor')) ?>
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edición</h5>
                                        <div class="text-center ml-auto my-auto mr-1"><i id="labelcol" class="bi bi-square-fill"></i></div>
                                        <div class=" text-end">
                                            <select onchange="labelcolor()" name="estado_modal" id="estado_modal" class="form-select form-select-sm" aria-label="Floating label select example">
                                                <option value="0"> Inactivo</option>
                                                <option value="1"> Activo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <div class="px-2">
                                            <div class="form-floating">
                                                <input type="number"  min="0" class="form-control " id="editRUC" name="ruc" placeholder="-"></input>
                                                <label for="exampleFormControlInput1" class="form-label">RUC</label>
                                            </div>
                                        </div>
                                        <div class="px-2 pt-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="editRazon" name="razon" placeholder="-"></input>
                                                <label for="exampleFormControlInput1" class="form-label">Razón Social</label>
                                            </div>
                                        </div>
                                        <div class="px-2 pt-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" name="correo" id="editEmail" placeholder="-"></input>
                                                <label for="exampleFormControlInput1" class="form-label">Correo Electrónico</label>
                                            </div>
                                        </div>
                                        <div class="px-2 pt-3">
                                            <div class="form-floating">
                                                <input type="number" min="0" class="form-control" name="tel" id="editTel" placeholder="-"></input>
                                                <label for="exampleFormControlInput1" class="form-label">N° Teléfono</label>
                                            </div>
                                        </div>
                                        <div class="px-2 row pt-3">
                                            <div class="col-sm-4 ">
                                                <div class="form-floating">
                                                    <select class="form-select js-example-basic-single form-select-sm" name="sel_departamento_modal" id="sel_departamento_modal" aria-label="Floating label select example">
                                                    </select>
                                                    <label for="floatingSelect">Departamento</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-floating">
                                                    <select class="form-select js-example-basic-single form-select-sm" name="sel_provincia_modal" id="sel_provincia_modal" aria-label="Floating label select example">
                                                    </select>
                                                    <label for="floatingSelect">Provincia</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-floating">
                                                    <select class="form-select js-example-basic-single form-select-sm" name="dist" id="sel_distrito_modal" aria-label="Floating label select example">
                                                    </select>
                                                    <label for="floatingSelect">Distrito</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="px-2 pt-3">
                                            <div class="form-floating">
                                                <input type="text" name="dir" class="form-control" id="editDir" placeholder="Codigo"></input>
                                                <label for="exampleFormControlInput1" class="form-label">Dirección</label>
                                            </div>
                                        </div>
                                        <input type="text" hidden name="id" id="id"></input>
                                    </div>
                                    <div class="modal-footer">
                                        <a type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</a>
                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                    </div>
                                    <?= form_close(); ?>
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