<?php
/**
 * 
 */
class Coupon {

	private $id;
	private $number;
	private $used;
	private $release_date;
	private $discount;

	function __construct($id, $number, $used, $release_date, $discount) {
		$this->id = $id;
		$this->number = $number;
		$this->used = $used;
		$this->release_date = $release_date;
		$this->discount = $discount;
	}

	/**
	* GETTERS
	*/

	public function getId() {
		return $this->id;
	}

	public function getNumber() {
		return $this->number;
	}

	public function getUsed() {
		return $this->used;
	}

	public function getReleaseDate() {
		return $this->release_date;
	}

	public function getDiscount() {
		return $this->discount;
	}

	/**
	* SETTERS
	*/

	public function setId($id) {
		$this->id = $id;
	}

	public function setNumber($number) {
		return $this->number = $number;
	}

	public function setUsed($used) {
		return $this->used = $used;
	}

	public function setReleaseDate($release_date) {
		return $this->release_date = $release_date;
	}

	public function setDiscount($discount) {
		return $this->discount = $discount;
	}

}