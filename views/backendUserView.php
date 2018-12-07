<?php
class BackendUserView extends twig {
	public function show($products=NULL, $employee, $message=NULL, $error=NULL) {
			echo self::getTwig()->render('user.html' , array('products' => $products, 'employee' => $employee, 'message' => $message, 'error' => $error));
	}
}