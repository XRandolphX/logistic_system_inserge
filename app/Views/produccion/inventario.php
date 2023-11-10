<?php
if (isset($_SESSION['usuario']) && $_SESSION['Inventario'] == 1 && $_SESSION['status_usuario'] == 1) {
?>
    <div class="layoutSidenav_content py-4">
        <main>
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="h4 mb-0 text-gray-800">
                        <p class="d-none d-md-inline">Registro de Productos</p>
                    </div>
                    <ul class="nav nav-pills my-auto" id="pills-tab" role="tablist">
                        <li class="ml-sm-2 nav-item" role="presentation">
                            <button class="nav-link border active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><i class="bi bi-bag-plus"></i> Nuevo Material</button>
                        </li>
                        <li class="ml-sm-2 nav-item" role="presentation">
                            <button class="nav-link border" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false"><i class="bi bi-bag-check"></i> Ingreso de material</button>
                        </li>
                        <li class="ml-sm-2 nav-item" role="presentation">
                            <button class="nav-link border" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false"><i class="bi bi-bag-x"></i> Retiro de material</button>
                        </li>
                        <li class="ml-sm-2 d-none d-sm-inline nav-item" role="presentation">
                            <a class="nav-link border" id="" type="button" role="tab" href="<?php echo base_url('/movimientos'); ?>"><i class="bi bi-bezier2"></i> Asignar</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content my-3" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <?= form_open_multipart('#', array('id' => 'frmregProducto', 'name' => 'frmregProducto')) ?>
                        <div class="row mx-auto">
                            <div class=" col-md-2 col-sm-3 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="" name="codigo_producto" placeholder="Codigo"></input>
                                    <label for="exampleFormControlInput1" class="form-label">Código</label>
                                </div>
                            </div>
                            <div class=" col-md-6 col-sm-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="" name="descripcion" placeholder="Codigo"></input>
                                    <label for="exampleFormControlInput1" class="form-label">Descripción</label>
                                </div>
                            </div>
                            <div class=" col-md-4 col-sm-3 mb-3">
                                <div class="input-group form-floating">
                                    <select class="form-select form-select-sm" id="SelectMedida" name="unidad_medida" aria-label="Floating label select example">
                                    </select>
                                    <label for="floatingSelect">Unid. Medida</label>
                                    <div class="input-group-append">
                                        <button class="btn" style="border: 1px solid #ced4da;" type="button"><a href="medida" class="bi bi-plus-lg text-secondary"></a></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-3 mb-3">
                                <div class="form-floating">
                                    <input type="number" min="1" class="form-control" id="" name="stock" placeholder="Codigo"></input>
                                    <label for="exampleFormControlInput1" class="form-label">Stock inicial</label>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-3 mb-3">
                                <div class="form-floating">
                                    <input type="number" min="1" class="form-control" id="" name="stockMin" placeholder="Codigo"></input>
                                    <label for="exampleFormControlInput1" class="form-label">Stock mínimo</label>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="form-floating">
                                    <select class="SelectPicker form-select form-select-sm" name="proveedor" id="SelectProveedor" aria-label="Floating label select example">
                                    </select>
                                    <label for="SelectProveedor">Proveedor principal</label>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-6 mb-3">
                                <div class="form-floating">
                                    <div class="form-floating">
                                        <input type="date" value="<?php echo date('Y-m-d', strtotime("today")); ?>" max="<?php echo date('Y-m-d', strtotime("today")); ?>" class="form-control" id="" name="Fllegada" placeholder="-"></input>
                                        <label for="nacimi" class="form-label">Fecha de llegada</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-6 mb-3">
                                <div class="form-floating">
                                    <div class="form-floating"><!-- value="<#? php echo date('H:i', strtotime("now")); ?>" -->
                                        <input type="time"  class="form-control" id="" name="Hllegada" placeholder="-"></input>
                                        <label for="nacimi" class="form-label">Hora de llegada</label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid d-flex justify-content-end">
                                <div class="justify-content-end flex-wrap">
                                    <small class="mr-2 text-secondary d-none d-md-inline">
                                        Recuerda completar los campos obligatorios
                                    </small>
                                    <button type="submit" class="btn btn-success bi bi-plus-lg mr-2"> Registrar </button>
                                    <a onClick="Clean()" class="btn btn-info bi bi-clipboard-x"> Limpiar Campos </a>
                                </div>
                            </div>
                        </div>
                        <?= form_close(); ?>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <?= form_open_multipart('#', array('id' => 'frmnewProducto', 'name' => 'frmnewProducto')) ?>
                        <div class="row mx-auto">

                            <div class="col-md-2 col-sm-3 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="Descrip" name="" placeholder="-" readonly></input>
                                    <label for="exampleFormControlInput1" class="form-label">Código</label>
                                </div>
                            </div>
                            <div class=" col-md-4 col-sm-3 mb-3">
                                <div class="form-floating">
                                    <div class="form-floating">
                                        <select class="form-select form-select-sm" id="SelectMateriales" name="id_producto" aria-label="Floating label select example">
                                        </select>
                                        <label for="floatingSelect">Producto</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-3 mb-3">
                                <div class="input-group form-floating">
                                    <select class="form-select js-example-basic-single form-select-sm" name="proveedor" id="SelectProveedor2" aria-label="Floating label select example" data-toggle="tooltip" data-placement="top" title="Tooltip on top" disabled>
                                    </select>
                                    <label for="sel_departamento">Proveedor</label>
                                    <div class="input-group-append">
                                        <button class="btn" style="border: 1px solid #ced4da;" type="button"><a href="<?php echo base_url('/proveedores'); ?>" class="bi bi-plus-lg text-secondary"></a></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-3 mb-3">
                                <div class="input-group form-floating">
                                    <select class="form-select js-example-basic-single form-select-sm" name="motivo" id="SelectMotivo" aria-label="Floating label select example" data-toggle="tooltip" data-placement="top" title="Tooltip on top" disabled>
                                        <option value=""> Selecciona </option>
                                        <option value="4"> Compra </option>
                                        <option value="5"> Donación </option>
                                    </select>
                                    <label for="sel_departamento">Motivo</label>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-3 mb-3">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="Stock" name="" placeholder="-" readonly></input>
                                    <label for="exampleFormControlInput1" class="form-label">Stock actual</label>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-4 mb-3">
                                <div class="form-floating">
                                    <input type="number" min="1" class="form-control" id="Cantidad" name="cantidad" placeholder="Codigo" readonly></input>
                                    <label for="exampleFormControlInput1" class="form-label">Cantidad</label>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="Obs" name="observacion" placeholder="Codigo" readonly></input>
                                    <label for="exampleFormControlInput1" class="form-label">Observación</label>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-4 mb-3">
                                <div class="form-floating">
                                    <div class="form-floating">
                                        <input type="date" value="<?php echo date('Y-m-d', strtotime("today")); ?>" max="<?php echo date('Y-m-d', strtotime("today")); ?>" class="form-control" id="Fllegada" name="Fllegada" placeholder="-" readonly></input>
                                        <label for="nacimi" class="form-label">Fecha de llegada</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-4 mb-3">
                                <div class="form-floating">
                                    <div class="form-floating">
                                        <input type="time" class="form-control" id="Hllegada" name="Hllegada" placeholder="-" readonly></input>
                                        <label for="nacimi" class="form-label">Hora de llegada</label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid d-flex justify-content-between">
                                <div class="d-none d-md-inline">
                                    <a onClick="" class="btn btn-secondary bi bi-list-ul mr-auto" data-bs-toggle="offcanvas" href="#offcanvasINSERT" role="button" aria-controls="offcanvasINSERT">
                                        Últimos movimientos
                                    </a>
                                </div>
                                <div class="justify-content-end flex-wrap">
                                    <small class="mr-2 text-secondary d-none d-md-inline">
                                        Recuerda completar los campos obligatorios
                                    </small>
                                    <button type="submit" class="btn btn-success bi bi-plus-lg mr-2"> Registrar </button>
                                    <a onClick="Clean()" class="btn btn-info bi bi-clipboard-x"> Limpiar Campos
                                    </a>
                                </div>
                            </div>

                        </div>
                        <?= form_close(); ?>
                    </div>

                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                        <?= form_open_multipart('#', array('id' => 'frmdropProducto', 'name' => 'frmdropProducto')) ?>
                        <div class="row mx-auto">
                            <div class="col-md-2 col-sm-3 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="Descrip2" name="" placeholder="-" readonly></input>
                                    <label for="exampleFormControlInput1" class="form-label">Código</label>
                                </div>
                            </div>
                            <div class=" col-md-4 col-sm-3 mb-3">
                                <div class="form-floating">
                                    <div class="form-floating">
                                        <select class="form-select form-select-sm" id="SelectMateriales2" name="id_producto" aria-label="Floating label select example">
                                        </select>
                                        <label for="floatingSelect">Producto</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-3 mb-3">
                                <div class="input-group form-floating">
                                    <select class="form-select js-example-basic-single form-select-sm" name="proveedor" id="SelectProveedor3" aria-label="Floating label select example" data-toggle="tooltip" data-placement="top" title="Tooltip on top" disabled>
                                    </select>
                                    <label for="sel_departamento">Proveedor</label>
                                    <div class="input-group-append">
                                        <button class="btn" style="border: 1px solid #ced4da;" type="button"><a href="<?php echo base_url('/proveedores'); ?>" class="bi bi-plus-lg text-secondary"></a></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-3 mb-3">
                                <div class="input-group form-floating">
                                    <select class="form-select js-example-basic-single form-select-sm" name="motivo" id="SelectMotivo2" aria-label="Floating label select example" data-toggle="tooltip" data-placement="top" title="Tooltip on top" disabled>
                                        <option value=""> Selecciona </option>
                                        <option value="1"> Venta </option>
                                        <option value="2"> Perdida </option>
                                        <option value="3"> Descomposición </option>
                                    </select>
                                    <label for="sel_departamento">Motivo</label>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-3 mb-3">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="Stock2" name="" placeholder="-" readonly></input>
                                    <label for="exampleFormControlInput1" class="form-label">Stock Actual</label>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-4 mb-3">
                                <div class="form-floating">
                                    <input type="number" min="1" class="form-control" id="Cantidad2" name="cantidad" placeholder="Codigo" readonly></input>
                                    <label for="exampleFormControlInput1" class="form-label">Cantidad</label>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="Obs2" name="observacion" placeholder="Codigo" readonly></input>
                                    <label for="exampleFormControlInput1" class="form-label">Observación</label>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-4 mb-3">
                                <div class="form-floating">
                                    <div class="form-floating">
                                        <input type="date" value="<?php echo date('Y-m-d', strtotime("today")); ?>" max="<?php echo date('Y-m-d', strtotime("today")); ?>" class="form-control" id="Fllegada2" name="Fllegada" placeholder="-" readonly></input>
                                        <label for="nacimi" class="form-label">Fecha de llegada</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-4 mb-3">
                                <div class="form-floating">
                                    <div class="form-floating">
                                        <input type="time" class="form-control" id="Hllegada2" name="Hllegada" placeholder="-" readonly></input>
                                        <label for="nacimi" class="form-label">Hora de llegada</label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid d-flex justify-content-between">
                                <div class="d-none d-md-inline">
                                    <a onClick="" class="btn btn-secondary bi bi-list-ul mr-auto" data-bs-toggle="offcanvas" href="#offcanvasDROP" role="button" aria-controls="offcanvasDROP">
                                        Últimos movimientos
                                    </a>
                                </div>
                                <div class="justify-content-end flex-wrap">
                                    <small class="mr-2 text-secondary d-none d-md-inline">
                                        Recuerda completar los campos obligatorios
                                    </small>
                                    <button type="submit" class="btn btn-success bi bi-plus-lg mr-2"> Registrar </button>
                                    <a onClick="Clean()" class="btn btn-info bi bi-clipboard-x"> Limpiar Campos
                                    </a>
                                </div>
                            </div>

                        </div>
                        <?= form_close(); ?>
                    </div>

                    <div class="col-md-12">
                        <div class="pt-2">
                            <div class="table-responsive">
                                <table id="Tabla_products" class="table table-sm table-bordered w-100">
                                    <thead class="text-center bg-primary text-white">
                                        <tr>
                                            <th scope="col">Código de Producto</th>
                                            <th scope="col">#</th>
                                            <th scope="col">Descripción</th>
                                            <th scope="col">Unidad de Medida</th>
                                            <th scope="col">Stock</th>
                                            <th scope="col">Stock Mínimo</th>
                                            <th scope="col">Fecha de Llegada</th>
                                            <th scope="col">Hora de Llegada</th>
                                            <th scope="col">Proveedor</th>
                                            <th scope="col">Fecha de Registro</th>
                                            <th scope="col">Usuario de registro</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasINSERT" aria-labelledby="offcanvasExampleLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Movimientos</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <div>
                                Alguno de los últimos movimientos realizados en el sistema web.
                            </div>
                            <div class="table-responsive">
                                <table id="Tabla_products_insert" class="table table-bordered table-sm w-100">
                                    <thead class="text-center bg-primary text-white">
                                        <tr>
                                            <th scope="col">Producto</th>
                                            <th scope="col">Motivo</th>
                                            <th scope="col">Cantidad</th>
                                            <th scope="col">Observación</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Hora</th>
                                            <th scope="col">Proveedor</th>
                                            <th scope="col">Fecha de registro</th>
                                            <th scope="col">Registrado por</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasDROP" aria-labelledby="offcanvasExampleLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Movimientos</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <div>
                                Alguno de los últimos movimientos de retiro realizados en el sistema web.
                            </div>
                            <div class="table-responsive"></div>
                            <table id="Tabla_products_drop" name="table table-bordered" class="table table-sm w-100">
                                <thead class="text-center bg-primary text-white">
                                    <tr>
                                        <th scope="col">Producto</th>
                                        <th scope="col">Motivo</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Observación</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Hora</th>
                                        <th scope="col">Proveedor</th>
                                        <th scope="col">Fecha de registro</th>
                                        <th scope="col">Registrado por</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
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