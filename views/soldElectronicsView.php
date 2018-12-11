<?php
class SoldElectronicsView extends twig {
	public function show($message=NULL) {
			echo self::getTwig()->render('soldElectronics.html' , array('message' => $message));
	}
}