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
        $this->views->getModal('modalChat',$data);
    }


	public function getChat() {
		$arrData = $this->model->getAvailableUsers();
	
		if (empty($arrData)) {
			$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
		} else {
			$arrResponse = array('status' => true, 'data' => $arrData);
		}
	
		echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		die();
	}
	
	
}