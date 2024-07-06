<!-- Modal -->
<div class="modal fade" id="modalFormEmpleado" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo <?= $data['page_name'] ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formEmpleado" name="formEmpleado" class="form-horizontal">
          <!-- name idEmpleado es en PHP js con POST no con id # -->
          <input type="hidden" id="idEmpleado" name="idEmpleado" value="">
          <p class="text-primary">Recuerda: Todos los campos son obligatorios.</p>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="txtIdentificacion">Identificación</label>
              <input type="text"  data-type="dni" maxlength="8" class="form-control valid validDNI" id="txtIdentificacion" name="txtIdentificacion" required>

              <script>
                var txtIdentificacion = document.getElementById("txtIdentificacion");

                txtIdentificacion.addEventListener("input", function () {
                  var dni = txtIdentificacion.value;

                  // Verificar si el valor tiene 8 dígitos
                  if (dni.length === 8 && !isNaN(dni)) {
                    fetch(
                      "https://apiperu.dev/api/dni/" +
                      dni +
                      "?api_token=dec23f93e86189baef7a513b17e780a437f85d5b4d26eb0834a261b2476e67d3"
                    )
                      .then((res) => res.json())
                      .then((data) => {
                        document.getElementById("txtNombre").value = data.data.nombres;
                        // document.getElementById("txtPassword").value = dni;
                        document.getElementById("txtApellido").value = data.data.apellido_paterno + " " + data.data.apellido_materno;
                      });
                  }
                });
              </script>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="txtNombre">Nombres</label>
              <input type="text" class="form-control valid validText" id="txtNombre" name="txtNombre" required="">
            </div>
            <div class="form-group col-md-6">
              <label for="txtApellido">Apellidos</label>
              <input type="text" class="form-control valid validText" id="txtApellido" name="txtApellido" required="">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="txtTelefono">Teléfono</label>
              <input type="number" data-type="telefono" min="900000000" max="999999999" maxlength="9" class="form-control valid validPhoneNumber" id="txtTelefono" name="txtTelefono" required=""
                onkeypress="return controlTag(event);">
            </div>
            <div class="form-group col-md-6">
              <label for="txtEmail">Email</label>
              <input type="email" class="form-control valid validEmail" id="txtEmail" name="txtEmail" required="">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="listRolid">Roles</label>
              <select class="form-control" data-live-search="true" id="listRolid" name="listRolid" required>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="listStatus">Estado</label>
              <select class="form-control selectpicker" id="listStatus" name="listStatus" required>
                <option value="1">Activo</option>
                <option value="2">Inactivo</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <!-- <label for="txtPassword">Contraseña</label> -->
              <!-- <input type="password" class="form-control" id="txtPassword" name="txtPassword"> -->
            </div>
          </div>
          <div class="tile-footer">
            <button id="btnActionForm" class="btn btn-primary" type="submit">
              <i class="fa fa-fw fa-lg fa-check-circle"></i>
              <span id="btnText">Guardar</span>
            </button>&nbsp;&nbsp;&nbsp;
            <button class="btn btn-success" type="button" data-dismiss="modal">
              <i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalViewUser" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del <?= $data['page_name'] ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Identificación:</td>
              <td id="celIdentificacion">654654654</td>
            </tr>
            <tr>
              <td>Nombres:</td>
              <td id="celNombre">Jacob</td>
            </tr>
            <tr>
              <td>Apellidos:</td>
              <td id="celApellido">Jacob</td>
            </tr>
            <tr>
              <td>Teléfono:</td>
              <td id="celTelefono">Larry</td>
            </tr>
            <tr>
              <td>Email (Empleado):</td>
              <td id="celEmail">Larry</td>
            </tr>
            <tr>
              <td>Tipo Empleado:</td>
              <td id="celTipoEmpleado">Larry</td>
            </tr>
            <tr>
              <td>Estado:</td>
              <td id="celEstado">Larry</td>
            </tr>
            <tr>
              <td>Fecha registro:</td>
              <td id="celFechaRegistro">Larry</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>