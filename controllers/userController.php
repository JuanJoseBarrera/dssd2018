<?php

/** CONTROLADOR DEL USUARIO **/

class UserController {

	private static $instance;

	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {}

	public function index() {
		$view = new BackendUserView();
		$view->show();
	}

	public function elegirTipo() {
		$message = NULL;
		$tipos = ProductDB::getInstance()->getProductTypes();
		$view = new SelectTypeView();
		$view->show($tipos, $message);
	}
}