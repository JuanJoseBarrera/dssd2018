<?php
class QuantityCouponView extends twig {
	public function show($id, $employee, $message=NULL) {
			echo self::getTwig()->render('cantidad_cupon.html' , array('idProduct' => $id, 'employee' => $employee, 'message' => $message));
	}
}