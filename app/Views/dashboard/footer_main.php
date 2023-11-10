<footer class="py-4 mt-auto">
  <div class="container-fluid px-4">
    <div class="d-flex align-items-center justify-content-between small">
      <div class="text-muted">&copy; 2022 Inserge || Todos los derechos reservados.</div>
      <div>Versión Beta 0.1.11.07.2022</div>
    </div>
  </div>
</footer>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
      <div class="modal-footer"></div>
      <button class="btn btn-secondary btn-lg " type="button" data-dismiss="modal">Cancel</button>
      <a class="btn btn-primary btn-lg " href="<?php echo base_url('/') ?>" role="button">Logout</a>
    </div>
  </div>
</div>

<div class="modal fade" id="settingsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><strong>Perfil de <?php echo $_SESSION['Nombres']; ?></strong></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-auto">
            <strong>Identificador de Usuario:</strong> <?php echo $_SESSION['usuario']; ?>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-auto">
            <strong>Propiedades de Sesión:</strong>
          </div>
        </div>
        <div class="row">
          <div class="col-auto ml-3">
            <strong>- Estado: </strong><i class="bi bi-square-fill text-success"></i> Activa
          </div>
        </div>
        <div class="row">
          <div class="col-auto ml-3">
            <strong>- Último Acceso: </strong><?php echo $_SESSION['ult_acceso']; ?>
          </div>
        </div>
        <div class="row">
          <div class="col-auto ml-3">
            <strong>- Cargo: </strong><?php echo $_SESSION['rol']; ?>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<div class="modal" id="cambiar_contrasenia" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <?php $validation = \Config\Services::validation(); ?>
      <?= form_open_multipart('#', array('id' => 'frmactcontrasenia', 'name' => 'frmactcontrasenia')) ?>
      <div class="modal-header">
        <h5 class="modal-title"><strong>Actualizar contraseña</strong></h5>
      </div>
      <div class="modal-body mb-3">
        <label class="form-label"><strong>Contraseña:</strong></label>
        <div class="input-group">
          <input type="password" class="form-control" name="passw" id="passw" placeholder="Ingresa tu nueva contraseña. Maximo 6 caracteres.">
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

<!-- ICONOS -->
<script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<!-- Bootstrap JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>

<!-- DataTable -->

<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/cr-1.5.5/date-1.1.2/fc-4.0.2/fh-3.2.2/kt-2.6.4/r-2.2.9/rg-1.1.4/rr-1.2.8/sc-2.0.5/sb-1.3.2/sp-2.0.0/sl-1.3.4/sr-1.1.0/datatables.min.js"></script>



<!--
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js" integrity="sha512-0QbL0ph8Tc8g5bLhfVzSqxe9GERORsKhIn1IrpxDAgUsbBGz/V7iSav2zzW325XGd1OMLdL4UiqRJj702IeqnQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.compatibility.min.js" integrity="sha512-sZ2H+EQd+WBqD/p1lsiqdLI6IldPoh0aWEL6gGyXVboGOzfMlUWT57pdGk9iVzO0qIWTTs7yRXQhgAncsjdbWA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js" integrity="sha512-xq+0+dRhI6SZOh+lDnMJEju2p2YPINflJLcYrRAsIMaXnJi6/V3lppCMCYsB2MLeF2E93r+fVo0MioY90pNzpw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
-->
<!-- Latest compiled and minified JavaScript -->
<!-- Custom scripts for all pages-->
<script src="<?php echo base_url(); ?>/resources/js/dashboard/scripts.js"></script>
<script src="<?php echo base_url(); ?>/resources/js/dashboard/sb-admin-2.min.js"></script>
<script src="<?php echo base_url(); ?>/resources/js/gestion/Father.js"></script>
<script src="<?php echo base_url(); ?>/resources/js/combos.js"></script>

<script>
  ruta = '<?= base_url() ?>';
</script>



</body>

</html>