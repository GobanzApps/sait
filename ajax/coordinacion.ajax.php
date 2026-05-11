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

require_once "../controladores/coordinacion.controlador.php";
require_once "../modelos/coordinacion.modelo.php";

class AjaxCoordinacion{

	/* Editar */

	public $idCoordinacion;

	public function ajaxEditarCoordinacion(){

		$item = "id";
		$valor = $this->idCoordinacion;

		$respuesta = ControladorCoordinacion::ctrMostrarCoordinacion($item, $valor);

		echo json_encode($respuesta);

	}

	/* Actualizar */

	public $activarCoordinacion;
	public $activarId;


	public function ajaxActivarCoordinacion(){

		$tabla = "coordinacion";

		$item1 = "estado";
		$valor1 = $this->activarCoordinacion;

		$item2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloCoordinacion::mdlActualizarCoordinacion($tabla, $item1, $valor1, $item2, $valor2);

		 echo json_encode(["coordinacion" => $respuesta]);

	}

	/* Validar no repetir coordinacion */

	public $validarCoordinacion;

	public function ajaxValidarCoordinacion(){

		$item = "coordinacion";
		$valor = $this->validarCoordinacion;

		$respuesta = ControladorCoordinacion::ctrMostrarCoordinacion($item, $valor);

		echo json_encode($respuesta);

	}
}

/* Editar */

if(isset($_POST["idCoordinacion"])){

	$editar = new AjaxCoordinacion();
	$editar -> idCoordinacion = $_POST["idCoordinacion"];
	$editar -> ajaxEditarCoordinacion();

}

/* Activar Coordinacion */

if(isset($_POST["activarCoordinacion"])){

	$activarCoordinacion = new AjaxCoordinacion();
	$activarCoordinacion -> activarCoordinacion = $_POST["activarCoordinacion"];
	$activarCoordinacion -> activarId = $_POST["activarId"];
	$activarCoordinacion -> ajaxActivarCoordinacion();

}

/* Validar no repetir Coordinacion */

if(isset( $_POST["validarCoordinacion"])){

	$valCoordinacion = new AjaxCoordinacion();
	$valCoordinacion -> validarCoordinacion = $_POST["validarCoordinacion"];
	$valCoordinacion -> ajaxValidarCoordinacion();

}