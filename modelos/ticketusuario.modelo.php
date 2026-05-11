<?php

require_once "conexion.php";

class ModeloTicketusuario{

	/* Mostrar */
	static public function mdlMostrarTicketusuario($tabla, $ticketusuario, $valor){

		// LISTA BLANCA PARA LA TABLA
		$tablasPermitidas = ['ticketusuario', 'coordinacion', 'documento', 'entes', 'item', 'medio', 'prioridad', 'prueba', 'servicios', 'status', 'ticket', 'ticketcoordinacion', 'ticketservicios', 'ticketstatus', 'tipodocs', 'usuarios'];
		if (!in_array($tabla, $tablasPermitidas)) {
			error_log("Intento de inyección SQL detectado en mdlMostrarTicketusuario: Tabla no permitida - " . $tabla);
			return [];
		}

		if($ticketusuario != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $ticketusuario = :$ticketusuario");

			$stmt -> bindParam(":".$ticketusuario, $valor, PDO::PARAM_STR);

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
	static public function mdlCrearTicketusuario($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_ticket, id_usuario) VALUES (:id_ticket, :id_usuario)");
	
		$stmt->bindParam(":id_ticket", $datos["id_ticket"], PDO::PARAM_STR);
		$stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";	
		}else{
			return "error";
		}

		$stmt->close();
		$stmt = null;
	}

	/* Editar */
	static public function mdlEditarTicketusuario($tabla, $datos){
	
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET ticketusuario = :ticketusuario WHERE id = :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":ticketusuario", $datos["ticketusuario"], PDO::PARAM_STR);

		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}

		$stmt -> close();
		$stmt = null;
	}

	/* Actualizar - CORREGIDO CON LISTA BLANCA */
	static public function mdlActualizarTicketusuario($tabla, $ticketusuario1, $valor1, $ticketusuario2, $valor2){

		// LISTA BLANCA PARA PREVENIR INYECCIÓN SQL
		$tablasPermitidas = ['ticketusuario', 'coordinacion', 'documento', 'entes', 'item', 'medio', 'prioridad', 'prueba', 'servicios', 'status', 'ticket', 'ticketcoordinacion', 'ticketservicios', 'ticketstatus', 'tipodocs', 'usuarios'];
		$columnasPermitidas = ['id', 'estado', 'id_ticket', 'id_usuario', 'ticketusuario'];

		if (!in_array($tabla, $tablasPermitidas)) {
			error_log("Intento de inyección SQL detectado en mdlActualizarTicketusuario: Tabla no permitida - " . $tabla);
			return "error";
		}
		if (!in_array($ticketusuario1, $columnasPermitidas) || !in_array($ticketusuario2, $columnasPermitidas)) {
			error_log("Intento de inyección SQL detectado en mdlActualizarTicketusuario: Columna no permitida - " . $ticketusuario1 . ", " . $ticketusuario2);
			return "error";
		}

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $ticketusuario1 = :$ticketusuario1 WHERE $ticketusuario2 = :$ticketusuario2");

		$stmt -> bindParam(":".$ticketusuario1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$ticketusuario2, $valor2, PDO::PARAM_STR);

		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}

		$stmt -> close();
		$stmt = null;
	}

	/* Borrar */
	static public function mdlBorrarTicketusuario($tabla, $datos){

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