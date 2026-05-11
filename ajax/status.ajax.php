<?php

// ** INICIO: VERIFICACIÓN DE SESIÓN Y SEGURIDAD **
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["iniciarSesion"]) || $_SESSION["iniciarSesion"] != "ok") {
    header('HTTP/1.1 401 Unauthorized');
    echo json_encode(["error" => "Acceso no autorizado"]);
    exit();
}
header('Content-Type: application/json');
// ** FIN **

require_once "../controladores/status.controlador.php";
require_once "../modelos/status.modelo.php";

class AjaxStatus{

	/* Editar */

	public $idStatus;

	public function ajaxEditarStatus(){

		$item = "id";
		$valor = $this->idStatus;

		$respuesta = ControladorStatus::ctrMostrarStatus($item, $valor);

		echo json_encode($respuesta);

	}

	/* Actualizar */

	public $activarStatus;
	public $activarId;


	public function ajaxActivarStatus(){

		$tabla = "status";

		$item1 = "estado";
		$valor1 = $this->activarStatus;

		$item2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloStatus::mdlActualizarStatus($tabla, $item1, $valor1, $item2, $valor2);

		 echo json_encode(["status" => $respuesta]);

	}

	/* Validar no repetir status */

	public $validarStatus;

	public function ajaxValidarStatus(){

		$item = "status";
		$valor = $this->validarStatus;

		$respuesta = ControladorStatus::ctrMostrarStatus($item, $valor);

		echo json_encode($respuesta);

	}
}

/* Editar */

if(isset($_POST["idStatus"])){

	$editar = new AjaxStatus();
	$editar -> idStatus = $_POST["idStatus"];
	$editar -> ajaxEditarStatus();

}

/* Activar Status */

if(isset($_POST["activarStatus"])){

	$activarStatus = new AjaxStatus();
	$activarStatus -> activarStatus = $_POST["activarStatus"];
	$activarStatus -> activarId = $_POST["activarId"];
	$activarStatus -> ajaxActivarStatus();

}

/* Validar no repetir Status */

if(isset( $_POST["validarStatus"])){

	$valStatus = new AjaxStatus();
	$valStatus -> validarStatus = $_POST["validarStatus"];
	$valStatus -> ajaxValidarStatus();

}