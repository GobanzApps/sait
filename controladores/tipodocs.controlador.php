<?php
// Archivo: controladores/tipodocs.controlador.php

class ControladorTipodocs{

    /* Mostrar */
    static public function ctrMostrarTipodocs($item, $valor){

        $tabla = "tipodocs";

        $respuesta = ModeloTipodocs::mdlMostrarTipodocs($tabla, $item, $valor);

        return $respuesta;
    }

    /* Crear */
    static public function ctrCrearTipodoc(){

        if(isset($_POST["nuevoTipodoc"])){

            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoTipodoc"])){

                $tabla = "tipodocs";

                $datos = array(
                    "tipodocs" => $_POST["nuevoTipodoc"],
                    "estado" => "1"
                    // Nota: 'modificacion' y 'fecha' se manejarán automáticamente en la BD con TIMESTAMP/CURRENT_TIMESTAMP
                );

                $respuesta = ModeloTipodocs::mdlCrearTipodoc($tabla, $datos);
            
                if($respuesta == "ok"){

                    echo '<script>

                    swal({
                        type: "success",
                        title: "¡Ha sido guardado correctamente!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then(function(result){
                        if(result.value){
                            window.location = "tipodocs";
                        }
                    });
                    </script>';

                }   

            }else{

                echo '<script>
                swal({
                    type: "error",
                    title: "¡El Formulario no puede ir vacío o llevar caracteres especiales!",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                }).then(function(result){
                    if(result.value){
                        window.location = "tipodocs";
                    }
                });
                </script>';
            }
        }
    }

    /* Editar */
    static public function ctrEditarTipodoc(){

        if(isset($_POST["editarTipodoc"])){

            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarTipodoc"])){

                $tabla = "tipodocs";

                $datos = array(
                    "id" => $_POST["idTipodoc"],
                    "tipodocs" => $_POST["editarTipodoc"]
                );

                $respuesta = ModeloTipodocs::mdlEditarTipodoc($tabla, $datos);

                if($respuesta == "ok"){

                    echo'<script>
                    swal({
                        type: "success",
                        title: "Ha sido editado correctamente",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then(function(result) {
                        if (result.value) {
                            window.location = "tipodocs";
                        }
                    });
                    </script>';

                }

            }else{

                echo'<script>
                swal({
                    type: "error",
                    title: "¡El formulario no puede ir vacío o llevar caracteres especiales!",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                }).then(function(result) {
                    if (result.value) {
                        window.location = "tipodocs";
                    }
                });
                </script>';
            }
        }
    }

    /* Borrar */
    static public function ctrBorrarTipodoc(){

        if(isset($_GET["idTipodoc"])){

            $tabla = "tipodocs";
            $datos = $_GET["idTipodoc"];

            $respuesta = ModeloTipodocs::mdlBorrarTipodoc($tabla, $datos);

            if($respuesta == "ok"){

                echo'<script>
                swal({
                    type: "success",
                    title: "Ha sido borrado correctamente",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar",
                    closeOnConfirm: false
                }).then(function(result) {
                    if (result.value) {
                        window.location = "tipodocs";
                    }
                });
                </script>';
            }       
        }
    }
}
?>