<?php

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

/** CONFIGS **/
require_once './configs/configs.php';

/** CONTROLADORES **/
require_once './controllers/indexController.php';
require_once './controllers/loginController.php';
require_once './controllers/userController.php';
require_once './controllers/errorController.php';

/** CLASES MODELO**/
require_once './model/clases/coupon.php';
require_once './model/clases/employee.php';
require_once './model/clases/product.php';
require_once './model/clases/productType.php';
require_once './model/clases/user.php';
require_once './model/clases/sale.php';

/** MODELO CONSULTAS**/
require_once './model/db/modelDB.php';
require_once './model/db/modelPostgreDB.php';
require_once './model/db/couponDB.php';
require_once './model/db/employeeDB.php';
require_once './model/db/productDB.php';
require_once './model/db/userDB.php';
require_once './model/db/saleDB.php';

/** VISTAS **/
include_once './views/twig.php';
require_once './views/indexView.php';
require_once './views/loginView.php';
require_once './views/backendAdminView.php';
require_once './views/backendManagerView.php';
require_once './views/backendUserView.php';
require_once './views/productsListView.php';
require_once './views/quantityCouponView.php';
require_once './views/salesListView.php';
require_once './views/selectTypeView.php';
require_once './views/errorView.php';

session_start();
try {
	if (isset($_GET["action"]) && $_GET["action"] == 'login') {
		LoginController::getInstance()->login();
	}

	elseif (isset($_GET["action"]) && $_GET["action"] == 'logout') {
		LoginController::getInstance()->logout();
	}

	elseif (isset($_GET["action"]) && $_GET["action"] == 'validar') {
		LoginController::getInstance()->validar();
	}
	elseif (isset($_GET["action"]) && $_GET["action"] == 'indexUser' && (UserController::getInstance()->getPermisos())) {
		UserController::getInstance()->index();
	}

	elseif (isset($_GET["action"]) && ($_GET["action"] == 'elegirTipo') && (UserController::getInstance()->getPermisos())) {
		UserController::getInstance()->elegirTipo();
	}

	elseif (isset($_GET["action"]) && ($_GET["action"] == 'listProducts') && (UserController::getInstance()->getPermisos())) {
		UserController::getInstance()->listProducts();
	}
	elseif (isset($_GET["action"]) && ($_GET["action"] == 'selectQuantityAndCoupon') && (UserController::getInstance()->getPermisos())) {
		$id = filter_input(INPUT_GET, "productId");
		UserController::getInstance()->selectQuantityAndCoupon($id);
	}
	elseif (isset($_GET["action"]) && ($_GET["action"] == 'buyItem') && (UserController::getInstance()->getPermisos())) {
		$id = filter_input(INPUT_POST, "idProduct");
		$cant = filter_input(INPUT_POST, "cantidad");
		$cupon = filter_input(INPUT_POST, "cupon");
		UserController::getInstance()->buyItem($id, $cant, $cupon);
	}
	elseif (isset($_GET["action"]) && ($_GET["action"] == 'compras') && (UserController::getInstance()->getPermisos())) {
		UserController::getInstance()->compras();
	}
	else {
			IndexController::getInstance()->index();
	}
} catch (Exception $e) {
		if (isset($_SESSION['controller'])) {
			$controller = $_SESSION['controller'];
			//echo $controller;
			$controller::getInstance()->index("Ha ocurrido un error, vuelva a intentar en otro momento");
		} else {
	ErrorController::getInstance()->index("Ha ocurrido un error, vuelva a intentar en otro momento");
		}
}