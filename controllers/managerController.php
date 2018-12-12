<?php

/** CONTROLADOR DEL USUARIO **/

class ManagerController {

	private static $instance;

	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {}

	public function getPermisos() {
		if (isset($_SESSION['rol'])) {
			$rol = $_SESSION['rol'];
			return (!strcmp($rol, 'Jerarquico'));
		} else {
			return false;
		}
	}

	public function index($message=NULL) {
		$view = new BackendManagerView();
		$view->show($message);
	}

	/**
	* para usar en una de las metricas
	**/
	public function listProducts() {
		$type = filter_input(INPUT_POST, "productType");
		$products = ProductDB::getInstance()->getProductsByType($type);
		$employee = $_SESSION['employee'];
		$view = new ProductsListView();
		$view->show($products, $employee);
	}

	public function productosVendidos($message=NULL) {
		$view = new SoldProductsView();
		$view->show($message);
	}

	public function getSoldProducts($fechaInicio, $fechaFin) {
		$products = ManagerDB::getInstance()->getSoldProducts($fechaInicio, $fechaFin);
		$result = array();
		foreach ($products as $product) {
			$metric = new Metric('id', 'idProduct', 'cantidad', 'fecha', 'cupon', 'cantEmp', 'cantNoEmp');
			$metric->setCantidad((int)$product->getCantidad());
			$metric->setFecha($product->getFecha());
			$result[] = $metric;
		}
		header('Content-type: application/json; charset=utf-8');
		echo(json_encode($result));
	}

	public function electronicosVendidos($message=NULL) {
		$view = new SoldElectronicsView();
		$view->show($message);
	}

	public function getSoldElectronics($fechaInicio, $fechaFin) {
		$products = ManagerDB::getInstance()->getSoldElectronics($fechaInicio, $fechaFin);
		$result = array();
		foreach ($products as $product) {
			$metric = new Metric('id', 'idProduct', 'cantidad', 'fecha', 'cupon', 'cantEmp', 'cantNoEmp');
			$metric->setCantidad((int)$product->getCantidad());
			$metric->setFecha($product->getFecha());
			$result[] = $metric;
		}
		header('Content-type: application/json; charset=utf-8');
		echo(json_encode($result));
	}

	public function productosVendidosEmpleados($message=NULL) {
		$view = new ProductsEmployeesView();
		$view->show($message);
	}

	public function getProductsEmployees($fechaInicio, $fechaFin) {
		$products = ManagerDB::getInstance()->getProductsEmployees($fechaInicio, $fechaFin);
		$result = array();
		foreach ($products as $product) {
			$metric = new Metric('id', 'idProduct', 'cantidad', 'fecha', 'cupon', 'cantEmp', 'cantNoEmp');
			$metric->setCantEmp((int)$product->getCantEmp());
			$metric->setNoEmp((int)$product->getCantNoEmp());
			$result[] = $metric;
		}
		header('Content-type: application/json; charset=utf-8');
		echo(json_encode($result));
	}

	public function cuponesUtilizados($message=NULL) {
		$view = new UsedCouponsView();
		$view->show($message);
	}

	public function getUsedCoupons($fechaInicio, $fechaFin) {
		$products = ManagerDB::getInstance()->getUsedCoupons($fechaInicio, $fechaFin);
		$result = array();
		foreach ($products as $product) {
			$metric = new Metric('id', 'idProduct', 'cantidad', 'fecha', 'cupon', 'cantEmp', 'cantNoEmp');
			$metric->setCantidad((int)$product->getCantidad());
			$metric->setFecha($product->getFecha());
			$result[] = $metric;
		}
		header('Content-type: application/json; charset=utf-8');
		echo(json_encode($result));
	}
}