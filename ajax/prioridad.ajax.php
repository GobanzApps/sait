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

require_once "../controladores/prioridad.controlador.php";
require_once "../modelos/prioridad.modelo.php";

class AjaxPrioridad{

	/* Editar */

	public $idPrioridad;

	public function ajaxEditarPrioridad(){

		$item = "id";
		$valor = $this->idPrioridad;

		$respuesta = ControladorPrioridad::ctrMostrarPrioridad($item, $valor);

		echo json_encode($respuesta);

	}

	/* Actualizar */

	public $activarPrioridad;
	public $activarId;


	public function ajaxActivarPrioridad(){

		$tabla = "prioridad";

		$item1 = "estado";
		$valor1 = $this->activarPrioridad;

		$item2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloPrioridad::mdlActualizarPrioridad($tabla, $item1, $valor1, $item2, $valor2);

		 echo json_encode(["status" => $respuesta]);

	}

	/* Validar no repetir prioridad */

	public $validarPrioridad;

	public function ajaxValidarPrioridad(){

		$item = "prioridad";
		$valor = $this->validarPrioridad;

		$respuesta = ControladorPrioridad::ctrMostrarPrioridad($item, $valor);

		echo json_encode($respuesta);

	}
}

/* Editar */

if(isset($_POST["idPrioridad"])){

	$editar = new AjaxPrioridad();
	$editar -> idPrioridad = $_POST["idPrioridad"];
	$editar -> ajaxEditarPrioridad();

}

/* Activar Prioridad */

if(isset($_POST["activarPrioridad"])){

	$activarPrioridad = new AjaxPrioridad();
	$activarPrioridad -> activarPrioridad = $_POST["activarPrioridad"];
	$activarPrioridad -> activarId = $_POST["activarId"];
	$activarPrioridad -> ajaxActivarPrioridad();

}

/* Validar no repetir Prioridad */

if(isset( $_POST["validarPrioridad"])){

	$valPrioridad = new AjaxPrioridad();
	$valPrioridad -> validarPrioridad = $_POST["validarPrioridad"];
	$valPrioridad -> ajaxValidarPrioridad();

}