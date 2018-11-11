<?php
class IndexView extends twig {
	public function show($message=NULL) {
			echo self::getTwig()->render('index.html' , array('message' => $message));
	}
}