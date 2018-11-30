<?php
class SalesListView extends twig {
	public function show($ventas, $message=NULL) {
			echo self::getTwig()->render('salesList.html' , array('ventas' => $ventas, 'message' => $message));
	}
}