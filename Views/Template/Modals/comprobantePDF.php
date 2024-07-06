<?php
$cliente = $data['cliente'];
$orden = $data['orden'];
$detalle = $data['detalle'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="<?= media(); ?>/images/favicon.ico">
	<title>Factura</title>
	<style>
		table {
			width: 100%;
		}

		table td,
		table th {
			font-size: 12px;
		}

		h4 {
			margin-bottom: 0px;
		}

		.text-center {
			text-align: center;
		}

		.text-right {
			text-align: right;
		}

		.wd33 {
			width: 33.33%;
		}

		.tbl-cliente {
			border: 1px solid #CCC;
			border-radius: 10px;
			padding: 5px;
		}

		.wd10 {
			width: 10%;
		}

		.wd15 {
			width: 15%;
		}

		.wd40 {
			width: 40%;
		}

		.wd55 {
			width: 55%;
		}

		.tbl-detalle {
			border-collapse: collapse;
		}

		.tbl-detalle thead th {
			padding: 5px;
			background-color: #F37101;
			color: #FFF;
		}

		.tbl-detalle tbody td {
			border-bottom: 1px solid #CCC;
			padding: 5px;
		}

		.tbl-detalle tfoot td {
			padding: 5px;
		}

		p.noboleta {
			color: #c6c9cb;
		}
	</style>
</head>

<body class="text-container" style="border: 1px solid red;">
	<table class="tbl-hader">
		<tbody style="border: 1px solid red;">
			<tr>
				<td class="wd33">
					<img src="<?= media() ?>/tienda/images/logo.png" alt="Logo">
				</td>
				<td class="text-center wd33">
					<h4><strong><?= NOMBRE_EMPESA ?></strong></h4>
				</td>
				<td class="text-right wd33">
				</td>
			</tr>
			<tr>
				<td class="wd33">
					<p><?= DIRECCION ?> <br><br>
						Teléfono: <?= TELEMPRESA ?> <br><br>
						Email: <?= EMAIL_EMPRESA ?></p>
				</td>
				<td class="text-center wd33">
				</td>
				<td class="text-right wd33">
					<p>No. Orden <strong><?= $orden['codigo_venta'] ?></strong><br><br>
						Fecha: <?= $orden['fecha'] ?> <br><br>
						Método Pago: <?= $orden['tipopago'] ?>
					</p>
				</td>
			</tr>
		</tbody>
	</table>
	<br>
	<table class="tbl-cliente">
		<tbody>
			<tr>
				<td class="wd10">DNI:</td>
				<td class="wd40"><?= $cliente['identificacion'] ?></td>
				<td class="wd10">Teléfono:</td>
				<td class="wd40"><?= $cliente['telefono'] ?></td>
			</tr>
			<tr>
				<td class="wd20">Nombre:</td>
				<td><?= $cliente['nombres'] . ' ' . $cliente['apellidos'] ?></td>
				<td class="wd20">Correo electrónico:</td>
				<!-- <td class="wd40"><?= $cliente['email_user'] ?></td> -->
				<td class="wd2">alex.huasasquichesoto@gmail.com</td>
			</tr>
		</tbody>
	</table>
	<br>
	<!-- esto es mio mi test para ver datos  -->
	<p>
		<?php
		$subtotalreal = 0;
		foreach ($detalle as $servicio) {

			// echo($servicio['servicio']);
			$importereal = $servicio['precioreal'] * $servicio['cantidad'];
			$subtotalreal = $subtotalreal + $importereal;
		}
		// echo($subtotalreal);
		// echo json_encode($detalle, JSON_PRETTY_PRINT);
		// echo(SMONEY . ' ' . formatMoney($subtotal));
		// echo(SMONEY . ' ' . formatMoney($orden['total']));
		
		?>
	</p>
	<table class="tbl-detalle m-1">
		<thead>
			<tr style="text-align: center;">
				<th style="width:4%">#</th>
				<th style="width:45%">Tipo de servicio</th>
				<th style="width:12%">Cantidad</th>
				<th style="width:12%">Precio</th>
				<th style="width:12%">Descuento</th>
				<th style="width:15%">Precio Total</th>
			</tr>
		</thead>
		<tbody style="text-align: center;">
			<?php
			$subtotal = 0;
			$descuentototal = 0;
			$i = 0;
			foreach ($detalle as $servicio) {
				$importe = $servicio['precio'] * $servicio['cantidad'];
				$subtotal = $subtotal + $importe;

				$importe2 = $servicio['descuento'] * $servicio['cantidad'];
				$descuentototal = $descuentototal + $importe2;
				
				$i++;
				?>
				<tr>
					<td><?= $i ?></td>
					<td><?= $servicio['servicio'] ?></td>
					<td class="text-center"><?= $servicio['cantidad'] ?></td>
					<td class="text-center"><?= SMONEY . ' ' . formatMoney($servicio['precio']) ?></td>
					<td class="text-center"><?= SMONEY . ' ' . formatMoney($servicio['descuento']) ?></td>
					<td class="text-center"><?= SMONEY . ' ' . formatMoney($orden['total']) ?></td>
				</tr>
			<?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<td></td>
				<td></td>
				<td colspan="3" class="text-right">Sub Total:</td>
				<td class="text-right"><?= SMONEY . ' ' . formatMoney($subtotal); ?></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td colspan="3" class="text-right">Descuento:</td>
				<td class="text-right"><?= SMONEY . ' ' . formatMoney($descuentototal); ?></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td colspan="3" class="text-right">Total:</td>
				<td class="text-right"><?= SMONEY . ' ' . formatMoney($orden['total']); ?></td>
			</tr>
		</tfoot>
	</table>
	<div class="text-center ">
		<p class="noboleta">Esta guía de boleta sirve para el control interno de la agencia.</p>
		<h4>¡Gracias por tu eleccion!</h4>
	</div>
</body>

</html>