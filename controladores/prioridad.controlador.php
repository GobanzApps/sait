<?php

class ControladorPrioridad{


	/* Mostrar */

	static public function ctrMostrarPrioridad($item, $valor){

		$tabla = "prioridad";

		$respuesta = ModeloPrioridad::MdlMostrarPrioridad($tabla, $item, $valor);

		return $respuesta;
	}


	/* Crear */

	static public function ctrCrearPrioridad(){

		if(isset($_POST["nuevoPrioridad"])){

			if(
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoPrioridad"]) &&    
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ #]+$/', $_POST["nuevoColor"])
               
               ){

				$tabla = "prioridad";

				$datos = array(
                                "prioridad" => $_POST["nuevoPrioridad"],
					            "estado" => "1",
					            "color" => $_POST["nuevoColor"]
								
					           );

				$respuesta = ModeloPrioridad::mdlCrearPrioridad($tabla, $datos);
			
				if($respuesta == "ok"){

					echo '<script>

					swal({

						type: "success",
						title: "¡Ha sido guardado correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"

					}).then(function(result){

						if(result.value){
						
							window.location = "prioridad";

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
						
							window.location = "prioridad";

						}

					});
				

				</script>';

			}


		}


	}


	/* Editar */

	static public function ctrEditarPrioridad(){

		if(isset($_POST["editarPrioridad"])){

			if(
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarPrioridad"]) &&   
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ #]+$/', $_POST["editarColor"])
               
               ){


				$tabla = "prioridad";

				$datos = array(
								"id" => $_POST["idPrioridad"],
                                "prioridad" => $_POST["editarPrioridad"],
					            "color" => $_POST["editarColor"]
					           );

				$respuesta = ModeloPrioridad::mdlEditarPrioridad($tabla, $datos);


				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "Ha sido editado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
									if (result.value) {

									window.location = "prioridad";

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

							window.location = "prioridad";

							}
						})

			  	</script>';

			}

		}

	}

	/* Borrar */

	static public function ctrBorrarPrioridad(){

		if(isset($_GET["idPrioridad"])){

			$tabla ="prioridad";
			$datos = $_GET["idPrioridad"];

			$respuesta = ModeloPrioridad::mdlBorrarPrioridad($tabla, $datos);

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

								window.location = "prioridad";

								}
							})

				</script>';

			}		

		}

	

	}


}
	


