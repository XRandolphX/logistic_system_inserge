<?php
if (isset($_SESSION['usuario']) && $_SESSION['Medidas'] == 1 && $_SESSION['status_usuario'] == 1) {
?>

<div class="layoutSidenav_content py-4">
    <main>
        <div class="container-fluid px-4">
            <div class="row align-items-center justify-content-center">
                <div class="row justify-content-center">
                    <div class="col-md-5">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="fw-bold text-center pb-3">Administración de Medidas</div>
                                <?php $validation = \Config\Services::validation(); ?>
                                <?= form_open_multipart('#', array('id' => 'frmregMedidas', 'name' => 'frmregMedidas')) ?>
                                <div class="row">
                                    <div class="col-sm-6 pt-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="unid" name="unid" placeholder="-"></input>
                                            <label for="conv" class="form-label">Unidad de Medida</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 pt-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="plr" name="plr" placeholder="-"></input>
                                            <label for="conv" class="form-label">Plural de Medida</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="simb" name="simb" placeholder="-"></input>
                                        <label for="desc" class="form-label">Símbolo</label>
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
                                <div class="fw-bold text-center pb-3">Listado de Unidades de Medidas</div>
                                <div class="pt-2">
                                    <div class="table-responsive">
                                        <table id="Table_Unidad" class="table table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Unidad de Medida</th>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Plurar de Medida</th>
                                                    <th scope="col">Símbolo</th>
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
                                <?= form_open_multipart('#', array('id' => 'frmeditMedidas', 'name' => 'frmeditMedidas')) ?>
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
                                        <div class="col-sm-6 pt-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="editUnid" name="unid" placeholder="-"></input>
                                                <label for="conv" class="form-label">Unidad de Medida</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pt-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="editPlr" name="plr" placeholder="-"></input>
                                                <label for="conv" class="form-label">Plural de Medida</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pt-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="editSimb" name="simb" placeholder="-"></input>
                                            <label for="desc" class="form-label">Símbolo</label>
                                        </div>
                                    </div>
                                    <div class="row">
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