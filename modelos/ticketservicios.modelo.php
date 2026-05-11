<?php

require_once "conexion.php";

class ModeloTicketservicios{

	/* Mostrar Ticketservicios */
	static public function MdlMostrarTicketservicios($tabla, $item, $valor){

		// LISTA BLANCA PARA LA TABLA
		$tablasPermitidas = ['ticketservicios', 'coordinacion', 'documento', 'entes', 'item', 'medio', 'prioridad', 'prueba', 'servicios', 'status', 'ticket', 'ticketcoordinacion', 'ticketstatus', 'ticketusuario', 'tipodocs', 'usuarios'];
		if (!in_array($tabla, $tablasPermitidas)) {
			error_log("Intento de inyección SQL detectado en MdlMostrarTicketservicios: Tabla no permitida - " . $tabla);
			return [];
		}

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			// JOIN con servicios, coordinacion e item para traer todos los nombres relacionados
			$stmt = Conexion::conectar()->prepare("SELECT ts.*, 
				s.servicios as nombre_servicio,
				s.id_coordinacion,
				c.coordinacion as nombre_coordinacion,
				i.item as nombre_item
				FROM ticketservicios ts
				LEFT JOIN servicios s ON ts.id_servicios = s.id
				LEFT JOIN coordinacion c ON s.id_coordinacion = c.id
				LEFT JOIN item i ON ts.id_item = i.id
				ORDER BY ts.fecha DESC, ts.id DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();
		$stmt = null;
	}

static public function mdlCrearTicketservicios($tabla, $datos){
    $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_ticket, id_servicios, id_item, descripcion, cantidad, fecha) VALUES (:id_ticket, :id_servicios, :id_item, :descripcion, :cantidad, :fecha)");

    $stmt -> bindParam(":id_ticket", $datos["id_ticket"], PDO::PARAM_STR);
    $stmt -> bindParam(":id_servicios", $datos["id_servicios"], PDO::PARAM_INT);
    $stmt -> bindParam(":id_item", $datos["id_item"], PDO::PARAM_INT);
    $stmt -> bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
    $stmt -> bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_INT);
    $stmt -> bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);

    if($stmt -> execute()){
        return "ok";
    }else{
        return "error";
    }

    $stmt -> close();
    $stmt = null;
}

	/* Editar Ticketservicios */
	static public function mdlEditarTicketservicios($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_ticket = :id_ticket, id_servicios = :id_servicios, id_item = :id_item, cantidad = :cantidad, fecha = :fecha WHERE id = :id");

		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt -> bindParam(":id_ticket", $datos["id_ticket"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_servicios", $datos["id_servicios"], PDO::PARAM_INT);
		$stmt -> bindParam(":id_item", $datos["id_item"], PDO::PARAM_INT);
		$stmt -> bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_INT);
		$stmt -> bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);

		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";
		}

		$stmt -> close();
		$stmt = null;
	}

	/* Actualizar Ticketservicios (estado) - CORREGIDO CON LISTA BLANCA */
	static public function mdlActualizarTicketservicios($tabla, $item1, $valor1, $item2, $valor2){

		// LISTA BLANCA PARA PREVENIR INYECCIÓN SQL
		$tablasPermitidas = ['ticketservicios', 'coordinacion', 'documento', 'entes', 'item', 'medio', 'prioridad', 'prueba', 'servicios', 'status', 'ticket', 'ticketcoordinacion', 'ticketstatus', 'ticketusuario', 'tipodocs', 'usuarios'];
		$columnasPermitidas = ['id', 'estado', 'id_ticket', 'id_servicios', 'id_item', 'cantidad', 'fecha'];

		if (!in_array($tabla, $tablasPermitidas)) {
			error_log("Intento de inyección SQL detectado en mdlActualizarTicketservicios: Tabla no permitida - " . $tabla);
			return "error";
		}
		if (!in_array($item1, $columnasPermitidas) || !in_array($item2, $columnasPermitidas)) {
			error_log("Intento de inyección SQL detectado en mdlActualizarTicketservicios: Columna no permitida - " . $item1 . ", " . $item2);
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

	/* Actualizar Ticketservicios Completo - CORREGIDO CON LISTA BLANCA */
	static public function mdlActualizarTicketserviciosCompleto($tabla, $datos){

		// LISTA BLANCA PARA LA TABLA
		$tablasPermitidas = ['ticketservicios', 'coordinacion', 'documento', 'entes', 'item', 'medio', 'prioridad', 'prueba', 'servicios', 'status', 'ticket', 'ticketcoordinacion', 'ticketstatus', 'ticketusuario', 'tipodocs', 'usuarios'];
		if (!in_array($tabla, $tablasPermitidas)) {
			error_log("Intento de inyección SQL detectado en mdlActualizarTicketserviciosCompleto: Tabla no permitida - " . $tabla);
			return "error";
		}

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_servicios = :id_servicios, id_item = :id_item, descripcion = :descripcion, cantidad = :cantidad WHERE id = :id");

		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt -> bindParam(":id_servicios", $datos["id_servicios"], PDO::PARAM_INT);
		$stmt -> bindParam(":id_item", $datos["id_item"], PDO::PARAM_INT);
		$stmt -> bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt -> bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_INT);

		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";
		}

		$stmt -> close();
		$stmt = null;
	}

	/* Borrar Ticketservicios */
	static public function mdlBorrarTicketservicios($tabla, $datos){

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