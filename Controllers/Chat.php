<?php
class Chat extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
    }

    public function Chat()
    {
        $data['page_id'] = 3;
        $data['page_tag'] = "chat";
        $data['page_title'] = "chat";
        $data['page_name'] = "chat";
        $data['page_functions_js'] = "functions_chats.js"; // Asegúrate de tener el archivo JS correspondiente
        // $this->views->getModal('chat',$data);
        $this->views->getModal('modalChat', $data);
    }


    public function getChat()
    {
        $iduser = $_SESSION['userData']['idpersona'];
        $arrData = $this->model->getAvailableUsers($iduser);

        if (empty($arrData)) {
            $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
        } else {
            $arrResponse = array('status' => true, 'data' => $arrData);
        }

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function getChatuser($idpersona)
    {
        $iduser = $_SESSION['userData']['idpersona'];
        $arrData = $this->model->getMSQUsers($iduser, $idpersona);

        if (empty($arrData)) {
            $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
        } else {
            $arrResponse = array('status' => true, 'data' => $arrData);
        }

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function setMSG()
{
    $idpersona = $_POST['idpersona'];
    $msg = $_POST['msg'];
    $iduser = $_SESSION['userData']['idpersona'];

    if (empty($idpersona) || empty($msg)) {
        $arrResponse = array('status' => false, 'msg' => 'Datos incompletos.');
    } else {
        $arrData = $this->model->insertMSG($iduser, $idpersona, $msg);

        if ($arrData > 0) {
            $arrResponse = array('status' => true, 'msg' => 'Mensaje guardado.');
        } else {
            $arrResponse = array('status' => false, 'msg' => 'No se pudo guardar el mensaje.');
        }
    }

    echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    die();
}


}