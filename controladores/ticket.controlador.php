<?php

class ControladorTicket{


	/* Mostrar */

	static public function ctrMostrarTicket($item, $valor){

		$tabla = "ticket";

		$respuesta = ModeloTicket::MdlMostrarTicket($tabla, $item, $valor);

		return $respuesta;
	}


	/* Crear */

	static public function ctrCrearTicket(){

		if(isset($_POST["nuevoTicket"])){

			if(
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s\+\-\*\.\,]+$/', $_POST["nuevoSolicitante"]) &&
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s\+\-\*\.\,]+$/', $_POST["nuevoDescripcion"])      
                //preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoDescripcion"]) 
               
               ){

				$tabla = "ticket";

				$datos = array(
                                "ticket" => $_POST["nuevoTicket"],
					            "estado" => "1",
								"id_ente" => $_POST["nuevoEnte"],
								"id_medio" => $_POST["nuevoMedio"],
								"id_prioridad" => $_POST["nuevoPrioridad"],
								"solicitante" => $_POST["nuevoSolicitante"],
								"descripcion" => $_POST["nuevoDescripcion"],
								"id_usuario" => $_SESSION["id"],
								"finalizado" => "no"									
					           );

				$respuesta = ModeloTicket::mdlCrearTicket($tabla, $datos);
			
				if($respuesta == "ok"){

					echo '<script>

					swal({

						type: "success",
						title: "¡Ha sido guardado correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"

					}).then(function(result){

						if(result.value){
						
							window.location = "tickets";

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
						
							window.location = "tickets";

						}

					});
				

				</script>';

			}


		}


	}


	/* Editar */

	static public function ctrEditarTicket(){

		if(isset($_POST["editarTicket"])){

			if(
             	preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s\+\-\*\.\,]+$/', $_POST["editarSolicitante"]) &&  
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s\+\-\*\.\,]+$/', $_POST["editarDescripcion"])        
           //     preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarDescripcion"]) 
               
               ){


				$tabla = "ticket";

				$datos = array(

								"id" => $_POST["idTicket"],
                                "ticket" => $_POST["editarTicket"],
								"id_ente" => $_POST["editarEnte"],
								"id_medio" => $_POST["editarMedio"],
								"id_prioridad" => $_POST["editarPrioridad"],
								"solicitante" => $_POST["editarSolicitante"],
								"descripcion" => $_POST["editarDescripcion"],
								"finalizado" => $_POST["editarFinalizado"]
								
					           );

				$respuesta = ModeloTicket::mdlEditarTicket($tabla, $datos);


				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "Ha sido editado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
									if (result.value) {

									window.location = "tickets";

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

							window.location = "tickets";

							}
						})

			  	</script>';

			}

		}

	}

	/* Borrar */

	static public function ctrBorrarTicket(){

		if(isset($_GET["idTicket"])){

			$tabla ="ticket";
			$datos = $_GET["idTicket"];

			$respuesta = ModeloTicket::mdlBorrarTicket($tabla, $datos);

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

								window.location = "tickets";

								}
							})

				</script>';

			}		

		}

	

	}

	/* Editar en ticket.php  */

	static public function ctrEditarTicket2(){

		if(isset($_POST["editarTicket"])){

			if(
             	preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarSolicitante"]) 
               
               ){


				$tabla = "ticket";

				$datos = array(

								"id" => $_POST["idTicket"],
                                "ticket" => $_POST["editarTicket"],
								"id_ente" => $_POST["editarEnte"],
								"id_medio" => $_POST["editarMedio"],
								"id_prioridad" => $_POST["editarPrioridad"],
								"solicitante" => $_POST["editarSolicitante"],
								"descripcion" => $_POST["editarDescripcion"],
								"finalizado" => $_POST["editarFinalizado"]
								
					           );

				$respuesta = ModeloTicket::mdlEditarTicket($tabla, $datos);


				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "Ha sido editado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result) {
									if (result.value) {

									window.location.href;
									location.replace(location.href);

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
							
									window.location.href;
									location.replace(location.href);

							}
						})

			  	</script>';

			}

		}

	}

	/* Actualizar Finalizado */

	static public function ctrActualizarFinalizado(){

		if(isset($_POST["finalizarTicket"])){

			$tabla = "ticket";

			$item1 = "finalizado";
			$valor1 = $_POST["finalizarTicket"];

			$item2 = "id";
			$valor2 = $_POST["finalizarId"];

			$respuesta = ModeloTicket::mdlActualizarFinalizado($tabla, $item1, $valor1, $item2, $valor2);

			echo json_encode(["status" => $respuesta]);

		}

	}

}