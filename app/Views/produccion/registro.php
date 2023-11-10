<div class="layoutSidenav_content pt-4">
    <main>
        <div class="container-fluid px-4">
            
            <div class="d-flex align-items-center justify-content-between">
                <div class="h4 text-gray-800">
                    <p class="d-none d-md-inline">Registro de Proyectos</p>
                </div>
                <ul class="nav nav-pills my-auto" id="pills-tab" role="tablist">
                    <!-- Nuevo Registro de Proyectos -->
                    <li class="ml-sm-2 nav-item" role="presentation">
                        <button class="nav-link border active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><i class="bi bi-bag-plus"></i> Nuevo</button>
                    </li>
                    <!-- Reportes/Resumen del Proyecto -->
                    <li class="ml-sm-2 nav-item" role="presentation">
                        <button class="nav-link border" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false"><i class="bi bi-bag-check"></i> Reportes</button>
                    </li>
                    <!-- Edición de los campos registrados en el Proyecto -->
                    <li class="ml-sm-2 nav-item" role="presentation">
                        <button class="nav-link border" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false"><i class="bi bi-bag-x"></i> Editar </button>
                    </li>
                </ul>
            </div>
            <!-- Formulario de Registro de Proyectos -->
            <div class="tab-content mt-4" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <?= form_open_multipart('#', array('id' => 'frmRegProyect', 'name' => 'frmRegProyect')) ?>
                    <div class="row mx-auto">
                        <div class="col-md-3 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="codigo_beneficiario" name="Codigo" placeholder="Codigo"></input>
                                <label for="exampleFormControlInput1" class="form-label">Código</label>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="codigo_beneficiario" name="NContrato" placeholder="Codigo"></input>
                                <label for="exampleFormControlInput1" class="form-label">Número de Contrato</label>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-floating">
                                <select class="form-select" id="SelectConvocatoria" name="Conv" aria-label="Floating label select example">
                                </select>
                                <label for="modulo">Convocatoria</label>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-floating">
                                <select class="form-select" id="SelectPerson" name="Persona" aria-label="Floating label select example">
                                </select>
                                <label for="modulo">Persona</label>
                            </div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <div class="form-floating">
                                <select class="form-select" id="sel_departamento">
                                </select>
                                <label for="floatingSelect">Departamento</label>
                            </div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <div class="form-floating">
                                <select class="form-select" id="sel_provincia">
                                </select>
                                <label for="floatingSelect">Provincia</label>
                            </div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <div class="form-floating">
                                <select class="form-select" id="sel_distrito" name="dist">
                                </select>
                                <label for="floatingSelect">Distrito</label>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="Sector" name="Sector" placeholder="Dirección"></input>
                                <label for="exampleFormControlInput1" class="form-label">Sector</label>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6 mb-3">
                            <div class="form-floating">
                                <select class="form-select" id="tipoUrb" name="tipoUrb" aria-label="Floating label select example">
                                    <option value="-1">Seleccione</option>
                                    <option value="1">Urb. Urbanización</option>
                                    <option value="2">P.J. Pueblo Joven</option>
                                    <option value="3">U.V. Unidad Vecinal</option>
                                    <option value="4">C.H. Conjunto Habitacional</option>
                                    <option value="5">A.H. Asentamiento Humano</option>
                                    <option value="6">Coo. Cooperativa</option>
                                    <option value="7">Res. Residencial</option>
                                    <option value="8">Z.I. Zona Industrial</option>
                                    <option value="9">Gru. Grupo</option>
                                    <option value="10">Cas. Caserio</option>
                                    <option value="11">Fnd. Fundo</option>
                                    <option value="12">Otros</option>
                                </select>
                                <label for="estado_beneficario">Tipo de Selec</label>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="direccion_proyecto" name="direccion_proyecto" placeholder="Dirección"></input>
                                <label for="exampleFormControlInput1" class="form-label">Dirección</label>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="Manz" name="Manz" placeholder="Dirección"></input>
                                <label for="exampleFormControlInput1" class="form-label">Manzana</label>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="Lote" name="Lote" placeholder="Dirección"></input>
                                <label for="exampleFormControlInput1" class="form-label">Lote</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 row mx-auto">
                            <div class="col-sm-8 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="Frente" name="Frente" placeholder="Dirección"></input>
                                    <label for="exampleFormControlInput1" class="form-label">Frente</label>
                                </div>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="FrenteM" name="FrenteM" min="0" oninput="CalcularPerimetro()" placeholder="Dirección"></input>
                                    <label for="exampleFormControlInput1" class="form-label">Medida</label>
                                </div>
                            </div>
                            <div class="col-sm-8 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="Derecha" name="Derecha" placeholder="Dirección"></input>
                                    <label for="exampleFormControlInput1" class="form-label">Derecha</label>
                                </div>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="DerechaM" name="DerechaM" min="0" oninput="CalcularPerimetro()"  placeholder="Dirección"></input>
                                    <label for="exampleFormControlInput1" class="form-label">Medida</label>
                                </div>
                            </div>
                            <div class="col-sm-8 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="Izquierda" name="Izquierda"  placeholder="Dirección"></input>
                                    <label for="exampleFormControlInput1" class="form-label">Izquierda</label>
                                </div>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="IzquierdaM" name="IzquierdaM" min="0" oninput="CalcularPerimetro()"  placeholder="Dirección"></input>
                                    <label for="exampleFormControlInput1" class="form-label">Medida</label>
                                </div>
                            </div>
                            <div class="col-sm-8 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="Fondo" name="Fondo" placeholder="Dirección"></input>
                                    <label for="exampleFormControlInput1" class="form-label">Fondo</label>
                                </div>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="FondoM" name="FondoM" min="0" oninput="CalcularPerimetro()"  placeholder="Dirección"></input>
                                    <label for="exampleFormControlInput1" class="form-label">Medida</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 row mx-auto">
                            <div class="col-sm-4 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="Area" name="Area" min="0" oninput="CalcularPresupuesto()" placeholder="Dirección"></input>
                                    <label for="exampleFormControlInput1" class="form-label">Área</label>
                                </div>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="Arancel" name="Arancel" placeholder="Dirección"></input>
                                    <label for="exampleFormControlInput1" class="form-label">Arancel</label>
                                </div>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="CVU" name="CVU" min="0" oninput="CalcularPresupuesto()" placeholder="Dirección"></input>
                                    <label for="exampleFormControlInput1" class="form-label">CVU</label>
                                </div>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="Perimetro" placeholder="Dirección" readonly></input>
                                    <label for="exampleFormControlInput1" class="form-label">Perímetro</label>
                                </div>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" value="26400" id="VObra" name="VObra" placeholder="Dirección"></input>
                                    <label for="exampleFormControlInput1" class="form-label">Valor de Obra</label>
                                </div>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="Presupuesto" name="Presupuesto" placeholder="Dirección" readonly></input>
                                    <label for="exampleFormControlInput1" class="form-label">Presupuesto</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <select class="form-select" id="SelectModule" name="Modulo" aria-label="Floating label select example">
                                    </select>
                                    <label for="modulo">Módulo</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="CoorX" name="CoorX" placeholder="Codigo" step="0.00000001"></input>
                                    <label for="exampleFormControlInput1" class="form-label">Coordenada X</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="CoorY" name="CoorY" placeholder="Codigo" step="0.00000001"></input>
                                    <label for="exampleFormControlInput1" class="form-label">Coordenada Y</label>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="form-floating">
                                    <select class="form-select" id="estado_beneficario" name="estado" aria-label="Floating label select example">
                                        <option class="text-bold" value="-1"> Selecciona</option>
                                        <option class="text-success text-bold" value="E"> ■ Elegible</option>
                                        <option class="text-danger text-bold" value="N"> ■ No Elegible</option>
                                        <option class="text-secondary text-bold" value="D"> ■ Desembolsado</option>
                                        <option class="text-warning text-bold" value="C"> ■ Con otra E.T.</option>
                                    </select>
                                    <label for="estado_beneficario">Estado</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="date" max="<?php echo date('Y-m-d', strtotime("today")); ?>" value="<?php echo date('Y-m-d', strtotime("today")); ?>" class="form-control" id="fecha" name="fecha" placeholder="-"></input>
                                    <label for="nacimi" class="form-label">Fecha</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-auto">
                        <div class="col-sm-3 d-flex justify-content-center mx-auto">
                            <div class="form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="Luz" name="Luz">
                                <label class="form-check-label">Luz</label>
                            </div>
                        </div>
                        <div class="col-sm-3 d-flex justify-content-center mx-auto">
                            <div class="form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="Agua" name="Agua">
                                <label class="form-check-label" for="flexSwitchCheckChecked">Agua</label>
                            </div>
                        </div>
                        <div class="col-sm-3 d-flex justify-content-center mx-auto">
                            <div class="form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="Desage" name="Desage">
                                <label class="form-check-label" for="flexSwitchCheckChecked">Desagüe</label>
                            </div>
                        </div>
                        <div class="col-sm-3 d-flex justify-content-center mx-auto">
                            <div class="form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="Septico" name="Septico">
                                <label class="form-check-label" for="flexSwitchCheckChecked">Pozo Séptico</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col d-flex flex-row-reverse mb-2">
                            <!-- Button trigger modal -->
                            <button id="btn_limpiar" type="button" class="btn btn-secondary m-2" onClick="Clean()">Limpiar Campos</button>
                            <button type="submit" class="btn btn-primary m-2">Registrar</button>
                        </div>
                    </div>
                    <?= form_close(); ?>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div id="TitleResumen" class="row d-none">
                        <div class="mb-0 text-center text-secondary">No hay datos suficientes para cargar el resumen</div>
                    </div>
                    <div id="Resumen" class="d-none row">
                        <div class="col-md-4 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Último Proyecto</div>
                                            <div id="last" class="h5 mb-0 font-weight-bold"></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" col-md-3 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Convocatoria Actual</div>
                                            <div id="lastConv" class="h5 mb-0 font-weight-bold"></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="bi bi-megaphone-fill fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" col-md-5 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Porcentaje de Proyectos</div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col">
                                                    <div class="progress mr-2">
                                                        <div id="EL" class="progress-bar bg-success text-white" role="progressbar" style="width: 0%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="NE" class="progress-bar bg-danger text-white" role="progressbar" style="width: 0%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="DE" class="progress-bar bg-secondary text-white" role="progressbar" style="width: 0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                        <div id="CN" class="progress-bar bg-warning text-white" role="progressbar" style="width: 0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row p-1">
                                                <div class="col-auto">
                                                    <div class="text-xs text-success">Elegibles</div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="text-xs text-danger">No elegibles</div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="text-xs text-secondary">Desembolsados</div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="text-xs text-warning">Con otra E.T.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card" id=card_beneficiarios>
                        <div class="card-header">
                            <b>Tabla de Proyectos</b>
                        </div>
                        <div class="card-text p-4">
                            <div class="table-responsive" id="tabla_beneficiarios">
                                <table id="tablaProyects" class="table table-bordered table-sm w-100">
                                    <thead class="text-center bg-primary text-white">
                                        <tr>
                                            <th scope="col">Estado</th>
                                            <th scope="col">Código</th>
                                            <th scope="col">Número de Contrato</th>
                                            <th scope="col">Convocatoria</th>
                                            <th scope="col">Beneficiario</th>
                                            <th scope="col">DNI</th>
                                            <th scope="col">Módulo</th>
                                            <th scope="col">Área techada</th>
                                            <th scope="col">Área Construida</th>
                                            <th scope="col">Sector</th>
                                            <th scope="col">Dirección</th>
                                            <th scope="col">Mz</th>
                                            <th scope="col">Lote</th>
                                            <th scope="col">Frente</th>
                                            <th scope="col">Medida del Frente</th>
                                            <th scope="col">Derecha</th>
                                            <th scope="col">Medida del Derecha</th>
                                            <th scope="col">Izquierda</th>
                                            <th scope="col">Medida del Izquierda</th>
                                            <th scope="col">Fondo</th>
                                            <th scope="col">Medida del Fondo</th>
                                            <th scope="col">Área</th>
                                            <th scope="col">Arancel</th>
                                            <th scope="col">CVU</th>
                                            <th scope="col">Valor de Obra</th>
                                            <th scope="col">x</th>
                                            <th scope="col">y</th>
                                            <th scope="col">Departamento</th>
                                            <th scope="col">Provincia</th>
                                            <th scope="col">Distrito</th>
                                            <th scope="col">Alcalde</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Luz</th>
                                            <th scope="col">Agua</th>
                                            <th scope="col">Desague</th>
                                            <th scope="col">Pozo Séptico</th>
                                            <th scope="col">Fecha de Registro</th>
                                            <th scope="col">Registrado por</th>
                                            <th scope="col">Archivos</th>
                                            <th scope="col">En mapa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                    <?= form_open_multipart('#', array('id' => 'frmConsultaProyect', 'name' => 'frmConsultaProyect')) ?>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                        <div>
                            <select class="form-select" name="TipoDato" id="inputGroupSelect01">
                                <option value="1">Código </option>
                                <option value="2">Contrato </option>
                                <option value="3">DNI </option>
                            </select>
                        </div>
                        <div class="input-group">
                            <input type="text" id="editBuscador" name="Dato" class="form-control" placeholder="Código o Nombre del Material">
                            <button type="submit" class="btn btn-primary bi bi-search" href="http://localhost:82/inserge/clb_productos/doList"></button>
                            <a onClick="CleanEditProyect()" class="btn btn-secondary bi bi-x-lg"></a>
                        </div>
                    </div>
                    <?= form_close(); ?>
                    <?= form_open_multipart('#', array('id' => 'frmUpdateProyect', 'name' => 'frmUpdateProyect')) ?>
                    <div class="row">
                        <div class="col-sm-3 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="editcodigo_beneficiario" name="Codigo" placeholder="Codigo"></input>
                                <label for="exampleFormControlInput1" class="form-label">Código</label>
                            </div>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="editcontrato_beneficiario" name="NContrato" placeholder="Codigo"></input>
                                <label for="exampleFormControlInput1" class="form-label">N Contrato</label>
                            </div>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="editPerson_beneficiario" placeholder="Codigo" readonly></input>
                                <label for="exampleFormControlInput1" class="form-label">Persona</label>
                            </div>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <div class="form-floating">
                                <select class="form-select" id="editestado_beneficario" name="estado" aria-label="Floating label select example">
                                    <option class="text-bold" value="-1"> Selecciona</option>
                                    <option class="text-success text-bold" value="E"> ■ Elegible</option>
                                    <option class="text-danger text-bold" value="N"> ■ No Elegible</option>
                                    <option class="text-secondary text-bold" value="D"> ■ Desembolsado</option>
                                    <option class="text-warning text-bold" value="C"> ■ Con otra E.T.</option>
                                </select>
                                <label for="estado_beneficario">Estado</label>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="editSector" name="Sector" placeholder="Dirección"></input>
                                <label for="exampleFormControlInput1" class="form-label">Sector</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="form-floating">
                                <select class="form-select" id="editTipoUrb" name="tipoUrb" aria-label="Floating label select example">
                                <option value="-1">Seleccione</option>
                                    <option value="1">Urb. Urbanización</option>
                                    <option value="2">P.J. Pueblo Joven</option>
                                    <option value="3">U.V. Unidad Vecinal</option>
                                    <option value="4">C.H. Conjunto Habitacional</option>
                                    <option value="5">A.H. Asentamiento Humano</option>
                                    <option value="6">Coo. Cooperativa</option>
                                    <option value="7">Res. Residencial</option>
                                    <option value="8">Z.I. Zona Industrial</option>
                                    <option value="9">Gru. Grupo</option>
                                    <option value="10">Cas. Caserio</option>
                                    <option value="11">Fnd. Fundo</option>
                                    <option value="12">Otros</option>
                                </select>
                                <label for="estado_beneficario">Tipo de Selec</label>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-8 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="editDireccion_proyecto" name="direccion_proyecto" placeholder="Dirección"></input>
                                <label for="exampleFormControlInput1" class="form-label">Dirección</label>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-2 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="editManz" name="Manz" placeholder="Dirección"></input>
                                <label for="exampleFormControlInput1" class="form-label">Manzana</label>
                            </div>
                        </div>
                        <div class="col-md-1 col-sm-2 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="editLote" name="Lote" placeholder="Dirección"></input>
                                <label for="exampleFormControlInput1" class="form-label">Lote</label>
                            </div>
                        </div>
                    </div>
                    <div class="mx-auto row">
                        <div class="col-md-6 row">
                            <div class="col-sm-8 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="editFrente" name="Frente" placeholder="Dirección"></input>
                                    <label for="exampleFormControlInput1" class="form-label">Frente</label>
                                </div>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="editFrenteM" name="FrenteM" min="0" oninput="CalcularPerimetro2()" placeholder="Dirección"></input>
                                    <label for="exampleFormControlInput1" class="form-label">Medida</label>
                                </div>
                            </div>
                            <div class="col-sm-8 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="editDerecha" name="Derecha" placeholder="Dirección"></input>
                                    <label for="exampleFormControlInput1" class="form-label">Derecha</label>
                                </div>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="editDerechaM" name="DerechaM" min="0" oninput="CalcularPerimetro2()" placeholder="Dirección"></input>
                                    <label for="exampleFormControlInput1" class="form-label">Medida</label>
                                </div>
                            </div>
                            <div class="col-sm-8 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="editIzquierda" name="Izquierda"  placeholder="Dirección"></input>
                                    <label for="exampleFormControlInput1" class="form-label">Izquierda</label>
                                </div>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="editIzquierdaM" name="IzquierdaM" min="0" oninput="CalcularPerimetro2()" placeholder="Dirección"></input>
                                    <label for="exampleFormControlInput1" class="form-label">Medida</label>
                                </div>
                            </div>
                            <div class="col-sm-8 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="editFondo" name="Fondo" placeholder="Dirección"></input>
                                    <label for="exampleFormControlInput1" class="form-label">Fondo</label>
                                </div>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="editFondoM" name="FondoM" min="0" oninput="CalcularPerimetro2()" placeholder="Dirección"></input>
                                    <label for="exampleFormControlInput1" class="form-label">Medida</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 row">
                            <div class="col-sm-4 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="editArea" name="Area" min="0" oninput="CalcularPresupuesto2()" placeholder="Dirección"></input>
                                    <label for="exampleFormControlInput1" class="form-label">Área</label>
                                </div>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="editArancel" name="Arancel" placeholder="Dirección"></input>
                                    <label for="exampleFormControlInput1" class="form-label">Arancel</label>
                                </div>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="editPerimetro" placeholder="Dirección" readonly></input>
                                    <label for="exampleFormControlInput1" class="form-label">Perímetro</label>
                                </div>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="editCVU" name="CVU" min="0" oninput="CalcularPresupuesto2()"  placeholder="Dirección"></input>
                                    <label for="exampleFormControlInput1" class="form-label">CVU</label>
                                </div>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" value="26400" id="editVObra" name="VObra" placeholder="Dirección"></input>
                                    <label for="exampleFormControlInput1" class="form-label">Valor de Obra</label>
                                </div>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="editPresupuesto" name="Presupuesto" placeholder="Dirección" readonly></input>
                                    <label for="exampleFormControlInput1" class="form-label">Presupuesto</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-2 mb-3">
                                <div class="form-floating">
                                    <select class="form-select" id="SelectModule2" name="Modulo" aria-label="Floating label select example">
                                    </select>
                                    <label for="modulo">Módulo</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="date" max="<?php echo date('Y-m-d', strtotime("today")); ?>" value="<?php echo date('Y-m-d', strtotime("today")); ?>" class="form-control" id="editFecha" name="fecha" placeholder="-"></input>
                                    <label for="nacimi" class="form-label">Fecha</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-3 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="editCoorX" name="CoorX" placeholder="Codigo" step="0.00000001"></input>
                                    <label for="exampleFormControlInput1" class="form-label">Coord X</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-3 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="editCoorY" name="CoorY" placeholder="Codigo" step="0.00000001"></input>
                                    <label for="exampleFormControlInput1" class="form-label">Coord Y</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-sm-3 d-flex justify-content-center mx-auto">
                            <div class="form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="editLuz" name="Luz">
                                <label class="form-check-label">Luz</label>
                            </div>
                        </div>
                        <div class="col-sm-3 d-flex justify-content-center mx-auto">
                            <div class="form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="editAgua" name="Agua">
                                <label class="form-check-label" for="flexSwitchCheckChecked">Agua</label>
                            </div>
                        </div>
                        <div class="col-sm-3 d-flex justify-content-center mx-auto">
                            <div class="form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="editDesage" name="Desage">
                                <label class="form-check-label" for="flexSwitchCheckChecked">Desagüe</label>
                            </div>
                        </div>
                        <div class="col-sm-3 d-flex justify-content-center mx-auto">
                            <div class="form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="editSeptico" name="Septico">
                                <label class="form-check-label" for="flexSwitchCheckChecked">Pozo Séptico</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <div class="input-group">
                                <input type="text" class="form-control" id="UrlModal" readonly>
                                <button class="btn btn-primary" type="button" id="button-addon2" data-bs-dismiss="modal"><i class="text-white bi bi-box-arrow-in-down"></i></button>
                                <button class="btn btn-danger" type="button" data-bs-dismiss="modal"><i class="bi bi-x-lg text-white"></i></button>
                            </div>
                        </div>
                        <div class="modal-body overflow-auto" id="ModalBody" style="max-height: 500px;">
                            <div class="spinner-border mx-auto" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <?= form_open_multipart('#', array('id' => 'frmUpFile', 'name' => 'frmUpFile')) ?>
                        <div class="modal-footer">
                            <p class="mr-auto">Subir archivo</p>
                            <div class="input-group">
                                <input type="file" name="file" class="form-control" id="fileDesc">
                                <button type="submit" class="btn btn-success"><i class="bi bi-box-arrow-up text-white"></i></button>
                            </div>
                            <small id="MensajeFiles" class="mr-auto text-success">Subir archivo</small>
                        </div>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>