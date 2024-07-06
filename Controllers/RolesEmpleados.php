<?php 

	class RolesEmpleados extends Controllers{
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
			getPermisos(MROLEMPLEADOS);
		}

		public function RolesEmpleados()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_id'] = 3;
			$data['page_tag'] = "Roles Empleados";
			$data['page_name'] = "rol_usuario";
			$data['page_title'] = "Roles Empleados";
			$data['page_functions_js'] = "functions_rolesempleados.js";
			$this->views->getView($this,"rolesempleados",$data);
		}

		public function getRolesEmpleados()
		{
			if($_SESSION['permisosMod']['r']){
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				$arrData = $this->model->selectRolesEmpleados();

				for ($i=0; $i < count($arrData); $i++) {

					if($arrData[$i]['status'] == 1)
					{
						$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
					}else{
						$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
					}

					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm btnView btnViewRol" onClick="fntViewRol('.$arrData[$i]['idrolempleado'].')" title="Ver Empleado"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary btn-sm btnEdit btnEditRol" onClick="fntEditRol('.$arrData[$i]['idrolempleado'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($arrData[$i]['nombrerolempleado'] == 'Cliente'){
						if($_SESSION['permisosMod']['d']){
							$btnDelete = '<button class="btn btn-secondary btn-sm btnDel btnDelRol" onClick="" title="Eliminar desactivado"><i class="far fa-trash-alt"></i></button>
						</div>';
						}
					}else{
						if($_SESSION['permisosMod']['d']){
							$btnDelete = '<button class="btn btn-danger btn-sm btnDelRol" onClick="fntDelRol('.$arrData[$i]['idrolempleado'].')" title="Eliminar"><i class="far fa-trash-alt"></i></button>
						</div>';
						}
					}
					$arrData[$i]['options'] = '<div class="text-center" style="display:flex; flex-direction:row; justify-content:space-evenly; gap:10px;">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		public function getRolesEmpleadoslist()
		{
			if($_SESSION['permisosMod']['r']){
				$arrData = $this->model->selectRolesEmpleados();

				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getSelectRoles()
		{
			$htmlOptions = "";
			$arrData = $this->model->selectRolesEmpleados();
			if(count($arrData) > 0 ){
				for ($i=0; $i < count($arrData); $i++) { 
					if($arrData[$i]['status'] == 1 ){
					$htmlOptions .= '<option value="'.$arrData[$i]['idrolempleado'].'">'.$arrData[$i]['nombrerolempleado'].'</option>';
					}
				}
			}
			echo $htmlOptions;
			die();		
		}

		public function getSelectRolesEmpleadosventa()
		{
			$htmlOptions = "";
			$arrData = $this->model->selectRolesEmpleadosventa();
			if (count($arrData) > 0) {
				$rol_id_anterior = null;
				foreach ($arrData as $row) {
					// Filtramos el nombre del rol "Cargador" o "cargador"
					if ((strtolower($row['rol_nombre']) === 'cargador')) {
						continue; // Saltamos al siguiente registro si el rol es "Cargador"
					}
					// Solo creamos el div y el select cuando cambia el rol
					if ($rol_id_anterior != $row['rol_id']) {
						// Cerramos el div anterior si ya existe
						if (!is_null($rol_id_anterior)) {
							$htmlOptions .= '</select>
										</div>
									</div>';
						}
						// Creamos el nuevo div para el nuevo rol
					$htmlOptions .= '<div class="col-lg-4 col-md-6">
										<div class="form-group">
											<label class="control-label" id="listRolEmpleado_'.htmlspecialchars($row['rol_nombre']).'">' .htmlspecialchars($row['rol_nombre']). '</label>
											<select class="form-control" id="listRolEmpleado_'.htmlspecialchars($row['rol_nombre']).'" name="select_'.htmlspecialchars($row['rol_nombre']).'">
												<option value="">Seleccione una opción</option>';

					}
					// Agregamos las opciones del select
					$htmlOptions .= '<option value="'.htmlspecialchars($row['persona_id']).'">'.htmlspecialchars($row['persona_nombre']).'</option>';
					// Actualizamos el rol_id_anterior
					$rol_id_anterior = $row['rol_id'];
				}
				// Cerramos el último div
				$htmlOptions .= '</select>
										</div>
									</div>';
			}
			echo $htmlOptions;
			die();
		}
		


		
		public function getSelectRolesCargadores() {
			$htmlOptions = '<option value="">Seleccione una opción</option>';
			$arrData = $this->model->selectRolesCargadores();
			foreach ($arrData as $row) {
				$htmlOptions .= '<option value="' . htmlspecialchars($row['persona_id']) . '">' . htmlspecialchars($row['persona_nombre']) . '</option>';
			}
			echo $htmlOptions;
			die();
		}
		
		public function getNewCargadorSelect() {
			$htmlOptions = '<option value="">Seleccione una opción</option>';
			$arrData = $this->model->selectRolesCargadores();
			foreach ($arrData as $row) {
				$htmlOptions .= '<option value="' . htmlspecialchars($row['persona_id']) . '">' . htmlspecialchars($row['persona_nombre']) . '</option>';
			}
			echo $htmlOptions;
			die();
		}
		









		public function getRolEmpleado(String $idrolempleado)
		{
			if($_SESSION['permisosMod']['r']){
				$intIdrolempleado = intval(strClean($idrolempleado));
				if($intIdrolempleado > 0)
				{
					$arrData = $this->model->selectRol($intIdrolempleado);
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

		public function setRolEmpleados(){
				$intIdrolempleado = intval($_POST['idRolEmpleado']);
				$strRolempleado =  strClean($_POST['txtNombre']);
				$strDescipcion = strClean($_POST['txtDescripcion']);
				$intStatus = intval($_POST['listStatus']);
				$request_rol = "";
				if($intIdrolempleado == 0)
				{
					//Crear
					if($_SESSION['permisosMod']['w']){
						$request_rol = $this->model->insertRol($strRolempleado, $strDescipcion,$intStatus);
						$option = 1;
					}
				}else{
					//Actualizar
					if($_SESSION['permisosMod']['u']){
						$request_rol = $this->model->updateRol($intIdrolempleado, $strRolempleado, $strDescipcion, $intStatus);
						$option = 2;
					}
				}

				if($request_rol > 0 )
				{
					if($option == 1)
					{
						$arrResponse = array('status' => true,'action' => 'insert',  'msg' => 'Datos de roles del empleado guardados correctamente.');
					}else{
						$arrResponse = array('status' => true,'action' => 'edit',  'msg' => 'Datos de roles actualizados correctamente.');
					}
				}else if($request_rol == 'exist'){
					
					$arrResponse = array('status' => false, 'msg' => '¡Atención! El Rol ya existe.');
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}

		public function delRolEmpleado()
		{
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdrolempleado = intval($_POST['idrolempleado']);
					$requestDelete = $this->model->deleteRol($intIdrolempleado);
					if($requestDelete == 'ok')
					{
						$arrResponse = array('status' => true, 'msg' => 'Datos del rol eliminado correctamente.');
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