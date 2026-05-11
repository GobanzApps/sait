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

require_once "../controladores/servicios.controlador.php";
require_once "../modelos/servicios.modelo.php";

class AjaxServicios{

	/* Editar */
	public $idServicios;

	public function ajaxEditarServicios(){

		$item = "id";
		$valor = $this->idServicios;

		$respuesta = ControladorServicios::ctrMostrarServicios($item, $valor);

		echo json_encode($respuesta);

	}

	/* Actualizar */
	public $activarServicios;
	public $activarId;

	public function ajaxActivarServicios(){

		$tabla = "servicios";

		$item1 = "estado";
		$valor1 = $this->activarServicios;

		$item2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloServicios::mdlActualizarServicios($tabla, $item1, $valor1, $item2, $valor2);

		 echo json_encode(["servicios" => $respuesta]);

	}

	/* Validar no repetir servicios */
	public $validarServicios;

	public function ajaxValidarServicios(){

		$item = "servicios";
		$valor = $this->validarServicios;

		$respuesta = ControladorServicios::ctrMostrarServicios($item, $valor);

		echo json_encode($respuesta);

	}
}

/* Editar */
if(isset($_POST["idServicios"])){

	$editar = new AjaxServicios();
	$editar -> idServicios = $_POST["idServicios"];
	$editar -> ajaxEditarServicios();

}

/* Activar Servicios */
if(isset($_POST["activarServicios"])){

	$activarServicios = new AjaxServicios();
	$activarServicios -> activarServicios = $_POST["activarServicios"];
	$activarServicios -> activarId = $_POST["activarId"];
	$activarServicios -> ajaxActivarServicios();

}

/* Validar no repetir Servicios */
if(isset( $_POST["validarServicios"])){

	$valServicios = new AjaxServicios();
	$valServicios -> validarServicios = $_POST["validarServicios"];
	$valServicios -> ajaxValidarServicios();

}
?>