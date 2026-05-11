<?php
require_once "conexion.php";

class ModeloTicketevidencia{

    /* Mostrar evidencias de un ticket */
    static public function mdlMostrarTicketevidencia($tabla, $item, $valor){

        $tablasPermitidas = ['ticketevidencia'];
        if (!in_array($tabla, $tablasPermitidas)) {
            error_log("Intento de inyección SQL detectado en mdlMostrarTicketevidencia: Tabla no permitida - " . $tabla);
            return [];
        }

        if($item != null){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id ASC");
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt -> execute();
            $resultado = $stmt -> fetchAll();
            $stmt = null;
            return $resultado;
        }else{
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
            $stmt -> execute();
            $resultado = $stmt -> fetchAll();
            $stmt = null;
            return $resultado;
        }
    }

    /* Contar evidencias por ticket */
    static public function mdlContarEvidenciasPorTicket($tabla, $id_ticket){
        $stmt = Conexion::conectar()->prepare("SELECT COUNT(*) as total FROM $tabla WHERE id_ticket = :id_ticket");
        $stmt -> bindParam(":id_ticket", $id_ticket, PDO::PARAM_INT);
        $stmt -> execute();
        $resultado = $stmt -> fetch(PDO::FETCH_ASSOC);
        $stmt = null;
        return $resultado['total'];
    }

    /* Crear evidencia */
    static public function mdlCrearTicketevidencia($tabla, $datos){

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_ticket, ticketevidencia, fecha_subida) VALUES (:id_ticket, :ticketevidencia, :fecha_subida)");
    
        $stmt->bindParam(":id_ticket", $datos["id_ticket"], PDO::PARAM_INT);
        $stmt->bindParam(":ticketevidencia", $datos["ticketevidencia"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_subida", $datos["fecha_subida"], PDO::PARAM_STR);

        if($stmt->execute()){
            $stmt = null;
            return "ok";    
        }else{
            $stmt = null;
            return "error";
        }
    }

    /* Borrar evidencia */
    static public function mdlBorrarTicketevidencia($tabla, $datos){

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
        $stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

        if($stmt -> execute()){
            $stmt = null;
            return "ok";
        }else{
            $stmt = null;
            return "error";    
        }
    }

    /* Obtener ruta de imagen por ID */
    static public function mdlObtenerRutaImagen($tabla, $id){
        $stmt = Conexion::conectar()->prepare("SELECT ticketevidencia FROM $tabla WHERE id = :id");
        $stmt -> bindParam(":id", $id, PDO::PARAM_INT);
        $stmt -> execute();
        $resultado = $stmt -> fetch(PDO::FETCH_ASSOC);
        $stmt = null;
        return $resultado ? $resultado['ticketevidencia'] : '';
    }
}
?>