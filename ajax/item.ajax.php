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

require_once "../controladores/item.controlador.php";
require_once "../modelos/item.modelo.php";

class AjaxItem{

	/* Editar */

	public $idItem;

	public function ajaxEditarItem(){

		$item = "id";
		$valor = $this->idItem;

		$respuesta = ControladorItem::ctrMostrarItem($item, $valor);

		echo json_encode($respuesta);

	}

	/* Actualizar */

	public $activarItem;
	public $activarId;


	public function ajaxActivarItem(){

		$tabla = "item";

		$item1 = "estado";
		$valor1 = $this->activarItem;

		$item2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloItem::mdlActualizarItem($tabla, $item1, $valor1, $item2, $valor2);

		 echo json_encode(["item" => $respuesta]);

	}

	/* Validar no repetir item */

	public $validarItem;

	public function ajaxValidarItem(){

		$item = "item";
		$valor = $this->validarItem;

		$respuesta = ControladorItem::ctrMostrarItem($item, $valor);

		echo json_encode($respuesta);

	}
}

/* Editar */

if(isset($_POST["idItem"])){

	$editar = new AjaxItem();
	$editar -> idItem = $_POST["idItem"];
	$editar -> ajaxEditarItem();

}

/* Activar Item */

if(isset($_POST["activarItem"])){

	$activarItem = new AjaxItem();
	$activarItem -> activarItem = $_POST["activarItem"];
	$activarItem -> activarId = $_POST["activarId"];
	$activarItem -> ajaxActivarItem();

}

/* Validar no repetir Item */

if(isset( $_POST["validarItem"])){

	$valItem = new AjaxItem();
	$valItem -> validarItem = $_POST["validarItem"];
	$valItem -> ajaxValidarItem();

}