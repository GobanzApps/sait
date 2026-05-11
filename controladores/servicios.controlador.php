<?php

class ControladorServicios{

	/* Mostrar */
	static public function ctrMostrarServicios($item, $valor){

		$tabla = "servicios";

		$respuesta = ModeloServicios::MdlMostrarServicios($tabla, $item, $valor);

		return $respuesta;
	}

	/* Crear */
	static public function ctrCrearServicios(){

		if(isset($_POST["nuevoServicios"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoServicios"])){
				
				// Verificar que se haya seleccionado una coordinación
				$id_coordinacion = isset($_POST["nuevoIdCoordinacion"]) && $_POST["nuevoIdCoordinacion"] != "" ? $_POST["nuevoIdCoordinacion"] : null;

				$tabla = "servicios";

				$datos = array(
					"servicios" => $_POST["nuevoServicios"],
					"id_coordinacion" => $id_coordinacion,
					"estado" => "1"
				);

				$respuesta = ModeloServicios::mdlCrearServicios($tabla, $datos);
			
				if($respuesta == "ok"){

					echo '<script>
					swal({
						type: "success",
						title: "¡Ha sido guardado correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
					}).then(function(result){
						if(result.value){
							window.location = "servicios";
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
						window.location = "servicios";
					}
				});
				</script>';

			}

		}

	}

	/* Editar */
	static public function ctrEditarServicios(){

		if(isset($_POST["editarServicios"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarServicios"])){

				// Verificar que se haya seleccionado una coordinación
				$id_coordinacion = isset($_POST["editarIdCoordinacion"]) && $_POST["editarIdCoordinacion"] != "" ? $_POST["editarIdCoordinacion"] : null;

				$tabla = "servicios";

				$datos = array(
					"id" => $_POST["idServicios"],
					"servicios" => $_POST["editarServicios"],
					"id_coordinacion" => $id_coordinacion
				);

				$respuesta = ModeloServicios::mdlEditarServicios($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>
					swal({
						type: "success",
						title: "Ha sido editado correctamente",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
					}).then(function(result) {
						if (result.value) {
							window.location = "servicios";
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
						window.location = "servicios";
					}
				});
				</script>';

			}

		}

	}

	/* Borrar */
	static public function ctrBorrarServicios(){

		if(isset($_GET["idServicios"])){

			$tabla ="servicios";
			$datos = $_GET["idServicios"];

			$respuesta = ModeloServicios::mdlBorrarServicios($tabla, $datos);

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
						window.location = "servicios";
					}
				});
				</script>';

			}		

		}

	}

}
?>