<?php

class Metric {

	public $id;
	public $idProduct;
	public $cantidad;
	public $fecha;
	public $cupon;
	public $cantEmp;
	public $cantNoEmp;

	function __construct($id, $idProduct, $cantidad, $fecha, $cupon, $cantEmp, $cantNoEmp) {
		$this->id = $id;
		$this->idProduct = $idProduct;
		$this->cantidad = $cantidad;
		$this->fecha = $fecha;
		$this->cupon = $cupon;
		$this->cantEmp = $cantEmp;
		$this->cantNoEmp = $cantNoEmp;
	}

	/**
	* GETTERS
	*/

	public function getId() {
		return $this->id;
	}

	public function getIdProduct() {
		return $this->idProduct;
	}

	public function getCantidad() {
		return $this->cantidad;
	}

	public function getFecha() {
		return $this->fecha;
	}

	public function getCupon() {
		return $this->fecha;
	}

	public function getCantEmp() {
		return $this->cantEmp;
	}

	public function getCantNoEmp() {
		return $this->cantNoEmp;
	}

	/**
	* SETTERS
	*/

	public function setId($id) {
		$this->id = $id;
	}

	public function setIdProduct($idProduct) {
		$this->idProduct = $idProduct;
	}

	public function setCantidad($cantidad) {
		$this->cantidad = $cantidad;
	}

	public function setFecha($fecha) {
		$this->fecha = $fecha;
	}

	public function setCupon($cupon) {
		$this->cupon = $cupon;
	}

	public function setCantEmp($cantEmp) {
		$this->cantEmp = $cantEmp;
	}

	public function setNoEmp($cantNoEmp) {
		$this->cantNoEmp = $cantNoEmp;
	}
}