<?php

class Item {

	private $id;
	private $description;
	private $price;
	private $cant;

	function __construct($id, $description, $price, $cant) {
		$this->id = $id;
		$this->description = $description;
		$this->price = $price;
		$this->cant = $cant;
	}
}