<?php

/** CONTROLADOR DEL USUARIO **/

require_once './vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Cookie\SessionCookieJar;
use GuzzleHttp\Cookie\CookieJar;

class UserController {

	private static $instance;

	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {}

	public function index($message=NULL) {
		$view = new BackendUserView();
		$view->show(NULL, $message);
	}

	public function elegirTipo() {
		$message = NULL;
		$tipos = ProductDB::getInstance()->getProductTypes();
		$view = new SelectTypeView();
		$view->show($tipos, $message);
	}

	public function listProducts() {
		$type = filter_input(INPUT_POST, "productType");
		$products = ProductDB::getInstance()->getProductsByType($type);
		$view = new ProductsListView();
		$view->show($products);
	}

	public function buyItem($id) {

		$dni = $_SESSION['dni']; //dni del usuario loguedo que realiza la compra de un producto

		$cookieJar = new SessionCookieJar('MiCookie', true);
		$client = new Client([
			// Base URI is used with relative requests
			'base_uri' => BONITA_BASE_URL,
			// You can set any number of default request options.
			'timeout'  => 2.0,
			'cookies'=>$cookieJar
		]);

		//se loguea en la api
		// Send a request to https://foo.com/api/test
		$response = $client->request('POST', 'loginservice',[
			'form_params' => [
				'username' => BONITA_USER,
				'password' => BONITA_PASS,
				'redirect' => 'false'
			]
		]);
		$code = $response->getStatusCode(); // 200
		$reason = $response->getReasonPhrase(); // OK

		/*
		echo "estado de login </br>";
		var_dump($code);
		*/

		//obtengo la cookie y me la quedo en una variable
		$token = $cookieJar->getCookieByName('X-Bonita-API-Token');
		//var_dump($token->getValue());

		// se obtiene un listado de procesos disponibles con su id
		$response = $client->request('GET', 'API/bpm/process?p=0&c=1000',
			['headers' => [
				'X-Bonita-API-Token' => $token->getValue() //se debe pasar la api de bonita en el header para que tenga efecto el request
			]]);
		$info =$response->getBody();
		/*
		echo "<br/>";
		echo "Listado de procesos disponibles </br>";
		echo ($info);  // muestra mensaje de advertencia de php pero no es error
		*/

		$processId = json_decode($info)[0]->id; //me guardo el id del proceso
		//echo $processId;

		$response = $client->request('POST', 'API/bpm/case',
			['json'=>[
				"processDefinitionId"=>$processId
			],
			'headers' =>[
				'X-Bonita-API-Token' => $token->getValue() //se debe pasar la api de bonita en el header para que tenga efecto el request
			]
		]);

		$info =$response->getBody();
		/*
		echo "<br/>";
		echo "caso creado </br>";
		echo ($info);
		*/

		$caseId = json_decode($info)->id;
		echo $caseId;

		$response = array();
		$request = $client->request('PUT', 'API/bpm/caseVariable/'.$caseId.'/dniUsuario',
			['headers' => [
				'X-Bonita-API-Token' => $token->getValue()
			],
			'json' => [
				'type' => 'java.lang.String',
				'value'=> $dni
			]
		]);
		$datos = $request->getBody();
		$response['success'] = true;
		$datos = $response['data'] = json_decode($datos);
		//echo $datos;

		$request = $client->request('PUT', 'API/bpm/caseVariable/'.$caseId.'/productoIngresado',
			['headers' => [
				'X-Bonita-API-Token' => $token->getValue()
			],
			'json' => [
				'type' => 'java.lang.String',
				'value'=> $id
			]
		]);
		$datos = $request->getBody();
		$response['success'] = true;
		$datos = $response['data'] = json_decode($datos);

		/*
		*/
		$tipos = ProductDB::getInstance()->getProductTypes();
		$view = new SelectTypeView();
		$view->show($tipos, "compra realizada");
	}

	/** Obtener el listado de productos por tipo de la api de bonita**/
	private function getProducts($type) {
		$curl = curl_init(BONITA_BASE_URL.$type);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$res = curl_exec($curl);
		$result = json_decode($res, true);
		return $result;
	}
}