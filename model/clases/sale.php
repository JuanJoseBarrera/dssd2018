<?php

class Sale {

	private $id;
	private $product;
	private $description;
	private $price;
	private $cant;
	private $dni;

	function __construct($id, $product, $description, $price, $cant, $dni) {
		$this->id = $id;
		$this->product = $product;
		$this->description = $description;
		$this->price = $price;
		$this->cant = $cant;
		$this->dni = $dni;
	}

	/**
	* GETTERS
	*/

	public function getId() {
		return $this->id;
	}

	public function getProduct() {
		return $this->product;
	}

	public function getDescription() {
		return $this->description;
	}

	public function getPrice() {
		return $this->price;
	}

	public function getCant() {
		return $this->cant;
	}

	public function getDni() {
		return $this->dni;
	}

	/**
	* SETTERS
	*/

	public function setId($id) {
		$this->id = $id;
	}

	public function setProduct($product) {
		$this->product = $product;
	}

	public function setDescription($description) {
		$this->description = $description;
	}

	public function setPrice($price) {
		$this->price = $price;
	}

	public function setCant($cant) {
		$this->cant = $cant;
	}

	public function setDni($dni) {
		$this->dni = $dni;
	}
}