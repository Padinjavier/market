<?php 
require_once("Models/TTipoPago.php"); 
class Ventas extends Controllers{
	use TTipoPago;
	public function __construct()
	{
		parent::__construct();
		session_start();
		if(empty($_SESSION['login']))
		{
			header('Location: '.base_url().'/login');
			die();
		}
		getPermisos(MVENTAS);
	}

	public function Ventas()
	{
		if(empty($_SESSION['permisosMod']['r'])){
			header("Location:".base_url().'/dashboard');
		}
		$data['page_tag'] = "Ventas";
		$data['page_title'] = "Ventas <small> </small>";
		$data['page_name'] = "ventas";
		$data['page_functions_js'] = "functions_ventas.js";
		$this->views->getView($this,"ventas",$data);
	}


	public function orden($idventa){
		if(!is_numeric($idventa)){
			header("Location:".base_url().'/ventas');
		}
		if(empty($_SESSION['permisosMod']['r'])){
			header("Location:".base_url().'/dashboard');
		}
		$idpersona = "";
		if( $_SESSION['userData']['idrolusuario'] == RCLIENTES ){
			$idpersona = $_SESSION['userData']['idpersona'];
		}
		
		$data['page_tag'] = "Ventas";
		$data['page_title'] = "VENTAS <small></small>";
		$data['page_name'] = "ventas";
		$data['arrVenta'] = $this->model->selectVenta($idventa,$idpersona);
		$this->views->getView($this,"orden",$data);
	}



	public function getTransaccion(string $transaccion){
		if($_SESSION['permisosMod']['r'] and $_SESSION['userData']['idrolusuario'] != RCLIENTES){
			if($transaccion == ""){
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			}else{
				$transaccion = strClean($transaccion);
				$requestTransaccion = $this->model->selectTransPaypal($transaccion);
				if(empty($requestTransaccion)){
					$arrResponse = array("status" => false, "msg" => "Datos no disponibles.");
				}else{
					$htmlModal = getFile("Template/Modals/modalReembolso",$requestTransaccion);
					$arrResponse = array("status" => true, "html" => $htmlModal);
				}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}


	public function getVenta($idventa){
		if ($_SESSION['permisosMod']['u'] and $_SESSION['userData']['idrolusuario'] != RCLIENTES) {
			$idventa = intval($idventa);
			if ($idventa > 0)
			{
				$arrData = $this->model->selectVenta($idventa, "");
				if (empty($arrData)) {
					$arrResponse = array("status" => false, "msg" => "Datos no disponibles.");
				} else {
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
			
			} else {
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos error.');
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}



// --------------------------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------------------------
	public function setVenta(){
		if($_POST){
			if($_SESSION['permisosMod']['u'] && $_SESSION['userData']['idrolusuario'] != RCLIENTES){

				// Obtener datos JSON
				$idvendedor = $_SESSION['userData']['idpersona'];

				$idVenta = isset($_POST['idVenta']) ? strClean($_POST['idVenta']) : '';
				$dni_cliente = isset($_POST['dni']) ? strClean($_POST['dni']) : '';
				$metodopago = isset($_POST['metodopago']) ? strClean($_POST['metodopago']) : '';
				$servicios = isset($_POST['servicios']) ? json_decode($_POST['servicios'], true) : [];
				$total = isset($_POST['total']) ? strClean($_POST['total']) : '';

				// Verificar campos obligatorios
				if( $dni_cliente == '' || empty($servicios) || $metodopago == '' || $total == '') {
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				} else {

					if(empty($idVenta)){
						$option = 1;
						$requestVenta = $this->model->inserVenta($dni_cliente, $idvendedor, $metodopago, $total, $servicios);
						
					} else {
						$option = 2;
						// Aquí puedes agregar la lógica para actualizar una venta existente si lo deseas
						$requestVenta = $this->model->updateVenta($idVenta, $dni_cliente, $idvendedor, $metodopago, $total, $servicios);
					}

					if($requestVenta) {
						if($option == 1){
							$arrResponse = array('status' => true,'action' => 'insert', 'msg' => 'Datos de la venta guardados correctamente.');
						} else {
							$arrResponse = array('status' => true,'action' => 'edit', 'msg' => 'Datos del usuario actualizados correctamente.');
						}
					} else {
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
				}

				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}

	public function getVentas(){
		if($_SESSION['permisosMod']['r']){
			
			$idpersona = $_SESSION['userData']['idpersona'];
			
			$arrData = $this->model->selectVentas($idpersona);
			//dep($arrData);
			for ($i=0; $i < count($arrData); $i++) {
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				$btnPdf="";
				$btntiket="";
				$btntiket2="";

				$btnViewdetalle="";
				$btnViewTrans="";
				// Cambios en los nombres de las claves de los datos obtenidos
				$arrData[$i]['transaccion'] = $arrData[$i]['codigo_venta'];
				// Combina nombres y email_user en una nueva clave ddd
				$arrData[$i]['nombres_emails'] = $arrData[$i]['nombres'] . ' | ' . $arrData[$i]['email_user'];
	
				if($_SESSION['permisosMod']['r']){
					$btnView = '<button class="btn btn-info btn-sm btnView btnViewEmpleado" onClick="fntViewVenta('.$arrData[$i]['idventa'].')" title="Ver Venta"><i class="far fa-eye"></i></button>';
					// $btnViewTrans = '<a title="Ver Transacción" href="'.base_url().'/ventas/transaccion/'.$arrData[$i]['idventa'].'" target="_blanck" class="btn btn-info btn-sm"> <i class="fa fa-paypal" aria-hidden="true"></i> </a> '; // Se usa la clave 'transaccion'
					// $btnViewdetalle = ' <a title="Ver Detalle" href="'.base_url().'/ventas/orden/'.$arrData[$i]['idventa'].'" target="_blanck" class="btn btn-info btn-sm"> <i class="far fa-eye"></i> </a>';
					$btnPdf = '<a  class="btn btn-secondary btn-sm  btnViewEmpleado" href="'.base_url().'/factura/generarFactura/'.$arrData[$i]['idventa'].'" target="_blanck"  title="Ver PDF Venta"><i class="bi bi-filetype-pdf"></i></a> ';
					// $btntiket = '<a  class="btn btn-success btn-sm  btnViewEmpleado" href="'.base_url().'/factura/generarFactura/'.$arrData[$i]['idventa'].'" target="_blanck"  title="Imprimir tiket Venta"><i class="bi bi-printer"></i></a> ';
					// $btntiket2 = '<button type="button" class="button is-link is-light" 
					// 				onclick="print_ticket('.base_url()."/Ticket.php?code=".$arrData[$i]['idventa'].')" >
                    //             		<i class="bi bi-printer"></i> &nbsp;
                    //             		Imprimir ticket de venta
                    //         </buttona>';
					$btntiket2 = '<button type="button" class="button is-link is-light" 
										onclick="print_ticket(\''.base_url().'/Ticket/getVenta/'.$arrData[$i]['codigo_venta'].'\')">
										<i class="bi bi-printer"></i> &nbsp;
										Imprimir ticket de venta
									</button>';


				}
				if($_SESSION['permisosMod']['u']){
					$btnEdit = '<button class="btn btn-primary  btn-sm btnEdit btnEditInfo" onClick="fntEditInfo(this,'.$arrData[$i]['idventa'].')" title="Editar Venta"><i class="fas fa-pencil-alt"></i></button>';
					
				}
				if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm btnDel btnDelEmpleado" onClick="fntDelEmpleado('.$arrData[$i]['idventa'].')" title="Eliminar Venta"><i class="far fa-trash-alt"></i></button>';
				}
				$arrData[$i]['options'] = '<div class="text-center" style="display:flex; flex-direction:row; justify-content:space-evenly; gap:10px;">
				'.$btnView.''.$btnEdit.''.$btnDelete.''.$btnPdf.''.$btntiket.''.''.$btntiket2.''.$btnViewTrans.''.$btnViewdetalle.'</div>';
			

			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		}
		die();
	}
	

	public function getlisttipopago() {
		$htmlOptions = '<option value="">Seleccione una opción</option>';
		$arrData = $this->model->selectTipopago();
		if (count($arrData) > 0) {
			foreach ($arrData as $row) {
				$htmlOptions .= '<option value="'.htmlspecialchars($row['idtipopago']).'">'.htmlspecialchars($row['tipopago']).'</option>';
			}
		}
		echo $htmlOptions;
		die();
	}


public function delVenta()
	{
		if($_POST){
			if($_SESSION['permisosMod']['d']){
				$intIdventa = intval($_POST['idVenta']);
				$requestDelete = $this->model->deleteVenta($intIdventa);
				if($requestDelete)
				{
					$arrResponse = array('status' => true, 'msg' => 'Datos de la venta eliminado correctamente.');
				}else{
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar al Empleado.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}
	
	public function getSelectVentas() {
		$htmlOptions = '<option value="">Código de venta</option>';
		$arrData = $this->model->selectlistventa();
		if (count($arrData) > 0) {
			foreach ($arrData as $row) {
				$htmlOptions .= '<option value="'.htmlspecialchars($row['idventa']).'">'.htmlspecialchars($row['codigo_venta']).'</option>';
			}
		}
		echo $htmlOptions;
		die();
	}
// ------------------------------------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------------------------------------
	
}
 ?>