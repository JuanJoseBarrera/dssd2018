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

/** CLASES MODELO**/
require_once './model/clases/coupon.php';
require_once './model/clases/employee.php';
require_once './model/clases/product.php';
require_once './model/clases/productType.php';
require_once './model/clases/user.php';

/** MODELO CONSULTAS**/
require_once './model/db/modelDB.php';
require_once './model/db/modelPostgreDB.php';
require_once './model/db/couponDB.php';
require_once './model/db/employeeDB.php';
require_once './model/db/productDB.php';
require_once './model/db/userDB.php';

/** VISTAS **/
include_once './views/twig.php';
require_once './views/indexView.php';
require_once './views/loginView.php';
require_once './views/backendAdminView.php';
require_once './views/backendManagerView.php';
require_once './views/backendUserView.php';
require_once './views/selectTypeView.php';


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
	elseif (isset($_GET["action"]) && $_GET["action"] == 'indexUser') {
		UserController::getInstance()->index();
	}

	elseif (isset($_GET["action"]) && ($_GET["action"] == 'elegirTipo')) {
		UserController::getInstance()->elegirTipo();
	}

/*
	elseif (isset($_GET["action"]) && ($_GET["action"] == 'AltaPaciente') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "paciente_new"))) {
		PacienteController::getInstance()->AltaPaciente();
	}

	elseif (isset($_GET['action']) && ($_GET['action'] =='PacienteList') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "paciente_index"))) {
		PacienteController::getInstance()->pacienteList();
	}

	elseif (isset($_GET["action"]) && ($_GET["action"] == 'PacienteEdit') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "paciente_update"))) {
		PacienteController::getInstance()->PacienteEdit();
	}

	elseif (isset($_GET["action"]) && ($_GET["action"] == 'ModificarPaciente') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "paciente_update"))) {
		PacienteController::getInstance()->ModificarPaciente();
	}

	elseif (isset($_GET['action']) && ($_GET['action'] =='pacienteSearch') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "paciente_index"))) {
		PacienteController::getInstance()->pacienteSearch();
	}

	elseif (isset($_GET["action"]) && ($_GET["action"] == 'DeletePaciente') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "paciente_destroy"))) {
		PacienteController::getInstance()->DeletePaciente();
	}

	elseif (isset($_GET["action"]) && ($_GET["action"] == 'DemograficoLoad') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "demograficos_new"))) {
		DemograficoController::getInstance()->DemograficoLoad();
	}

	elseif (isset($_GET["action"]) && ($_GET["action"] == 'AltaDemografico')  && (PermisosController::getInstance()->isGranted($_SESSION['id'], "demograficos_new"))) {
		DemograficoController::getInstance()->AltaDemografico();
	}

	elseif (isset($_GET["action"]) && ($_GET["action"] == 'DemograficoEdit') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "demograficos_update"))) {
		DemograficoController::getInstance()->DemograficoEdit();
	}

	elseif (isset($_GET["action"]) && ($_GET["action"] == 'ModificarDemografico') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "demograficos_update"))) {
		DemograficoController::getInstance()->AltaDemografico();
	}

	elseif (isset($_GET["action"]) && ($_GET["action"] == 'DemograficoShow') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "demograficos_show"))) {
		DemograficoController::getInstance()->DemograficoShow();
	}

	elseif (isset($_GET["action"]) && ($_GET["action"] == 'DemograficoDelete') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "demograficos_destroy"))) {
		DemograficoController::getInstance()->DemograficoDelete();
	}

	elseif (isset($_GET['action']) && ($_GET['action'] == 'UsuarioLoad') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "usuario_new"))) {
		UsuarioController::getInstance()->newUserForm();
	}

	elseif (isset($_GET['action']) && ($_GET['action'] == 'saveUser') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "usuario_new"))) {
		UsuarioController::getInstance()->saveUser();
	}

	elseif (isset($_GET['action']) && ($_GET['action'] =='UsuarioList') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "usuario_index"))) {
		UsuarioController::getInstance()->listUsers();
	}

	elseif (isset($_GET['action']) && ($_GET['action'] =='userSearch') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "usuario_index"))) {
		UsuarioController::getInstance()->userSearch();
	}

	elseif (isset($_GET['action']) && ($_GET['action'] == 'disableUser') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "usuario_update"))) {
		UsuarioController::getInstance()->disableUser();
	}

	elseif (isset($_GET['action']) && ($_GET['action'] == 'enableUser') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "usuario_update"))) {
		UsuarioController::getInstance()->enableUser();
	}

	elseif (isset($_GET['action']) && ($_GET['action'] == 'editUser') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "usuario_update"))) {
		UsuarioController::getInstance()->editUser();
	}

	elseif (isset($_GET['action']) && ($_GET['action'] == 'updateUser') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "usuario_update"))) {
		UsuarioController::getInstance()->updateUser();
	}

	elseif (isset($_GET['action']) && ($_GET['action'] == 'deleteUser') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "usuario_destroy"))) {
		UsuarioController::getInstance()->deleteUser();
	}

	elseif (isset($_GET['action']) && ($_GET['action'] == 'configNew') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "config_new"))) {
		ConfiguracionController::getInstance()->configNew();
	}

	elseif (isset($_GET['action']) && ($_GET['action'] == 'saveConfig') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "config_new"))) {
		ConfiguracionController::getInstance()->saveConfig();
	}

	elseif (isset($_GET['action']) && ($_GET['action'] == 'modificarConfig') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "config_update"))) {
		ConfiguracionController::getInstance()->modificarConfig();
	}

	elseif (isset($_GET['action']) && ($_GET['action'] == 'updateConfig') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "config_update"))) {
		ConfiguracionController::getInstance()->updateConfig();
	}
	elseif (isset($_GET["action"]) && ($_GET["action"] == 'DemograficoShow') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "demograficos_show"))) {
		DemograficoController::getInstance()->DemograficoShow();
	}

	elseif (isset($_GET['action']) && ($_GET['action'] =='DemograficoList') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "demograficos_index"))) {
		DemograficoController::getInstance()->DemograficoList();
	}

	elseif (isset($_GET['action']) && ($_GET['action'] == 'historiaClinicaList') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "hist_clinica_index"))) {
		ClinicaController::getInstance()->historiaClinicaList();
	}

	elseif ((isset($_GET['action']) && ($_GET['action']) == 'clinicaForm')  && (PermisosController::getInstance()->isGranted($_SESSION['id'], "hist_clinica_new"))) {
		ClinicaController::getInstance()->historyForm();
	}

	elseif ((isset($_GET['action']) && ($_GET['action']) == 'saveHistory') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "hist_clinica_new"))) {
		ClinicaController::getInstance()->saveHistory();
	}

	elseif ((isset($_GET['action']) && ($_GET['action']) == 'clinicaEdit') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "hist_clinica_update"))) {
		ClinicaController::getInstance()->clinicaLoad();
	}

	elseif ((isset($_GET['action']) && ($_GET['action']) == 'clinicaShow') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "hist_clinica_index"))) {
		ClinicaController::getInstance()->clinicaList();
	}

	elseif (isset($_GET['action']) && ($_GET['action'] == 'weightGraph') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "hist_clinica_show"))) {
		ClinicaController::getInstance()->weightGraph();
	}

	elseif (isset($_GET['action']) && ($_GET['action'] == 'getGrowth') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "hist_clinica_show"))) {
		ClinicaController::getInstance()->getGrowth();
	}

	elseif (isset($_GET['action']) && ($_GET['action'] == 'sizeGraph') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "hist_clinica_show"))) {
		ClinicaController::getInstance()->sizeGraph();
	}

	elseif (isset($_GET['action']) && ($_GET['action'] == 'getSize') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "hist_clinica_show"))) {
		ClinicaController::getInstance()->getSize();
	}

	elseif (isset($_GET['action']) && ($_GET['action'] == 'ppcGraph') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "hist_clinica_show"))) {
		ClinicaController::getInstance()->ppcGraph();
	}

	elseif (isset($_GET['action']) && ($_GET['action'] == 'getPpc') && (PermisosController::getInstance()->isGranted($_SESSION['id'], "hist_clinica_show"))) {
		ClinicaController::getInstance()->getPpc();
	}

	elseif (isset($_GET['action']) && ($_GET['action'] == 'editHistory') && (PermisosController::getInstance()->isGranted($_SESSION['id'], 'hist_clinica_update'))) {
		ClinicaController::getInstance()->editHistory();
	}

	elseif (isset($_GET['action']) && ($_GET['action'] == 'updateHistory') && (PermisosController::getInstance()->isGranted($_SESSION['id'], 'hist_clinica_update'))) {
		ClinicaController::getInstance()->updateHistory();
	}

	elseif (isset($_GET['action']) && ($_GET['action'] == 'deleteHistory') && (PermisosController::getInstance()->isGranted($_SESSION['id'], 'hist_clinica_destroy'))) {
		ClinicaController::getInstance()->deleteHistory();
	}

	elseif (isset($_GET['action']) && ($_GET['action'] == 'demograficoGraph') && (PermisosController::getInstance()->isGranted($_SESSION['id'], 'demograficos_show'))) {
		DemograficoController::getInstance()->demograficoGraph();
	}

	elseif (isset($_GET['action']) && ($_GET['action'] == 'getGraphData') && (PermisosController::getInstance()->isGranted($_SESSION['id'], 'demograficos_show'))) {
		DemograficoController::getInstance()->getGraphData();
	}

	elseif (isset($_GET['action']) && ($_GET['action'] == 'turnosForm') && (PermisosController::getInstance()->isGranted($_SESSION['id'], 'fecha_new'))) {
		TurnosController::getInstance()->turnosForm();
	}

	elseif (isset($_GET['action']) && ($_GET['action'] == 'saveTurno') && (PermisosController::getInstance()->isGranted($_SESSION['id'], 'fecha_new'))) {
		TurnosController::getInstance()->save();
	}
*/
	else {
		IndexController::getInstance()->index();
	}
} catch (Exception $e) {
	ErrorController::getInstance()->index("Ha ocurrido un error, vuelva a intentar en otro momento");
}