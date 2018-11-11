<?php
class LoginView extends twig {
	public function show($message=NULL) {
			echo self::getTwig()->render('login.html' , array('message' => $message));
	}
}