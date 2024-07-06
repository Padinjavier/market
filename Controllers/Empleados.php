<?php 

	class Empleados extends Controllers{
		public function __construct()
		{
			parent::__construct();
			session_start();
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				die();
			}
			getPermisos(MEMPLEADOS);
		}

		public function Empleados()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "Empleados";
			$data['page_title'] = "Empleados <small> </small>";
			$data['page_name'] = "empleado";
			$data['page_functions_js'] = "functions_empleados.js";
			$this->views->getView($this,"empleados",$data);
		}

		public function setEmpleado(){
			if($_POST){			
				if(empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['listRolid']) || empty($_POST['listStatus']) )
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{ 
					$idEmpleado = intval($_POST['idEmpleado']);
					$strIdentificacion = strClean($_POST['txtIdentificacion']);
					$strNombre = ucwords(strClean($_POST['txtNombre']));
					$strApellido = ucwords(strClean($_POST['txtApellido']));
					$intTelefono = intval(strClean($_POST['txtTelefono']));
					$strEmail = strtolower(strClean($_POST['txtEmail']));
					$intTipoId = intval(strClean($_POST['listRolid']));
					$intStatus = intval(strClean($_POST['listStatus']));
					$request_user = "";
					$request_opc = "";
					if($idEmpleado == 0)
					{
						$option = 1;
						if($_SESSION['permisosMod']['w']){
							$request_user = $this->model->insertEmpleado($strIdentificacion,
																				$strNombre, 
																				$strApellido, 
																				$intTelefono, 
																				$strEmail,
																				$intTipoId, 
																				$intStatus );
						}
					}else{
						$option = 2;
						if($_SESSION['permisosMod']['u']){
							$request_user = $this->model->updateEmpleado($idEmpleado,
																		$strIdentificacion, 
																		$strNombre,
																		$strApellido, 
																		$intTelefono, 
																		$strEmail,
																		$intTipoId, 
																		$intStatus);
						}
					}

					if($request_user > 0 )
					{
						if($option == 1){
							$arrResponse = array('status' => true,'action' => 'insert', 'msg' => 'Datos del empleado guardados correctamente.');
						}else{
							$arrResponse = array('status' => true,'action' => 'edit', 'msg' => 'Datos del empleado actualizados correctamente.');
						}
					}else if($request_user == -1){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! el email o la identificación ya existe, ingrese otro.');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getEmpleados()
		{
			if($_SESSION['permisosMod']['r']){
				$arrData = $this->model->selectEmpleados();
				for ($i=0; $i < count($arrData); $i++) {
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';

					if($arrData[$i]['status'] == 1)
					{
						$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
					}else{
						$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
					}

					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm btnView btnViewEmpleado" onClick="fntViewEmpleado('.$arrData[$i]['idpersona'].')" title="Ver Empleado"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['permisosMod']['u']){
							$btnEdit = '<button class="btn btn-primary  btn-sm btnEdit btnEditEmpleado" onClick="fntEditEmpleado(this,'.$arrData[$i]['idpersona'].')" title="Editar Empleado"><i class="fas fa-pencil-alt"></i></button>';
						
					}
					if($_SESSION['permisosMod']['d']){
							$btnDelete = '<button class="btn btn-danger btn-sm btnDel btnDelEmpleado" onClick="fntDelEmpleado('.$arrData[$i]['idpersona'].')" title="Eliminar Empleado"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center" style="display:flex; flex-direction:row; justify-content:space-evenly; gap:10px;">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getEmpleado($idpersona){
			if($_SESSION['permisosMod']['r']){
				$idEmpleado = intval($idpersona);
				if($idEmpleado > 0)
				{
					$arrData = $this->model->selectEmpleado($idEmpleado);
					if(empty($arrData))
					{
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function delEmpleado()
		{
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdpersona = intval($_POST['idEmpleado']);
					$requestDelete = $this->model->deleteEmpleado($intIdpersona);
					if($requestDelete)
					{
						$arrResponse = array('status' => true, 'msg' => 'Datos del empleado eliminado correctamente.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar al Empleado.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function perfil(){
			$data['page_tag'] = "Perfil";
			$data['page_title'] = "Perfil de empleado";
			$data['page_name'] = "perfil";
			$data['page_functions_js'] = "functions_empleados.js";
			$this->views->getView($this,"perfil",$data);
		}


		public function putDFical(){
			if($_POST){
				if(empty($_POST['txtNit']) || empty($_POST['txtNombreFiscal']) || empty($_POST['txtDirFiscal']) )
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					$idEmpleado = $_SESSION['idUser'];
					$strNit = strClean($_POST['txtNit']);
					$strNomFiscal = strClean($_POST['txtNombreFiscal']);
					$strDirFiscal = strClean($_POST['txtDirFiscal']);
					$request_datafiscal = $this->model->updateDataFiscal($idEmpleado,
																		$strNit,
																		$strNomFiscal, 
																		$strDirFiscal);
					if($request_datafiscal)
					{
						sessionUser($_SESSION['idUser']);
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible actualizar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		public function getSelectEmpleados() {
			$htmlOptions = '<option value="">Ingrese el nombre del empleado</option>';
			$arrData = $this->model->selectlistempleado();
			if (count($arrData) > 0) {
				foreach ($arrData as $row) {
					$htmlOptions .= '<option value="'.htmlspecialchars($row['idpersona']).'">'.htmlspecialchars($row['nombres']).'</option>';
				}
			}
			echo $htmlOptions;
			die();
		}
	}
 ?>