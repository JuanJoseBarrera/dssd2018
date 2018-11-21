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

	/** Obtener el listado de productos por tipo de la api de bonita**/
	private function getProducts($type) {
		$curl = curl_init(BONITA_BASE_URL.$type);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$res = curl_exec($curl);
		$result = json_decode($res, true);
		return $result;
	}
}