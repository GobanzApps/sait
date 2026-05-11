<?php

class ControladorMedio{


	/* Mostrar */

	static public function ctrMostrarMedio($item, $valor){

		$tabla = "medio";

		$respuesta = ModeloMedio::MdlMostrarMedio($tabla, $item, $valor);

		return $respuesta;
	}


	/* Crear */

	static public function ctrCrearMedio(){

		if(isset($_POST["nuevoMedio"])){

			if(
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoMedio"]) &&    
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ #]+$/', $_POST["nuevoColor"])
               
               ){

				$tabla = "medio";

				$datos = array(
                                "medio" => $_POST["nuevoMedio"],
					            "estado" => "1",
					            "color" => $_POST["nuevoColor"]
								
					           );

				$respuesta = ModeloMedio::mdlCrearMedio($tabla, $datos);
			
				if($respuesta == "ok"){

					echo '<script>

					swal({

						type: "success",
						title: "¡Ha sido guardado correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"

					}).then(function(result){

						if(result.value){
						
							window.location = "medios";

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
						
							window.location = "medios";

						}

					});
				

				</script>';

			}


		}


	}


	/* Editar */

	static public function ctrEditarMedio(){

		if(isset($_POST["editarMedio"])){

			if(
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarMedio"]) &&   
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ #]+$/', $_POST["editarColor"])
               
               ){


				$tabla = "medio";

				$datos = array(
								"id" => $_POST["idMedio"],
                                "medio" => $_POST["editarMedio"],
					            "color" => $_POST["editarColor"]
					           );

				$respuesta = ModeloMedio::mdlEditarMedio($tabla, $datos);


				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "Ha sido editado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
									if (result.value) {

									window.location = "medios";

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

							window.location = "medios";

							}
						})

			  	</script>';

			}

		}

	}

	/* Borrar */

	static public function ctrBorrarMedio(){

		if(isset($_GET["idMedio"])){

			$tabla ="medio";
			$datos = $_GET["idMedio"];

			$respuesta = ModeloMedio::mdlBorrarMedio($tabla, $datos);

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

								window.location = "medios";

								}
							})

				</script>';

			}		

		}

	

	}


}
	


