<?php
if (isset($_SESSION['usuario']) && $_SESSION['Resumen'] == 1 && $_SESSION['status_usuario'] == 1) {
?>
    <div class="layoutSidenav_content py-4">
        <main>
            <div class="container-fluid px-4">
                <div class="d-sm-flex align-items-center justify-content-center mb-4">
                    <h1 class="h3 mb-0 text-gray"><strong>Creación de usuario</strong></h1>
                </div>
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <strong>Búsqueda de empleado</strong>
                            </div>

                            <div class="p-3">
                                <?= form_open_multipart('#', array('id' => 'frmempleado', 'name' => 'frmempleado')) ?>
                                <div class="row justify-content-center">
                                    <div class="col-md-5">
                                        <label class="form-label"><strong>Identificación: </strong></label>
                                        <div class="input-group">
                                            <input class="form-control" id="identificacion" name="identificacion" type="text" required placeholder="Ingresa el número de identificación" autofocus>

                                            <?php $validation = \Config\Services::validation(); ?>

                                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>

                                    <div class="col-md-5 p-2">
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <b>Recuerda: </b> Que el empleado debe estar previamente registrado
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    </div>
                                </div>
                                <?= form_close(); ?>
                            </div>
                        </div>

                        <div id="contenido_empleado" class="card mt-3" style="display: NONE">

                            <div class="card-header">
                                <strong>Datos del empleado</strong>
                            </div>
                            <div class="row align-items-center justify-content-center p-3">

                                <div class="col-md-5 mb-3">
                                    <label class="form-label"><strong>Identificación:</strong></label>
                                    <input type="text" class="form-control" name="nro_doc" id="nro_doc" disabled>
                                </div>

                                <div class="col-md-5 mb-3">
                                    <label class="form-label"><strong>Sexo:</strong></label>
                                    <input type="text" class="form-control" name="sexo" id="sexo" disabled>
                                </div>

                                <div class="col-md-5 mb-3">
                                    <label class="form-label"><strong>Nombre(s):</strong></label>
                                    <input type="text" class="form-control" name="nombre" id="nombre" disabled>
                                </div>

                                <div class="col-md-5 mb-3">
                                    <label class="form-label"><strong>Apellido(s):</strong></label>
                                    <input type="text" class="form-control" name="apellido" id="apellido" disabled>
                                </div>


                                <div class="col-md-5 mb-3">
                                    <label class="form-label"><strong>Celular:</strong></label>
                                    <input type="text" class="form-control" name="celular" id="celular" disabled>
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label class="form-label"><strong>Profesión: </strong></label>
                                    <input type="text" class="form-control" name="profesion" id="profesion" disabled>
                                </div>

                                <div class="col-md-10">
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Correo Electrónico: </strong></label>
                                        <input type="text" class="form-control" name="correo" id="correo" disabled>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div id="contenido_usuario" class="card mt-3" style="display: NONE">

                            <div class="card-header">
                                <strong>Asignación de usuario</strong>
                            </div>

                            <?= form_open_multipart('#', array('id' => 'frmusuario', 'name' => 'frmusuario')) ?>
                            <div class="row align-items-center justify-content-center p-3">
                               
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>Importante: </strong> Presiona en generar para asignarle un usuario y su contraseña temporal.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Usuario:</strong></label>
                                        <input type="text" class="form-control" name="usuario" id="usuario" placeholder="esperando..." readonly="readonly">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Contraseña:</strong></label>
                                        <input type="text" class="form-control" name="contrasenia" id="contrasenia" placeholder="esperando..." readonly="readonly">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label for="codRol"><strong>Rol: </strong></label>
                                            <?php
                                            echo form_dropdown('codRol', $comboRoles, '', 'class=" selectpicker form-control" id="codRol" data-live-search="true" required title="Seleccione el rol de acceso"');
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <?php $validation = \Config\Services::validation(); ?>


                            </div>

                            <div class="row align-items-center justify-content-center mb-4">

                                <div class="col-md-12">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                        <button type="button" class="btn btn-primary" onclick="generar();">Generar</button>

                                        <button type="submit" class="btn btn-success">Registrar</button>

                                        <button type="button" class="btn btn-warning text-black" onclick="Ocultar_informacion();">Limpiar Campos</button>

                                        <a href="<?php echo base_url('/resumen-usuarios'); ?>">
                                            <button type="button" class="btn btn-danger col">Cancelar</button>
                                        </a>
                                    </div>

                                </div>

                            </div>

                            <?= form_close(); ?>

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