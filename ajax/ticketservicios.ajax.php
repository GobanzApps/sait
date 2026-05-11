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

require_once "../controladores/ticketservicios.controlador.php";
require_once "../modelos/ticketservicios.modelo.php";

class AjaxTicketservicios{

	/* Editar */
	public $idTicketservicios;

	public function ajaxEditarTicketservicios(){
		$ticketservicios = "id";
		$valor = $this->idTicketservicios;
		$respuesta = ControladorTicketservicios::ctrMostrarTicketservicios($ticketservicios, $valor);
		echo json_encode($respuesta);
	}

	/* Actualizar registro completo */
	public $id;
	public $id_servicios;
	public $id_item;
	public $descripcion;
	public $cantidad;

	public function ajaxActualizarTicketservicios(){
		$datos = array(
			"id" => $this->id,
			"id_servicios" => $this->id_servicios,
			"id_item" => $this->id_item,
			"descripcion" => $this->descripcion,
			"cantidad" => $this->cantidad
		);
		$respuesta = ControladorTicketservicios::ctrActualizarTicketservicios($datos);
		echo json_encode(["respuesta" => $respuesta]);
	}

	/* Actualizar estado */
	public $activarTicketservicios;
	public $activarId;

	public function ajaxActivarTicketservicios(){
		$tabla = "ticketservicios";
		$ticketservicios1 = "estado";
		$valor1 = $this->activarTicketservicios;
		$ticketservicios2 = "id";
		$valor2 = $this->activarId;
		$respuesta = ModeloTicketservicios::mdlActualizarTicketservicios($tabla, $ticketservicios1, $valor1, $ticketservicios2, $valor2);
		echo json_encode(["ticketservicios" => $respuesta]);
	}

	/* Validar no repetir ticketservicios */
	public $validarTicketservicios;

	public function ajaxValidarTicketservicios(){
		$ticketservicios = "ticketservicios";
		$valor = $this->validarTicketservicios;
		$respuesta = ControladorTicketservicios::ctrMostrarTicketservicios($ticketservicios, $valor);
		echo json_encode($respuesta);
	}
}

/* Editar */
if(isset($_POST["idTicketservicios"])){
	$editar = new AjaxTicketservicios();
	$editar -> idTicketservicios = $_POST["idTicketservicios"];
	$editar -> ajaxEditarTicketservicios();
}

/* Actualizar Ticketservicios */
if(isset($_POST["actualizarId"])){
	$actualizar = new AjaxTicketservicios();
	$actualizar -> id = $_POST["actualizarId"];
	$actualizar -> id_servicios = $_POST["actualizarId_servicios"];
	$actualizar -> id_item = $_POST["actualizarId_item"];
	$actualizar -> descripcion = $_POST["actualizarDescripcion"];
	$actualizar -> cantidad = $_POST["actualizarCantidad"];
	$actualizar -> ajaxActualizarTicketservicios();
}

/* Activar Ticketservicios */
if(isset($_POST["activarTicketservicios"])){
	$activarTicketservicios = new AjaxTicketservicios();
	$activarTicketservicios -> activarTicketservicios = $_POST["activarTicketservicios"];
	$activarTicketservicios -> activarId = $_POST["activarId"];
	$activarTicketservicios -> ajaxActivarTicketservicios();
}

/* Validar no repetir Ticketservicios */
if(isset($_POST["validarTicketservicios"])){
	$valTicketservicios = new AjaxTicketservicios();
	$valTicketservicios -> validarTicketservicios = $_POST["validarTicketservicios"];
	$valTicketservicios -> ajaxValidarTicketservicios();
}
?>