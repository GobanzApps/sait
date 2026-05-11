<?php

require_once "controladores/plantilla.controlador.php";

require_once "controladores/usuarios.controlador.php";
require_once "modelos/usuarios.modelo.php";

require_once "controladores/prueba.controlador.php";
require_once "modelos/prueba.modelo.php";

require_once "controladores/medio.controlador.php";
require_once "modelos/medio.modelo.php";

require_once "controladores/status.controlador.php";
require_once "modelos/status.modelo.php";

require_once "controladores/prioridad.controlador.php";
require_once "modelos/prioridad.modelo.php";

require_once "controladores/coordinacion.controlador.php";
require_once "modelos/coordinacion.modelo.php";

require_once "controladores/entes.controlador.php";
require_once "modelos/entes.modelo.php";

require_once "controladores/servicios.controlador.php";
require_once "modelos/servicios.modelo.php";

require_once "controladores/item.controlador.php";
require_once "modelos/item.modelo.php";

require_once "controladores/ticket.controlador.php";
require_once "modelos/ticket.modelo.php";

require_once "controladores/ticketcoordinacion.controlador.php";
require_once "modelos/ticketcoordinacion.modelo.php";

require_once "controladores/ticketusuario.controlador.php";
require_once "modelos/ticketusuario.modelo.php";

require_once "controladores/ticketstatus.controlador.php";
require_once "modelos/ticketstatus.modelo.php";

require_once "controladores/ticketservicios.controlador.php";
require_once "modelos/ticketservicios.modelo.php";

require_once "controladores/tipodocs.controlador.php";
require_once "modelos/tipodocs.modelo.php";

require_once "controladores/documento.controlador.php";
require_once "modelos/documento.modelo.php";

require_once "controladores/ticketevidencia.controlador.php";
require_once "modelos/ticketevidencia.modelo.php";

require_once "controladores/actividad.controlador.php";
require_once "modelos/actividad.modelo.php";

$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();





