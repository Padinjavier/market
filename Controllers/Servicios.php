<?php
	class Servicios extends Controllers{
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
		getPermisos(MSERVICIOS);
	}

	public function Servicios()
	{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
		}
		$data['page_tag'] = "Servicios";
		$data['page_title'] = "SERVICIOS";
		$data['page_name'] = "servicios";
		$data['page_functions_js'] = "functions_servicios.js";
			$this->views->getView($this,"servicios",$data);
	}

		public function setServicio(){
			if($_POST){
				if(empty($_POST['txtNombre']) || empty($_POST['txtDescripcion']) || empty($_POST['txtPrecio']) || empty($_POST['listStatus']) )
	{
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{

				$intIdservicio = intval($_POST['idServicio']);
					$strServicio =  strClean($_POST['txtNombre']);
				$strDescipcion = strClean($_POST['txtDescripcion']);
				$strPrecio = strClean($_POST['txtPrecio']);
				$intStatus = intval($_POST['listStatus']);

				$ruta = strtolower(clear_cadena($strServicio));
					$ruta = str_replace(" ","-",$ruta);

					$foto   	 	= $_FILES['foto'];
					$nombre_foto 	= $foto['name'];
					$type 		 	= $foto['type'];
					$url_temp    	= $foto['tmp_name'];
					$imgPortada 	= 'portada_servicio.png';
				$request_cateria = "";
					if($nombre_foto != ''){
						$imgPortada = 'img_'.md5(date('d-m-Y H:i:s')).'.jpg';
				}

					if($intIdservicio == 0)
					{
					//Crear
						if($_SESSION['permisosMod']['w']){
							$request_cateria = $this->model->inserServicio($strServicio, $strDescipcion, $strPrecio, $imgPortada,$ruta,$intStatus);
						$option = 1;
					}
					}else{
					//Actualizar
						if($_SESSION['permisosMod']['u']){
							if($nombre_foto == ''){
								if($_POST['foto_actual'] != 'portada_servicio.png' && $_POST['foto_remove'] == 0 ){
								$imgPortada = $_POST['foto_actual'];
							}
						}
							$request_cateria = $this->model->updateServicio($intIdservicio,$strServicio, $strDescipcion, $strPrecio ,$imgPortada,$ruta,$intStatus);
						$option = 2;
					}
				}
					if($request_cateria > 0 )
					{
						if($option == 1)
						{
						$arrResponse = array('status' => true,'action' => 'insert' ,'msg' => 'Datos del servicio guardados correctamente.');
							if($nombre_foto != ''){ uploadImage($foto,$imgPortada); }
						}else{
						$arrResponse = array('status' => true,'action' => 'edit', 'msg' => 'Datos del servicio actualizados correctamente.');
							if($nombre_foto != ''){ uploadImage($foto,$imgPortada); }

							if(($nombre_foto == '' && $_POST['foto_remove'] == 1 && $_POST['foto_actual'] != 'portada_servicio.png')
								|| ($nombre_foto != '' && $_POST['foto_actual'] != 'portada_servicio.png')){
							deleteFile($_POST['foto_actual']);
						}
					}
					}else if($request_cateria == 'exist'){
					$arrResponse = array('status' => false, 'msg' => '¡Atención! Servicio ya existe.');
					}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
			}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function getServicios()
	{
			if($_SESSION['permisosMod']['r']){
			$arrData = $this->model->selectServicios();
				for ($i=0; $i < count($arrData); $i++) {
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';

					$arrData[$i]['precio']= "S/".($arrData[$i]['precio']);

					if($arrData[$i]['status'] == 1)
					{
					$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
					}else{
					$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
				}

					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['idservicio'].')" title="Ver servicio"><i class="far fa-eye"></i></button>';
				}
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary  btn-sm btnEdit btnEditInfo" onClick="fntEditInfo(this,'.$arrData[$i]['idservicio'].')" title="Editar servicio"><i class="fas fa-pencil-alt"></i></button>';
				}
					if($_SESSION['permisosMod']['d']){	
						$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['idservicio'].')" title="Eliminar servicio"><i class="far fa-trash-alt"></i></button>';
				}
					$arrData[$i]['options'] = '<div class="text-center" style="display:flex; flex-direction:row; justify-content:space-evenly; gap:10px;">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
			}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function getServicio($idservicio)
	{
			if($_SESSION['permisosMod']['r']){
			$intIdservicio = intval($idservicio);
				if($intIdservicio > 0)
				{
				$arrData = $this->model->selectServicio($intIdservicio);
					if(empty($arrData))
					{
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
						$arrData['url_portada'] = media().'/images/uploads/'.$arrData['portada'];
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}

	public function delServicio()
	{
			if($_POST){
				if($_SESSION['permisosMod']['d']){
				$intIdservicio = intval($_POST['idservicio']);
				$requestDelete = $this->model->deleteServicio($intIdservicio);
					if($requestDelete == 'ok')
					{
					$arrResponse = array('status' => true, 'msg' => 'Datos del servicio eliminado correctamente.');
					}else{
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el servicio.');
				}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}

		public function getSelectCategorias(){
		$htmlOptions = "";
		$arrData = $this->model->selectServicios();
			if(count($arrData) > 0 ){
				for ($i=0; $i < count($arrData); $i++) { 
					if($arrData[$i]['status'] == 1 ){
					$htmlOptions .= '<option value="'.$arrData[$i]['idservicio'].'">'.$arrData[$i]['nombre'].'</option>';
				}
			}
		}
		echo $htmlOptions;
		die();
	}



	// ---------------------------------------------
// ---------------------------------------------
// ---------------------------------------------
	// public function getSelectServicios()
	// {
	// 	$servicios = $this->model->selectServicios();
	// 	$options = '<option value="">Seleccione una opción</option>';
	
	// 	foreach ($servicios as $servicio) {
	// 		$options .= '<option value="' . htmlspecialchars($servicio['idservicio']) . '">' . htmlspecialchars($servicio['nombre']) . ' S/' . htmlspecialchars($servicio['precio']) . '</option>';
	// 	}
	
	// 	$data = [];
	// 	$data[0] = $options;
	// 	$data[1] = isset($servicio['precio']) ? htmlspecialchars($servicio['precio']) : 0;
	
	// 	echo json_encode($data);
	// }
	
	public function getSelectServicios()
{
    $servicios = $this->model->selectServicios();
    $options = '<option value="">Seleccione una opción</option>';

    foreach ($servicios as $servicio) {
        $options .= '<option value="' . htmlspecialchars($servicio['idservicio']) . '" data-precio="' . htmlspecialchars($servicio['precio']) . '">' . htmlspecialchars($servicio['nombre']) . ' S/' . htmlspecialchars($servicio['precio']) . '</option>';
    }

    $data = [];
    $data[0] = $options;

    echo json_encode($data);
}











	// ---------------------------------------------
// ---------------------------------------------
// ---------------------------------------------

}


?>