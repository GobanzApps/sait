<?php

class ControladorPrueba{


	/* Mostrar */

	static public function ctrMostrarPrueba($item, $valor){

		$tabla = "prueba";

		$respuesta = ModeloPrueba::MdlMostrarPrueba($tabla, $item, $valor);

		return $respuesta;
	}


	/* Crear */

	static public function ctrCrearPrueba(){

		if(isset($_POST["nuevoPrueba"])){

			if(
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoPrueba"]) &&       
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoItem_i"]) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoItem_s"]) 
               
               ){

				$tabla = "prueba";

				$datos = array(
                                "prueba" => $_POST["nuevoPrueba"],
					            "estado" => "1",
								"item_i" => $_POST["nuevoItem_i"],
					            "item_s" => $_POST["nuevoItem_s"]
								
					           );

				$respuesta = ModeloPrueba::mdlCrearPrueba($tabla, $datos);
			
				if($respuesta == "ok"){

					echo '<script>

					swal({

						type: "success",
						title: "¡Ha sido guardado correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"

					}).then(function(result){

						if(result.value){
						
							window.location = "prueba";

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
						
							window.location = "prueba";

						}

					});
				

				</script>';

			}


		}


	}


	/* Editar */

	static public function ctrEditarPrueba(){

		if(isset($_POST["editarPrueba"])){

			if(
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarPrueba"]) &&       
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarItem_i"]) &&
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarItem_s"]) 
               
               ){


				$tabla = "prueba";

				$datos = array(
								"id" => $_POST["idPrueba"],
                                "prueba" => $_POST["editarPrueba"],
					            "item_i" => $_POST["editarItem_i"],
					            "item_s" => $_POST["editarItem_s"]
					           );

				$respuesta = ModeloPrueba::mdlEditarPrueba($tabla, $datos);


				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "Ha sido editado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
									if (result.value) {

									window.location = "prueba";

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

							window.location = "prueba";

							}
						})

			  	</script>';

			}

		}

	}

	/* Borrar */

	static public function ctrBorrarPrueba(){

		if(isset($_GET["idPrueba"])){

			$tabla ="prueba";
			$datos = $_GET["idPrueba"];

			$respuesta = ModeloPrueba::mdlBorrarPrueba($tabla, $datos);

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

								window.location = "prueba";

								}
							})

				</script>';

			}		

		}

	

	}


}
	


