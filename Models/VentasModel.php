<?php
class VentasModel extends Mysql
{
	private $objCategoria;
	private $intIdVenta;
	public function __construct()
	{
		parent::__construct();
	}

// -------------------------------------------------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------------------------------------------------------

	// el segundo select es dibidifo y es select_all debido a que necesito que traiga losdatos de toods 
	// los evicion indexados a la venta en lotes de array para ahcer el for del llenado de datos
	public function selectVenta(int $idventa)
	{
		$request = array();
		$sql = "SELECT v.idventa,
							v.codigo_venta,
							v.datecreated AS fecha,
							v.dni_cliente,
							v.idtipopago,
							tp.tipopago,
							v.total,
							v.status,
							p.nombres 
					FROM venta AS v
						INNER JOIN 
							persona AS p ON v.dni_cliente = p.identificacion
						INNER JOIN 
							tipopago AS tp ON v.idtipopago = tp.idtipopago
						INNER JOIN
							detalle_venta AS dv ON v.codigo_venta = dv.codigo_venta
					WHERE v.idventa =  $idventa";
		$requestVenta = $this->select($sql);
		if (!empty($requestVenta)) {
			$codigo_venta = $requestVenta['codigo_venta'];
			$sql_detalle = "SELECT dv.iddetalleventa,
										dv.codigo_venta,
										dv.idservicio,
										dv.cantidad,
										dv.precio,
										dv.descuento,
										s.nombre
								FROM detalle_venta AS dv
								INNER JOIN 
								servicio AS s ON dv.idservicio = s.idservicio
								WHERE dv.codigo_venta = '$codigo_venta'";
			$requestDetalle = $this->select_all($sql_detalle);
			$request = array('venta' => $requestVenta, 'detalle_venta' => $requestDetalle);
		}
		return $request;
	}

	public function inserVenta($dni_cliente, $idvendedor, $metodopago, $total, $servicios)
	{
		// Generar código de venta
		$codigoVenta = $this->generateCodigoVenta();

		// Inserción en la tabla venta
		$sqlVenta = "INSERT INTO venta (codigo_venta, dni_cliente, idvendedor, idtipopago, total)
						 VALUES (?, ?, ?, ?, ?)";
		$arrDataVenta = array($codigoVenta, $dni_cliente, $idvendedor, $metodopago, $total);
		$requestVenta = $this->insert($sqlVenta, $arrDataVenta);

		if ($requestVenta) {

			// Inserción en la tabla detalle_venta
			foreach ($servicios as $servicio) {
				$idservicio = $servicio['id'];
				$cantidad = $servicio['cantidad'];
				$precio = $servicio['precio'];
				$descuento = $servicio['descuento'];

				$sqlDetalleVenta = "INSERT INTO detalle_venta (codigo_venta, idservicio, cantidad, precio, descuento)
										VALUES (?, ?, ?, ?, ?)";
				$arrDataDetalleVenta = array($codigoVenta, $idservicio, $cantidad, $precio, $descuento);
				$this->insert($sqlDetalleVenta, $arrDataDetalleVenta);
			}

			return true;
		} else {
			return false;
		}
	}

	private function generateCodigoVenta()
	{
		// Obtener el último código de venta insertado
		$sql = "SELECT codigo_venta FROM venta ORDER BY idventa DESC LIMIT 1";
		$request = $this->select($sql);

		if (empty($request)) {
			return 'v_1';
		} else {
			$lastCodigo = $request['codigo_venta'];
			$number = intval(str_replace('v_', '', $lastCodigo)) + 1;
			return 'v_' . $number;
		}
	}

	public function updateVenta($idVenta, $dni_cliente, $idvendedor, $metodopago, $total, $servicios)
	{
		// Actualizar la tabla venta
		$sqlVenta = "UPDATE venta 
						 SET dni_cliente = ?, idvendedor = ?, idtipopago = ?, total = ?
						 WHERE codigo_venta = ?";
		$arrDataVenta = array($dni_cliente, $idvendedor, $metodopago, $total, $idVenta);
		$requestVenta = $this->update($sqlVenta, $arrDataVenta);

		if ($requestVenta) {
			// Eliminar los detalles de venta existentes
			$sqlDeleteDetalle = "DELETE FROM detalle_venta WHERE codigo_venta = '" . $idVenta . "'";
			$this->delete($sqlDeleteDetalle);

			// Insertar los nuevos detalles de venta
			foreach ($servicios as $servicio) {
				$idservicio = $servicio['id'];
				$cantidad = $servicio['cantidad'];
				$precio = $servicio['precio'];
				$descuento = $servicio['descuento'];

				$sqlDetalleVenta = "INSERT INTO detalle_venta (codigo_venta, idservicio, cantidad, precio, descuento)
										VALUES (?, ?, ?, ?, ?)";
				$arrDataDetalleVenta = array($idVenta, $idservicio, $cantidad, $precio, $descuento);
				$this->insert($sqlDetalleVenta, $arrDataDetalleVenta);
			}

			return true;
		} else {
			return false;
		}
	}

	public function selectVentas($idpersona)
	{
		$where = " WHERE v.status = 1";
		if ($idpersona != null) {
			$where .= " AND v.idvendedor = " . $idpersona;
		}
		$sql = "SELECT v.idventa,
						   v.codigo_venta,
						   DATE_FORMAT(v.datecreated, '%d-%m-%Y | %h:%i:%s %p') as datecreated,
						   v.idvendedor,
						   v.dni_cliente,
						   v.idtipopago,
						   tp.tipopago as tipopago_nombre,
						   v.total,
						   v.status,
						   p.nombres,
						   p.email_user
					FROM venta v
					INNER JOIN tipopago tp	ON v.idtipopago = tp.idtipopago 
					INNER JOIN persona p ON v.dni_cliente = p.identificacion" . $where;
		$request = $this->select_all($sql);
		return $request;
	}

	public function selectTipopago()
	{
		$sql = "SELECT * FROM tipopago 
					WHERE  status != 0 ";
		$request = $this->select_all($sql);
		return $request;
	}

	public function deleteVenta(int $intIdventa)
	{
		$this->intIdVenta = $intIdventa;
		$sql = "UPDATE venta SET status = ? WHERE idventa = $this->intIdVenta ";
		$arrData = array(0);
		$request = $this->update($sql, $arrData);
		return $request;
	}
	public function selectlistventa()
	{
		$sql = "SELECT * FROM venta 
					WHERE  status != 0 ";
		$request = $this->select_all($sql);
		return $request;
	}


	// -------------------------------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------------------------------------------------------------
}
?>