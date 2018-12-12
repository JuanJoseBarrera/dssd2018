<?php

/**
 * MODELO BASE DE DATOS METRICAS
 */
class ManagerDB extends ModelDB {

	private static $instance;

	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct() {}

	public function getSoldProducts($fechaInicio, $fechaFin) {
		$mapper = function($row) {
			$product = new Metric('id', 'idProduct', $row['cant'], $row['fechaCompra'], 'cupon', 'cantEmp', 'cantNoEmp');
			return $product;
		};
		$query = "SELECT SUM(c.cantidadComprada) AS cant, fechaCompra FROM consultoria c WHERE (c.fechaCompra BETWEEN ? AND ?) GROUP BY c.fechaCompra";
		$answer = $this->queryList($query, [$fechaInicio, $fechaFin], $mapper);
		return $answer;
	}

	public function getSoldElectronics($fechaInicio, $fechaFin) {
		$mapper = function($row) {
			$product = new Metric('id', 'idProduct', $row['cant'], $row['fechaCompra'], 'cupon', 'cantEmp', 'cantNoEmp');
			return $product;
		};
		$query = "SELECT SUM(c.cantidadComprada) AS cant, fechaCompra FROM consultoria c JOIN product p ON (c.idProdComprado = p.id) JOIN producttype pt ON (p.producttype = pt.id) WHERE (pt.description = 'Electro') AND (c.fechaCompra BETWEEN ? AND ?) GROUP BY c.fechaCompra";
		$answer = $this->queryList($query, [$fechaInicio, $fechaFin], $mapper);
		return $answer;
	}

	public function getProductsEmployees($fechaInicio, $fechaFin) {
		$mapper = function($row) {
			$product = new Metric('id', 'idProduct', 'cant', 'fechaCompra', 'cupon', $row['cantEmpleados'], $row['clientes']);
			return $product;
		};
		$query = "SELECT SUM(c.cantidadEmpleado) AS cantEmpleados, SUM(c.cantidadNoEmpleado) AS clientes FROM consultoria c WHERE (c.fechaCompra BETWEEN ? AND ?)";
		$answer = $this->queryList($query, [$fechaInicio, $fechaFin], $mapper);
		return $answer;
	}

	public function getUsedCoupons($fechaInicio, $fechaFin) {
		$mapper = function($row) {
			$product = new Metric('id', 'idProduct', $row['cant'], $row['fechaCompra'], 'cupon', 'cantEmp', 'cantNoEmp');
			return $product;
		};
		$query = "SELECT SUM(c.cantCuponesUsado) AS cant, c.fechaCompra FROM consultoria c WHERE (c.fechaCompra BETWEEN ? AND ?) GROUP BY c.fechaCompra";
		$answer = $this->queryList($query, [$fechaInicio, $fechaFin], $mapper);
		return $answer;
	}
}