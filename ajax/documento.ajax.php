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

require_once "../controladores/documento.controlador.php";
require_once "../modelos/documento.modelo.php";

class AjaxDocumento{

	/* Editar */
	public $idDocumento;

	public function ajaxEditarDocumento(){

		$item = "id";
		$valor = $this->idDocumento;

		$respuesta = ControladorDocumento::ctrMostrarDocumento($item, $valor);

		echo json_encode($respuesta);
	}

	/* Actualizar Estado */
	public $activarDocumento;
	public $activarId;

	public function ajaxActivarDocumento(){

		$tabla = "documento";

		$item1 = "estado";
		$valor1 = $this->activarDocumento;

		$item2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloDocumento::mdlActualizarDocumento($tabla, $item1, $valor1, $item2, $valor2);

		echo json_encode(["status" => $respuesta]);
	}

	/* Validar no repetir documento */
	public $validarDocumento;

	public function ajaxValidarDocumento(){

		$item = "documento";
		$valor = $this->validarDocumento;

		$respuesta = ControladorDocumento::ctrMostrarDocumento($item, $valor);

		echo json_encode($respuesta);
	}
}

/* Editar */
if(isset($_POST["idDocumento"])){

	$editar = new AjaxDocumento();
	$editar->idDocumento = $_POST["idDocumento"];
	$editar->ajaxEditarDocumento();
}

/* Activar Documento */
if(isset($_POST["activarDocumento"])){

	$activarDocumento = new AjaxDocumento();
	$activarDocumento->activarDocumento = $_POST["activarDocumento"];
	$activarDocumento->activarId = $_POST["activarId"];
	$activarDocumento->ajaxActivarDocumento();
}

/* Validar no repetir Documento */
if(isset($_POST["validarDocumento"])){

	$valDocumento = new AjaxDocumento();
	$valDocumento->validarDocumento = $_POST["validarDocumento"];
	$valDocumento->ajaxValidarDocumento();
}
?>