<?php

class SalidasModel extends Mysql
{
	private $idSalida;
	private $strNombre;
	private $strDescripcion;
	private $intCodigo;
	private $intCategoriaId;
	private $intPrecio;
	private $intStock;
	private $strfecha;
	private $intStatus;
	private $strRuta;
	private $strImagen;
	private $CodVenta;
	private $idNombre;
	private $Pago;
	private $Nombreexterno;
	private $descripcion;
	private $servicios;

	public function __construct()
	{
		parent::__construct();
	}

	public function selectSalidas()
	{
		$sql = "SELECT s.idsalida,
							s.codigo_venta,
							s.personaid,
							CASE 
								WHEN p.nombres IS NOT NULL AND p.apellidos IS NOT NULL THEN CONCAT(p.nombres, ' ', p.apellidos)
								WHEN p.nombres IS NOT NULL THEN p.nombres
								WHEN p.apellidos IS NOT NULL THEN p.apellidos
								ELSE s.persona_externa
							END AS nombre_completo,
							DATE_FORMAT(s.datecreated, '%d-%m-%Y | %h:%i:%s %p') AS datecreated,
							s.pago,
							s.status 
						FROM salida s 
						LEFT JOIN persona p ON s.personaid = p.idpersona
						WHERE s.status != 0";
		$request = $this->select_all($sql);
		return $request;
	}

	public function insertSalida($CodVenta, $idNombre, $Nombreexterno, $descripcion, $Pago, $servicios)
	{
		// Asignar null a las variables si están vacías
		$CodVenta = !empty($CodVenta) ? $CodVenta : null;
		$idNombre = !empty($idNombre) ? $idNombre : null;
		$Nombreexterno = !empty($Nombreexterno) ? $Nombreexterno : null;
		$descripcion = !empty($descripcion) ? $descripcion : null;
		$Pago = !empty($Pago) ? $Pago : null;

		$query_insert = "INSERT INTO salida(codigo_venta, personaid, persona_externa, descripcion, pago) 
									  VALUES(?,?,?,?,?)";
		$arrData = array($CodVenta, $idNombre, $Nombreexterno, $descripcion, $Pago);
		$request_insert = $this->insert($query_insert, $arrData);
		// Verificar si la inserción en salida fue exitosa
		if ($request_insert > 0) {
			// Obtener el último ID de salida insertado
			$query_IdSalida = "SELECT idsalida FROM salida ORDER BY idsalida DESC LIMIT 1;";
			$ultimoIsSalida = $this->select($query_IdSalida);

			if ($ultimoIsSalida) {
				$idsalida = $ultimoIsSalida['idsalida'];

				foreach ($servicios as $servicio) {
					$idservicio = $servicio['idServicio'];
					$cantidad = $servicio['cantidad'];
					$sqlDetalleVenta = "INSERT INTO detalle_salida (idsalida, idservicio, cantidad)
												VALUES (?, ?, ?)";
					$arrDataDetalleVenta = array($idsalida, $idservicio, $cantidad);
					$request = $this->insert($sqlDetalleVenta, $arrDataDetalleVenta);
				}
				$return = $request;
			} else {
				$return = $ultimoIsSalida;
			}
		} else {
			$return = $request_insert;
		}
		return $return;
	}

	public function updateSalida($idSalida, $CodVenta, $idNombre, $Nombreexterno, $descripcion, $Pago, $servicios)
	{
		// Asignar null a las variables si están vacías
		$request = 0;
		$idSalida = !empty($idSalida) ? $idSalida : null;
		$CodVenta = !empty($CodVenta) ? $CodVenta : null;
		$idNombre = !empty($idNombre) ? $idNombre : null;
		$Nombreexterno = !empty($Nombreexterno) ? $Nombreexterno : null;
		$descripcion = !empty($descripcion) ? $descripcion : null;
		$Pago = !empty($Pago) ? $Pago : null;

		$sql = "UPDATE salida 
							SET codigo_venta = ?, 
								personaid = ?, 
								persona_externa = ?, 
								descripcion = ?, 
								pago = ? 
							WHERE idsalida = ?";
		$arrData = array($CodVenta, $idNombre, $Nombreexterno, $descripcion, $Pago, $idSalida);
		$requestupdatesalida = $this->update($sql, $arrData);

		if ($requestupdatesalida) {
			// Eliminar los detalles de venta existentes
			$sqlDeleteDetalle = "DELETE FROM detalle_salida WHERE idsalida = '" . $idSalida . "'";
			$this->delete($sqlDeleteDetalle);

			foreach ($servicios as $servicio) {
				$idservicio = $servicio['idServicio'];
				$cantidad = $servicio['cantidad'];
				$sqlDetalleVenta = "INSERT INTO detalle_salida (idsalida, idservicio, cantidad)
										VALUES (?,?,?)";
				$arrDataDetalleVenta = array($idSalida, $idservicio, $cantidad, );
				$this->update($sqlDetalleVenta, $arrDataDetalleVenta);
			}
			return true;
		} else {
			return false;
		}
	}


	public function selectSalida(int $idSalida)
	{
		$this->idSalida = $idSalida;
		// Consulta para obtener los datos básicos de la salida
		$sql = "SELECT s.idsalida,
						   s.codigo_venta,
						   v.idventa,
						   s.personaid,
						    COALESCE(CONCAT(p.nombres, ' ', p.apellidos), p.nombres, p.apellidos, s.persona_externa) AS nombre_completo,
       						COALESCE(CONCAT(p.nombres, ' ', p.apellidos), p.nombres, p.apellidos) AS nombres_apellidos,
       					   s.persona_externa,
						   s.descripcion,
						   DATE_FORMAT(s.datecreated, '%d-%m-%Y | %h:%i:%s %p') as datecreated,
						   s.pago,
						   s.status 
					FROM salida s 
					LEFT JOIN persona p ON s.personaid = p.idpersona
					INNER JOIN venta v ON s.codigo_venta = v.codigo_venta
					WHERE s.idsalida = $this->idSalida";

		$requestSalida = $this->select($sql);

		// Consulta para obtener los detalles de la salida
		if (!empty($requestSalida)) {
			// $codigo_venta = $requestSalida['codigo_venta'];
			$sql_detalle = "SELECT ds.iddetalle_salida,
									   ds.idsalida,
									   ds.idservicio,
									   ds.cantidad,
									   s.idservicio,
									   s.nombre AS nombre_servicio
								FROM detalle_salida AS ds
								INNER JOIN servicio AS s ON ds.idservicio = s.idservicio
								WHERE ds.idsalida = $this->idSalida";

			$requestDetalle = $this->select_all($sql_detalle);
			$request = array('Salida' => $requestSalida, 'detalle_salida' => $requestDetalle);
		}
		return $request;
	}

	public function deleteSalida(int $idsalida)
	{
		$this->idSalida = $idsalida;
		$sql = "UPDATE salida SET status = ? WHERE idsalida = $this->idSalida ";
		$arrData = array(0);
		$request = $this->update($sql, $arrData);
		return $request;
	}
}

?>