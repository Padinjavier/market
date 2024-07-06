<?php 
	class Salidas extends Controllers{
		public function __construct()
		{
			parent::__construct();
			session_start();
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				die();
			}
			getPermisos(MSALIDAS);
		}

		public function Salidas()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "Salidas";
			$data['page_title'] = "Salidas <small> </small>";
			$data['page_name'] = "salidas";
			$data['page_functions_js'] = "functions_salidas.js";
			$this->views->getView($this,"salidas",$data);
		}

		public function getSalidas()
		{
			if($_SESSION['permisosMod']['r']){
				$arrData = $this->model->selectSalidas();
				for ($i=0; $i < count($arrData); $i++) {
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';

					// Determinar el estado de pago
					$pagoStatus = '';
					if ($arrData[$i]['pago'] == 1) {
						$pagoStatus = '<span style="color: white; background-color: red; padding: 5px; border-radius: 3px;">Falta'.$arrData[$i]['pago'].'</span>';
					} elseif ($arrData[$i]['pago'] == 2) {
						$pagoStatus = '<span style="color: white; background-color: green; padding: 5px; border-radius: 3px;">Listo'.$arrData[$i]['pago'].'</span>';
					}

					// Asignar el estado de pago al arreglo de datos
					$arrData[$i]['pago_status'] = $pagoStatus;
				
					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm btnView " onClick="fntViewInfo('.$arrData[$i]['idsalida'].')" title="Ver salida"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary  btn-sm btnEdit" onClick="fntEditInfo(this,'.$arrData[$i]['idsalida'].')" title="Editar salida"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){	
						$btnDelete = '<button class="btn btn-danger btn-sm btnDel" onClick="fntDelInfo('.$arrData[$i]['idsalida'].')" title="Eliminar salida"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center" style="display:flex; flex-direction:row; justify-content:space-evenly; gap:10px;">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
	
		public function setSalida(){
			if($_POST){
				// if(empty($_POST['idSalida']) || empty($_POST['CodVenta']) || empty($_POST['idNombre']) || empty($_POST['Nombreexterno'])  || empty($_POST['descripcion']) || empty($_POST['Pago']) || empty($_POST['servicios']) )
				if(empty($_POST['CodVenta']) || empty($_POST['servicios']) )
				{
					$arrResponse = array("status" => false, "msg" => 'Faltan datos.');
				}else{
					
					$idSalida = isset($_POST['idSalida']) ? strClean($_POST['idSalida']) : '';
					$CodVenta = isset($_POST['CodVenta']) ? strClean($_POST['CodVenta']) : '';
					$idNombre = isset($_POST['idNombre']) ? strClean($_POST['idNombre']) : '';
					$Pago = isset($_POST['Pago']) ? strClean($_POST['Pago']) : '';
					$Nombreexterno = isset($_POST['Nombreexterno']) ? strClean($_POST['Nombreexterno']) : '';
					$descripcion = isset($_POST['descripcion']) ? strClean($_POST['descripcion']) : '';
					$servicios = isset($_POST['servicios']) ? json_decode($_POST['servicios'], true) : [];
					$request_salida = "";


					if(empty($idSalida))
					{
						$option = 1;
						if($_SESSION['permisosMod']['w']){
							$request_salida = $this->model->insertSalida($CodVenta, 
																		$idNombre, 
																		$Nombreexterno,
																		$descripcion, 
																		$Pago, 
																		$servicios);
						}
					}else{
						$option = 2;
						if($_SESSION['permisosMod']['u']){
							$request_salida = $this->model->updateSalida($idSalida,
																		$CodVenta,
																		$idNombre, 
																		$Nombreexterno,
																		$descripcion, 
																		$Pago, 
																		$servicios);
						}
					}
					if($request_salida > 0 )
					{
						if($option == 1){
							$arrResponse = array('status' => true, 'action' => 'insert', 'msg' => 'Datos de la salida guardados correctamente.');
						}else{
							$arrResponse = array('status' => true, 'action' => 'edit', 'msg' => 'Datos Actualizados correctamente.');
						}
					}else {
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos. -> ' . json_encode($option));
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}


		public function getSalida($idSalida){
			if($_SESSION['permisosMod']['r']){
				$idSalida = intval($idSalida);
				if($idSalida > 0){
					$arrData = $this->model->selectSalida($idSalida);
					$arrResponse = array(); // Inicializa $arrResponse aquí
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
	

		public function delSalida(){
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdsalida = intval($_POST['idSalida']);
					$requestDelete = $this->model->deleteSalida($intIdsalida);
					if($requestDelete)
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la salida');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar la salida.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
	}
 ?>