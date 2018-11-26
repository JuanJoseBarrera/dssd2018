<?php
class BackendUserView extends twig {
	public function show($message=NULL, $error=NULL) {
			echo self::getTwig()->render('user.html' , array('message' => $message, 'error' => $error));
	}
}