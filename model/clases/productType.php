<?php

/**
 * MODELO TIPO PRODUCTO
 */
class ProductType {

	private $id;
	private $initials;
	private $description;

	function __construct($id, $initials, $description) {
		$this->id = $id;
		$this->initials = $initials;
		$this->description = $description;
	}

	/**
	* GETTERS
	*/

	public function getId() {
		return $this->id;
	}

	public function getInitials() {
		return $this->initials;
	}

	public function getDescription() {
		return $this->description;
	}

	/**
	* SETTERS
	*/

	public function setId($id) {
		$this->id = $id;
	}

	public function setInitials($initials) {
		$this->initials = $initials;
	}

	public function setDescription($description) {
		$this->description = $description;
	}
}