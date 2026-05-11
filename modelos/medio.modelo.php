<?php

require_once "conexion.php";

class ModeloMedio{

	/* Mostrar */
	static public function mdlMostrarMedio($tabla, $item, $valor){

		// LISTA BLANCA PARA LA TABLA
		$tablasPermitidas = ['medio', 'coordinacion', 'documento', 'entes', 'item', 'prioridad', 'prueba', 'servicios', 'status', 'ticket', 'ticketcoordinacion', 'ticketservicios', 'ticketstatus', 'ticketusuario', 'tipodocs', 'usuarios'];
		if (!in_array($tabla, $tablasPermitidas)) {
			error_log("Intento de inyección SQL detectado en mdlMostrarMedio: Tabla no permitida - " . $tabla);
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
	static public function mdlCrearMedio($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(medio, color, estado) VALUES (:medio, :color, :estado)");

		$stmt->bindParam(":medio", $datos["medio"], PDO::PARAM_STR);
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
	static public function mdlEditarMedio($tabla, $datos){
	
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET medio = :medio, color = :color WHERE id = :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":medio", $datos["medio"], PDO::PARAM_STR);
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
	static public function mdlActualizarMedio($tabla, $item1, $valor1, $item2, $valor2){

		// LISTA BLANCA PARA PREVENIR INYECCIÓN SQL
		$tablasPermitidas = ['medio', 'coordinacion', 'documento', 'entes', 'item', 'prioridad', 'prueba', 'servicios', 'status', 'ticket', 'ticketcoordinacion', 'ticketservicios', 'ticketstatus', 'ticketusuario', 'tipodocs', 'usuarios'];
		$columnasPermitidas = ['id', 'estado', 'medio', 'color', 'coordinacion', 'entes', 'documento', 'item', 'prioridad', 'prueba', 'servicios', 'status', 'ticket', 'ticketcoordinacion', 'ticketservicios', 'ticketstatus', 'ticketusuario', 'tipodocs', 'id_tipodocs', 'fecha', 'emision', 'remitente', 'destinatario', 'asunto', 'adjunto', 'id_ticket', 'finalizado', 'usuario', 'nombre', 'apellido', 'id_coordinacion', 'password', 'perfil', 'foto', 'ultimo_login'];

		if (!in_array($tabla, $tablasPermitidas)) {
			error_log("Intento de inyección SQL detectado en mdlActualizarMedio: Tabla no permitida - " . $tabla);
			return "error";
		}
		if (!in_array($item1, $columnasPermitidas) || !in_array($item2, $columnasPermitidas)) {
			error_log("Intento de inyección SQL detectado en mdlActualizarMedio: Columna no permitida - " . $item1 . ", " . $item2);
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
	static public function mdlBorrarMedio($tabla, $datos){

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