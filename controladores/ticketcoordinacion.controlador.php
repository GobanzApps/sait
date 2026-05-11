<?php

class ControladorTicketcoordinacion{


	/* Mostrar */

	static public function ctrMostrarTicketcoordinacion($ticketcoordinacion, $valor){

		$tabla = "ticketcoordinacion";

		$respuesta = ModeloTicketcoordinacion::MdlMostrarTicketcoordinacion($tabla, $ticketcoordinacion, $valor);

		return $respuesta;
	}


	/* Crear */

	static public function ctrCrearTicketcoordinacion(){

		if(isset($_POST["nuevoId_coordinacion"])){

			if(
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoId_coordinacion"])
               
               ){

				$tabla = "ticketcoordinacion";

				$datos = array(
                                "id_coordinacion" => $_POST["nuevoId_coordinacion"],
					            "id_ticket" => $_POST["nuevoId_ticket"]
					           );

				$respuesta = ModeloTicketcoordinacion::mdlCrearTicketcoordinacion($tabla, $datos);
			
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

	static public function ctrBorrarTicketcoordinacion(){

		if(isset($_GET["idTicketcoordinacion"])){

			$tabla ="ticketcoordinacion";
			$datos = $_GET["idTicketcoordinacion"];
			
			$idTicket = $_GET["id"]; 
			
			$respuesta = ModeloTicketcoordinacion::mdlBorrarTicketcoordinacion($tabla, $datos);

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
	


