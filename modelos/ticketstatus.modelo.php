<?php

require_once "conexion.php";

class ModeloTicketstatus{

	/* Mostrar */
	static public function mdlMostrarTicketstatus($tabla, $ticketstatus, $valor){

		// LISTA BLANCA PARA LA TABLA
		$tablasPermitidas = ['ticketstatus', 'coordinacion', 'documento', 'entes', 'item', 'medio', 'prioridad', 'prueba', 'servicios', 'status', 'ticket', 'ticketcoordinacion', 'ticketservicios', 'ticketusuario', 'tipodocs', 'usuarios'];
		if (!in_array($tabla, $tablasPermitidas)) {
			error_log("Intento de inyección SQL detectado en mdlMostrarTicketstatus: Tabla no permitida - " . $tabla);
			return [];
		}

		if($ticketstatus != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $ticketstatus = :$ticketstatus");

			$stmt -> bindParam(":".$ticketstatus, $valor, PDO::PARAM_STR);

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
	static public function mdlCrearTicketstatus($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_ticket, id_status) VALUES (:id_ticket, :id_status)");
	
		$stmt->bindParam(":id_ticket", $datos["id_ticket"], PDO::PARAM_STR);
		$stmt->bindParam(":id_status", $datos["id_status"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";	
		}else{
			return "error";
		}

		$stmt->close();
		$stmt = null;
	}

	/* Editar */
	static public function mdlEditarTicketstatus($tabla, $datos){
	
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET ticketstatus = :ticketstatus WHERE id = :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":ticketstatus", $datos["ticketstatus"], PDO::PARAM_STR);

		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}

		$stmt -> close();
		$stmt = null;
	}

	/* Actualizar - CORREGIDO CON LISTA BLANCA */
	static public function mdlActualizarTicketstatus($tabla, $ticketstatus1, $valor1, $ticketstatus2, $valor2){

		// LISTA BLANCA PARA PREVENIR INYECCIÓN SQL
		$tablasPermitidas = ['ticketstatus', 'coordinacion', 'documento', 'entes', 'item', 'medio', 'prioridad', 'prueba', 'servicios', 'status', 'ticket', 'ticketcoordinacion', 'ticketservicios', 'ticketusuario', 'tipodocs', 'usuarios'];
		$columnasPermitidas = ['id', 'estado', 'id_ticket', 'id_status', 'ticketstatus'];

		if (!in_array($tabla, $tablasPermitidas)) {
			error_log("Intento de inyección SQL detectado en mdlActualizarTicketstatus: Tabla no permitida - " . $tabla);
			return "error";
		}
		if (!in_array($ticketstatus1, $columnasPermitidas) || !in_array($ticketstatus2, $columnasPermitidas)) {
			error_log("Intento de inyección SQL detectado en mdlActualizarTicketstatus: Columna no permitida - " . $ticketstatus1 . ", " . $ticketstatus2);
			return "error";
		}

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $ticketstatus1 = :$ticketstatus1 WHERE $ticketstatus2 = :$ticketstatus2");

		$stmt -> bindParam(":".$ticketstatus1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$ticketstatus2, $valor2, PDO::PARAM_STR);

		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}

		$stmt -> close();
		$stmt = null;
	}

	/* Borrar */
	static public function mdlBorrarTicketstatus($tabla, $datos){

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