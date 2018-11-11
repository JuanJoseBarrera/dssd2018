<?php

class User {

	private $id;
	private $username;
	private $password;
	private $email;
	private $dni;
	private $rol;

	function __construct($id, $username, $password, $email, $dni, $rol) {
		$this->id = $id;
		$this->username = $username;
		$this->password = $password;
		$this->email = $email;
		$this->dni = $dni;
		$this->rol = $rol;
	}

	/**
	* GETTERS
	*/

	public function getId() {
		return $this->id;
	}

	public function getUsername() {
		return $this->username;
	}

	public function getPassword() {
		return $this->password;
	}

	public function getEmail() {
		return $this->email;
	}

	public function getDni() {
		return $this->dni;
	}

	public function getRol() {
		return $this->rol;
	}

	/**
	* SETTERS
	*/

	public function setId($id) {
		$this->id = $id;
	}

	public function setUsername($username) {
		$this->username = $username;
	}

	public function setPassword($password) {
		$this->password = $password;
	}

	public function setEmail($email) {
		$this->email = $email;
	}

	public function setDni($dni) {
		$this->dni = $dni;
	}

	public function setRol($rol) {
		$this->rol = $rol;
	}
}