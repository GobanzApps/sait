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

require_once "../controladores/entes.controlador.php";
require_once "../modelos/entes.modelo.php";

class AjaxEntes{

	/* Editar */

	public $idEntes;

	public function ajaxEditarEntes(){

		$item = "id";
		$valor = $this->idEntes;

		$respuesta = ControladorEntes::ctrMostrarEntes($item, $valor);

		echo json_encode($respuesta);

	}

	/* Actualizar */

	public $activarEntes;
	public $activarId;


	public function ajaxActivarEntes(){

		$tabla = "entes";

		$item1 = "estado";
		$valor1 = $this->activarEntes;

		$item2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloEntes::mdlActualizarEntes($tabla, $item1, $valor1, $item2, $valor2);

		 echo json_encode(["entes" => $respuesta]);

	}

	/* Validar no repetir entes */

	public $validarEntes;

	public function ajaxValidarEntes(){

		$item = "entes";
		$valor = $this->validarEntes;

		$respuesta = ControladorEntes::ctrMostrarEntes($item, $valor);

		echo json_encode($respuesta);

	}
}

/* Editar */

if(isset($_POST["idEntes"])){

	$editar = new AjaxEntes();
	$editar -> idEntes = $_POST["idEntes"];
	$editar -> ajaxEditarEntes();

}

/* Activar Entes */

if(isset($_POST["activarEntes"])){

	$activarEntes = new AjaxEntes();
	$activarEntes -> activarEntes = $_POST["activarEntes"];
	$activarEntes -> activarId = $_POST["activarId"];
	$activarEntes -> ajaxActivarEntes();

}

/* Validar no repetir Entes */

if(isset( $_POST["validarEntes"])){

	$valEntes = new AjaxEntes();
	$valEntes -> validarEntes = $_POST["validarEntes"];
	$valEntes -> ajaxValidarEntes();

}