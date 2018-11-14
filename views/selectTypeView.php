<?php
class SelectTypeView extends twig {
	public function show($tipos, $message=NULL) {
			echo self::getTwig()->render('selectType.html' , array('tipos' => $tipos, 'message' => $message));
	}
}