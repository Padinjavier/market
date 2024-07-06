<?php 
    headerAdmin($data); 
    //getModal('modalProductos',$data);
    getModal('modalVenta',$data);
?>
    <div id="divModal"></div>
    <main class="app-content">
      <div class="app-title">
        <div>
            <h1><?= $data['page_title'] ?>
            <?php if($_SESSION['permisosMod']['w']){ ?>
                <button class="btn btn-primary" type="button" onclick="openModal();" ><i class="fas fa-plus-circle"></i> Agregar</button>
              <?php } ?>
            </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="app-menu__icon bi bi-house-door-fill"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>/ventas" class="text-info"><?= $data['page_title'] ?></a></li>
        </ul>
      </div>
        <div class="row">
            <div class="col-md-12">
              <div class="tile">
                <div class="tile-body">
                  <div class="table-responsive">
                    <table class="table table-hover table-bordered w-100" id="tableVentas">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Identificación</th>
                          <th>Fecha</th>
                          <th>Tipo de pago</th>
                          <th>Total</th>
                          <!-- <th>Estado</th> -->
                          <th>Acciones</th>
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
    </main>
<?php footerAdmin($data); ?>
    