<?php
class ProductsListView extends twig {
	public function show($products, $message=NULL) {
			echo self::getTwig()->render('productList.html' , array('products' => $products, 'message' => $message));
	}
}