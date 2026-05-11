<?php

class ControladorTicketusuario{


	/* Mostrar */

	static public function ctrMostrarTicketusuario($ticketusuario, $valor){

		$tabla = "ticketusuario";

		$respuesta = ModeloTicketusuario::MdlMostrarTicketusuario($tabla, $ticketusuario, $valor);

		return $respuesta;
	}


	/* Crear */

	static public function ctrCrearTicketusuario(){

		if(isset($_POST["nuevoId_usuario"])){

			if(
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoId_usuario"])
               
               ){

				$tabla = "ticketusuario";

				$datos = array(
                                "id_usuario" => $_POST["nuevoId_usuario"],
					            "id_ticket" => $_POST["nuevoId_ticket"]
					           );

				$respuesta = ModeloTicketusuario::mdlCrearTicketusuario($tabla, $datos);
			
				if($respuesta == "ok"){

					echo '<script>

					swal({

						type: "success",
						title: "¡Ha sido guardado correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"

					}).then(function(result){

						if(result.value){
						
									window.location.href;
									location.replace(location.href);

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
						
									window.location.href;
									location.replace(location.href);

						}

					});
				

				</script>';

			}


		}


	}


	/* Borrar */

	static public function ctrBorrarTicketusuario(){

		if(isset($_GET["idTicketusuario"])){

			$tabla ="ticketusuario";
			$datos = $_GET["idTicketusuario"];
			
			$idTicket = $_GET["id"]; 
			
			$respuesta = ModeloTicketusuario::mdlBorrarTicketusuario($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>
				swal({
					type: "success",
					title: "Ha sido borrado correctamente",
					showConfirmButton: true,
					confirmButtonText: "Cerrar"
				}).then(function(result) {
					if (result.value) {
						window.location = "index.php?ruta=ticket&id=' . $idTicket . '";
					}
				})
				</script>';

			}        
		}
	}



















}
	


