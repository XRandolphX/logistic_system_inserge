<?php
if (isset($_SESSION['usuario']) && $_SESSION['Modulos'] == 1 && $_SESSION['status_usuario'] == 1) {
?>
    <div class="layoutSidenav_content py-4">
        <main>
            <div class="container-fluid px-4">
                <div id="TitleResumen" class="row d-none">
                    <div class="mb-0 text-center text-secondary">No hay datos suficientes para cargar el resumen</div>
                </div>
                <div id="Resumen" class="row d-none">
                    <div class="col-xl-3 col-md-4 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Número de Módulos</div>
                                        <div id="TotalResumeModulos" class="h4 mb-0 font-weight-bold text-gray-800"> </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-box fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9 col-md-8 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Módulos en Proyectos</div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col">
                                                <div class="progress mx-2">
                                                    <div id="ActiveResumeModulos" class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div id="InactiveResumeModulos" class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-1 d-flex mx-1 justify-content-between">
                                            <div class="col-auto">
                                                <div class="text-xs text-success">Activos</div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="text-xs text-danger">Inactivos</div>
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
                <div class="row align-items-center justify-content-center">
                    <div class="row justify-content-center">
                        <div class="col-md-5">
                            <div class="card shadow">
                                <div class="card-body">
                                    <div class="fw-bold text-center pb-3">Administración de Modulos</div>
                                    <?php $validation = \Config\Services::validation(); ?>
                                    <?= form_open_multipart('#', array('id' => 'frmregModulo', 'name' => 'frmregModulo')) ?>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="mod" name="mod" placeholder="-"></input>
                                        <label for="mod" class="form-label">Módulo</label>
                                    </div>
                                    <div class="pt-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="desc" name="desc" placeholder="-"></input>
                                            <label for="desc" class="form-label">Descripción</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 pt-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="acon" name="acon" placeholder="-"></input>
                                                <label for="acon" class="form-label">Área Construida</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pt-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="atec" name="atec" placeholder="-"></input>
                                                <label for="atec" class="form-label">Área Techada</label>
                                            </div>
                                        </div>
                                    </div>
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
                            <div class="card shadow">
                                <div class="card-body">
                                <div class="fw-bold text-center pb-3">Listado de los tipos de módulos</div>
                                    <div class="pt-2">
                                        <div class="table-responsive">
                                            <table id="Table_Modulos" class="table table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Módulo</th>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Descripción</th>
                                                        <th scope="col">Área Techada</th>
                                                        <th scope="col">Área Construida</th>
                                                        <th scope="col">Fecha de Registro</th>
                                                        <th scope="col">Usuario de Registro</th>
                                                        <th scope="col"></th>
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
                        <div class="modal" id="exampleModal" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <?php $validation = \Config\Services::validation(); ?>
                                    <?= form_open_multipart('#', array('id' => 'frmeditModulo', 'name' => 'frmeditModulo')) ?>
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edición</h5>
                                        <div class="text-center ml-auto my-auto mr-1"><i id="labelcol" class="bi bi-square-fill"></i></div>
                                        <div class=" text-end">
                                            <select onchange="labelcolor()" name="status" id="estado_modal" class="form-select form-select-sm" aria-label="Floating label select example">
                                                <option value="0"> Inactivo</option>
                                                <option value="1"> Activo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="editMod" name="mod" placeholder="-"></input>
                                            <label for="mod" class="form-label">Módulo</label>
                                        </div>
                                        <div class="pt-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="editDesc" name="desc" placeholder="-"></input>
                                                <label for="desc" class="form-label">Descripción</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 pt-3">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="editAcon" name="acon" placeholder="-"></input>
                                                    <label for="acon" class="form-label">Área Construida</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 pt-3">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="editAtec" name="atec" placeholder="-"></input>
                                                    <label for="atec" class="form-label">Área Techada</label>
                                                </div>
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