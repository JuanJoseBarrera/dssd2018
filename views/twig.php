<?php

require_once './vendor/autoload.php';

abstract class Twig {

	private static $twig;

	public static function getTwig() {

		if (!isset(self::$twig)) {
			Twig_Autoloader::register();
			$templatesDir = __DIR__."/../templates/";
			$loader = new Twig_Loader_Filesystem($templatesDir);
			self::$twig = new Twig_Environment($loader);
		}
		return self::$twig;
	}

}