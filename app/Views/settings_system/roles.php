<div class="layoutSidenav_content py-4">
  <main>
    <div class="container-fluid px-4">

      <!-- Aqui va el codigo --->

      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h4 mb-0 text-gray-800">Gestión de roles de acceso</h1>
      </div>

      <div class="row align-items-center justify-content-center">

        <div class="row justify-content-center">

          <div class="col-md-5 p-1">
            <div class="card">
              <div class="card-header">
                <strong>Administración de roles</strong>
              </div>

              <div class="col-md-12 p-3">

                <div class="mb-3">
                  <label class="form-label"><strong>Nombre de rol: </strong></label>
                  <input type="text" class="form-control" name="txtnombre" placeholder="Asigne un nombre al rol">
                </div>

                <div class="mb-3">
                  <label class="form-label"><strong>Descripción: </strong></label>
                  <input type="text" class="form-control" name="txtnombre" placeholder="Asigne una descripción al rol">
                </div>

                <div class="mb-1">
                  <label class="form-label"><strong>Estado: </strong></label>
                  <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                    <option value="1"></option>
                    <option value="2">Activo</option>
                    <option value="3">Inactivo</option>
                  </select>
                </div>

              </div>

              <div class="row align-items-center justify-content-center p-2">
                <div class="col-md-11">
                  <div class="card">
                    <div class="card-header">
                      Asignacion de permisos
                    </div>
                    <div id="rolees" class="row align-items-center justify-content-center p-3">

                      <!-- Titulos --->
                      

                      
                    </div>
                  </div>
                </div>
              </div>

              <div class="p-3">
                <div class="d-grid p-1">
                  <input type="submit" class="btn btn-primary" value="guardar">
                </div>
              </div>

            </div>
          </div>

          <div class="col-md-4 p-1">
            <div class="card">
              <div class="card-header">
                <strong>Listado de roles de acceso</strong>
              </div>

              <div class="p-4">
                <div class="table-responsive">
                  <table id="tabla_roles" class="table table-bordered" cellspacing="0" width="100%">

                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Usuarios</th>
                        <th scope="col">Permisos</th>
                        <th scope="col">Denegados</th>
                        <th scope="col">Estado</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                      </tr>
                    </thead>

                    <tbody>

                      <tr>
                        <td class="text-center">1</td>
                        <td>Administrador</td>
                        <td class="text-center">2</td>
                        <td class="text-center">4</td>
                        <td class="text-center">0</td>
                        <td class="text-center text-success">Activo</td>
                        <td class="text-info text-center"><i class="bi bi-key"></i></td>
                        <td class="text-primary text-center"><i class="bi bi-pencil-square"></i></td>
                        <td class="text-danger text-center"><i class="bi bi-lock"></i></td>
                      </tr>

                      <tr>
                        <td class="text-center">2</td>
                        <td>Almacen</td>
                        <td class="text-center">1</td>
                        <td class="text-center">2</td>
                        <td class="text-center">3</td>
                        <td class="text-center text-success">Activo</td>
                        <td class="text-info text-center"><i class="bi bi-key"></i></td>
                        <td class="text-primary text-center"><i class="bi bi-pencil-square"></i></td>
                        <td class="text-danger text-center"><i class="bi bi-lock"></i></td>
                      </tr>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>


        </div>

      </div>

    </div>
  </main>
</div>