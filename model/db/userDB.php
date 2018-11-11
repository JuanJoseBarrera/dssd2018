<?php

class UserDB extends ModelDB {
	private static $instance;

	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct() {}

	public function get($usuario, $password) {
		$mapper = function($row) {
			$resource = new User($row['id'], $row['username'], 'password', 'email', 'dni', $row['rol']);
			return $resource;
		};
		$query = "SELECT u.id, u.username, r.name AS rol FROM user u JOIN rol r ON (u.rol = r.id) WHERE u.username = ? AND u.password = ?";
		$answer = $this->queryList($query, [$usuario, $password], $mapper);
		return $answer[0];
	}
}