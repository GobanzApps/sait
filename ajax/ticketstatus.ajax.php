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

require_once "../controladores/ticketstatus.controlador.php";
require_once "../modelos/ticketstatus.modelo.php";

class AjaxTicketstatus{

	/* Editar */

	public $idTicketstatus;

	public function ajaxEditarTicketstatus(){

		$ticketstatus = "id";
		$valor = $this->idTicketstatus;

		$respuesta = ControladorTicketstatus::ctrMostrarTicketstatus($ticketstatus, $valor);

		echo json_encode($respuesta);

	}

	/* Actualizar */

	public $activarTicketstatus;
	public $activarId;


	public function ajaxActivarTicketstatus(){

		$tabla = "ticketstatus";

		$ticketstatus1 = "estado";
		$valor1 = $this->activarTicketstatus;

		$ticketstatus2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloTicketstatus::mdlActualizarTicketstatus($tabla, $ticketstatus1, $valor1, $ticketstatus2, $valor2);

		 echo json_encode(["ticketstatus" => $respuesta]);

	}

	/* Validar no repetir ticketstatus */

	public $validarTicketstatus;

	public function ajaxValidarTicketstatus(){

		$ticketstatus = "ticketstatus";
		$valor = $this->validarTicketstatus;

		$respuesta = ControladorTicketstatus::ctrMostrarTicketstatus($ticketstatus, $valor);

		echo json_encode($respuesta);

	}
}

/* Editar */

if(isset($_POST["idTicketstatus"])){

	$editar = new AjaxTicketstatus();
	$editar -> idTicketstatus = $_POST["idTicketstatus"];
	$editar -> ajaxEditarTicketstatus();

}

/* Activar Ticketstatus */

if(isset($_POST["activarTicketstatus"])){

	$activarTicketstatus = new AjaxTicketstatus();
	$activarTicketstatus -> activarTicketstatus = $_POST["activarTicketstatus"];
	$activarTicketstatus -> activarId = $_POST["activarId"];
	$activarTicketstatus -> ajaxActivarTicketstatus();

}

/* Validar no repetir Ticketstatus */

if(isset( $_POST["validarTicketstatus"])){

	$valTicketstatus = new AjaxTicketstatus();
	$valTicketstatus -> validarTicketstatus = $_POST["validarTicketstatus"];
	$valTicketstatus -> ajaxValidarTicketstatus();

}