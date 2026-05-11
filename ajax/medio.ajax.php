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

require_once "../controladores/medio.controlador.php";
require_once "../modelos/medio.modelo.php";

class AjaxMedio{

	/* Editar */

	public $idMedio;

	public function ajaxEditarMedio(){

		$item = "id";
		$valor = $this->idMedio;

		$respuesta = ControladorMedio::ctrMostrarMedio($item, $valor);

		echo json_encode($respuesta);

	}

	/* Actualizar */

	public $activarMedio;
	public $activarId;


	public function ajaxActivarMedio(){

		$tabla = "medio";

		$item1 = "estado";
		$valor1 = $this->activarMedio;

		$item2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloMedio::mdlActualizarMedio($tabla, $item1, $valor1, $item2, $valor2);

		 echo json_encode(["status" => $respuesta]);

	}

	/* Validar no repetir medio */

	public $validarMedio;

	public function ajaxValidarMedio(){

		$item = "medio";
		$valor = $this->validarMedio;

		$respuesta = ControladorMedio::ctrMostrarMedio($item, $valor);

		echo json_encode($respuesta);

	}
}

/* Editar */

if(isset($_POST["idMedio"])){

	$editar = new AjaxMedio();
	$editar -> idMedio = $_POST["idMedio"];
	$editar -> ajaxEditarMedio();

}

/* Activar Medio */

if(isset($_POST["activarMedio"])){

	$activarMedio = new AjaxMedio();
	$activarMedio -> activarMedio = $_POST["activarMedio"];
	$activarMedio -> activarId = $_POST["activarId"];
	$activarMedio -> ajaxActivarMedio();

}

/* Validar no repetir Medio */

if(isset( $_POST["validarMedio"])){

	$valMedio = new AjaxMedio();
	$valMedio -> validarMedio = $_POST["validarMedio"];
	$valMedio -> ajaxValidarMedio();

}