<?php

class ControladorStatus{


	/* Mostrar */

	static public function ctrMostrarStatus($item, $valor){

		$tabla = "status";

		$respuesta = ModeloStatus::MdlMostrarStatus($tabla, $item, $valor);

		return $respuesta;
	}


	/* Crear */

	static public function ctrCrearStatus(){

		if(isset($_POST["nuevoStatus"])){

			if(
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoStatus"]) &&    
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ #]+$/', $_POST["nuevoColor"])
               
               ){

				$tabla = "status";

				$datos = array(
                                "status" => $_POST["nuevoStatus"],
					            "estado" => "1",
					            "color" => $_POST["nuevoColor"]
								
					           );

				$respuesta = ModeloStatus::mdlCrearStatus($tabla, $datos);
			
				if($respuesta == "ok"){

					echo '<script>

					swal({

						type: "success",
						title: "¡Ha sido guardado correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"

					}).then(function(result){

						if(result.value){
						
							window.location = "status";

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
						
							window.location = "status";

						}

					});
				

				</script>';

			}


		}


	}


	/* Editar */

	static public function ctrEditarStatus(){

		if(isset($_POST["editarStatus"])){

			if(
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarStatus"]) &&   
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ #]+$/', $_POST["editarColor"])
               
               ){


				$tabla = "status";

				$datos = array(
								"id" => $_POST["idStatus"],
                                "status" => $_POST["editarStatus"],
					            "color" => $_POST["editarColor"]
					           );

				$respuesta = ModeloStatus::mdlEditarStatus($tabla, $datos);


				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "Ha sido editado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
									if (result.value) {

									window.location = "status";

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

							window.location = "status";

							}
						})

			  	</script>';

			}

		}

	}

	/* Borrar */

	static public function ctrBorrarStatus(){

		if(isset($_GET["idStatus"])){

			$tabla ="status";
			$datos = $_GET["idStatus"];

			$respuesta = ModeloStatus::mdlBorrarStatus($tabla, $datos);

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

								window.location = "status";

								}
							})

				</script>';

			}		

		}

	

	}


}
	


