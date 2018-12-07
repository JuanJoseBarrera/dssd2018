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
			$_SESSION['username'] = $user->getUsername();
			$_SESSION['id'] = $user->getId();
			$dni = $user->getDni();
			$_SESSION['dni'] = $dni;
			$_SESSION['rol'] = $user->getRol();
			if ($user->getRol() == "Admin") {
				$view = new BackendAdminView();
				$view->show();
			} elseif ($user->getRol() == "Jerarquico") {
				$view = new BackendManagerView();
				$view->show();
			} else {
				$_SESSION['controller'] = 'UserController';
				$employee = UserDB::getInstance()->isEmployee($dni);
				$_SESSION['employee'] = $employee;
				UserController::getInstance()->index();
			}
		} else {
			$mensaje = "Acceso Incorrecto. Intente nuevamente.";
			$view = new LoginView();
			$view->show($mensaje);
		}
	}
}