<?php
headerAdmin($data);

// getModal('modalClientes',$data);
getModal('modalChat',$data);

// Configurar la zona horaria
date_default_timezone_set('America/Lima');
// Obtener el nombre del día de la semana en español
$dias = DiasSemana();
$nombre_dia = $dias[date('w')];
// Obtener el día del mes
$dia_mes = date('d');
// Obtener el mes en español utilizando la función Meses()
$meses = Meses();
$mes = $meses[date('n') - 1]; // Restamos 1 porque los meses en PHP son indexados desde 0
// Obtener el año
$anio = date('Y');
// Formatear la fecha en el formato deseado
$fecha_formateada = "$nombre_dia, $dia_mes $mes $anio";
?>
<main class="app-content bg-white">
  <!-- <div class="container"> -->
    <div class="row">
      <div class="col-12">
        <div class="mb-3">
          <p class="text-right">
            <?= $fecha_formateada ?>
          </p>
        </div>
      </div>
      <div class="col-12 ">
        <div class="mb-3">
          <p class="font-weight-bold h4">¡Te damos la bienvenida, <span class="text-primary">
              <?= $_SESSION['userData']['nombres']; ?>!
            </span></p>
        </div>
      </div>
      <div class="col-12 ">
        <div class="mb-3 mr-4">
          <p class="">Nos alegra tenerte en nuestro sistema web de ventas. Gracias a tu experiencia y dedicación, juntos haremos realidad las aventuras de nuestros clientes.<br>
          ¡A vender aventuras inolvidables! Atte. El equipo de "Vive tu aventura"</p>
        </div>
      </div>
    </div>
  <!-- </div> -->
  <div class="row">
      <div class="col-12  mt-4">
          <p class="font-weight-bold">Mis servicios</p>
      </div>
    <?php if (!empty ($_SESSION['permisos'][5]['r'])) { ?>
      <div class="col-md-6">
      <div class="row isotope-grid justify-content-around pb-3">
    <?php if (!empty ($_SESSION['permisos'][3]['r'])) { ?>
      <div class=" m-2">
        <a href="<?= base_url() ?>/clientes" class="linkw">
          <div class="widget-small info coloured-icon shadow  p-2 pt-3 " style="display: flex;
    flex-direction: column;
    align-items: center;
    width: 100px;">
      <i class="icon bi bi-person-fill"></i>
            <div class="info text-center p-0">
              <p class="pt-1 pb-2">Clientes</p>
              <p class="pb-2"><b>
                  <?= $data['clientes'] ?>
                </b></p>
            </div>
          </div>
        </a>
      </div>
    <?php } ?>
    <?php if (!empty ($_SESSION['permisos'][4]['r'])) { ?>
      <div class="m-2">
        <a href="<?= base_url() ?>/salidas" class="linkw">
          <div class="widget-small warning coloured-icon shadow p-2 pt-3" style="display: flex;
    flex-direction: column;
    align-items: center;
    width: 100px;">
    <i class="icon bi bi-people-fill "></i>
            <div class="info text-center p-0">
              <p class="pt-1 pb-2">Salidas</p>
              <p class="pb-2"><b>
                  <?= $data['productos'] ?>
                </b></p>
            </div>
          </div>
        </a>
      </div>
    <?php } ?>
    <?php if (!empty ($_SESSION['permisos'][5]['r'])) { ?>
      <div class="m-2">
        <a href="<?= base_url() ?>/ventas" class="linkw">
          <div class="widget-small danger coloured-icon shadow p-2 pt-3" style="display: flex;
    flex-direction: column;
    align-items: center;
    width: 100px;">
    <i class="icon bi bi-archive-fill"></i>
            <div class="info text-center p-0">
              <p class="pt-1 pb-2">Ventas</p>
              <p class="pb-2"><b>
                  <?= $data['pedidos'] ?>
                </b></p>
            </div>
          </div>
        </a>
      </div>
    <?php } ?>
  </div>
  <p class="tile-title font-weight-bold">Últimas Ventas</p>
    <div class="tile">
      <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
          <table class="table table-striped table-sm">
              <thead>
                  <tr>
                      <th>#</th>
                      <th>Cliente</th>
                      <th>Tipo Pago</th>
                      <th class="text-right">Monto</th>
                      <!-- <th></th> -->
                  </tr>
              </thead>
              <tbody>
              <?php
              if (count($data['lastOrders']) > 0) {
                  foreach ($data['lastOrders'] as $pedido) {
                      ?>
                      <tr>
                          <td><?= $pedido['idventa'] ?></td>
                          <td><?= $pedido['nombre'] ?></td>
                          <td><?= $pedido['tipopago'] ?></td>
                          <td class="text-right"><?= SMONEY . " " . formatMoney($pedido['total']) ?></td>
                          <!-- <td><a href="<?= base_url() ?>/pedidos/orden/<?= $pedido['idventa'] ?>" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a></td> -->
                          <!-- <td><a  class="btn btn-secondary btn-sm  btnViewEmpleado" href="<?= base_url()?>./factura/generarFactura/<?= $pedido['idventa'] ?>" target="_blanck"  title="Ver PDF Venta"><i class="bi bi-filetype-pdf"></i></a></td> -->
                      </tr>
                      <?php 
                  }
              }
              ?>
              </tbody>
          </table>
      </div>
  </div>
  <style>
      .table-responsive::-webkit-scrollbar {
          width: 0px;  /* Elimina la barra de desplazamiento vertical */
          background: transparent;  /* Opcional: Fondo transparente para que no ocupe espacio */
      }
  </style>
      </div>
    <?php } ?>
    <div class="col-md-6">
      <div class="tile">
        <div class="container-title">
          <h3 class="tile-title">Tipo de pagos por mes</h3>
          <div class="dflex">
            <input class="date-picker pagoMes" name="pagoMes" placeholder="Mes y Año">
            <button type="button" class="btnTipoVentaMes btn btn-info btn-sm" onclick="fntSearchPagos()" aria-label="Buscar pagos por mes">
                <i class="fas fa-search" aria-hidden="true"></i></button>
          </div>
        </div>
        <div id="pagosMesAnio"></div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="container-title">
          <h3 class="tile-title">Ventas por mes</h3>
          <div class="dflex">
            <input class="date-picker ventasMes" name="ventasMes" placeholder="" aria-label="Seleccionar mes para ventas">
            <button type="button" class="btnVentasMes btn btn-info btn-sm" onclick="fntSearchVMes()"  aria-label="Buscar ventas por mes"> <i
                class="fas fa-search" aria-hidden="true"></i> </button>
          </div>
        </div>
        <div id="graficaMes"></div>
      </div>
    </div>
  </div>
</main>
<?php footerAdmin($data); ?>
<script>
  Highcharts.chart('pagosMesAnio', {
    chart: {
      plotBackgroundColor: null,
      plotBorderWidth: null,
      plotShadow: false,
      type: 'pie'
    },
    title: {
      text: 'Ventas por tipo pago, <?= $data['pagosMes']['mes'] . ' ' . $data['pagosMes']['anio'] ?>'
    },
    tooltip: {
      pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
      point: {
        valueSuffix: '%'
      }
    },
    plotOptions: {
      pie: {
        allowPointSelect: true,
        cursor: 'pointer',
        dataLabels: {
          enabled: true,
          format: '<b>{point.name}</b>: {point.percentage:.1f} %'
        }
      }
    },
    series: [{
      name: 'Brands',
      colorByPoint: true,
      data: [
        <?php
        foreach ($data['pagosMes']['tipospago'] as $pagos) {
          echo "{name:'" . $pagos['tipopago'] . "',y:" . $pagos['total'] . "},";
        }
        ?>
      ]
    }]
  });
  Highcharts.chart('graficaMes', {
    chart: {
      type: 'line'
    },
    title: {
      text: 'Ventas de <?= $data['ventasMDia']['mes'] . ' del ' . $data['ventasMDia']['anio'] ?>'
    },
    subtitle: {
      text: 'Total Ventas <?= SMONEY . '. ' . formatMoney($data['ventasMDia']['total']) ?> '
    },
    xAxis: {
      categories: [
        <?php
        foreach ($data['ventasMDia']['ventas'] as $dia) {
          echo $dia['dia'] . ",";
        }
        ?>
      ]
    },
    yAxis: {
      title: {
        text: ''
      }
    },
    plotOptions: {
      line: {
        dataLabels: {
          enabled: true
        },
        enableMouseTracking: false
      }
    },
    series: [{
      name: 'Dato',
      data: [
        <?php
        foreach ($data['ventasMDia']['ventas'] as $dia) {
          echo $dia['total'] . ",";
        }
        ?>
      ]
    }]
  });
  // Highcharts.chart('graficaAnio', {
  //   chart: {
  //     type: 'column'
  //   },
  //   title: {
  //     text: 'Ventas del año 
  <?php
  // $data['ventasAnio']['anio']  
  
  ?> 
  //   },
  //   subtitle: {
  //     text: 'Esdística de ventas por mes'
  //   },
  //   xAxis: {
  //     type: 'category',
  //     labels: {
  //       rotation: -45,
  //       style: {
  //         fontSize: '13px',
  //         fontFamily: 'Verdana, sans-serif'
  //       }
  //     }
  //   },
  //   yAxis: {
  //     min: 0,
  //     title: {
  //       text: ''
  //     }
  //   },
  //   legend: {
  //     enabled: false
  //   },
  //   tooltip: {
  //     pointFormat: 'Population in 2017: <b>{point.y:.1f} millions</b>'
  //   },
  //   series: [{
  //     name: 'Population',
  //     data: [
  //       <?php
  //       foreach ($data['ventasAnio']['meses'] as $mes) {
  //         echo "['" . $mes['mes'] . "'," . $mes['venta'] . "],";
  //       }
  //       ?>
  //     ],
  //     dataLabels: {
  //       enabled: true,
  //       rotation: -90,
  //       color: '#FFFFFF',
  //       align: 'right',
  //       format: '{point.y:.1f}', // one decimal
  //       y: 10, // 10 pixels down from the top
  //       style: {
  //         fontSize: '13px',
  //         fontFamily: 'Verdana, sans-serif'
  //       }
  //     }
  //   }]
  // });

</script>