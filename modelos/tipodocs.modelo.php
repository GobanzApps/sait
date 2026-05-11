<?php

require_once "conexion.php";

class ModeloTipodocs{

    /* Mostrar */
    static public function mdlMostrarTipodocs($tabla, $item, $valor){

        // LISTA BLANCA PARA LA TABLA
        $tablasPermitidas = ['tipodocs', 'coordinacion', 'documento', 'entes', 'item', 'medio', 'prioridad', 'prueba', 'servicios', 'status', 'ticket', 'ticketcoordinacion', 'ticketservicios', 'ticketstatus', 'ticketusuario', 'usuarios'];
        if (!in_array($tabla, $tablasPermitidas)) {
            error_log("Intento de inyección SQL detectado en mdlMostrarTipodocs: Tabla no permitida - " . $tabla);
            return [];
        }

        if($item != null){

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt -> execute();
            return $stmt -> fetch();

        }else{

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
            $stmt -> execute();
            return $stmt -> fetchAll();

        }

        $stmt -> close();
        $stmt = null;
    }

    /* Crear */
    static public function mdlCrearTipodoc($tabla, $datos){

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(tipodocs, estado) VALUES (:tipodocs, :estado)");

        $stmt->bindParam(":tipodocs", $datos["tipodocs"], PDO::PARAM_STR);
        $stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);

        if($stmt->execute()){
            return "ok";    
        }else{
            return "error";
        }

        $stmt->close();
        $stmt = null;
    }

    /* Editar */
    static public function mdlEditarTipodoc($tabla, $datos){
    
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET tipodocs = :tipodocs WHERE id = :id");

        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
        $stmt->bindParam(":tipodocs", $datos["tipodocs"], PDO::PARAM_STR);

        if($stmt -> execute()){
            return "ok";
        }else{
            return "error";    
        }

        $stmt -> close();
        $stmt = null;
    }

    /* Actualizar (para estado) - CORREGIDO CON LISTA BLANCA */
    static public function mdlActualizarTipodocs($tabla, $item1, $valor1, $item2, $valor2){

        // LISTA BLANCA PARA PREVENIR INYECCIÓN SQL
        $tablasPermitidas = ['tipodocs', 'coordinacion', 'documento', 'entes', 'item', 'medio', 'prioridad', 'prueba', 'servicios', 'status', 'ticket', 'ticketcoordinacion', 'ticketservicios', 'ticketstatus', 'ticketusuario', 'usuarios'];
        $columnasPermitidas = ['id', 'estado', 'tipodocs'];

        if (!in_array($tabla, $tablasPermitidas)) {
            error_log("Intento de inyección SQL detectado en mdlActualizarTipodocs: Tabla no permitida - " . $tabla);
            return "error";
        }
        if (!in_array($item1, $columnasPermitidas) || !in_array($item2, $columnasPermitidas)) {
            error_log("Intento de inyección SQL detectado en mdlActualizarTipodocs: Columna no permitida - " . $item1 . ", " . $item2);
            return "error";
        }

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

        $stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
        $stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

        if($stmt -> execute()){
            return "ok";
        }else{
            return "error";    
        }

        $stmt -> close();
        $stmt = null;
    }

    /* Borrar */
    static public function mdlBorrarTipodoc($tabla, $datos){

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
        $stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

        if($stmt -> execute()){
            return "ok";
        }else{
            return "error";    
        }

        $stmt -> close();
        $stmt = null;
    }
}