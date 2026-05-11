
<div class="content-wrapper">
    <section class="content-header">
        <h1>Administrar Actividades</h1>
        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Administrar Actividades</li>
        </ol>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarActividad">
                    Agregar Actividad
                </button>
            </div>

            <div class="box-body">
                <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                    <thead>
                        <tr>
                            <th style="width:10px">#</th>
                            <th>Actividad</th>
                            <th>Usuarios Asignados</th>
                            <th>Servicios Relacionados</th>
                            <th>Entes Relacionados</th>
                            <th>Coordinación</th>
                            <th>Descripción</th>
                            <th>Fecha de Creación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $actividades = ControladorActividad::ctrMostrarActividad(null, null);
                        foreach ($actividades as $key => $value){

                            // Validar permisos según perfil
                            if ($_SESSION["id_coordinacion"] != "9" && $_SESSION["perfil"] != "Administrador") {
                                if (isset($value["id_coordinacion"]) && $value["id_coordinacion"] != $_SESSION["id_coordinacion"] && $value["id_coordinacion"] != $_SESSION["id_apoyo"]) {
                                    continue;
                                }
                            }
                        
                            // Obtener nombres de usuarios a partir del JSON
                            $usuariosHtml = obtenerNombresUsuariosPorIds($value["id_usuario"]);
                            // Obtener nombres de servicios a partir del JSON
                            $serviciosHtml = obtenerNombresServiciosPorIds($value["id_servicios"]);
                            // Obtener nombres de entes a partir del JSON
                            $entesHtml = obtenerNombresEntesPorIds($value["id_ente"]);
                            // Obtener nombre de la coordinación
                            $coordinacionNombre = obtenerNombreCoordinacion($value["id_coordinacion"]);
                            // Obtener datos del usuario creador
                            $usuarioCreador = obtenerDatosUsuario($value["id_usuario_creador"] ?? $_SESSION["id"]);
                            
                            echo '<tr>
                                <td>'.($key+1).'</td>
                                <td>'.$value["actividad"].'</td>
                                <td><ul class="list-unstyled" style="margin-bottom:0;">'.$usuariosHtml.'</ul></td>
                                <td><ul class="list-unstyled" style="margin-bottom:0;">'.$serviciosHtml.'</ul></td>
                                <td><ul class="list-unstyled" style="margin-bottom:0;">'.$entesHtml.'</ul></td>
                                <td>'.$coordinacionNombre.'</td>
                                <td>'.nl2br(htmlspecialchars(substr($value["descripcion"], 0, 100))).(strlen($value["descripcion"]) > 100 ? '...' : '').'</td>
                                <td>'.$value["fecha"].'</td>';
                            
                            
                            // Acciones
                            echo '<td>
                                <div class="btn-group">
                                    <button class="btn btn-xs btn-warning btnEditarActividad" idActividad="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarActividad"><i class="fa fa-pencil"></i></button>
                                    <button class="btn btn-xs btn-success btnCompartirWhatsApp" 
                                        data-id="'.$value["id"].'"
                                        data-actividad="'.htmlspecialchars($value["actividad"]).'"
                                        data-descripcion="'.htmlspecialchars($value["descripcion"]).'"
                                        data-fecha="'.$value["fecha"].'"
                                        data-coordinacion="'.htmlspecialchars($coordinacionNombre).'"
                                        data-usuarios="'.htmlspecialchars(strip_tags($usuariosHtml)).'"
                                        data-servicios="'.htmlspecialchars(strip_tags($serviciosHtml)).'"
                                        data-entes="'.htmlspecialchars(strip_tags($entesHtml)).'"
                                        data-creador="'.htmlspecialchars($usuarioCreador["nombre"].' '.$usuarioCreador["apellido"]).'"
                                        data-usuario-creador="'.htmlspecialchars($usuarioCreador["usuario"]).'">
                                        <i class="fa fa-whatsapp"></i>
                                    </button>
                                    <button class="btn btn-xs btn-danger btnEliminarActividad" idActividad="'.$value["id"].'" actividad="'.$value["actividad"].'"><i class="fa fa-times"></i></button>
                                </div>
                            </td>
                        </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<?php 
include "vistas/modales/actividad.php";
$borrar = new ControladorActividad();
$borrar->ctrBorrarActividad();
?>
<script src="vistas/js/actividad.js"></script>

<style>
/* Estilo para el botón de WhatsApp */
.btn-success {
    background-color: #25D366 !important;
    border-color: #25D366 !important;
}

.btn-success:hover {
    background-color: #128C7E !important;
    border-color: #128C7E !important;
}

/* Estilo para el tooltip del botón WhatsApp */
.btn-success .fa-whatsapp {
    font-size: 14px;
}
    </style>