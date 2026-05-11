<?php

class ControladorCoordinacion{


	/* Mostrar */

	static public function ctrMostrarCoordinacion($item, $valor){

		$tabla = "coordinacion";

		$respuesta = ModeloCoordinacion::MdlMostrarCoordinacion($tabla, $item, $valor);

		return $respuesta;
	}


	/* Crear */

	static public function ctrCrearCoordinacion(){

		if(isset($_POST["nuevoCoordinacion"])){

			if(
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoCoordinacion"])
               
               ){

				$tabla = "coordinacion";

				$datos = array(
                                "coordinacion" => $_POST["nuevoCoordinacion"],
					            "estado" => "1"
								
					           );

				$respuesta = ModeloCoordinacion::mdlCrearCoordinacion($tabla, $datos);
			
				if($respuesta == "ok"){

					echo '<script>

					swal({

						type: "success",
						title: "¡Ha sido guardado correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"

					}).then(function(result){

						if(result.value){
						
							window.location = "coordinacion";

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
						
							window.location = "coordinacion";

						}

					});
				

				</script>';

			}


		}


	}


	/* Editar */

	static public function ctrEditarCoordinacion(){

		if(isset($_POST["editarCoordinacion"])){

			if(
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarCoordinacion"]) 
               
               ){


				$tabla = "coordinacion";

				$datos = array(
								"id" => $_POST["idCoordinacion"],
                                "coordinacion" => $_POST["editarCoordinacion"]
					           );

				$respuesta = ModeloCoordinacion::mdlEditarCoordinacion($tabla, $datos);


				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "Ha sido editado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
									if (result.value) {

									window.location = "coordinacion";

									}
								})

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

							window.location = "coordinacion";

							}
						})

			  	</script>';

			}

		}

	}

	/* Borrar */

	static public function ctrBorrarCoordinacion(){

		if(isset($_GET["idCoordinacion"])){

			$tabla ="coordinacion";
			$datos = $_GET["idCoordinacion"];

			$respuesta = ModeloCoordinacion::mdlBorrarCoordinacion($tabla, $datos);

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

								window.location = "coordinacion";

								}
							})

				</script>';

			}		

		}

	

	}


}
	


