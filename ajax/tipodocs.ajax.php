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

require_once "../controladores/tipodocs.controlador.php";
require_once "../modelos/tipodocs.modelo.php";

class AjaxTipodocs{

    /* Editar */
    public $idTipodoc;

    public function ajaxEditarTipodoc(){

        $item = "id";
        $valor = $this->idTipodoc;

        $respuesta = ControladorTipodocs::ctrMostrarTipodocs($item, $valor);

        echo json_encode($respuesta);

    }

    /* Actualizar (Activar/Desactivar) */
    public $activarTipodoc;
    public $activarId;

    public function ajaxActivarTipodoc(){

        $tabla = "tipodocs";

        $item1 = "estado";
        $valor1 = $this->activarTipodoc;

        $item2 = "id";
        $valor2 = $this->activarId;

        $respuesta = ModeloTipodocs::mdlActualizarTipodocs($tabla, $item1, $valor1, $item2, $valor2);

        echo json_encode(["status" => $respuesta]);

    }

    /* Validar no repetir tipo de documento */
    public $validarTipodoc;

    public function ajaxValidarTipodoc(){

        $item = "tipodocs";
        $valor = $this->validarTipodoc;

        $respuesta = ControladorTipodocs::ctrMostrarTipodocs($item, $valor);

        echo json_encode($respuesta);

    }
}

/* Editar */
if(isset($_POST["idTipodoc"])){

    $editar = new AjaxTipodocs();
    $editar -> idTipodoc = $_POST["idTipodoc"];
    $editar -> ajaxEditarTipodoc();

}

/* Activar Tipodoc */
if(isset($_POST["activarTipodoc"])){

    $activarTipodoc = new AjaxTipodocs();
    $activarTipodoc -> activarTipodoc = $_POST["activarTipodoc"];
    $activarTipodoc -> activarId = $_POST["activarId"];
    $activarTipodoc -> ajaxActivarTipodoc();

}

/* Validar no repetir Tipodoc */
if(isset($_POST["validarTipodoc"])){

    $valTipodoc = new AjaxTipodocs();
    $valTipodoc -> validarTipodoc = $_POST["validarTipodoc"];
    $valTipodoc -> ajaxValidarTipodoc();

}
?>