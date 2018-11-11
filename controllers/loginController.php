<?php

/** CONTROLADOR DEL INDEX **/

class LoginController {

	private static $instance;

	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {}

	public function index() {
		$view = new IndexView();
		$view->show();
	}

	public function login($message=NULL) {
		$view = new LoginView();
		$view->show($message);
	}

	public function logout() {
		// Destruir todas las variables de sesión.
		$_SESSION = array();
		session_destroy();
		IndexController::getInstance()->index();
	}

	public function validar() {
		$usuario = filter_input(INPUT_POST, "username");
		$password = filter_input(INPUT_POST, "password");
		$user = UserDB::getInstance()->get($usuario, $password);
		if (!empty($user)) {
			/*if ($user->getActivo()) {
			}*/
				//$session_token = md5(uniqid(microtime(), true));
				//$isAdmin = $this->isAdmin($roles);
				/*if($sitioHabilitado) {
					$_SESSION['username'] = $user->getUsername();
					$_SESSION['id'] = $user->getId();
					//$_SESSION['session_token'] = $session_token;
					$view = new backendView();
					$view->show($roles, $user->getUsername());
				}*/
				if ($user->getRol() == "Admin") {
					$_SESSION['username'] = $user->getUsername();
					$_SESSION['id'] = $user->getId();
					//$_SESSION['session_token'] = $session_token;
					$view = new BackendAdminView();
					$view->show();
				} elseif ($user->getRol() == "Jerarquico") {
					$view = new BackendManagerView();
					$view->show();
				} else {
					$view = new BackendUserView();
					$view->show();
				}
		} else {
			$mensaje = "Acceso Incorrecto. Intente nuevamente.";
			$view = new LoginView();
			$view->show($mensaje);
		}
	}
}