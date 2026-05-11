

/* Editar */

$(".tablas").on("click", ".btnEditarStatus", function(){

	var idStatus = $(this).attr("idStatus");
	
	var datos = new FormData();
	datos.append("idStatus", idStatus);

	$.ajax({

		url:"ajax/status.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			
			$("#editarStatus").val(respuesta["status"]);
			$("#editarColor").val(respuesta["color"]);
			$("#idStatus").val(respuesta["id"]);

		}

	});

})



/* Activar Status */

$(".tablas").on("click", ".btnActivar", function(){

    var idStatus = $(this).attr("idStatus");
    var estadoActual = $(this).attr("estadoStatus");
    
    // Determinar el nuevo estado (invertir el actual)
    var nuevoEstado = (estadoActual == 0) ? 1 : 0;

    var datos = new FormData();
    datos.append("activarId", idStatus);
    datos.append("activarStatus", nuevoEstado);  // Enviar el nuevo estado

    $.ajax({
        url: "ajax/status.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
            if(respuesta.status == "ok"){
                // Actualizar la UI
                if(nuevoEstado == 1){
                    $(this).removeClass('btn-danger');
                    $(this).addClass('btn-success');
                    $(this).html('Activado');
                    $(this).attr('estadoStatus', 1);
                } else {
                    $(this).removeClass('btn-success');
                    $(this).addClass('btn-danger');
                    $(this).html('Desactivado');
                    $(this).attr('estadoStatus', 0);
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





/* Revisar si status ya esta registrado */

$("#nuevoStatus").change(function(){

	$(".alert").remove();

	var usuario = $(this).val();

	var datos = new FormData();
	datos.append("validarStatus", usuario);

	 $.ajax({
	    url:"ajax/status.ajax.php",
	    method:"POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success:function(respuesta){
	    	
	    	if(respuesta){

	    		$("#nuevoStatus").parent().after('<div class="alert alert-warning">Ya existe en la base de datos</div>');

	    		$("#nuevoStatus").val("");

	    	}

	    }

	})
})

/* Eliminar */
$(".tablas").on("click", ".btnEliminarStatus", function(){

  var idStatus = $(this).attr("idStatus");
  var status = $(this).attr("status");

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
      window.location = "index.php?ruta=status&idStatus=" + idStatus;
	  
    }
  });
})



