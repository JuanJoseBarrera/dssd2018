<?php

/**
* MODELO EMPLEADO BASE DE DATOS
*/
class EmployeeDB extends ModelDB {

	private static $instance;

	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct() {}

	public function existEmployee($dni) {
		$mapper= function($row) {
			return $row['cant'];
		};
		$query = "SELECT COUNT(*) AS cant FROM employee e WHERE e.dni = ?";
		$answer = $this->queryList($query, [$dni], $mapper);
		return $answer[0];
	}

	public function getEmployees() {
		$mapper = function($row) {
			$resource = new Employee($row['id'], $row['dni'], $row['firstname'], $row['surname'], $row['email'], $row['password'], $row['type']);
			return $resource;
		};
		$query = "SELECT e.id, e.dni, e.firstname, e.surname, e.email, e.password, et.description as type FROM employee e JOIN employeetype et ON e.employeetype = et.id";
		$answer = $this->queryList($query, [], $mapper);
		return $answer;
	}

	public function getFullEmployee($dni) {
		$mapper = function($row) {
			$employee = new Employee($row['id'], $row['dni'], $row['firstname'], $row['surname'], $row['email'], $row['password'], $row['type']);
			return $employee;
		};
		$query = "SELECT e.id, e.dni, e.firstname, e.surname, e.email, e.password, t.description as type FROM employee e JOIN employeetype t ON e.employeetype = t.id WHERE e.dni = ?";
		$answer = $this->queryList($query, [$dni], $mapper);
		return $answer[0];
	}

	public function getEmployeesByType($type) {
		$mapper = function($row) {
			$resource = new Employee($row['id'], $row['dni'], $row['firstname'], $row['surname'], $row['email'], $row['password'], $row['type']);
			return $resource;
		};
		$query = "SELECT e.id, e.dni, e.firstname, e.surname, e.email, e.password, et.description as type FROM employee e JOIN employeetype et ON e.employeetype = et.id WHERE et.initials = ?";
		$answer = $this->queryList($query, [$type], $mapper);
		return $answer;
	}

	/**
	* Guarda un nuevo empleado
	*/
	public function save($employee) {
		$connection = $this->getConnection();
		$connection->beginTransaction();
		try {
			$query = "INSERT INTO employee (dni, firstname, surname, email, password, employeetype) VALUES (?, ?, ?, ?, ?, ?)";
			$stmt = $connection->prepare($query);
			$params= array($employee->getDni(), $employee->getFirstName(), $employee->getSurName(), $employee->getEmail(), $employee->getPassword(), $employee->getType());
			$stmt->execute($params);
			return $connection->commit();
		} catch (PDOException $e) {
			$connection->rollBack();
		}
		return;
	}

	/**
	* Actualiza datos de un empleado
	*/
	public function update($employee) {
		$connection = $this->getConnection();
		$connection->beginTransaction();
		try {
			$query = "UPDATE employee SET dni = ?, firstname = ?, surname = ?, email = ?, password = ?, employeetype = ? WHERE id = ?";
			$stmt = $connection->prepare($query);
			$params = array($employee->getDni(), $employee->getFirstName(), $employee->getSurName(), $employee->getEmail(), $employee->getPassword(), $employee->getType(), $employee->getId());
			$stmt->execute($params);

			return $connection->commit();
		} catch (Exception $e) {
			return $connection->rollBack();
		}
	}

	/**
	* Elimina logicamente un empleado
	*/
	public function delete() {}
}