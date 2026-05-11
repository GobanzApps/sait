<?php

require_once "conexion.php";

class ModeloUsuarios{

	/*=============================================
	MOSTRAR USUARIOS - CORREGIDO CON LISTA BLANCA
	=============================================*/

	static public function mdlMostrarUsuarios($tabla, $item, $valor){

		// LISTA BLANCA PARA LA TABLA
		$tablasPermitidas = ['usuarios', 'coordinacion', 'documento', 'entes', 'item', 'medio', 'prioridad', 'prueba', 'servicios', 'status', 'ticket', 'ticketcoordinacion', 'ticketservicios', 'ticketstatus', 'ticketusuario', 'tipodocs'];
		if (!in_array($tabla, $tablasPermitidas)) {
			error_log("Intento de inyección SQL detectado en mdlMostrarUsuarios: Tabla no permitida - " . $tabla);
			return [];
		}

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT u.*, 
				c1.coordinacion as nombre_coordinacion,
				c2.coordinacion as nombre_apoyo
				FROM $tabla u
				LEFT JOIN coordinacion c1 ON u.id_coordinacion = c1.id
				LEFT JOIN coordinacion c2 ON u.id_apoyo = c2.id");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}
		

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	REGISTRO DE USUARIO
	=============================================*/

	static public function mdlIngresarUsuario($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(usuario, nombre, apellido, id_coordinacion, id_apoyo, estado, password, perfil, foto) 
			VALUES (:usuario, :nombre, :apellido, :id_coordinacion, :id_apoyo, :estado, :password, :perfil, :foto)");

		$stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
		$stmt->bindParam(":id_coordinacion", $datos["id_coordinacion"], PDO::PARAM_STR);
		$stmt->bindParam(":id_apoyo", $datos["id_apoyo"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt->bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
		$stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";    
		}else{
			return "error";
		}

		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	EDITAR USUARIO
	=============================================*/

	static public function mdlEditarUsuario($tabla, $datos){
	
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, apellido = :apellido, id_coordinacion = :id_coordinacion, id_apoyo = :id_apoyo, password = :password, perfil = :perfil, foto = :foto WHERE usuario = :usuario");

		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_coordinacion", $datos["id_coordinacion"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_apoyo", $datos["id_apoyo"], PDO::PARAM_STR);
		$stmt -> bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt -> bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
		$stmt -> bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
		$stmt -> bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);

		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";	
		}

		$stmt -> close();
		$stmt = null;
	}

	/*=============================================
	ACTUALIZAR USUARIO - CORREGIDO CON LISTA BLANCA
	=============================================*/

	static public function mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2){

		// LISTA BLANCA PARA PREVENIR INYECCIÓN SQL
		$tablasPermitidas = ['usuarios', 'coordinacion', 'documento', 'entes', 'item', 'medio', 'prioridad', 'prueba', 'servicios', 'status', 'ticket', 'ticketcoordinacion', 'ticketservicios', 'ticketstatus', 'ticketusuario', 'tipodocs'];
		$columnasPermitidas = ['id', 'estado', 'usuario', 'nombre', 'apellido', 'id_coordinacion', 'id_apoyo', 'password', 'perfil', 'foto', 'ultimo_login'];

		if (!in_array($tabla, $tablasPermitidas)) {
			error_log("Intento de inyección SQL detectado en mdlActualizarUsuario: Tabla no permitida - " . $tabla);
			return "error";
		}
		if (!in_array($item1, $columnasPermitidas) || !in_array($item2, $columnasPermitidas)) {
			error_log("Intento de inyección SQL detectado en mdlActualizarUsuario: Columna no permitida - " . $item1 . ", " . $item2);
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

	/*=============================================
	BORRAR USUARIO
	=============================================*/

	static public function mdlBorrarUsuario($tabla, $datos){

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