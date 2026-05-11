<?php

class ControladorItem{


	/* Mostrar */

	static public function ctrMostrarItem($item, $valor){

		$tabla = "item";

		$respuesta = ModeloItem::MdlMostrarItem($tabla, $item, $valor);

		return $respuesta;
	}


	/* Crear */

	static public function ctrCrearItem(){

		if(isset($_POST["nuevoItem"])){

			if(
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoItem"])
               
               ){

				$tabla = "item";

				$datos = array(
                                "item" => $_POST["nuevoItem"],
					            "estado" => "1"
								
					           );

				$respuesta = ModeloItem::mdlCrearItem($tabla, $datos);
			
				if($respuesta == "ok"){

					echo '<script>

					swal({

						type: "success",
						title: "¡Ha sido guardado correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"

					}).then(function(result){

						if(result.value){
						
							window.location = "item";

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
						
							window.location = "item";

						}

					});
				

				</script>';

			}


		}


	}


	/* Editar */

	static public function ctrEditarItem(){

		if(isset($_POST["editarItem"])){

			if(
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarItem"]) 
               
               ){


				$tabla = "item";

				$datos = array(
								"id" => $_POST["idItem"],
                                "item" => $_POST["editarItem"]
					           );

				$respuesta = ModeloItem::mdlEditarItem($tabla, $datos);


				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "Ha sido editado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
									if (result.value) {

									window.location = "item";

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

							window.location = "item";

							}
						})

			  	</script>';

			}

		}

	}

	/* Borrar */

	static public function ctrBorrarItem(){

		if(isset($_GET["idItem"])){

			$tabla ="item";
			$datos = $_GET["idItem"];

			$respuesta = ModeloItem::mdlBorrarItem($tabla, $datos);

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

								window.location = "item";

								}
							})

				</script>';

			}		

		}

	

	}


}
	


