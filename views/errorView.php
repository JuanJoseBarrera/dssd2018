<?php
class ErrorView extends Twig {
	public function show($message) {
		echo self::getTwig()->render('index.html' , array('nombre' => 'Backend', 'error' => $message));
	}
}