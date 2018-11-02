<?php
require '../vendor/autoload.php';

require '../model/clases/coupon.php';

require '../model/db/modelPostgreDB.php';
require '../model/db/couponDB.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$config = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$app = new \Slim\App($config);

$app->get('/', function ($request, $response, $args) {
	$response->withStatus(200);
	$body = $response->getBody();
	$body->write('<html><body><h1>Slim API</h1></body></html>');
	$response->withHeader('Content-Type', 'text/html');
	return $response;
});

/* listado de cupones */
$app->get('/coupon', function($request, $response, $args) {
	$coupons = CouponDB::getInstance()->getCoupons();
	$co = array();
	if (count($coupons) > 0) {
		foreach ($coupons as $coupon) {
			$co[] = object_encode($coupon);
		}
		return $response->withJson($co, 200);
	} else {
		return $response->withJson(array("No hay cupones cargados"));
	}
});

/* ver datos del cupon */
$app->get('/coupon/{number}', function($request, $response, $args) {
	$number = $args['number'];
	$coupon = CouponDB::getInstance()->getFullCoupon($number);
	if ($coupon) {
		return $response->withJson(object_encode($coupon), 200);
	} else {
		return $response->withJson(array("No existe un cupon con el numero ingresado"));
	}
});

/* listado de cupones usados */
$app->get ('/usedCoupon', function($request, $response, $args) {
	$coupons = CouponDB::getInstance()->getUsedCoupons();
	$co = array();
	if (count($coupons) > 0) {
		foreach ($coupons as $coupon) {
			$co[] = object_encode($coupon);
		}
		return $response->withJson($co, 200);
	} else {
		return $response->withJson(array("No hay cupones cargados"));
	}
});

/* listado de cupones sin usar*/
$app->get ('/notUsedCoupon', function($request, $response, $args) {
	$coupons = CouponDB::getInstance()->getNotUsedCoupons();
	$co = array();
	if (count($coupons) > 0) {
		foreach ($coupons as $coupon) {
			$co[] = object_encode($coupon);
		}
		return $response->withJson($co, 200);
	} else {
		return $response->withJson(array("No hay cupones cargados"));
	}
});

/* listado de cupones para una fecha */
$app->get('/couponsByDate/{date}', function($request, $response, $args) {
	$date = $args['date'];
	$coupons = CouponDB::getInstance()->getCouponsByDate($date);
	$co = array();
	if (count($coupons) > 0) {
		foreach ($coupons as $coupon) {
			$co[] = object_encode($coupon);
		}
		return $response->withJson($co, 200);
	} else {
		return $response->withJson(array("No hay cupones cargados"));
	}
});

/* aplicar cupon, marcar usado*/
$app->put('/coupon/{number}', function($request, $response, $args) {
	$number = $args['number'];
	$coupon = CouponDB::getInstance()->markCouponUsed($number);
	if ($coupon) {
		return $response->withJson("El cupon con numero $number fue utilizado con exito!!!");
	} else {
		return $response->withJson(array("No se puede utilizar el cupon con el numero $number"));
	}
});

/* creacion de un cupon*/
$app->post('/coupon', function($request, $response, $args) {
	$data = $request->getParsedBody();
	$number = $data['number'];
echo $number;
	$coupon = new Coupon('xx', $data['number'], $data['used'], $data['release_date'], $data['discount']);
	try {
		$couponDB = CouponDB::getInstance();

		$count = $couponDB->existCoupon($coupon->getNumber());

		$result = false;

		if ($count == 0) {
			$result = $couponDB->save($coupon);
		}

		$response->withStatus(200);
		$body = $response->getBody();
		$response->withHeader('Content-Type', 'text/plain');

		if($result) {
			$body->write("El cupon con numero $number fue ingresado con exito!!!");
		}else {
			$body->write("Ya existe un cupon con number $number");
		}
	} catch(\Exception $e) {
		var_dump($e->getMessage());

		$response->withStatus(500);
		$body = $response->getBody();
		$body->write("Error al insertar!!!");
		$response->withHeader('Content-Type', 'text/plain');
	}
	return $response;
});

/**
* convierte un object en un array asociativo
*/
function object_encode($coupon) {
	return array('id' => $coupon->getId(), 'number' => $coupon->getNumber(), 'used' => $coupon->getUsed(), 'release_date' => $coupon->getReleaseDate(), 'discount' => $coupon->getDiscount());
}
$app->run();