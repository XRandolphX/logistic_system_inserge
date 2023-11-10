<?php
if (isset($_SESSION['usuario']) && $_SESSION['Resumen'] == 1 && $_SESSION['status_usuario'] == 1) {
?>

    <div class="layoutSidenav_content py-4">
        <main>
            <div class="container-fluid px-4">

                <!-- Aqui va el codigo --->

                <div class="d-sm-flex align-items-center justify-content-between mb-3">
                    <h1 class="h4 mb-0 text-gray-800">Usuarios del sistema</h1>
                </div>

                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Importante: </strong> Para poder mostrar los datos debes hacer click en generar.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

                <div class="row align-items-center justify-content-center mb-4">
                    <div class="col-md-12">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">

                            <a href="<?php echo base_url('/registrar-usuarios'); ?>">
                                <button type="button" class="btn btn-success col">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                    </svg> Nuevo
                                </button>
                            </a>

                            <button type="button" class="btn btn-warning text-black" onclick="cargarUsuario();">
                                <i class="bi bi-arrow-clockwise"></i> Recargar
                            </button>

                            <!--
                    <button type="button" class="btn btn-info">Info</button>
                    <button type="button" class="btn btn-light">Light</button>
                    <button type="button" class="btn btn-dark">Dark</button>
                    -->
                        </div>
                    </div>
                </div>

                <div class="row align-items-center justify-content-center">

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Usuarios Totales</div>
                                        <div id="UT" class="h4 mb-0 font-weight-bold text-gray-800">0</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings (Annual) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Usuarios Activos</div>
                                        <div id="UA" class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-check fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings (Annual) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                            Usuarios Inactivos</div>
                                        <div id="UI" class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-lock fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-12 p-4">

                    <div class="card">
                        <div class="card-header">
                            <b>Lista de usuarios</b>
                        </div>
                        <div id="listado_usuario" class="p-4" style="display: NONE">

                            <div class="table-responsive">
                                <table id="Table_usuario_resumen" class="table table-bordered" cellspacing="0" width="100%">

                                    <thead>
                                        <tr>
                                            <th scope="col">Identificación</th>
                                            <th scope="col">Nombre(s) y Apellido(s)</th>
                                            <th scope="col">Usuario</th>
                                            <th scope="col">Último acceso</th>
                                            <th scope="col">Rol</th>
                                            <th scope="col">Status</th>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div class="modal" id="update_user" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <?php $validation = \Config\Services::validation(); ?>
                <?= form_open_multipart('#', array('id' => 'frmeditusuario', 'name' => 'frmeditusuario')) ?>
                <div class="modal-header">
                    <h5 class="modal-title">Editar usuario</h5>
                    <div class="text-center ml-auto my-auto mr-1"><i id="labelcol" class="bi bi-square-fill"></i></div>
                    <div class=" text-end">
                        <select onchange="labelcolor()" name="status" id="estado_modal" class="form-select form-select-sm" aria-label="Floating label select example">
                            <option value="0"> Inactivo</option>
                            <option value="1"> Activo</option>
                        </select>
                    </div>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <div class="form-group">
                            <label for="codRol"><strong>Rol: </strong></label>
                            <?php
                            echo form_dropdown('codRol', $comboRoles, '', 'class=" selectpicker form-control" id="codRol" data-live-search="true" required title="Seleccione el rol de acceso"');
                            ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</a>
                    <button data-bs-dismiss="modal" type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <div class="modal" id="restablecer_pass" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <?php $validation = \Config\Services::validation(); ?>
                <?= form_open_multipart('#', array('id' => 'frmactusuario', 'name' => 'frmactusuario')) ?>
                <div class="modal-header">
                    <h5 class="modal-title">Restaurar contraseña</h5>
                </div>
                <div class="modal-body">
                    <label class="form-label"><strong>Contraseña:</strong></label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="passw" id="passw" placeholder="esperando..." readonly="readonly">
                        <button type="button" class="btn btn-primary" onclick="getPassword();">Generar</button>
                    </div>

                </div>
                <div class="modal-footer">
                    <a id="copy" class="btn btn-secundary" onclick="toClipboard();">Copiar</a>
                    <a type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</a>
                    <button data-bs-dismiss="modal" type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

<?php
} else {
    header('Location:' . base_url() . '/');
    ob_end_flush();
    die();
}
?>