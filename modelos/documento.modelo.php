<?php

require_once "conexion.php";

class ModeloDocumento{

	/* Mostrar Documentos */
	static public function mdlMostrarDocumento($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}
		
		$stmt -> close();
		$stmt = null;
	}

	/* Crear Documento */
	static public function mdlCrearDocumento($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(documento, id_tipodocs, fecha, emision, remitente, destinatario, asunto, adjunto, id_ticket, estado) 
			VALUES (:documento, :id_tipodocs, :fecha, :emision, :remitente, :destinatario, :asunto, :adjunto, :id_ticket, :estado)");

		$stmt->bindParam(":documento", $datos["documento"], PDO::PARAM_STR);
		$stmt->bindParam(":id_tipodocs", $datos["id_tipodocs"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":emision", $datos["emision"], PDO::PARAM_STR);
		$stmt->bindParam(":remitente", $datos["remitente"], PDO::PARAM_STR);
		$stmt->bindParam(":destinatario", $datos["destinatario"], PDO::PARAM_STR);
		$stmt->bindParam(":asunto", $datos["asunto"], PDO::PARAM_STR);
		$stmt->bindParam(":adjunto", $datos["adjunto"], PDO::PARAM_STR);
		$stmt->bindParam(":id_ticket", $datos["id_ticket"], PDO::PARAM_INT);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";	

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;
	}

	/* Editar Documento */
	static public function mdlEditarDocumento($tabla, $datos){
	
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET documento = :documento, id_tipodocs = :id_tipodocs, fecha = :fecha, emision = :emision, remitente = :remitente, destinatario = :destinatario, asunto = :asunto, adjunto = :adjunto, id_ticket = :id_ticket WHERE id = :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":documento", $datos["documento"], PDO::PARAM_STR);
		$stmt->bindParam(":id_tipodocs", $datos["id_tipodocs"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":emision", $datos["emision"], PDO::PARAM_STR);
		$stmt->bindParam(":remitente", $datos["remitente"], PDO::PARAM_STR);
		$stmt->bindParam(":destinatario", $datos["destinatario"], PDO::PARAM_STR);
		$stmt->bindParam(":asunto", $datos["asunto"], PDO::PARAM_STR);
		$stmt->bindParam(":adjunto", $datos["adjunto"], PDO::PARAM_STR);
		$stmt->bindParam(":id_ticket", $datos["id_ticket"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();
		$stmt = null;
	}

	/* Actualizar Estado - CORREGIDO CON LISTA BLANCA */
	static public function mdlActualizarDocumento($tabla, $item1, $valor1, $item2, $valor2){

		// LISTA BLANCA PARA PREVENIR INYECCIÓN SQL
		$tablasPermitidas = ['coordinacion', 'documento', 'entes', 'item', 'medio', 'prioridad', 'prueba', 'servicios', 'status', 'ticket', 'ticketcoordinacion', 'ticketservicios', 'ticketstatus', 'ticketusuario', 'tipodocs', 'usuarios'];
		$columnasPermitidas = ['id', 'estado', 'coordinacion', 'entes', 'item', 'medio', 'prioridad', 'prueba', 'servicios', 'status', 'ticket', 'ticketcoordinacion', 'ticketservicios', 'ticketstatus', 'ticketusuario', 'tipodocs', 'documento', 'id_tipodocs', 'fecha', 'emision', 'remitente', 'destinatario', 'asunto', 'adjunto', 'id_ticket', 'finalizado', 'usuario', 'nombre', 'apellido', 'id_coordinacion', 'password', 'perfil', 'foto', 'ultimo_login', 'color'];

		if (!in_array($tabla, $tablasPermitidas)) {
			error_log("Intento de inyección SQL detectado en mdlActualizarDocumento: Tabla no permitida - " . $tabla);
			return "error";
		}
		if (!in_array($item1, $columnasPermitidas) || !in_array($item2, $columnasPermitidas)) {
			error_log("Intento de inyección SQL detectado en mdlActualizarDocumento: Columna no permitida - " . $item1 . ", " . $item2);
			return "error";
		}

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();
		$stmt = null;
	}

	/* Borrar Documento */
	static public function mdlBorrarDocumento($tabla, $datos){

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
?>