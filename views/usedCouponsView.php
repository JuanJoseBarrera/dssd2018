<?php
class UsedCouponsView extends twig {
	public function show($message=NULL) {
			echo self::getTwig()->render('usedCoupons.html' , array('message' => $message));
	}
}