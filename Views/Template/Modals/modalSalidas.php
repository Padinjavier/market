<!-- Modal Salida-->
<div class="modal fade" id="modalFormSalidas" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nueva Salida</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formSalidas" name="formSalidas" class="form-horizontal">
              <input type="hidden" id="idSalida" name="idSalida" value="">
              <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">Código de venta</label>
                        <select class="form-control" data-live-search="true" id="listCodVenta" name="listCodVenta" required="">
                          <!-- se agregar los cod venta automatico -->
                        </select>                       
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Nombres</label>
                        <select class="form-control" data-live-search="true" id="listNombres" name="listNombres" required="">
                        </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Estado de pago</label>
                            <select class="form-control selectpicker" id="listEstPago" name="listEstPago" required="">
                              <option value="1">Falta</option>
                              <option value="2">Realizado</option>
                            </select>
                            
                        
                        </div>
                        <!-- //agregamos externo -->
                        <div class="form-group col-md-6">
                          <div class="switch-container">
                              <span>Externo a la agencia</span>
                              <label class="switch">
                                  <input type="checkbox" id="externo" name="externo">
                                  <span class="slider"></span>
                              </label>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="listNombre">Nombres</label>
                            <input class="form-control" id="txtNombre" name="txtNombre" type="text" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="descripcion">Descripción (Opcional)</label>
                            <input class="form-control" id="txtdescripcion" name="txtdescripcion" type="text" placeholder="Ingrese una descripción" disabled>
                        </div>
                    </div>
                    <div class="lotessalida">
                      <div class="row">
                          <div class="form-group col-md-6">
                          </div>
                          <div class="form-group col-md-6" style="display: flex; justify-content: flex-end;">
                              <button class="btn btn-primary" type="button" id="btnAgregar"><i class="fas fa-plus-circle"></i> Agregar</button>
                          </div>
                      </div>
                      <table class="table table-sm">
                        <thead>
                            <tr style="text-align: center;">
                                <th style="width:45%" class="text-start">Tipo de servicio</th>
                                <th style="width:5%"></th>
                                <th style="width:45%" class="text-start">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody id="dynamicFields">
                            <!-- Las filas se generarán automáticamente con JavaScript -->
                        </tbody>
                      </table>
                    </div>
                    <div class="tile-footer">
                      <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle" aria-hidden="true"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                      <button class="btn btn-success" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle" aria-hidden="true"></i>Cerrar</button>
                    </div>
                </div>
              </div>
            </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalViewSalida" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos de la Salida</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Codigo:</td>
              <td id="celCodigo"></td>
            </tr>
            <tr>
              <td>Nombres:</td>
              <td id="celNombre"></td>
            </tr>
            <tr>
              <td>Estado de pago::</td>
              <td id="celEstadoPago"></td>
            </tr>
            <tr>
              <td>Descripción:</td>
              <td id="celDescripcion"></td>
            </tr>
            <tr>
              <td>Tipo de servicion:</td>
              <td id="celTipoServicios"></td>
            </tr>
            <tr>
              <td>Cantidad:</td>
              <td id="celCantidad"></td>
            </tr>
            <tr>
              <td>Fecha:</td>
              <td id="celFecha"></td>
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

