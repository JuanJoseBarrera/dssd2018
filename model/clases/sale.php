<?php

class Sale {

	private $id;
	private $item;
	private $price;
	private $cant;

	function __construct($id, $item, $price, $cant) {
		$this->id = $id;
		$this->item = $item;
		$this->price = $price;
		$this->cant = $cant;
	}
}