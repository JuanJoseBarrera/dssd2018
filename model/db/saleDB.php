<?php

class SaleDB extends ModelDB {
	private static $instance;

	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct() {}

	public function getSales($dni) {
		$mapper = function($row) {
			$resource = new Sale($row['idCompra'], $row['nombre'], $row['descProducto'], $row['precio'], $row['cantidad'], $row['dni']);
			return $resource;
		};
		$query = "SELECT c.idCompra, p.brand AS nombre, c.descProducto, c.precio, c.cantidad, c.dni FROM compra c JOIN product p ON p.id = c.idProducto WHERE c.dni = ?";
		$answer = $this->queryList($query, [$dni], $mapper);
		return $answer;
	}
}