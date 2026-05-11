<?php

require_once "conexion.php";

class ModeloServicios{

	/* Mostrar Servicios */
	static public function MdlMostrarServicios($tabla, $item, $valor){

		// LISTA BLANCA PARA LA TABLA
		$tablasPermitidas = ['servicios', 'coordinacion', 'documento', 'entes', 'item', 'medio', 'prioridad', 'prueba', 'status', 'ticket', 'ticketcoordinacion', 'ticketservicios', 'ticketstatus', 'ticketusuario', 'tipodocs', 'usuarios'];
		if (!in_array($tabla, $tablasPermitidas)) {
			error_log("Intento de inyección SQL detectado en MdlMostrarServicios: Tabla no permitida - " . $tabla);
			return [];
		}

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT s.*, c.coordinacion as nombre_coordinacion 
				FROM $tabla s
				LEFT JOIN coordinacion c ON s.id_coordinacion = c.id 
				WHERE s.$item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT s.*, c.coordinacion as nombre_coordinacion 
				FROM $tabla s
				LEFT JOIN coordinacion c ON s.id_coordinacion = c.id");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();
		$stmt = null;
	}

	/* Crear Servicios */
	static public function mdlCrearServicios($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(servicios, id_coordinacion, estado) VALUES (:servicios, :id_coordinacion, :estado)");

		$stmt -> bindParam(":servicios", $datos["servicios"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_coordinacion", $datos["id_coordinacion"], PDO::PARAM_INT);
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_INT);

		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";
		}

		$stmt -> close();
		$stmt = null;
	}

	/* Editar Servicios */
	static public function mdlEditarServicios($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET servicios = :servicios, id_coordinacion = :id_coordinacion WHERE id = :id");

		$stmt -> bindParam(":servicios", $datos["servicios"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_coordinacion", $datos["id_coordinacion"], PDO::PARAM_INT);
		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);

		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";
		}

		$stmt -> close();
		$stmt = null;
	}

	/* Actualizar Servicios (estado) - CORREGIDO CON LISTA BLANCA */
	static public function mdlActualizarServicios($tabla, $item1, $valor1, $item2, $valor2){

		// LISTA BLANCA PARA PREVENIR INYECCIÓN SQL
		$tablasPermitidas = ['servicios', 'coordinacion', 'documento', 'entes', 'item', 'medio', 'prioridad', 'prueba', 'status', 'ticket', 'ticketcoordinacion', 'ticketservicios', 'ticketstatus', 'ticketusuario', 'tipodocs', 'usuarios'];
		$columnasPermitidas = ['id', 'estado', 'servicios', 'id_coordinacion', 'coordinacion', 'entes', 'documento', 'item', 'medio', 'prioridad', 'prueba', 'status', 'ticket', 'ticketcoordinacion', 'ticketservicios', 'ticketstatus', 'ticketusuario', 'tipodocs', 'id_tipodocs', 'fecha', 'emision', 'remitente', 'destinatario', 'asunto', 'adjunto', 'id_ticket', 'finalizado', 'usuario', 'nombre', 'apellido', 'password', 'perfil', 'foto', 'ultimo_login'];

		if (!in_array($tabla, $tablasPermitidas)) {
			error_log("Intento de inyección SQL detectado en mdlActualizarServicios: Tabla no permitida - " . $tabla);
			return "error";
		}
		if (!in_array($item1, $columnasPermitidas) || !in_array($item2, $columnasPermitidas)) {
			error_log("Intento de inyección SQL detectado en mdlActualizarServicios: Columna no permitida - " . $item1 . ", " . $item2);
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

	/* Borrar Servicios */
	static public function mdlBorrarServicios($tabla, $datos){

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