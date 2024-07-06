<!-- modal venta -->
<div class="modal fade" id="modalFormVenta" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog modal-xl" >
        <div class="modal-content">
            <div class="modal-header headerUpdate">
                <h5 class="modal-title" id="titleModal">Nueva venta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formUpdateVenta" name="formUpdateVenta" class="form-horizontal">
                    <p class="text-primary">Recuerda: Todos los campos son obligatorios.</p>
                    <p class="viewcodigoventa d-none">Codigo venta: <span id="idVenta">v_001</span></p>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <label for="listClienteid">Cliente</label>
                            <select class="form-control" data-live-search="true" id="listClienteid" name="listClienteid" required >
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-">
                            <label for="listMetodoPagoid">Metodo de Pago</label>
                            <select class="form-control" data-live-search="true" id="listMetodoPagoid" name="listMetodoPagoid" required >
                            </select>
                        </div>
                        
                    </div>
                    <section>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <h4>Detalle de venta</h4>
                                </div>
                                <div class="col-6 d-flex justify-content-end">
                                    <button class="btn btn-primary btn-sm" type="button" id="btnAgregarProducto"><i
                                            class="fas fa-plus-circle" aria-hidden="true"></i> Agregar</button>
                                </div>
                            </div>
                            <!-- <div class="table-responsive"> -->
                            <div class="table-responsive">
                                <table class="table table-sm table-hover  w-100 dataTable no-footer">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th style="width:5%">#</th>
                                            <th style="width:35%">Tipo‎de‎servicio</th>
                                            <th style="width:10%">Cantidad</th>
                                            <th style="width:10%">Precio</th>
                                            <th style="width:10%">Descuento</th>
                                            <th style="width:10%">Precio.Total</th>
                                            <th style="width:5%"></th>
                                            <th style="width:0%"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tblDetalleVenta">
                                        <script>
                                            // se crean en automatico con el JS 
                                        </script>    

                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align: start;">
                                                <span>Sub.Total:</span><br>
                                                <span>Descuento.Total:</span><br>
                                                <span>Total:</span><br>
                                            </td>
                                            <td></td>
                                            <td>
                                                <span>S/ <span id="gran_sub_total">00.00</span></span><br>
                                                <span>S/ <span id="gran_descuento">00.00</span></span><br>
                                                <span>S/ <span id="gran_total">00.00</span></span><br>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </section>


                    <div class="tile-footer">
                <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                <button class="btn btn-success" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
              </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal view-->
<div class="modal fade" id="modalViewVenta" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos de <?= $data['page_name'] ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Código de venta:</td>
              <td id="celIdentificacion">654654654</td>
            </tr>
            <tr>
              <td>Cliente:</td>
              <td id="celNombre">Jacob</td>
            </tr>
            <tr>
              <td>Tipo de Pago:</td>
              <td id="celApellido">Jacob</td>
            </tr>
            <tr>
              <td>Total:</td>
              <td id="celTelefono">Larry</td>
            </tr>
            <tr>
              <td>Tipo de servicio:</td>
              <td id="celEmail">Larry</td>
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