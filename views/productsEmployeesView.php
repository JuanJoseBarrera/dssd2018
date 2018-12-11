<?php
class ProductsEmployeesView extends twig {
	public function show($message=NULL) {
			echo self::getTwig()->render('productsEmployees.html' , array('message' => $message));
	}
}