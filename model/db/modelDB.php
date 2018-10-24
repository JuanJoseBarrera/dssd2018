<?php

define("USERNAME", "root");
define("PASSWORD", "Juan1709");
define("HOST", "localhost");
define("DB", "dssd2018");

abstract class ModelDB {
	protected $db;
	protected $table;

	private function createConnection() {
		$this->db = new PDO("mysql:host=" . HOST . ";dbname=dssd2018", USERNAME, PASSWORD);
	}

	private function disconnect() {
		$this->db = null;
	}

	public function findAll() {
		$query = $this->db->prepare("SELECT * FROM $this->table Where activo=1");
		$query->execute();
		$resu=$query->fetchAll();
		return $resu;
	}

	public function find_id($id) {
		$query = $this->db->prepare("SELECT * FROM $this->table WHERE id = :id");
		$query->bindValue(":id", $id);
		$query->execute();
		if($query->rowCount() == 0) {
			return null;
		} else {
			return $query->fetch(PDO::FETCH_OBJ);
		}
	}

	protected function getConnection() {
		$this->createConnection();
		return $this->db;
	}

	protected function queryList($sql, $args, $mapper) {
		$connection = $this->getConnection();
		$stmt = $connection->prepare($sql);
		$stmt->execute($args);
		$list = [];
		while($element = $stmt->fetch()) {
			$list[] = $mapper($element);
		}
		$this->disconnect();
		return $list;
	}
}