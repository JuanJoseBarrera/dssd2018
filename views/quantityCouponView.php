<?php
class QuantityCouponView extends twig {
	public function show($id, $message=NULL) {
			echo self::getTwig()->render('cantidad_cupon.html' , array('idProduct' => $id, 'message' => $message));
	}
}