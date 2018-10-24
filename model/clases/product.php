<?php

/**
 * MODELO PRODUCTO
 */
class Product {

	private $id;
	private $brand;
	private $size;
	private $costprice;
	private $saleprice;
	private $stock;
	private $type;

	function __construct($id, $brand, $size, $costprice, $saleprice, $stock, $type) {
		$this->id = $id;
		$this->brand = $brand;
		$this->size = $size;
		$this->costprice = $costprice;
		$this->saleprice = $saleprice;
		$this->stock = $stock;
		$this->type = $type;
	}

	/**
	* GETTERS
	*/

	public function getId() {
		return $this->id;
	}

	public function getBrand() {
		return $this->brand;
	}

	public function getSize() {
		return $this->size;
	}

	public function getCostPrice() {
		return $this->costprice;
	}

	public function getSalePrice() {
		return $this->saleprice;
	}

	public function getStock() {
		return $this->stock;
	}

	public function getType() {
		return $this->type;
	}

	/**
	* SETTERS
	*/

	public function setId($id) {
		$this->id = $id;
	}

	public function setBrand($brand) {
		$this->brand = $brand;
	}

	public function setSize($size) {
		$this->size = $size;
	}

	public function setCostPrice($costprice) {
		$this->costprice = $costprice;
	}

	public function setSalePrice($saleprice) {
		$this->saleprice = $saleprice;
	}

	public function setStock($stock) {
		$this->stock = $stock;
	}

	public function setType($type) {
		$this->type = $type;
	}
}