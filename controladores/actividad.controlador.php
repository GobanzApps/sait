<?php
// Archivo: controladores/actividad.controlador.php

class ControladorActividad{

    /* Mostrar Actividades */
    static public function ctrMostrarActividad($item, $valor){
        $tabla = "actividad";
        $respuesta = ModeloActividad::mdlMostrarActividad($tabla, $item, $valor);
        return $respuesta;
    }

    /* Crear Actividad */
    static public function ctrCrearActividad(){
        if(isset($_POST["nuevoActividad"])){
            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s\+\-\*\.\,]+$/', $_POST["nuevoActividad"]) && 
               preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s\+\-\*\.\,]+$/', $_POST["nuevaDescripcion"])){

                $tabla = "actividad";
                
                // Serializar los arrays a JSON
                $id_usuario_json = json_encode($_POST["nuevoIdUsuario"]);
                $id_servicios_json = json_encode($_POST["nuevoIdServicios"]);
                $id_ente_json = json_encode($_POST["nuevoIdEnte"]);
                
                // Tomar id_coordinacion de la sesión
                $id_coordinacion = $_SESSION["id_coordinacion"];
                // Tomar id_usuario_creador de la sesión
                $id_usuario_creador = $_SESSION["id"];

                $datos = array(
                    "actividad" => $_POST["nuevoActividad"],
                    "id_usuario" => $id_usuario_json,
                    "id_servicios" => $id_servicios_json,
                    "id_ente" => $id_ente_json,
                    "id_coordinacion" => $id_coordinacion,
                    "id_usuario_creador" => $id_usuario_creador,
                    "descripcion" => $_POST["nuevaDescripcion"],
                    "estado" => 1
                );

                $respuesta = ModeloActividad::mdlCrearActividad($tabla, $datos);
            
                if($respuesta == "ok"){
                    echo '<script>
                    swal({
                        type: "success",
                        title: "¡Actividad guardada correctamente!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then(function(result){
                        if(result.value){
                            window.location = "actividad";
                        }
                    });
                    </script>';
                } else {
                    echo '<script>
                    swal({
                        type: "error",
                        title: "Error al guardar",
                        text: "No se pudo crear la actividad",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then(function(result){
                        if(result.value){
                            window.location = "actividad";
                        }
                    });
                    </script>';
                }
            } else {
                echo '<script>
                swal({
                    type: "error",
                    title: "¡Formulario inválido!",
                    text: "No se permiten caracteres especiales en campos de texto",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                }).then(function(result){
                    if(result.value){
                        window.location = "actividad";
                    }
                });
                </script>';
            }
        }
    }

    /* Editar Actividad */
    static public function ctrEditarActividad(){
        if(isset($_POST["editarActividad"])){
            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s\+\-\*\.\,]+$/', $_POST["editarActividad"]) && 
               preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s\+\-\*\.\,]+$/', $_POST["editarDescripcion"])){

                $tabla = "actividad";
                
                // Serializar los arrays a JSON
                $id_usuario_json = json_encode($_POST["editarIdUsuario"]);
                $id_servicios_json = json_encode($_POST["editarIdServicios"]);
                $id_ente_json = json_encode($_POST["editarIdEnte"]);

                $datos = array(
                    "id" => $_POST["idActividad"],
                    "actividad" => $_POST["editarActividad"],
                    "id_usuario" => $id_usuario_json,
                    "id_servicios" => $id_servicios_json,
                    "id_ente" => $id_ente_json,
                    "descripcion" => $_POST["editarDescripcion"]
                );

                $respuesta = ModeloActividad::mdlEditarActividad($tabla, $datos);

                if($respuesta == "ok"){
                    echo'<script>
                    swal({
                        type: "success",
                        title: "¡Actividad editada correctamente!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then(function(result) {
                        if (result.value) {
                            window.location = "actividad";
                        }
                    });
                    </script>';
                } else {
                    echo'<script>
                    swal({
                        type: "error",
                        title: "Error al editar",
                        text: "No se pudo actualizar la actividad",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then(function(result) {
                        if (result.value) {
                            window.location = "actividad";
                        }
                    });
                    </script>';
                }
            } else {
                echo'<script>
                swal({
                    type: "error",
                    title: "¡Formulario inválido!",
                    text: "No se permiten caracteres especiales en campos de texto",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                }).then(function(result) {
                    if (result.value) {
                        window.location = "actividad";
                    }
                });
                </script>';
            }
        }
    }

    /* Borrar Actividad */
    static public function ctrBorrarActividad(){
        if(isset($_GET["idActividad"])){
            $tabla = "actividad";
            $datos = $_GET["idActividad"];
            $respuesta = ModeloActividad::mdlBorrarActividad($tabla, $datos);

            if($respuesta == "ok"){
                echo'<script>
                swal({
                    type: "success",
                    title: "Actividad borrada",
                    text: "Se ha eliminado correctamente",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                }).then(function(result) {
                    if (result.value) {
                        window.location = "actividad";
                    }
                });
                </script>';
            } else {
                echo'<script>
                swal({
                    type: "error",
                    title: "Error al borrar",
                    text: "No se pudo eliminar la actividad",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                }).then(function(result) {
                    if (result.value) {
                        window.location = "actividad";
                    }
                });
                </script>';
            }
        }
    }
}
?>