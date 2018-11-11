<?php
class BackendAdminView extends twig {
	public function show($message=NULL) {
			echo self::getTwig()->render('administrador.html' , array('message' => $message));
	}
}