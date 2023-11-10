<?php
if (isset($_SESSION['usuario']) && $_SESSION['Talento'] == 1 && $_SESSION['status_usuario'] == 1) {
?>

<div class="layoutSidenav_content py-4">
    <main>
        <div class="container-fluid px-4">
            <div id="TitleResumen" class="row d-none">
                <div class="mb-0 text-center text-secondary">No hay datos suficientes para cargar el resumen</div>
            </div>
            <div id="Resumen" class="row d-none">
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-2 col-md-3 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Registos Totales:</div>
                                    <div id="TotalResumePerson" class="h4 mb-0 font-weight-bold text-gray-800"></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-box fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Earnings (Annual) Card Example -->
                <div class="col-xl-2 col-md-3 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Registrados Hoy</div>
                                    <div id="TodayResumePerson" class="h5 mb-0 font-weight-bold text-gray-800">
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clock fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tasks Card Example -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">% con Datos completos
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col">
                                            <div class="progress mr-2">
                                                <div id="CompleteResumePerson" class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                <div id="IncompleteResumePerson" class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row p-1 d-flex justify-content-between">
                                        <div class="col-auto">
                                            <div class="text-xs text-success">Datos completos</div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="text-xs text-danger">Datos imcompletos</div>
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

                <div class="col-xl-4 col-md-12 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Estado de Personas</div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col">
                                            <div class="progress mx-2 ">
                                                <div id="ActiveResumePerson" class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                <div id="InactiveResumePerson" class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row  mx-2 p-1 d-flex justify-content-between">
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
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-2 col-md-4 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Promedio de Edad</div>
                                    <div id="AvgEdadResumePerson" class="h4 mb-0 font-weight-bold text-gray-800"></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-box fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-5 col-md-8 mb-4">
                    <div class="card border-left-secondary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Último registro:</div>
                                    <div id="LastResumePerson" class="h4 mb-0 font-weight-bold text-gray-800"></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-box fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-md-12 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">% de Sexo de personas</div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col">
                                            <div class="progress mx-2">
                                                <div id="MResumePerson" class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                <div id="FResumePerson" class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                                <div id="NResumePerson" class="progress-bar bg-secondary" role="progressbar" style="width: 0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row p-1 d-flex  mx-1 justify-content-between">
                                        <div class="col-auto">
                                            <div class="text-xs text-success">Masculino</div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="text-xs text-danger">Femenino</div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="text-xs text-secondary">No especificado</div>
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
                                <div class="fw-bold text-center pb-3">Administración de Talento</div>
                                <?php $validation = \Config\Services::validation(); ?>
                                <?= form_open_multipart('#', array('id' => 'frmregPersona', 'name' => 'frmregPersona')) ?>
                                <div class="row">
                                    <div class="col-sm-3 pt-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="dni" name="dni" placeholder="-"></input>
                                            <label for="dni" class="form-label">DNI</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-9 pt-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="-"></input>
                                            <label for="nombre" class="form-label">Nombre</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 pt-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="apelPAT" name="apelPAT" placeholder="-"></input>
                                            <label for="apelPAT" class="form-label">Apellido Paterno</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 pt-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="apelMAT" name="apelMAT" placeholder="-"></input>
                                            <label for="apelMAT" class="form-label">Apellido Materno</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8 pt-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="correo" name="correo" placeholder="-"></input>
                                            <label for="correo" class="form-label">Correo Electrónico</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 pt-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="tel" name="tel" placeholder="-"></input>
                                            <label for="tel" class="form-label">Teléfono</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 pt-3">
                                        <div class="form-floating">
                                            <select class="form-select js-example-basic-single form-select-sm" name="sexo" id="sexo" aria-label="Floating label select example">
                                            <option value="-1">Selecciona</option>
                                                <option value="M">Masculino</option>
                                                <option value="F">Femenino</option>
                                                <option value="N">No especifica</option>
                                            </select>
                                            <label for="sexo">Sexo</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 pt-3">
                                        <div class="form-floating">
                                            <select class="form-select js-example-basic-single form-select-sm" name="estado" id="estado" aria-label="Floating label select example">
                                            <option value="-1">Selecciona</option>
                                                <option value="0">Soltero</option>
                                                <option value="1">Casado</option>
                                                <option value="2">Divorciado</option>
                                                <option value="3">Viudo</option>
                                            </select>
                                            <label for="estado" class="form-label">Estado Civil</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 pt-3">
                                        <div class="form-floating">
                                            <select class="form-select js-example-basic-single form-select-sm" name="sel_departamento" id="sel_departamento" aria-label="Floating label select example">
                                            </select>
                                            <label for="sel_departamento">Departamento</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 pt-3">
                                        <div class="form-floating">
                                            <select class="form-select js-example-basic-single form-select-sm" name="sel_provincia" id="sel_provincia" aria-label="Floating label select example">
                                            </select>
                                            <label for="sel_provincia">Provincia</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 pt-3">
                                        <div class="form-floating">
                                            <select class="form-select js-example-basic-single form-select-sm" name="dist" id="sel_distrito" aria-label="Floating label select example">
                                            </select>
                                            <label for="dist">Distrito</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-7 pt-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="dir" name="dir" placeholder="-"></input>
                                            <label for="dir" class="form-label">Direccion</label>
                                        </div>
                                    </div>
                                    <div class="col-md-5 pt-3">
                                        <div class="form-floating">
                                            <input type="date" max="<?php echo date('Y-m-d', strtotime("-18 years")); ?>" class="form-control" id="nacimi" name="nacimi" placeholder="-"></input>
                                            <label for="nacimi" class="form-label">Fecha de Nacimiento</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="profe" name="profe" placeholder="-"></input>
                                        <label for="profe" class="form-label">Profesión</label>
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
                            <div class="fw-bold text-center pb-3">Listado de Talento</div>
                                <div class="pt-2">
                                    <div class="table-responsive">
                                        <table id="Table_Personas" class="table table-bordered table-sm w-100">
                                            <thead class="text-center bg-primary text-white">
                                                <tr>
                                                    <th scope="col">DNI</th>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Nombre</th>
                                                    <th scope="col">Apellido Paterno</th>
                                                    <th scope="col">Apellido Materno</th>
                                                    <th scope="col">Sexo</th>
                                                    <th scope="col">Dirección</th>
                                                    <th scope="col">Teléfono</th>
                                                    <th scope="col">Email</th>
                                                    <th scope="col">Profesión</th>
                                                    <th scope="col">Departamento</th>
                                                    <th scope="col">Provincia</th>
                                                    <th scope="col">Distrito</th>
                                                    <th scope="col">Fecha de Nacimiento</th>
                                                    <th scope="col">Registrado por</th>
                                                    <th scope="col">Fecha de registro</th>
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
                                <?= form_open_multipart('#', array('id' => 'frmeditPerson', 'name' => 'frmeditPerson')) ?>
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
                                    <div class="row">
                                        <div class="col-sm-3 pt-3">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" id="editdni" name="dni" placeholder="-"></input>
                                                <label for="dni" class="form-label">DNI</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-9 pt-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="editnombre" name="nombre" placeholder="-"></input>
                                                <label for="nombre" class="form-label">Nombre</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 pt-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="editapelPAT" name="apelPAT" placeholder="-"></input>
                                                <label for="apelPAT" class="form-label">Apellido Paterno</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pt-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="editapelMAT" name="apelMAT" placeholder="-"></input>
                                                <label for="apelMAT" class="form-label">Apellido Materno</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8 pt-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="editCorreo" name="correo" placeholder="-"></input>
                                                <label for="correo" class="form-label">Correo Electrónico</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 pt-3">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" id="editTel" name="tel" placeholder="-"></input>
                                                <label for="tel" class="form-label">Teléfono</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 pt-3">
                                            <div class="form-floating">
                                                <select class="form-select js-example-basic-single form-select-sm" name="sexo" id="sexo_modal" aria-label="Floating label select example">
                                                    <option value="M">Masculino</option>
                                                    <option value="F">Femenino</option>
                                                    <option value="N">No especifica</option>
                                                </select>
                                                <label for="sexo">Sexo</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 pt-3">
                                            <div class="form-floating">
                                                <select class="form-select js-example-basic-single form-select-sm" name="estado" id="status_modal" aria-label="Floating label select example">
                                                    <option value="0">Soltero</option>
                                                    <option value="1">Casado</option>
                                                    <option value="2">Divorciado</option>
                                                    <option value="3">Viudo</option>
                                                </select>
                                                <label for="estado" class="form-label">Estado Civil</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4 pt-3">
                                            <div class="form-floating">
                                                <select class="form-select js-example-basic-single form-select-sm" name="sel_departamento_modal" id="sel_departamento_modal" aria-label="Floating label select example">
                                                </select>
                                                <label for="sel_departamento_modal">Departamento</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 pt-3">
                                            <div class="form-floating">
                                                <select class="form-select js-example-basic-single form-select-sm" name="sel_provincia" id="sel_provincia_modal" aria-label="Floating label select example">
                                                </select>
                                                <label for="sel_provincia_modal">Provincia</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 pt-3">
                                            <div class="form-floating">
                                                <select class="form-select js-example-basic-single form-select-sm" name="dist" id="sel_distrito_modal" aria-label="Floating label select example">
                                                </select>
                                                <label for="dist">Distrito</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-7 pt-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="editDir" name="dir" placeholder="-"></input>
                                                <label for="dir" class="form-label">Dirección</label>
                                            </div>
                                        </div>
                                        <div class="col-md-5 pt-3">
                                            <div class="form-floating">
                                                <input type="date" value="<?php echo date('Y-m-d', strtotime("-18 years")); ?>" max="<?php echo date('Y-m-d', strtotime("-18 years")); ?>" class="form-control" id="editNacimi" name="nacimi" placeholder="-"></input>
                                                <label for="nacimi" class="form-label">Fecha de Nacimiento</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pt-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="editProfe" name="profe" placeholder="-"></input>
                                            <label for="profe" class="form-label">Profesión</label>
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