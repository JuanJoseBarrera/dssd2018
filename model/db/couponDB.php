<?php

/**
* MODELO EMPLEADO BASE DE DATOS
*/
class CouponDB extends ModelPostgreDB {

	private static $instance;

	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct() {}

	function existCoupon($number) {
		$mapper= function($row) {
			return $row['cant'];
		};
		$query = "SELECT COUNT(*) AS cant FROM coupon c WHERE c.number = ?";
		$answer = $this->queryList($query, [$number], $mapper);
		return $answer[0];
	}

	function getFullCoupon($number) {
		$mapper = function($row) {
			$coupon = new Coupon($row['id'], $row['number'], $row['used'], $row['release_date'], $row['discount']);
			return $coupon;
		};
		$query = "SELECT c.id, c.number, c.used, c.release_date, c.discount FROM coupon c WHERE c.number = ?";
		$answer = $this->queryList($query, [$number], $mapper);
		return $answer[0];
	}

	function getCoupons() {
		$mapper = function($row) {
			$coupon = new Coupon($row['id'], $row['number'], $row['used'], $row['release_date'], $row['discount']);
			return $coupon;
		};
		$query = "SELECT c.id, c.number, c.used, c.release_date, c.discount FROM coupon c";
		$answer = $this->queryList($query, [], $mapper);
		return $answer;
	}

	function getUsedCoupons() {
		$mapper = function($row) {
			$coupon = new Coupon($row['id'], $row['number'], $row['used'], $row['release_date'], $row['discount']);
			return $coupon;
		};
		$query = "SELECT c.id, c.number, c.used, c.release_date, c.discount FROM coupon c WHERE c.used = true";
		$answer = $this->queryList($query, [], $mapper);
		return $answer;
	}

	function getNotUsedCoupons() {
		$mapper = function($row) {
			$coupon = new Coupon($row['id'], $row['number'], $row['used'], $row['release_date'], $row['discount']);
			return $coupon;
		};
		$query = "SELECT c.id, c.number, c.used, c.release_date, c.discount FROM coupon c WHERE c.used = false";
		$answer = $this->queryList($query, [], $mapper);
		return $answer;
	}

	function getCouponsByDate($date) {
		$mapper = function($row) {
			$coupon = new Coupon($row['id'], $row['number'], $row['used'], $row['release_date'], $row['discount']);
			return $coupon;
		};
		$query = "SELECT c.id, c.number, c.used, c.release_date, c.discount FROM coupon c WHERE c.release_date = ?";
		$answer = $this->queryList($query, [$date], $mapper);
		return $answer;
	}

	function markCouponUsed($number) {
		$connection = $this->getConnection();
		$connection->beginTransaction();
		try {
			$query = "UPDATE coupon SET used = true WHERE 'number' = ?";
			$stmt = $connection->prepare($query);
			$params = array($number);
			$stmt->execute($params);

			return $connection->commit();
		} catch (Exception $e) {
			return $connection->rollBack();
		}
	}

	function save($coupon) {
		$connection = $this->getConnection();
		$connection->beginTransaction();
		try {
			$query = "INSERT INTO coupon ('number', used, release_date, discount) VALUES (?, ?, ?, ?)";
			$stmt = $connection->prepare($query);
			$params= array($coupon->getNumber(), $coupon->getused(), $coupon->getReleaseDate(), $coupon->getDiscount());
			$stmt->execute($params);
			return $connection->commit();
		} catch (PDOException $e) {
			$connection->rollBack();
		}
		return;
	}
}