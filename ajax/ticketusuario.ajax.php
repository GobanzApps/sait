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

require_once "../controladores/ticketusuario.controlador.php";
require_once "../modelos/ticketusuario.modelo.php";

class AjaxTicketusuario{

	/* Editar */

	public $idTicketusuario;

	public function ajaxEditarTicketusuario(){

		$ticketusuario = "id";
		$valor = $this->idTicketusuario;

		$respuesta = ControladorTicketusuario::ctrMostrarTicketusuario($ticketusuario, $valor);

		echo json_encode($respuesta);

	}

	/* Actualizar */

	public $activarTicketusuario;
	public $activarId;


	public function ajaxActivarTicketusuario(){

		$tabla = "ticketusuario";

		$ticketusuario1 = "estado";
		$valor1 = $this->activarTicketusuario;

		$ticketusuario2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloTicketusuario::mdlActualizarTicketusuario($tabla, $ticketusuario1, $valor1, $ticketusuario2, $valor2);

		 echo json_encode(["ticketusuario" => $respuesta]);

	}

	/* Validar no repetir ticketusuario */

	public $validarTicketusuario;

	public function ajaxValidarTicketusuario(){

		$ticketusuario = "ticketusuario";
		$valor = $this->validarTicketusuario;

		$respuesta = ControladorTicketusuario::ctrMostrarTicketusuario($ticketusuario, $valor);

		echo json_encode($respuesta);

	}
}

/* Editar */

if(isset($_POST["idTicketusuario"])){

	$editar = new AjaxTicketusuario();
	$editar -> idTicketusuario = $_POST["idTicketusuario"];
	$editar -> ajaxEditarTicketusuario();

}

/* Activar Ticketusuario */

if(isset($_POST["activarTicketusuario"])){

	$activarTicketusuario = new AjaxTicketusuario();
	$activarTicketusuario -> activarTicketusuario = $_POST["activarTicketusuario"];
	$activarTicketusuario -> activarId = $_POST["activarId"];
	$activarTicketusuario -> ajaxActivarTicketusuario();

}

/* Validar no repetir Ticketusuario */

if(isset( $_POST["validarTicketusuario"])){

	$valTicketusuario = new AjaxTicketusuario();
	$valTicketusuario -> validarTicketusuario = $_POST["validarTicketusuario"];
	$valTicketusuario -> ajaxValidarTicketusuario();

}