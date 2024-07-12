<?php
class Logout extends Controllers {
    public function __construct() {
        parent::__construct();
        session_start();
        $this->getChat(); // Llama al método usando $this-> en lugar de una llamada directa
    }

    public function getChat() {
        $arrData = $this->model->cerrarconeccionuser($_SESSION['userData']['idpersona']);
        
        if (!$arrData) {
            $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
        } else {
            session_unset();
            session_destroy();
            header('location: ' . base_url() . '/login');
            die();
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
}
?>
