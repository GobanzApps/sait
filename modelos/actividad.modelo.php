<?php
// Archivo: modelos/actividad.modelo.php
require_once "conexion.php";

class ModeloActividad{

    /* Mostrar Actividades */
    static public function mdlMostrarActividad($tabla, $item, $valor){
        // LISTA BLANCA para prevenir inyección SQL
        $tablasPermitidas = ['actividad'];
        if (!in_array($tabla, $tablasPermitidas)) {
            error_log("Intento de inyección SQL detectado en mdlMostrarActividad: Tabla no permitida - " . $tabla);
            return [];
        }

        if($item != null){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt -> execute();
            $resultado = $stmt -> fetch();
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id DESC");
            $stmt -> execute();
            $resultado = $stmt -> fetchAll();
        }
        
        $stmt -> closeCursor();
        $stmt = null;
        return $resultado;
    }

    /* Crear Actividad */
    static public function mdlCrearActividad($tabla, $datos){
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(actividad, id_usuario, id_servicios, id_ente, id_coordinacion, id_usuario_creador, descripcion, estado) 
            VALUES (:actividad, :id_usuario, :id_servicios, :id_ente, :id_coordinacion, :id_usuario_creador, :descripcion, :estado)");

        $stmt->bindParam(":actividad", $datos["actividad"], PDO::PARAM_STR);
        $stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_STR);
        $stmt->bindParam(":id_servicios", $datos["id_servicios"], PDO::PARAM_STR);
        $stmt->bindParam(":id_ente", $datos["id_ente"], PDO::PARAM_STR);
        $stmt->bindParam(":id_coordinacion", $datos["id_coordinacion"], PDO::PARAM_INT);
        $stmt->bindParam(":id_usuario_creador", $datos["id_usuario_creador"], PDO::PARAM_INT);
        $stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
        $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_INT);

        if($stmt->execute()){
            return "ok";
        } else {
            error_log("Error al crear actividad: " . print_r($stmt->errorInfo(), true));
            return "error";
        }

        $stmt->closeCursor();
        $stmt = null;
    }

    /* Editar Actividad */
    static public function mdlEditarActividad($tabla, $datos){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET actividad = :actividad, id_usuario = :id_usuario, id_servicios = :id_servicios, id_ente = :id_ente, descripcion = :descripcion WHERE id = :id");

        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
        $stmt->bindParam(":actividad", $datos["actividad"], PDO::PARAM_STR);
        $stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_STR);
        $stmt->bindParam(":id_servicios", $datos["id_servicios"], PDO::PARAM_STR);
        $stmt->bindParam(":id_ente", $datos["id_ente"], PDO::PARAM_STR);
        $stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);

        if($stmt -> execute()){
            return "ok";
        } else {
            error_log("Error al editar actividad ID: {$datos['id']} - " . print_r($stmt->errorInfo(), true));
            return "error";
        }

        $stmt -> closeCursor();
        $stmt = null;
    }

    /* Actualizar Estado de Actividad */
    static public function mdlActualizarActividad($tabla, $item1, $valor1, $item2, $valor2){
        $tablasPermitidas = ['actividad'];
        $columnasPermitidas = ['id', 'estado'];

        if (!in_array($tabla, $tablasPermitidas) || !in_array($item1, $columnasPermitidas) || !in_array($item2, $columnasPermitidas)) {
            error_log("Intento de inyección SQL detectado en mdlActualizarActividad: Tabla/Columna no permitida");
            return "error";
        }

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");
        $stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
        $stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_INT);

        if($stmt -> execute()){
            return "ok";
        } else {
            error_log("Error al actualizar estado de actividad: " . print_r($stmt->errorInfo(), true));
            return "error";
        }

        $stmt -> closeCursor();
        $stmt = null;
    }

    /* Borrar Actividad */
    static public function mdlBorrarActividad($tabla, $datos){
        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
        $stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

        if($stmt -> execute()){
            return "ok";
        } else {
            error_log("Error al borrar actividad ID: $datos - " . print_r($stmt->errorInfo(), true));
            return "error";
        }

        $stmt -> closeCursor();
        $stmt = null;
    }
}
?>