<?php

require_once "conexion.php";

class ModeloTicketcoordinacion{

	/* Mostrar */
	static public function mdlMostrarTicketcoordinacion($tabla, $ticketcoordinacion, $valor){

		// LISTA BLANCA PARA LA TABLA
		$tablasPermitidas = ['ticketcoordinacion', 'coordinacion', 'documento', 'entes', 'item', 'medio', 'prioridad', 'prueba', 'servicios', 'status', 'ticket', 'ticketservicios', 'ticketstatus', 'ticketusuario', 'tipodocs', 'usuarios'];
		if (!in_array($tabla, $tablasPermitidas)) {
			error_log("Intento de inyección SQL detectado en mdlMostrarTicketcoordinacion: Tabla no permitida - " . $tabla);
			return [];
		}

		if($ticketcoordinacion != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $ticketcoordinacion = :$ticketcoordinacion");

			$stmt -> bindParam(":".$ticketcoordinacion, $valor, PDO::PARAM_STR);

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
	static public function mdlCrearTicketcoordinacion($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_ticket, id_coordinacion) VALUES (:id_ticket, :id_coordinacion)");
	
		$stmt->bindParam(":id_ticket", $datos["id_ticket"], PDO::PARAM_STR);
		$stmt->bindParam(":id_coordinacion", $datos["id_coordinacion"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";	
		}else{
			return "error";
		}

		$stmt->close();
		$stmt = null;
	}

	/* Editar */
	static public function mdlEditarTicketcoordinacion($tabla, $datos){
	
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET ticketcoordinacion = :ticketcoordinacion WHERE id = :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":ticketcoordinacion", $datos["ticketcoordinacion"], PDO::PARAM_STR);

		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}

		$stmt -> close();
		$stmt = null;
	}

	/* Actualizar - CORREGIDO CON LISTA BLANCA */
	static public function mdlActualizarTicketcoordinacion($tabla, $ticketcoordinacion1, $valor1, $ticketcoordinacion2, $valor2){

		// LISTA BLANCA PARA PREVENIR INYECCIÓN SQL
		$tablasPermitidas = ['ticketcoordinacion', 'coordinacion', 'documento', 'entes', 'item', 'medio', 'prioridad', 'prueba', 'servicios', 'status', 'ticket', 'ticketservicios', 'ticketstatus', 'ticketusuario', 'tipodocs', 'usuarios'];
		$columnasPermitidas = ['id', 'estado', 'id_ticket', 'id_coordinacion', 'coordinacion', 'ticketcoordinacion'];

		if (!in_array($tabla, $tablasPermitidas)) {
			error_log("Intento de inyección SQL detectado en mdlActualizarTicketcoordinacion: Tabla no permitida - " . $tabla);
			return "error";
		}
		if (!in_array($ticketcoordinacion1, $columnasPermitidas) || !in_array($ticketcoordinacion2, $columnasPermitidas)) {
			error_log("Intento de inyección SQL detectado en mdlActualizarTicketcoordinacion: Columna no permitida - " . $ticketcoordinacion1 . ", " . $ticketcoordinacion2);
			return "error";
		}

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $ticketcoordinacion1 = :$ticketcoordinacion1 WHERE $ticketcoordinacion2 = :$ticketcoordinacion2");

		$stmt -> bindParam(":".$ticketcoordinacion1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$ticketcoordinacion2, $valor2, PDO::PARAM_STR);

		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}

		$stmt -> close();
		$stmt = null;
	}

	/* Borrar */
	static public function mdlBorrarTicketcoordinacion($tabla, $datos){

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