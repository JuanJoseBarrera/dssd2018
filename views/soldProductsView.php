<?php
class SoldProductsView extends twig {
	public function show($message=NULL) {
			echo self::getTwig()->render('soldProducts.html' , array('message' => $message));
	}
}