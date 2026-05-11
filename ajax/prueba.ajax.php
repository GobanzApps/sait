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

require_once "../controladores/prueba.controlador.php";
require_once "../modelos/prueba.modelo.php";

class AjaxPrueba{

	/* Editar */

	public $idPrueba;

	public function ajaxEditarPrueba(){

		$item = "id";
		$valor = $this->idPrueba;

		$respuesta = ControladorPrueba::ctrMostrarPrueba($item, $valor);

		echo json_encode($respuesta);

	}

	/* Actualizar */

	public $activarPrueba;
	public $activarId;


	public function ajaxActivarPrueba(){

		$tabla = "prueba";

		$item1 = "estado";
		$valor1 = $this->activarPrueba;

		$item2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloPrueba::mdlActualizarPrueba($tabla, $item1, $valor1, $item2, $valor2);

		 echo json_encode(["status" => $respuesta]);

	}

	/* Validar no repetir prueba */

	public $validarPrueba;

	public function ajaxValidarPrueba(){

		$item = "prueba";
		$valor = $this->validarPrueba;

		$respuesta = ControladorPrueba::ctrMostrarPrueba($item, $valor);

		echo json_encode($respuesta);

	}
}

/* Editar */

if(isset($_POST["idPrueba"])){

	$editar = new AjaxPrueba();
	$editar -> idPrueba = $_POST["idPrueba"];
	$editar -> ajaxEditarPrueba();

}

/* Activar Prueba */

if(isset($_POST["activarPrueba"])){

	$activarPrueba = new AjaxPrueba();
	$activarPrueba -> activarPrueba = $_POST["activarPrueba"];
	$activarPrueba -> activarId = $_POST["activarId"];
	$activarPrueba -> ajaxActivarPrueba();

}

/* Validar no repetir Prueba */

if(isset( $_POST["validarPrueba"])){

	$valPrueba = new AjaxPrueba();
	$valPrueba -> validarPrueba = $_POST["validarPrueba"];
	$valPrueba -> ajaxValidarPrueba();

}