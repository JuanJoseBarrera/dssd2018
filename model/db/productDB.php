<?php

/**
 * MODELO PRODUCTO BASE DE DATOS
 */
class ProductDB extends ModelDB {

	private static $instance;

	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct() {}

	public function getProducts() {
		$mapper = function($row) {
			$resource = new Product($row['id'], $row['brand'], $row['size'], $row['costprice'], $row['saleprice'], $row['stock'], $row['type']);
			return $resource;
		};
		$query = "SELECT p.id, p.brand, p.size, p.costprice, p.saleprice, p.stock, t.description as type FROM product p JOIN producttype t ON p.producttype = t.id";
		$answer = $this->queryList($query, [], $mapper);
		return $answer;
	}

	public function getFullProduct($id) {
		$mapper = function($row) {
			$resource = new Product($row['id'], $row['brand'], $row['size'], $row['costprice'], $row['saleprice'], $row['stock'], $row['type']);
			return $resource;
		};
		$query = "SELECT p.id, p.brand, p.size, p.costprice, p.saleprice, p.stock, t.description as type FROM product p JOIN producttype t ON p.producttype = t.id WHERE p.id = ?";
		$answer = $this->queryList($query, [$id], $mapper);
		return $answer;
	}

	public function getProductsByType($type) {
		$mapper = function($row) {
			$product = new Product($row['id'], $row['brand'], $row['size'], $row['costprice'], $row['saleprice'], $row['stock'], $row['type']);
			return $product;
		};
		$query = "SELECT p.id, p.brand, p.size, p.costprice, p.saleprice, p.stock, t.description as type FROM product p JOIN producttype t ON p.producttype = t.id WHERE t.initials = ?";
		$answer = $this->queryList($query, [$type], $mapper);
		return $answer;
	}

	/**
	* Guarda un nuevo producto
	*/
	public function save($product) {
		$connection = $this->getConnection();
		$connection->beginTransaction();
		try {
			$query = "INSERT INTO product (brand, size, costprice, saleprice, stock, producttype) VALUES (?, ?, ?, ?, ?, ?)";
			$stmt = $connection->prepare($query);
			$params= array($product->getBrand(), $product->getSize(), $product->getCostPrice(), $product->getSalePrice(), $product->getStock(), $product->getType());
			$stmt->execute($params);
			return $connection->commit();
		} catch (PDOException $e) {
			$connection->rollBack();
		}
		return;
	}

	/**
	* Actualiza datos de un producto
	*/
	public function update() {
		$connection = $this->getConnection();
		$connection->beginTransaction();
		try {
			$query = "UPDATE product SET brand = ?, size = ?, costprice = ?, saleprice = ?, stock = ?, producttype = ? WHERE id = ?";
			$stmt = $connection->prepare($query);
			$params = array($product->getBrand(), $product->getSize(), $product->getCostPrice(), $product->getSalePrice(), $product->getStock(), $product->getType(), $product->getId());
			$stmt->execute($params);

			return $connection->commit();
		} catch (Exception $e) {
			return $connection->rollBack();
		}
	}

	/**
	* Elimina logicamente un producto
	*/
	public function delete() {}

	public function getProductTypes() {
		$mapper = function($row) {
 			$type = new ProductType($row['id'], $row['initials'], $row['description']);
			return $type;
		};
		$query = "SELECT t.id, t.initials, t.description FROM producttype t";
		$answer = $this->queryList($query, [], $mapper);
		return $answer;
	}
}