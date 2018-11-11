<?php
class BackendManagerView extends twig {
	public function show($message=NULL) {
			echo self::getTwig()->render('manager.html' , array('message' => $message));
	}
}