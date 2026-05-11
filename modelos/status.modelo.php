<?php

require_once "conexion.php";

class ModeloStatus{

	/* Mostrar */
	static public function mdlMostrarStatus($tabla, $item, $valor){

		// LISTA BLANCA PARA LA TABLA
		$tablasPermitidas = ['status', 'coordinacion', 'documento', 'entes', 'item', 'medio', 'prioridad', 'prueba', 'servicios', 'ticket', 'ticketcoordinacion', 'ticketservicios', 'ticketstatus', 'ticketusuario', 'tipodocs', 'usuarios'];
		if (!in_array($tabla, $tablasPermitidas)) {
			error_log("Intento de inyección SQL detectado en mdlMostrarStatus: Tabla no permitida - " . $tabla);
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
	static public function mdlCrearStatus($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(status, color, estado) VALUES (:status, :color, :estado)");

		$stmt->bindParam(":status", $datos["status"], PDO::PARAM_STR);
		$stmt->bindParam(":color", $datos["color"], PDO::PARAM_STR);
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
	static public function mdlEditarStatus($tabla, $datos){
	
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET status = :status, color = :color WHERE id = :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":status", $datos["status"], PDO::PARAM_STR);
		$stmt->bindParam(":color", $datos["color"], PDO::PARAM_STR);

		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}

		$stmt -> close();
		$stmt = null;
	}

	/* Actualizar - CORREGIDO CON LISTA BLANCA */
	static public function mdlActualizarStatus($tabla, $item1, $valor1, $item2, $valor2){

		// LISTA BLANCA PARA PREVENIR INYECCIÓN SQL
		$tablasPermitidas = ['status', 'coordinacion', 'documento', 'entes', 'item', 'medio', 'prioridad', 'prueba', 'servicios', 'ticket', 'ticketcoordinacion', 'ticketservicios', 'ticketstatus', 'ticketusuario', 'tipodocs', 'usuarios'];
		$columnasPermitidas = ['id', 'estado', 'status', 'color', 'coordinacion', 'entes', 'documento', 'item', 'medio', 'prioridad', 'prueba', 'servicios', 'ticket', 'ticketcoordinacion', 'ticketservicios', 'ticketstatus', 'ticketusuario', 'tipodocs', 'id_tipodocs', 'fecha', 'emision', 'remitente', 'destinatario', 'asunto', 'adjunto', 'id_ticket', 'finalizado', 'usuario', 'nombre', 'apellido', 'id_coordinacion', 'password', 'perfil', 'foto', 'ultimo_login'];

		if (!in_array($tabla, $tablasPermitidas)) {
			error_log("Intento de inyección SQL detectado en mdlActualizarStatus: Tabla no permitida - " . $tabla);
			return "error";
		}
		if (!in_array($item1, $columnasPermitidas) || !in_array($item2, $columnasPermitidas)) {
			error_log("Intento de inyección SQL detectado en mdlActualizarStatus: Columna no permitida - " . $item1 . ", " . $item2);
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
	static public function mdlBorrarStatus($tabla, $datos){

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