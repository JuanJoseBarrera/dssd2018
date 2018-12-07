<?php
class ProductsListView extends twig {
	public function show($products, $employee, $message=NULL) {
			echo self::getTwig()->render('productList.html' , array('products' => $products, 'employee' => $employee, 'message' => $message));
	}
}