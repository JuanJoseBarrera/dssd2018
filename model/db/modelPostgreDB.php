<?php

define("USERNAME_PG", "zimfeacffebqbm");
define("PASSWORD_PG", "ede9cc4d5b0d126ae147b1aa85022ab4178d4732a954952495022998a7ab973d");
define("HOST_PG", "ec2-75-101-138-26.compute-1.amazonaws.com");
define("DB_PG", "d7a8ie0qb7ithr");

abstract class ModelPostgreDB {
	protected $db;
	protected $table;

	private function createConnection() {
		$this->db = new PDO("pgsql:host=" . HOST_PG . ";dbname=".DB_PG, USERNAME_PG, PASSWORD_PG);
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