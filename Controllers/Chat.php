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

	public function Opciones()
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
			$html = '';
			foreach ($arrData as $i => $userData) {
				$html .= '<li class="p-2 border-bottom">
							<a href="#!" id="' . $i . '" class="d-flex justify-content-between">
								<div class="d-flex flex-row">
									<div>
										<img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp" alt="avatar"
											class="d-flex align-self-center me-3" width="60">
										<span class="badge bg-success badge-dot"></span>
									</div>
									<div class="pt-1">
										<p class="fw-bold mb-0 nombre">' . htmlspecialchars($userData['nombres'] . ' ' . $userData['apellidos']) . '</p>
										<p class="small text-muted">Hello, Are you there?</p>
									</div>
								</div>
								<div class="pt-1">
									<p class="small text-muted mb-1">Just now</p>
									<span class="badge bg-danger rounded-pill float-end">' . $i . '</span>
								</div>
							</a>
						</li>';
			}
	
			$arrResponse = array('status' => true, 'data' => $html);
		}
	
		echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		die();
	}
	
}