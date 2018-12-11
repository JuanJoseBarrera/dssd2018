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

	public function getPermisos() {
		if (isset($_SESSION['rol'])) {
			$rol = $_SESSION['rol'];
			return (!strcmp($rol, 'Cliente'));
		} else {
			return false;
		}
	}

	public function index($message=NULL) {
		$products = ProductDB::getInstance()->getProducts();
		$employee = $_SESSION['employee'];
		$view = new BackendUserView();
		$view->show($products, $employee, NULL, $message);
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
		$employee = $_SESSION['employee'];
		$view = new ProductsListView();
		$view->show($products, $employee);
	}

	public function selectQuantityAndCoupon($idProduct) {
		$employee = $_SESSION['employee'];
		$view = new QuantityCouponView();
		$view->show($idProduct, $employee);
	}


	public function buyItem($id, $cant, $cupon) {

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

		//obtengo la cookie y me la quedo en una variable
		$token = $cookieJar->getCookieByName('X-Bonita-API-Token');
		//var_dump($token->getValue());

		// se obtiene un listado de procesos disponibles con su id
		$response = $client->request('GET', 'API/bpm/process?p=0&c=1000',
			['headers' => [
				'X-Bonita-API-Token' => $token->getValue() //se debe pasar la api de bonita en el header para que tenga efecto el request
			]]);
		$info =$response->getBody();

		$processId = json_decode($info)[0]->id; //me guardo el id del proceso

		$response = $client->request('POST', 'API/bpm/case',
			['json'=>[
				"processDefinitionId"=>$processId
			],
			'headers' =>[
				'X-Bonita-API-Token' => $token->getValue() //se debe pasar la api de bonita en el header para que tenga efecto el request
			]
		]);

		$info =$response->getBody();

		$caseId = json_decode($info)->id;
		//echo $caseId;

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

		$request = $client->request('PUT', 'API/bpm/caseVariable/'.$caseId.'/cantidad',
			['headers' => [
				'X-Bonita-API-Token' => $token->getValue()
			],
			'json' => [
				'type' => 'java.lang.Integer',
				'value'=> $cant
			]
		]);
		$datos = $request->getBody();
		$response['success'] = true;
		$datos = $response['data'] = json_decode($datos);

		$request = $client->request('PUT', 'API/bpm/caseVariable/'.$caseId.'/cupon',
			['headers' => [
				'X-Bonita-API-Token' => $token->getValue()
			],
			'json' => [
				'type' => 'java.lang.Integer',
				'value'=> $cupon
			]
		]);
		$datos = $request->getBody();
		$response['success'] = true;
		$datos = $response['data'] = json_decode($datos);

		$tipos = ProductDB::getInstance()->getProductTypes();
		$view = new SelectTypeView();
		$view->show($tipos, "compra realizada");
	}

	public function compras() {
		$dni = $_SESSION['dni'];
		$sales = SaleDB::getInstance()->getSales($dni);
		$view = new SaleslistView();
		$view->show($sales);
	}
}