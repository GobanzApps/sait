/* Editar */

$(".tablas").on("click", ".btnEditarTicketservicios", function(){

	var idTicketservicios = $(this).attr("idTicketservicios");
	
	var datos = new FormData();
	datos.append("idTicketservicios", idTicketservicios);

	$.ajax({

		url:"ajax/ticketservicios.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			
			$("#editarTicketservicios").val(respuesta["ticketservicios"]);
			$("#idTicketservicios").val(respuesta["id"]);
			$("#editarId").val(respuesta["id"]);
			$("#editarId_servicios").val(respuesta["id_servicios"]);
			$("#editarId_item").val(respuesta["id_item"]);
			$("#editarDescripcion").val(respuesta["descripcion"]);
			$("#editarCantidad").val(respuesta["cantidad"]);

		}

	});

})

/* Activar Ticketservicios */

$(".tablas").on("click", ".btnActivar", function(){

    var idTicketservicios = $(this).attr("idTicketservicios");
    var estadoActual = $(this).attr("estadoTicketservicios");
    
    // Determinar el nuevo estado (invertir el actual)
    var nuevoEstado = (estadoActual == 0) ? 1 : 0;

    var datos = new FormData();
    datos.append("activarId", idTicketservicios);
    datos.append("activarTicketservicios", nuevoEstado);  // Enviar el nuevo estado

    $.ajax({
        url: "ajax/ticketservicios.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
            if(respuesta.ticketservicios == "ok"){
                // Actualizar la UI
                if(nuevoEstado == 1){
                    $(this).removeClass('btn-danger');
                    $(this).addClass('btn-success');
                    $(this).html('Activado');
                    $(this).attr('estadoTicketservicios', 1);
                } else {
                    $(this).removeClass('btn-success');
                    $(this).addClass('btn-danger');
                    $(this).html('Desactivado');
                    $(this).attr('estadoTicketservicios', 0);
                }
                
                if(window.matchMedia("(max-width:767px)").matches){
                    swal({
                        title: "Ya sido actualizado",
                        type: "success",
                        confirmButtonText: "¡Cerrar!"
                    });
                }
            }
        }.bind(this)  // Importante: bind(this) para mantener el contexto
    });
});

/* Revisar si ticketservicios ya esta registrado */

$("#nuevoTicketservicios").change(function(){

	$(".alert").remove();

	var usuario = $(this).val();

	var datos = new FormData();
	datos.append("validarTicketservicios", usuario);

	 $.ajax({
	    url:"ajax/ticketservicios.ajax.php",
	    method:"POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success:function(respuesta){
	    	
	    	if(respuesta){

	    		$("#nuevoTicketservicios").parent().after('<div class="alert alert-warning">Ya existe en la base de datos</div>');

	    		$("#nuevoTicketservicios").val("");

	    	}

	    }

	})
})

/* Eliminar */
$(".tablas").on("click", ".btnEliminarTicketservicios", function(){

  var idTicketservicios = $(this).attr("idTicketservicios");
  var ticketservicios = $(this).attr("ticketservicios");

  swal({
    title: '¿Está seguro de borrar?',
    text: "¡Si no lo está puede cancelar la acción!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, borrar!'
  }).then(function(result) {
    if (result.value) {
      // Redirigir con el ID para eliminar
      window.location = "index.php?ruta=ticketservicios&idTicketservicios=" + idTicketservicios;
	  
    }
  });
})

/* Guardar edición */
$("#guardarEdicion").on("click", function(){
    var datos = new FormData();
    datos.append("actualizarId", $("#editarId").val());
    datos.append("actualizarId_servicios", $("#editarId_servicios").val());
    datos.append("actualizarId_item", $("#editarId_item").val());
    datos.append("actualizarDescripcion", $("#editarDescripcion").val());
    datos.append("actualizarCantidad", $("#editarCantidad").val());
    
    $.ajax({
        url: "ajax/ticketservicios.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
            if(respuesta.respuesta == "ok"){
                swal({
                    type: "success",
                    title: "¡Actualizado correctamente!",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                }).then(function(result){
                    if(result.value){
                        location.reload();
                    }
                });
            } else {
                swal({
                    type: "error",
                    title: "¡Error al actualizar!",
                    text: "Verifica los datos ingresados",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                });
            }
        }
    });
});