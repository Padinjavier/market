<?php 

	class RolesUsuarios extends Controllers{
		public function __construct()
		{
			parent::__construct();
			session_start();
			//session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				die();
			}
			getPermisos(MROLUSUARIOS);
		}

		public function RolesUsuarios()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_id'] = 3;
			$data['page_tag'] = "Permisos Usuario";
			$data['page_name'] = "rol_usuario";
			$data['page_title'] = "Permisos <small> </small>";
			$data['page_functions_js'] = "functions_rolesusuario.js";
			$this->views->getView($this,"rolesusuarios",$data);
		}

		public function getRoles()
		{
			if($_SESSION['permisosMod']['r']){
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				$arrData = $this->model->selectRoles();

				for ($i=0; $i < count($arrData); $i++) {

					if($arrData[$i]['status'] == 1)
					{
						$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
					}else{
						$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
					}
					if($_SESSION['permisosMod']['u']){
						$btnView = '<button class="btn btn-info btn-sm btnView btnPermisosRol" onClick="fntPermisosUsuario('.$arrData[$i]['idrolusuario'].')" title="Permisos"><i class="fas fa-key"></i></button>';
						$btnEdit = '<button class="btn btn-primary btn-sm btnEdit btnEditRol" onClick="fntEditRolUsuario('.$arrData[$i]['idrolusuario'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						if(($arrData[$i]['nombrerolusuario'] == 'Cliente') || ($arrData[$i]['idrolusuario'] == '3')){
							
							$btnDelete = '<button class="btn btn-secondary btn-sm btnDelRol" disabled  onClick="" title="Eliminar desactivado"><i class="far fa-trash-alt"></i></button></div>';
						}else{
							$btnDelete = '<button class="btn btn-danger btn-sm btnDel btnDelRol" onClick="fntDelRolUsuario('.$arrData[$i]['idrolusuario'].')" title="Eliminar"><i class="far fa-trash-alt"></i></button></div>';
						}
					}
					$arrData[$i]['options'] = '<div class="text-center" style="display:flex; flex-direction:row; justify-content:space-evenly; gap:10px;">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getSelectRoles()
		{
			$htmlOptions = "";
			$arrData = $this->model->selectRoles();
			if(count($arrData) > 0 ){
				for ($i=0; $i < count($arrData); $i++) { 
					if($arrData[$i]['status'] == 1 ){
					$htmlOptions .= '<option value="'.$arrData[$i]['idrolusuario'].'">'.$arrData[$i]['nombrerolusuario'].'</option>';
					}
				}
			}
			echo $htmlOptions;
			die();		
		}

		public function getRol(String $idrol)
		{
			if($_SESSION['permisosMod']['r']){
				$intIdrol = intval(strClean($idrol));
				if($intIdrol > 0)
				{
					$arrData = $this->model->selectRol($intIdrol);
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

		public function setRol(){
				$intIdrol = intval($_POST['idRolUsuario']);
				$strRol =  strClean($_POST['txtNombre']);
				$strDescipcion = strClean($_POST['txtDescripcion']);
				$intStatus = intval($_POST['listStatus']);
				$request_rol = "";
				if($intIdrol == 0)
				{
					//Crear
					if($_SESSION['permisosMod']['w']){
						$request_rol = $this->model->insertRol($strRol, $strDescipcion,$intStatus);
						$option = 1;
					}
				}else{
					//Actualizar
					if($_SESSION['permisosMod']['u']){
						$request_rol = $this->model->updateRol($intIdrol, $strRol, $strDescipcion, $intStatus);
						$option = 2;
					}
				}

				if($request_rol > 0 )
				{
					if($option == 1)
					{
						$arrResponse = array('status' => true,'action' => 'insert', 'msg' => 'Datos del permiso guardados correctamente.');
					}else{
						$arrResponse = array('status' => true,'action' => 'edit', 'msg' => 'Datos del permiso actualizados correctamente.');
					}
				}else if($request_rol == 'exist'){
					
					$arrResponse = array('status' => false, 'msg' => '¡Atención! El Rol ya existe.');
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}

		public function delRol()
		{
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdrol = intval($_POST['idrolusuario']);
					$requestDelete = $this->model->deleteRol($intIdrol);
					if($requestDelete == 'ok')
					{
						$arrResponse = array('status' => true, 'msg' => 'Datos del permiso de usuario eliminado correctamente.');
					}else if($requestDelete == 'exist'){
						$arrResponse = array('status' => false, 'msg' => 'No es posible eliminar un Rol asociado a usuarios.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Rol.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

	}
 ?>