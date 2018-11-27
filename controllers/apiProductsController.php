<?php

require '../vendor/autoload.php';
require '../model/clases/product.php';
require '../model/db/modelDB.php';
require '../model/db/productDB.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
$config = [
	'settings' => [
		'displayErrorDetails' => true,
	],
];

$app = new \Slim\App($config);

$app->get('/',  function ($request, $response, $args) {
	$response->withStatus(200);
	$body = $response->getBody();
	$body->write('<html><body><h1>Slim API</h1></body></html>');
	$response->withHeader('Content-Type', 'text/html');
	return $response;
});

/**
* obtiene el listado de empleados
*/
$app->get('/products', function ($request, $response, $args) {
	$products = ProductDB::getInstance()->getProducts();
	$prods = array();
	if (count($products) > 0) {
		foreach ($products as $product) {
			$prods[] = object_encode($product);
		}
		return $response->withJson($prods, 200);
	} else {
		return $response->withJson(array("No hay productos cargados"));
	}
});

/**
* A partir del id obtiene los datos de un producto
*/
$app->get('/products/{id}', function ($request, $response, $args) {
	$id = $args['id'];
	$product = ProductDB::getInstance()->getFullProduct($id);
	if (count($product > 0)) {
		return $response->withJson(object_encode($product[0]), 200);
	} else {
		return $response->withJson(array("No existe un producto con el id ingresado"));
	}
});

/**
* Obtiene un listado de empleados de acuerdo a su tipo
*/
$app->get('/productsByType/{type}', function ($request, $response, $args) {
	$type = $args['type'];
	$products = ProductDB::getInstance()->getProductsByType($type);
	$prods =array();
	if (count($products >0)) {
		foreach ($products as $product) {
			$prods[] = object_encode($product);
		}
		return $response->withJson($prods, 200);
	} else {
		return $response->withJson(array("No hay productos para el tipo ingresado"));
	}
});

/**
*Obtiene el precio de costo de un producto
*/
$app->get('/productPrice/{id}', function ($request, $response, $args) {
	$id = $args['id'];
	$product = ProductDB::getInstance()->getFullProduct($id);
	if (count($product > 0)) {
		$result= array('price'=>$product[0]->getCostPrice());
		return $response->withJson($result, 200);
	} else {
		return $response->withJson(array("No existe un producto con el id ingresado"));
	}
});

/**
*Obtiene el precio de costo de un producto
*/
$app->get('/productSalePrice/{id}', function ($request, $response, $args) {
	$id = $args['id'];
	$product = ProductDB::getInstance()->getFullProduct($id);
	if (count($product > 0)) {
		return $response->withJson($product[0]->getSalePrice(), 200);
	} else {
		return $response->withJson(array("No existe un producto con el id ingresado"));
	}
});

/**
* convierte un object en un array asociativo
*/
function object_encode($product) {
	return array('id' => $product->getId(), 'brand' => $product->getBrand(),'size' => $product->getSize(), 'costprice' => $product->getCostPrice(), 'saleprice' => $product->getSalePrice(), 'stock' => $product->getStock(), 'type' => $product->getType());
}

$app->run();