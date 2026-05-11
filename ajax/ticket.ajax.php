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

require_once "../controladores/ticket.controlador.php";
require_once "../modelos/ticket.modelo.php";

class AjaxTicket{

	/* Editar */

	public $idTicket;

	public function ajaxEditarTicket(){

		$item = "id";
		$valor = $this->idTicket;

		$respuesta = ControladorTicket::ctrMostrarTicket($item, $valor);

		echo json_encode($respuesta);

	}

	/* Actualizar */

	public $activarTicket;
	public $activarId;


	public function ajaxActivarTicket(){

		$tabla = "ticket";

		$item1 = "estado";
		$valor1 = $this->activarTicket;

		$item2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloTicket::mdlActualizarTicket($tabla, $item1, $valor1, $item2, $valor2);

		 echo json_encode(["status" => $respuesta]);

	}

	/* Actualizar Finalizado */

	public $finalizarTicket;
	public $finalizarId;


	public function ajaxFinalizarTicket(){

		$tabla = "ticket";

		$item1 = "finalizado";
		$valor1 = $this->finalizarTicket;

		$item2 = "id";
		$valor2 = $this->finalizarId;

		$respuesta = ModeloTicket::mdlActualizarFinalizado($tabla, $item1, $valor1, $item2, $valor2);

		 echo json_encode(["status" => $respuesta]);

	}

	/* Validar no repetir ticket */

	public $validarTicket;

	public function ajaxValidarTicket(){

		$item = "ticket";
		$valor = $this->validarTicket;

		$respuesta = ControladorTicket::ctrMostrarTicket($item, $valor);

		echo json_encode($respuesta);

	}
}

/* Editar */

if(isset($_POST["idTicket"])){

	$editar = new AjaxTicket();
	$editar -> idTicket = $_POST["idTicket"];
	$editar -> ajaxEditarTicket();

}

/* Activar Ticket */

if(isset($_POST["activarTicket"])){

	$activarTicket = new AjaxTicket();
	$activarTicket -> activarTicket = $_POST["activarTicket"];
	$activarTicket -> activarId = $_POST["activarId"];
	$activarTicket -> ajaxActivarTicket();

}

/* Finalizar Ticket */

if(isset($_POST["finalizarTicket"])){

	$finalizarTicket = new AjaxTicket();
	$finalizarTicket -> finalizarTicket = $_POST["finalizarTicket"];
	$finalizarTicket -> finalizarId = $_POST["finalizarId"];
	$finalizarTicket -> ajaxFinalizarTicket();

}

/* Validar no repetir Ticket */

if(isset( $_POST["validarTicket"])){

	$valTicket = new AjaxTicket();
	$valTicket -> validarTicket = $_POST["validarTicket"];
	$valTicket -> ajaxValidarTicket();

}