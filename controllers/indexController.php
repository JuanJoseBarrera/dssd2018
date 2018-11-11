<?php

/** CONTROLADOR DEL INDEX **/

class IndexController {

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
}