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

require_once "../controladores/ticketcoordinacion.controlador.php";
require_once "../modelos/ticketcoordinacion.modelo.php";

class AjaxTicketcoordinacion{

	/* Editar */

	public $idTicketcoordinacion;

	public function ajaxEditarTicketcoordinacion(){

		$ticketcoordinacion = "id";
		$valor = $this->idTicketcoordinacion;

		$respuesta = ControladorTicketcoordinacion::ctrMostrarTicketcoordinacion($ticketcoordinacion, $valor);

		echo json_encode($respuesta);

	}

	/* Actualizar */

	public $activarTicketcoordinacion;
	public $activarId;


	public function ajaxActivarTicketcoordinacion(){

		$tabla = "ticketcoordinacion";

		$ticketcoordinacion1 = "estado";
		$valor1 = $this->activarTicketcoordinacion;

		$ticketcoordinacion2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloTicketcoordinacion::mdlActualizarTicketcoordinacion($tabla, $ticketcoordinacion1, $valor1, $ticketcoordinacion2, $valor2);

		 echo json_encode(["ticketcoordinacion" => $respuesta]);

	}

	/* Validar no repetir ticketcoordinacion */

	public $validarTicketcoordinacion;

	public function ajaxValidarTicketcoordinacion(){

		$ticketcoordinacion = "ticketcoordinacion";
		$valor = $this->validarTicketcoordinacion;

		$respuesta = ControladorTicketcoordinacion::ctrMostrarTicketcoordinacion($ticketcoordinacion, $valor);

		echo json_encode($respuesta);

	}
}

/* Editar */

if(isset($_POST["idTicketcoordinacion"])){

	$editar = new AjaxTicketcoordinacion();
	$editar -> idTicketcoordinacion = $_POST["idTicketcoordinacion"];
	$editar -> ajaxEditarTicketcoordinacion();

}

/* Activar Ticketcoordinacion */

if(isset($_POST["activarTicketcoordinacion"])){

	$activarTicketcoordinacion = new AjaxTicketcoordinacion();
	$activarTicketcoordinacion -> activarTicketcoordinacion = $_POST["activarTicketcoordinacion"];
	$activarTicketcoordinacion -> activarId = $_POST["activarId"];
	$activarTicketcoordinacion -> ajaxActivarTicketcoordinacion();

}

/* Validar no repetir Ticketcoordinacion */

if(isset( $_POST["validarTicketcoordinacion"])){

	$valTicketcoordinacion = new AjaxTicketcoordinacion();
	$valTicketcoordinacion -> validarTicketcoordinacion = $_POST["validarTicketcoordinacion"];
	$valTicketcoordinacion -> ajaxValidarTicketcoordinacion();

}