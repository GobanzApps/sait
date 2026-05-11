<?php
// Archivo: ajax/actividad.ajax.php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["iniciarSesion"]) || $_SESSION["iniciarSesion"] != "ok") {
    header('HTTP/1.1 401 Unauthorized');
    echo json_encode(["error" => "Acceso no autorizado"]);
    exit();
}
header('Content-Type: application/json');

require_once "../controladores/actividad.controlador.php";
require_once "../modelos/actividad.modelo.php";

class AjaxActividad{

    /* Editar - Obtener datos para el modal */
    public $idActividad;

    public function ajaxEditarActividad(){
        $item = "id";
        $valor = $this->idActividad;
        $respuesta = ControladorActividad::ctrMostrarActividad($item, $valor);
        
        // Decodificar los JSON para que Select2 los entienda como arrays
        if($respuesta){
            $respuesta["id_usuario"] = json_decode($respuesta["id_usuario"], true);
            $respuesta["id_servicios"] = json_decode($respuesta["id_servicios"], true);
            $respuesta["id_ente"] = json_decode($respuesta["id_ente"], true);
        }
        echo json_encode($respuesta);
    }

    /* Actualizar Estado */
    public $activarActividad;
    public $activarId;

    public function ajaxActivarActividad(){
        $tabla = "actividad";
        $item1 = "estado";
        $valor1 = $this->activarActividad;
        $item2 = "id";
        $valor2 = $this->activarId;

        $respuesta = ModeloActividad::mdlActualizarActividad($tabla, $item1, $valor1, $item2, $valor2);
        echo json_encode(["status" => $respuesta]);
    }

    /* Validar si ya existe (por nombre de actividad) */
    public $validarActividad;

    public function ajaxValidarActividad(){
        $item = "actividad";
        $valor = $this->validarActividad;
        $respuesta = ControladorActividad::ctrMostrarActividad($item, $valor);
        echo json_encode($respuesta);
    }
}

// Editar
if(isset($_POST["idActividad"])){
    $editar = new AjaxActividad();
    $editar->idActividad = $_POST["idActividad"];
    $editar->ajaxEditarActividad();
}

// Activar/Desactivar
if(isset($_POST["activarActividad"])){
    $activar = new AjaxActividad();
    $activar->activarActividad = $_POST["activarActividad"];
    $activar->activarId = $_POST["activarId"];
    $activar->ajaxActivarActividad();
}

// Validar
if(isset($_POST["validarActividad"])){
    $val = new AjaxActividad();
    $val->validarActividad = $_POST["validarActividad"];
    $val->ajaxValidarActividad();
}
?>