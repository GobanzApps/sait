<?php

class ControladorTicketservicios{

	/* Mostrar */

	static public function ctrMostrarTicketservicios($ticketservicios, $valor){

		$tabla = "ticketservicios";

		$respuesta = ModeloTicketservicios::MdlMostrarTicketservicios($tabla, $ticketservicios, $valor);

		return $respuesta;
	}

	/* Crear */

	static public function ctrCrearTicketservicios(){

		if(isset($_POST["nuevoId_servicios"])){

			if(
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoId_servicios"]) &&
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoId_item"]) &&
				is_numeric($_POST["nuevoCantidad"])
               ){

				$tabla = "ticketservicios";

				$datos = array(
                    "id_servicios" => $_POST["nuevoId_servicios"],
					"id_ticket" => $_POST["nuevoId_ticket"],
					"id_item" => $_POST["nuevoId_item"],
					"descripcion" => $_POST["nuevoDescripcion"],
					"cantidad" => $_POST["nuevoCantidad"],
					"fecha" => date("Y-m-d H:i:s")
					
				);

				$respuesta = ModeloTicketservicios::mdlCrearTicketservicios($tabla, $datos);
			
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

	static public function ctrBorrarTicketservicios(){

		if(isset($_GET["idTicketservicios"])){

			$tabla ="ticketservicios";
			$datos = $_GET["idTicketservicios"];
			
			$idTicket = $_GET["id"]; 
			
			$respuesta = ModeloTicketservicios::mdlBorrarTicketservicios($tabla, $datos);

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

	/* Actualizar Ticketservicios */
	static public function ctrActualizarTicketservicios($datos){
		
		if(
			preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $datos["id_servicios"]) &&
			preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $datos["id_item"]) &&
			is_numeric($datos["cantidad"])
		){
			
			$tabla = "ticketservicios";
			$respuesta = ModeloTicketservicios::mdlActualizarTicketserviciosCompleto($tabla, $datos);
			
			if($respuesta == "ok"){
				return "ok";
			} else {
				return "error";
			}
			
		} else {
			return "error_validacion";
		}
	}
}
?>