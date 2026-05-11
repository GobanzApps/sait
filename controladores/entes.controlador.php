<?php

class ControladorEntes{


	/* Mostrar */

	static public function ctrMostrarEntes($item, $valor){

		$tabla = "entes";

		$respuesta = ModeloEntes::MdlMostrarEntes($tabla, $item, $valor);

		return $respuesta;
	}


	/* Crear */

	static public function ctrCrearEntes(){

		if(isset($_POST["nuevoEntes"])){

			if(
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s\+\-\*\.\,]+$/', $_POST["nuevoEntes"])
				
               
               ){

				$tabla = "entes";

				$datos = array(
                                "entes" => $_POST["nuevoEntes"],
					            "estado" => "1"
								
					           );

				$respuesta = ModeloEntes::mdlCrearEntes($tabla, $datos);
			
				if($respuesta == "ok"){

					echo '<script>

					swal({

						type: "success",
						title: "¡Ha sido guardado correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"

					}).then(function(result){

						if(result.value){
						
							window.location = "entes";

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
						
							window.location = "entes";

						}

					});
				

				</script>';

			}


		}


	}


	/* Editar */

	static public function ctrEditarEntes(){

		if(isset($_POST["editarEntes"])){

			if(
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s\+\-\*\.\,]+$/', $_POST["editarEntes"]) 
               
               ){


				$tabla = "entes";

				$datos = array(
								"id" => $_POST["idEntes"],
                                "entes" => $_POST["editarEntes"]
					           );

				$respuesta = ModeloEntes::mdlEditarEntes($tabla, $datos);


				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "Ha sido editado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
									if (result.value) {

									window.location = "entes";

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

							window.location = "entes";

							}
						})

			  	</script>';

			}

		}

	}

	/* Borrar */

	static public function ctrBorrarEntes(){

		if(isset($_GET["idEntes"])){

			$tabla ="entes";
			$datos = $_GET["idEntes"];

			$respuesta = ModeloEntes::mdlBorrarEntes($tabla, $datos);

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

								window.location = "entes";

								}
							})

				</script>';

			}		

		}

	

	}


}
	


