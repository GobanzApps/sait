<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["iniciarSesion"]) || $_SESSION["iniciarSesion"] != "ok") {
    header('HTTP/1.1 401 Unauthorized');
    echo json_encode(["error" => "Acceso no autorizado"]);
    exit();
}
header('Content-Type: application/json');

require_once "../controladores/ticketevidencia.controlador.php";
require_once "../modelos/ticketevidencia.modelo.php";

class AjaxTicketevidencia{

    public $idTicketevidencia;

    public function ajaxEliminarTicketevidencia(){
        $tabla = "ticketevidencia";
        $respuesta = ModeloTicketevidencia::mdlBorrarTicketevidencia($tabla, $this->idTicketevidencia);
        echo json_encode(["status" => $respuesta]);
    }
}

if(isset($_POST["idTicketevidencia"])){
    $eliminar = new AjaxTicketevidencia();
    $eliminar->idTicketevidencia = $_POST["idTicketevidencia"];
    $eliminar->ajaxEliminarTicketevidencia();
}
?>