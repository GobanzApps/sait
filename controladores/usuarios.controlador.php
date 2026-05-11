<?php

class ControladorUsuarios{

	/*=============================================
	INGRESO DE USUARIO - CORREGIDO: Usa password_verify
	=============================================*/

	static public function ctrIngresoUsuario(){

		if(isset($_POST["ingUsuario"])){

			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"])){

				$tabla = "usuarios";

				$item = "usuario";
				$valor = $_POST["ingUsuario"];

				$respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);

				// Verificar usuario y contraseña con password_verify
				if($respuesta && $respuesta["usuario"] == $_POST["ingUsuario"] && password_verify($_POST["ingPassword"], $respuesta["password"])){

					if($respuesta["estado"] == 1){

						$_SESSION["iniciarSesion"] = "ok";
						$_SESSION["id"] = $respuesta["id"];
						$_SESSION["nombre"] = $respuesta["nombre"];
						$_SESSION["apellido"] = $respuesta["apellido"];
						$_SESSION["id_coordinacion"] = $respuesta["id_coordinacion"];
						$_SESSION["id_apoyo"] = $respuesta["id_apoyo"];
						$_SESSION["usuario"] = $respuesta["usuario"];
						$_SESSION["foto"] = $respuesta["foto"];
						$_SESSION["perfil"] = $respuesta["perfil"];

						/*=============================================
						REGISTRAR FECHA PARA SABER EL ÚLTIMO LOGIN
						=============================================*/

						date_default_timezone_set('America/Bogota');

						$fecha = date('Y-m-d');
						$hora = date('H:i:s');

						$fechaActual = $fecha.' '.$hora;

						$item1 = "ultimo_login";
						$valor1 = $fechaActual;

						$item2 = "id";
						$valor2 = $respuesta["id"];

						$ultimoLogin = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);

						if($ultimoLogin == "ok"){

							echo '<script>
								window.location = "inicio";
							</script>';

						}				
						
					}else{

						echo '<br>
							<div class="alert alert-danger">El usuario aún no está activado</div>';

					}		

				}else{

					echo '<br><div class="alert alert-danger">Error al ingresar, vuelve a intentarlo</div>';

				}

			}	

		}

	}

	/*=============================================
	REGISTRO DE USUARIO - CORREGIDO: Usa password_hash
	=============================================*/

	static public function ctrCrearUsuario(){

		if(isset($_POST["nuevoUsuario"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ .]+$/', $_POST["nuevoNombre"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoUsuario"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoPassword"])){

				/*=============================================
				VALIDAR IMAGEN
				=============================================*/

				$ruta = "";

				if(isset($_FILES["nuevaFoto"]["tmp_name"]) && !empty($_FILES["nuevaFoto"]["tmp_name"])){

					// Validar tipo de imagen real
					$finfo = finfo_open(FILEINFO_MIME_TYPE);
					$tipoMimeReal = finfo_file($finfo, $_FILES["nuevaFoto"]["tmp_name"]);
					finfo_close($finfo);
					
					$tiposPermitidos = ['image/jpeg', 'image/png'];
					if (!in_array($tipoMimeReal, $tiposPermitidos)) {
						echo '<script>
						swal({
							type: "error",
							title: "¡Solo se permiten imágenes JPG o PNG!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){
								window.location = "usuarios";
							}
						});
						</script>';
						return;
					}

					list($ancho, $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);

					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/

					$directorio = "vistas/img/usuarios/".$_POST["nuevoUsuario"];

					/*=============================================
					PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
					=============================================*/

					if(!empty($_POST["fotoActual"])){

						unlink($_POST["fotoActual"]);

					}else{

						if(!file_exists($directorio)){
							mkdir($directorio, 0755, true);
						}

					}	

					$user = $_POST["nuevoUsuario"];

					$origen = $_FILES["nuevaFoto"]["tmp_name"];

					$today = date('ymd-His');

					$mm = "$today$user";

					$jpeg = ".jpeg";
					$png = ".png";

					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

					if($tipoMimeReal == "image/jpeg"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						move_uploaded_file($origen, $directorio . "/" . $mm . $jpeg);

						$ruta = $directorio . "/" . $mm . $jpeg;
						
					}

					if($tipoMimeReal == "image/png"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						move_uploaded_file($origen, $directorio . "/" . $mm . $png);

						$ruta = $directorio . "/" . $mm . $png;

					}

				}

				$tabla = "usuarios";

				// Usar password_hash en lugar de crypt
				$encriptar = password_hash($_POST["nuevoPassword"], PASSWORD_DEFAULT);

				// Obtener id_apoyo (puede ser NULL si no se selecciona)
				$id_apoyo = isset($_POST["nuevoId_apoyo"]) && $_POST["nuevoId_apoyo"] != "" && $_POST["nuevoId_apoyo"] != "0" ? $_POST["nuevoId_apoyo"] : null;

				$datos = array(
					"nombre" => $_POST["nuevoNombre"],
					"usuario" => $_POST["nuevoUsuario"],
					"apellido" => $_POST["nuevoApellido"],
					"estado" => "1",
					"id_coordinacion" => $_POST["nuevoId_coordinacion"],
					"id_apoyo" => $id_apoyo,
					"password" => $encriptar,
					"perfil" => $_POST["nuevoPerfil"],
					"foto" => $ruta
				);

				$respuesta = ModeloUsuarios::mdlIngresarUsuario($tabla, $datos);
			
				if($respuesta == "ok"){

					echo '<script>
					swal({
						type: "success",
						title: "¡El usuario ha sido guardado correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
					}).then(function(result){
						if(result.value){
							window.location = "usuarios";
						}
					});
					</script>';

				}	

			}else{

				echo '<script>
				swal({
					type: "error",
					title: "¡El usuario no puede ir vacío o llevar caracteres especiales!",
					showConfirmButton: true,
					confirmButtonText: "Cerrar"
				}).then(function(result){
					if(result.value){
						window.location = "usuarios";
					}
				});
				</script>';

			}

		}

	}

	/*=============================================
	EDITAR USUARIO - CORREGIDO: Usa password_hash para nueva contraseña
	=============================================*/

	static public function ctrEditarUsuario(){

		if(isset($_POST["editarUsuario"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ .]+$/', $_POST["editarNombre"])){

				/*=============================================
				VALIDAR IMAGEN
				=============================================*/

				$ruta = $_POST["fotoActual"];

				if(isset($_FILES["editarFoto"]["tmp_name"]) && !empty($_FILES["editarFoto"]["tmp_name"])){

					// Validar tipo de imagen real
					$finfo = finfo_open(FILEINFO_MIME_TYPE);
					$tipoMimeReal = finfo_file($finfo, $_FILES["editarFoto"]["tmp_name"]);
					finfo_close($finfo);
					
					$tiposPermitidos = ['image/jpeg', 'image/png'];
					if (!in_array($tipoMimeReal, $tiposPermitidos)) {
						echo '<script>
						swal({
							type: "error",
							title: "¡Solo se permiten imágenes JPG o PNG!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){
								window.location = "usuarios";
							}
						});
						</script>';
						return;
					}

					list($ancho, $alto) = getimagesize($_FILES["editarFoto"]["tmp_name"]);

					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/

					$directorio = "vistas/img/usuarios/".$_POST["editarUsuario"];

					/*=============================================
					PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
					=============================================*/

					if(!empty($_POST["fotoActual"])){

						unlink($_POST["fotoActual"]);

					}else{

						if(!file_exists($directorio)){
							mkdir($directorio, 0755, true);
						}

					}	

					$user = $_POST["editarUsuario"];

					$origen = $_FILES["editarFoto"]["tmp_name"];

					$today = date('ymd-His');

					$mm = "$today$user";

					$jpeg = ".jpeg";
					$png = ".png";

					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

					if($tipoMimeReal == "image/jpeg"){

						move_uploaded_file($origen, $directorio . "/" . $mm . $jpeg);

						$ruta = $directorio . "/" . $mm . $jpeg;
						
					}

					if($tipoMimeReal == "image/png"){

						move_uploaded_file($origen, $directorio . "/" . $mm . $png);

						$ruta = $directorio . "/" . $mm . $png;

					}

				}

				$tabla = "usuarios";

				if($_POST["editarPassword"] != ""){

					if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarPassword"])){

						$encriptar = password_hash($_POST["editarPassword"], PASSWORD_DEFAULT);

					}else{

						echo'<script>
								swal({
									  type: "error",
									  title: "¡La contraseña no puede ir vacía o llevar caracteres especiales!",
									  showConfirmButton: true,
									  confirmButtonText: "Cerrar"
									  }).then(function(result) {
										if (result.value) {
										window.location = "usuarios";
										}
									})
						  	</script>';
						  	return;

					}

				}else{

					$encriptar = $_POST["passwordActual"];

				}

				// Obtener id_apoyo (puede ser NULL si no se selecciona)
				$id_apoyo = isset($_POST["editarId_apoyo"]) && $_POST["editarId_apoyo"] != "" && $_POST["editarId_apoyo"] != "0" ? $_POST["editarId_apoyo"] : null;

				$datos = array(
					"nombre" => $_POST["editarNombre"],
					"usuario" => $_POST["editarUsuario"],
					"apellido" => $_POST["editarApellido"],
					"id_coordinacion" => $_POST["editarId_coordinacion"],
					"id_apoyo" => $id_apoyo,
					"password" => $encriptar,
					"perfil" => $_POST["editarPerfil"],
					"foto" => $ruta
				);

				$respuesta = ModeloUsuarios::mdlEditarUsuario($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>
					swal({
						  type: "success",
						  title: "El usuario ha sido editado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
									if (result.value) {
									window.location = "usuarios";
									}
								})
					</script>';

				}

			}else{

				echo'<script>
				swal({
					  type: "error",
					  title: "¡El nombre no puede ir vacío o llevar caracteres especiales!",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result) {
						if (result.value) {
						window.location = "usuarios";
						}
					})
			  	</script>';

			}

		}

	}

	/*=============================================
	MOSTRAR USUARIO
	=============================================*/

	static public function ctrMostrarUsuarios($item, $valor){

		$tabla = "usuarios";

		$respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);

		return $respuesta;
	}

	/*=============================================
	BORRAR USUARIO
	=============================================*/

	static public function ctrBorrarUsuario(){

		if(isset($_GET["idUsuario"])){

			$tabla ="usuarios";
			$datos = $_GET["idUsuario"];

			if($_GET["fotoUsuario"] != ""){

				unlink($_GET["fotoUsuario"]);
				$dirUsuario = 'vistas/img/usuarios/'.$_GET["usuario"];
				if(is_dir($dirUsuario)){
					rmdir($dirUsuario);
				}

			}

			$respuesta = ModeloUsuarios::mdlBorrarUsuario($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>
				swal({
					  type: "success",
					  title: "El usuario ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then(function(result) {
								if (result.value) {
								window.location = "usuarios";
								}
							})
				</script>';

			}		

		}

	}

	/*=============================================
	CAMBIAR CONTRASEÑA DEL USUARIO LOGUEADO
	=============================================*/

	static public function ctrCambiarPassword($idUsuario, $passwordActual, $nuevaPassword, $confirmarPassword){
		
		// Validar que la nueva contraseña y confirmación coincidan
		if($nuevaPassword !== $confirmarPassword){
			return array(
				"status" => "error",
				"mensaje" => "La nueva contraseña y la confirmación no coinciden"
			);
		}
		
		// Validar que la nueva contraseña tenga al menos 4 caracteres
		if(strlen($nuevaPassword) < 4){
			return array(
				"status" => "error",
				"mensaje" => "La nueva contraseña debe tener al menos 4 caracteres"
			);
		}
		
		// Validar que la nueva contraseña solo tenga letras y números
		if(!preg_match('/^[a-zA-Z0-9]+$/', $nuevaPassword)){
			return array(
				"status" => "error",
				"mensaje" => "La contraseña solo puede contener letras y números"
			);
		}
		
		// Obtener los datos del usuario actual
		$usuario = ModeloUsuarios::mdlMostrarUsuarios("usuarios", "id", $idUsuario);
		
		if(!$usuario){
			return array(
				"status" => "error",
				"mensaje" => "Usuario no encontrado"
			);
		}
		
		// Verificar que la contraseña actual sea correcta usando password_verify
		if(!password_verify($passwordActual, $usuario["password"])){
			return array(
				"status" => "error",
				"mensaje" => "La contraseña actual es incorrecta"
			);
		}
		
		// Encriptar la nueva contraseña
		$nuevaPasswordEncriptada = password_hash($nuevaPassword, PASSWORD_DEFAULT);
		
		// Actualizar la contraseña en la base de datos
		$tabla = "usuarios";
		$item1 = "password";
		$valor1 = $nuevaPasswordEncriptada;
		$item2 = "id";
		$valor2 = $idUsuario;
		
		$respuesta = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);
		
		if($respuesta == "ok"){
			return array(
				"status" => "success",
				"mensaje" => "Contraseña actualizada correctamente"
			);
		}else{
			return array(
				"status" => "error",
				"mensaje" => "Error al actualizar la contraseña"
			);
		}
	}

}
?>