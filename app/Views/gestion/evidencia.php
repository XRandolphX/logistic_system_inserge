<?php
if (isset($_SESSION['usuario']) && $_SESSION['Categorias'] == 1 && $_SESSION['status_usuario'] == 1) {
?>

    <div class="layoutSidenav_content py-4">
        <main>
            <div class="container-fluid px-4">
                <div id="TitleResumen" class="row d-none">
                    <div class="mb-0 text-center text-secondary">No hay datos suficientes para cargar el resumen</div>
                </div>
                <div id="Resumen" class="d-none row">
                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-2 col-md-3 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total de archivos
                                        </div>
                                        <div id="TotalResumeEvid" class="h4 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-box fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Earnings (Annual) Card Example -->
                    <div class="col-xl-10 col-md-12 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Estado de Archivos</div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col">
                                                <div class="progress mr-2">
                                                    <div id="ArchivoResumeEvid" class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div id="FotografiaResumeEvid" class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div id="RenderResumeEvid" class="progress-bar bg-warning" role="progressbar" style="width: 0%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div id="DocumentaciónResumeEvid" class="progress-bar bg-info" role="progressbar" style="width: 0%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div id="PerfilResumeEvid" class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div id="OtroResumeEvid" class="progress-bar bg-secondary" role="progressbar" style="width: 0%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-1 d-flex justify-content-between">
                                            <div class="col-auto">
                                                <div class="text-xs text-success">Archivo</div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="text-xs text-danger">Fotografía</div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="text-xs text-warning">Render</div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="text-xs text-info">Documentación</div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="text-xs text-primary">Perfil</div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="text-xs text-secondary">Otros</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="fw-bold text-center pb-3">Administración de Evidencias</div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="border overflow-auto border-secondary d-flex justify-content-center rounded-3">
                                            <img id="pax" class="mh-100 p-2 position-absolute">
                                        </div>
                                    </div>
                                    <div class="col-sm-8 pt-3">
                                        <?php $validation = \Config\Services::validation(); ?>
                                        <?= form_open_multipart('#', array('id' => 'frmregEvidencia', 'name' => 'frmregEvidencia')) ?>
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="editUnid" name="desc" placeholder="-"></input>
                                            <label for="conv" class="form-label">Descripción</label>
                                        </div>
                                        <div class="mt-3 w-100">
                                            <input type="file" accept=".jpg, .jpeg, .png" name="foto" id="fotitos"></input>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-floating mt-3">
                                                    <select class="form-select js-example-basic-single form-select-sm" name="tipo" id="status_modal" aria-label="Floating label select example">
                                                        <option value="-1"> Selección </option>
                                                        <option value="1"> Archivo </option>
                                                        <option value="2"> Fotografía </option>
                                                        <option value="3"> Render </option>
                                                        <option value="4"> Documentación </option>
                                                        <option value="5"> Perfil </option>
                                                        <option value="0"> Otro </option>
                                                    </select>
                                                    <label for="estado" class="form-label">Tipo</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mt-3">
                                                    <input type="date" value="<?php echo date('Y-m-d', strtotime("today")); ?>" max="<?php echo date('Y-m-d', strtotime("today")); ?>" class="form-control" id="editNacimi" name="fecha" placeholder="-"></input>
                                                    <label for="nacimi" class="form-label">Fecha</label>
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="text-center m-3">Etiquetas</h5>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-floating ">
                                                    <select class="form-select js-example-basic-single form-select-sm" name="modulo" id="SelectModule" aria-label="Floating label select example">
                                                    </select>
                                                    <label for="estado" class="form-label">Módulo</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating mt-3 mt-md-0">
                                                    <select class="form-select js-example-basic-single form-select-sm" name="person" id="SelectPerson" aria-label="Floating label select example">
                                                    </select>
                                                    <label for="estado" class="form-label">Persona</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating mt-3 mt-md-0">
                                                    <select class="form-select js-example-basic-single form-select-sm" name="proyct" id="SelectMedida" aria-label="Floating label select example">
                                                    </select>
                                                    <label for="" class="form-label">Proyecto</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating mt-3">
                                                    <select class="form-select js-example-basic-single form-select-sm" name="Conv" id="SelectConvocatoria" aria-label="Floating label select example">
                                                    </select>
                                                    <label for="estado" class="form-label">Convocatoria</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating mt-3">
                                                    <select class="form-select js-example-basic-single form-select-sm" name="Prodc" id="SelectCategory" aria-label="Floating label select example">
                                                    </select>
                                                    <label for="estado" class="form-label">Producto</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating mt-3">
                                                    <select class="form-select js-example-basic-single form-select-sm" name="Prov" id="SelectProveedor" aria-label="Floating label select example">
                                                    </select>
                                                    <label for="estado" class="form-label">Proveedor</label>
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
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="my-4">
                            <div id="Pepito" class="card-columns">
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