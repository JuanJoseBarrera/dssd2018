<?php
require '../vendor/autoload.php';

require '../model/clases/employee.php';

require '../model/db/modelDB.php';
require '../model/db/employeeDB.php';

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

/**
* obtiene el listado de empleados
*/
$app->get('/employees', function ($request, $response, $args) {
	$employees = EmployeeDB::getInstance()->getEmployees();
	$emps = array();
	if (count($employees) > 0) {
		foreach ($employees as $employee) {
			$emps[] = object_encode($employee);
		}
		return $response->withJson($emps, 200);
	} else {
		return $response->withJson(array("No hay empleados cargados"));
	}
});

/**
* A partir del dni obtiene los datos de un empleado
*/
$app->get('/employees/{dni}', function ($request, $response, $args) {
	$dni = $args['dni'];
	$employee = EmployeeDB::getInstance()->getFullEmployee($dni);
	if ($employee) {
		return $response->withJson(object_encode($employee), 200);
	} else {
		return $response->withJson(NULL);
	}
});
/**
* Obtiene un listado de empleados de acuerdo a su tipo
*/
$app->get('/employeesByType/{type}', function ($request, $response, $args) {
	$type = $args['type'];
	$employees = EmployeeDB::getInstance()->getEmployeesByType($type);
	$emps = array();
	if (count($employees) > 0) {
		foreach ($employees as $employee) {
			$emps[] = object_encode($employee);
		}
		return $response->withJson($emps, 200);
	} else {
		return $response->withJson(array("No hay empleados cargados"));
	}
});

$app->post('/employees/{dni}/name/{name}/lastname/{lastname}/email/{email}/password/{password}/type/{type}', function ($request, $response) {
	$data = $request->getParsedBody();
	$dni = $data['dni'];

	$employee = new Employee('xx', $data['dni'], $data['name'], $data['lastname'], $data['email'], $data['password'], $data['type']);

	try {
		$employeeDB = EmployeeDB::getInstance();

		$count = $employeeDB->existEmployee($dni);

		$result = false;

		if ($count == 0) {
			$result = $employeeDB->save($employee);
		}

		$response->withStatus(200);
		$body = $response->getBody();
		$response->withHeader('Content-Type', 'text/plain');

		if($result) {
			$body->write("El empleado con documento $dni fue ingresado con exito!!!");
		}else {
			$body->write("Ya existe un empleado con documento $dni");
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
function object_encode($employee) {
	return array('id' => $employee->getId(), 'dni' => $employee->getDni(), 'firstname' => $employee->getFirstName(), 'surname' => $employee->getSurName(), 'email' => $employee->getEmail(), 'password' => $employee->getPassword(), 'type' => $employee->getType());
}
$app->run();