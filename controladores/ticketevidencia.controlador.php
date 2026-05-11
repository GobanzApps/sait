<?php

class ControladorTicketevidencia{

    /* Mostrar evidencias */
    static public function ctrMostrarTicketevidencia($item, $valor){
        $tabla = "ticketevidencia";
        $respuesta = ModeloTicketevidencia::mdlMostrarTicketevidencia($tabla, $item, $valor);
        return $respuesta;
    }

    /* Contar evidencias por ticket */
    static public function ctrContarEvidenciasPorTicket($id_ticket){
        $tabla = "ticketevidencia";
        return ModeloTicketevidencia::mdlContarEvidenciasPorTicket($tabla, $id_ticket);
    }

    /* Crear evidencia */
    static public function ctrCrearTicketevidencia(){

        if(isset($_FILES["nuevoTicketevidencia"]) && isset($_POST["nuevoId_ticket"])){
            
            $id_ticket = $_POST["nuevoId_ticket"];
            
            // Verificar que no exceda el límite de 2 imágenes
            $cantidadActual = self::ctrContarEvidenciasPorTicket($id_ticket);
            
            if($cantidadActual >= 2){
                echo '<script>
                swal({
                    type: "error",
                    title: "Límite alcanzado",
                    text: "Este ticket ya tiene 2 imágenes. Para agregar una nueva, debe eliminar una existente.",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                }).then(function(result){
                    if(result.value){
                        window.location.href;
                        location.replace(location.href);
                    }
                });
                </script>';
                return;
            }
            
            $archivo = $_FILES["nuevoTicketevidencia"];
            
            // Validar tipo de archivo (solo imágenes)
            $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/bmp'];
            $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];
            
            $nombreArchivo = $archivo["name"];
            $extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));
            $tipoMime = $archivo["type"];
            
            // Validar por extensión y MIME
            if(!in_array($extension, $extensionesPermitidas) || !in_array($tipoMime, $tiposPermitidos)){
                echo '<script>
                swal({
                    type: "error",
                    title: "Formato no válido",
                    text: "Solo se permiten archivos de imagen (JPG, PNG, GIF, WEBP, BMP)",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                }).then(function(result){
                    if(result.value){
                        window.location.href;
                        location.replace(location.href);
                    }
                });
                </script>';
                return;
            }
            
            // Validar tamaño máximo (2MB = 2097152 bytes)
            if($archivo["size"] > 2097152){
                echo '<script>
                swal({
                    type: "error",
                    title: "Archivo muy grande",
                    text: "La imagen no debe superar los 2MB",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                }).then(function(result){
                    if(result.value){
                        window.location.href;
                        location.replace(location.href);
                    }
                });
                </script>';
                return;
            }
            
            // Crear directorio si no existe
            $directorio = "vistas/img/evidencias/";
            if(!file_exists($directorio)){
                mkdir($directorio, 0777, true);
            }
            
            // Generar nombre único para la imagen
            $nombreUnico = uniqid() . "_" . $id_ticket . "_" . date("Ymd_His") . "." . $extension;
            $rutaDestino = $directorio . $nombreUnico;
            
            // Mover archivo
            if(move_uploaded_file($archivo["tmp_name"], $rutaDestino)){
                
                $tabla = "ticketevidencia";
                
                $datos = array(
                    "id_ticket" => $id_ticket,
                    "ticketevidencia" => $rutaDestino,
                    "fecha_subida" => date("Y-m-d H:i:s")
                );
                
                $respuesta = ModeloTicketevidencia::mdlCrearTicketevidencia($tabla, $datos);
                
                if($respuesta == "ok"){
                    echo '<script>
                    swal({
                        type: "success",
                        title: "¡Imagen guardada correctamente!",
                        text: "La evidencia ha sido agregada al ticket.",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then(function(result){
                        if(result.value){
                            window.location.href;
                            location.replace(location.href);
                        }
                    });
                    </script>';
                } else {
                    // Si falla la BD, eliminar el archivo subido
                    if(file_exists($rutaDestino)){
                        unlink($rutaDestino);
                    }
                    echo '<script>
                    swal({
                        type: "error",
                        title: "Error al guardar",
                        text: "No se pudo guardar la imagen en la base de datos",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then(function(result){
                        if(result.value){
                            window.location.href;
                            location.replace(location.href);
                        }
                    });
                    </script>';
                }
            } else {
                echo '<script>
                swal({
                    type: "error",
                    title: "Error al subir",
                    text: "No se pudo subir el archivo al servidor",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                }).then(function(result){
                    if(result.value){
                        window.location.href;
                        location.replace(location.href);
                    }
                });
                </script>';
            }
        }
    }

    /* Borrar evidencia */
    static public function ctrBorrarTicketevidencia(){

        if(isset($_GET["idTicketevidencia"])){
            
            $idTicketevidencia = $_GET["idTicketevidencia"];
            $idTicket = isset($_GET["id"]) ? $_GET["id"] : 0;
            
            // Obtener la ruta de la imagen para eliminarla del servidor
            $rutaImagen = ModeloTicketevidencia::mdlObtenerRutaImagen("ticketevidencia", $idTicketevidencia);
            
            $tabla = "ticketevidencia";
            $datos = $idTicketevidencia;
            
            $respuesta = ModeloTicketevidencia::mdlBorrarTicketevidencia($tabla, $datos);
            
            if($respuesta == "ok"){
                // Eliminar el archivo físico si existe
                if($rutaImagen && file_exists($rutaImagen)){
                    unlink($rutaImagen);
                }
                
                echo'<script>
                swal({
                    type: "success",
                    title: "Imagen eliminada",
                    text: "La evidencia ha sido eliminada correctamente",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                }).then(function(result) {
                    if (result.value) {
                        window.location = "index.php?ruta=ticket&id=' . $idTicket . '";
                    }
                });
                </script>';
            } else {
                echo'<script>
                swal({
                    type: "error",
                    title: "Error",
                    text: "No se pudo eliminar la evidencia",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                }).then(function(result) {
                    if (result.value) {
                        window.location = "index.php?ruta=ticket&id=' . $idTicket . '";
                    }
                });
                </script>';
            }        
        }
    }
}
?>