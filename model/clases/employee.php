<?php

/**
* MODELO EMPLEADO
*/
class Employee {

	private $id;
	private $dni;
	private $firstname;
	private $surname;
	private $email;
	private $password;
	private $type;
	
	function __construct($id, $dni, $firstname, $surname, $email, $password, $type) {
		$this->id = $id;
		$this->dni = $dni;
		$this->firstname = $firstname;
		$this->surname = $surname;
		$this->email = $email;
		$this->password = $password;
		$this->type = $type;
	}

	/**
	* GETTERS
	*/

	public function getId() {
		return $this->id;
	}

	public function getDni() {
		return $this->dni;
	}

	public function getFirstName() {
		return $this->firstname;
	}

	public function getSurName() {
		return $this->surname;
	}

	public function getEmail() {
		return $this->email;
	}

	public function getPassword() {
		return $this->password;
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

	public function setDni($dni) {
		$this->dni = $dni;
	}

	public function setFirstName($firstname) {
		$this->firstname = $firstname;
	}

	public function setSurName($surname) {
		$this->surname = $surname;
	}

	public function setEmail($email) {
		$this->email = $email;
	}

	public function setPassword($password) {
		$this->password = $password;
	}

	public function setType($type) {
		$this->type = $type;
	}
}