<?php
class Opciones extends Controllers
{
	public function __construct()
	{
		parent::__construct();
		session_start();
		if (empty($_SESSION['login'])) {
			header('Location: ' . base_url() . '/login');
			die();
		}
		getPermisos(MEMPLEADOS);
	}

	public function Opciones()
	{
		$data['page_id'] = 3;
		$data['page_tag'] = "Opciones";
		$data['page_title'] = "opcionesoooo";
		$data['page_name'] = "opciones";
		$data['page_functions_js'] = "functions_opciones.js"; // Asegúrate de tener el archivo JS correspondiente
        $this->views->getView($this, "opciones", $data);
    }

    public function getOpciones()
    {
        if ($_SESSION['permisosMod']['r']) {
            $idpersona= $_SESSION['userData']['idpersona'];
            $arrData = $this->model->selectOpciones($idpersona);
           
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setOpciones(){
        if($_POST){
            if(empty($_POST['selectIdioma']) || empty($_POST['selectTema']) || empty($_POST['selectMoneda']) )
            {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            }else{
                
                $intIdioma = intval($_POST['selectIdioma']);
                $intTema = strClean($_POST['selectTema']);
                $intMoneda = strClean($_POST['selectMoneda']);
                $request_producto = "";
                $idpersona= $_SESSION['userData']['idpersona'];

                        $request_producto = $this->model->updateOpciones($idpersona,
                                                                    $intIdioma, 
                                                                    $intTema, 
                                                                    $intMoneda);
                    
                
                if($request_producto > 0 )
                {
                    $arrResponse = array("status" => false, "msg" => 'Datos Actualizados correctamente.');	
                    // $arrResponse = array('status' => true, 'idproducto' => $idpersona, 'msg' => 'Datos Actualizados correctamente.');
                    
                }else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');	
                }
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
    }

}
?>