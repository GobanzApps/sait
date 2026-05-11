<?php

class ControladorDocumento{

	/* Mostrar Documentos */
	static public function ctrMostrarDocumento($item, $valor){

		$tabla = "documento";
		$respuesta = ModeloDocumento::mdlMostrarDocumento($tabla, $item, $valor);
		return $respuesta;
	}

	/* Crear Documento - CORREGIDO: Validación robusta de archivos */
	static public function ctrCrearDocumento(){

		if(isset($_POST["nuevoDocumento"])){

			if(preg_match('#^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s\+\-\*\.\,/°]+$#', $_POST["nuevoDocumento"]) &&       
			   preg_match('#^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s\+\-\*\.\,/°]+$#', $_POST["nuevoRemitente"]) &&
			   preg_match('#^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s\+\-\*\.\,/°]+$#', $_POST["nuevoDestinatario"]) &&
			   preg_match('#^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s\+\-\*\.\,/°]+$#', $_POST["nuevoAsunto"])){

				$tabla = "documento";

				$rutaAdjunto = "";
				
				// Subir archivo adjunto
				if(isset($_FILES["nuevoAdjunto"]["tmp_name"]) && !empty($_FILES["nuevoAdjunto"]["tmp_name"])){
					
					// VALIDACIÓN ROBUSTA CON MIME REAL
					$finfo = finfo_open(FILEINFO_MIME_TYPE);
					$tipoMimeReal = finfo_file($finfo, $_FILES["nuevoAdjunto"]["tmp_name"]);
					finfo_close($finfo);
					
					// Validar por tipo MIME real
					if($tipoMimeReal !== 'application/pdf'){
						echo '<script>
						swal({
							type: "error",
							title: "¡Solo se permiten archivos PDF válidos!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){
								window.location = "documento";
							}
						});
						</script>';
						return;
					}
					
					// Validar tamaño máximo (10MB = 10485760 bytes)
					if($_FILES["nuevoAdjunto"]["size"] > 10485760){
						echo '<script>
						swal({
							type: "error",
							title: "¡El archivo no debe superar los 10MB!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){
								window.location = "documento";
							}
						});
						</script>';
						return;
					}
					
					$directorio = "vistas/img/documentos/";
					if(!file_exists($directorio)){
						mkdir($directorio, 0755, true);
					}
					
					// Nombre de archivo seguro y único
					$nombreArchivo = bin2hex(random_bytes(16)) . '.pdf';
					$rutaAdjunto = $directorio . $nombreArchivo;
					
					move_uploaded_file($_FILES["nuevoAdjunto"]["tmp_name"], $rutaAdjunto);
				}

				$datos = array(
					"documento" => $_POST["nuevoDocumento"],
					"id_tipodocs" => $_POST["nuevoIdTipodocs"],
					"fecha" => $_POST["nuevoFecha"],
					"emision" => $_POST["nuevoEmision"],
					"remitente" => $_POST["nuevoRemitente"],
					"destinatario" => $_POST["nuevoDestinatario"],
					"asunto" => $_POST["nuevoAsunto"],
					"adjunto" => $rutaAdjunto,
					"id_ticket" => $_POST["nuevoIdTicket"] != "" ? $_POST["nuevoIdTicket"] : null,
					"estado" => 1
				);

				$respuesta = ModeloDocumento::mdlCrearDocumento($tabla, $datos);
			
				if($respuesta == "ok"){

					echo '<script>
					swal({
						type: "success",
						title: "¡Ha sido guardado correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
					}).then(function(result){
						if(result.value){
							window.location = "documento";
						}
					});
					</script>';
				}	

			}else{

				echo '<script>
					swal({
						type: "error",
						title: "¡El Formulario no puede ir vacío o llevar caracteres especiales!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
					}).then(function(result){
						if(result.value){
							window.location = "documento";
						}
					});
				</script>';
			}
		}
	}

	/* Editar Documento - CORREGIDO: Validación robusta de archivos */
	static public function ctrEditarDocumento(){

		if(isset($_POST["editarDocumento"])){

			if(preg_match('#^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s\+\-\*\.\,/°]+$#', $_POST["editarDocumento"]) &&     
			   preg_match('#^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s\+\-\*\.\,/°]+$#', $_POST["editarRemitente"]) &&
			   preg_match('#^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s\+\-\*\.\,/°]+$#', $_POST["editarDestinatario"]) &&
			   preg_match('#^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s\+\-\*\.\,/°]+$#', $_POST["editarAsunto"])){

				$tabla = "documento";
				
				// Obtener el documento actual para saber si tiene adjunto
				$documentoActual = ModeloDocumento::mdlMostrarDocumento($tabla, "id", $_POST["idDocumento"]);
				
				$rutaAdjunto = $documentoActual["adjunto"];
				
				// Subir nuevo archivo adjunto si se seleccionó uno
				if(isset($_FILES["editarAdjunto"]["tmp_name"]) && !empty($_FILES["editarAdjunto"]["tmp_name"])){
					
					// VALIDACIÓN ROBUSTA CON MIME REAL
					$finfo = finfo_open(FILEINFO_MIME_TYPE);
					$tipoMimeReal = finfo_file($finfo, $_FILES["editarAdjunto"]["tmp_name"]);
					finfo_close($finfo);
					
					// Validar por tipo MIME real
					if($tipoMimeReal !== 'application/pdf'){
						echo '<script>
						swal({
							type: "error",
							title: "¡Solo se permiten archivos PDF válidos!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){
								window.location = "documento";
							}
						});
						</script>';
						return;
					}
					
					// Validar tamaño máximo (10MB)
					if($_FILES["editarAdjunto"]["size"] > 10485760){
						echo '<script>
						swal({
							type: "error",
							title: "¡El archivo no debe superar los 10MB!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){
							if(result.value){
								window.location = "documento";
							}
						});
						</script>';
						return;
					}
					
					// Eliminar archivo anterior si existe
					if($rutaAdjunto && file_exists($rutaAdjunto)){
						unlink($rutaAdjunto);
					}
					
					$directorio = "vistas/img/documentos/";
					if(!file_exists($directorio)){
						mkdir($directorio, 0755, true);
					}
					
					// Nombre de archivo seguro y único
					$nombreArchivo = bin2hex(random_bytes(16)) . '.pdf';
					$rutaAdjunto = $directorio . $nombreArchivo;
					
					move_uploaded_file($_FILES["editarAdjunto"]["tmp_name"], $rutaAdjunto);
				}

				$datos = array(
					"id" => $_POST["idDocumento"],
					"documento" => $_POST["editarDocumento"],
					"id_tipodocs" => $_POST["editarIdTipodocs"],
					"fecha" => $_POST["editarFecha"],
					"emision" => $_POST["editarEmision"],
					"remitente" => $_POST["editarRemitente"],
					"destinatario" => $_POST["editarDestinatario"],
					"asunto" => $_POST["editarAsunto"],
					"adjunto" => $rutaAdjunto,
					"id_ticket" => $_POST["editarIdTicket"] != "" ? $_POST["editarIdTicket"] : null
				);

				$respuesta = ModeloDocumento::mdlEditarDocumento($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>
					swal({
						type: "success",
						title: "Ha sido editado correctamente",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
					}).then(function(result) {
						if (result.value) {
							window.location = "documento";
						}
					});
					</script>';
				}

			}else{

				echo'<script>
					swal({
						type: "error",
						title: "¡El formulario no puede ir vacío o llevar caracteres especiales!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
					}).then(function(result) {
						if (result.value) {
							window.location = "documento";
						}
					});
			  	</script>';
			}
		}
	}

	/* Borrar Documento */
	static public function ctrBorrarDocumento(){

		if(isset($_GET["idDocumento"])){

			$tabla = "documento";
			
			// Obtener el documento para eliminar el archivo adjunto
			$documento = ModeloDocumento::mdlMostrarDocumento($tabla, "id", $_GET["idDocumento"]);
			
			if($documento["adjunto"] && file_exists($documento["adjunto"])){
				unlink($documento["adjunto"]);
			}
			
			$respuesta = ModeloDocumento::mdlBorrarDocumento($tabla, $_GET["idDocumento"]);

			if($respuesta == "ok"){

				echo'<script>
				swal({
					type: "success",
				title: "Ha sido borrado correctamente",
					showConfirmButton: true,
					confirmButtonText: "Cerrar",
					closeOnConfirm: false
				}).then(function(result) {
					if (result.value) {
						window.location = "documento";
					}
				});
				</script>';
			}		
		}
	}
}
?>