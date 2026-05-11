<?php

class ControladorTicketstatus{


	/* Mostrar */

	static public function ctrMostrarTicketstatus($ticketstatus, $valor){

		$tabla = "ticketstatus";

		$respuesta = ModeloTicketstatus::MdlMostrarTicketstatus($tabla, $ticketstatus, $valor);

		return $respuesta;
	}


	/* Crear */

	static public function ctrCrearTicketstatus(){

		if(isset($_POST["nuevoId_status"])){

			if(
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoId_status"])
               
               ){

				$tabla = "ticketstatus";

				$datos = array(
                                "id_status" => $_POST["nuevoId_status"],
					            "id_ticket" => $_POST["nuevoId_ticket"]
					           );

				$respuesta = ModeloTicketstatus::mdlCrearTicketstatus($tabla, $datos);
			
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

	static public function ctrBorrarTicketstatus(){

		if(isset($_GET["idTicketstatus"])){

			$tabla ="ticketstatus";
			$datos = $_GET["idTicketstatus"];
			
			$idTicket = $_GET["id"]; 
			
			$respuesta = ModeloTicketstatus::mdlBorrarTicketstatus($tabla, $datos);

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
	


