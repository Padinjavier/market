<?php
class FacturaModel extends Mysql
{
	public function __construct()
	{
		parent::__construct();
	}

	public function selectPedido(int $idpedido)
	{

		$request = array();
		$sql = "SELECT v.idventa,
							v.codigo_venta,
							DATE_FORMAT(v.datecreated, '%d/%m/%Y') as fecha,
							v.idvendedor,
							v.dni_cliente,
							v.idtipopago,
							t.tipopago,
							v.total,
							v.status
					FROM venta as v
					INNER JOIN tipopago t ON v.idtipopago = t.idtipopago
					WHERE v.idventa =  $idpedido ";
		$requestPedido = $this->select($sql);
		if (!empty($requestPedido)) {
			$dnipersona = $requestPedido['dni_cliente'];
			$sql_cliente = "SELECT idpersona,
										identificacion,
										nombres,
										apellidos,
										telefono,
										hotel,
										email_user
								FROM persona WHERE identificacion = $dnipersona ";
			$requestcliente = $this->select($sql_cliente);

			if (!empty(($requestcliente))) {
				$codventa = $requestPedido['codigo_venta'];
				$sql_detalle = "SELECT s.idservicio,
											s.nombre as servicio,
											s.precio as precioreal,
											dv.precio,
											dv.cantidad,
											dv.descuento
									FROM detalle_venta dv
									INNER JOIN servicio s
									ON dv.idservicio = s.idservicio
									WHERE dv.codigo_venta =  '$codventa'";
				$requestProductos = $this->select_all($sql_detalle);
			}
			$request = array(
				'cliente' => $requestcliente,
				'orden' => $requestPedido,
				'detalle' => $requestProductos
			);
		}
		return $request;
	}
	// cliente es los datos del cliente
	// orden es los datos de la venta cosigo total etc 
	// detalle es la lista de todods los servicios
}
?>