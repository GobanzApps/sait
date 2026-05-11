

/* Editar */

$(".tablas").on("click", ".btnEditarCoordinacion", function(){

	var idCoordinacion = $(this).attr("idCoordinacion");
	
	var datos = new FormData();
	datos.append("idCoordinacion", idCoordinacion);

	$.ajax({

		url:"ajax/coordinacion.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			
			$("#editarCoordinacion").val(respuesta["coordinacion"]);
			$("#idCoordinacion").val(respuesta["id"]);

		}

	});

})



/* Activar Coordinacion */

$(".tablas").on("click", ".btnActivar", function(){

    var idCoordinacion = $(this).attr("idCoordinacion");
    var estadoActual = $(this).attr("estadoCoordinacion");
    
    // Determinar el nuevo estado (invertir el actual)
    var nuevoEstado = (estadoActual == 0) ? 1 : 0;

    var datos = new FormData();
    datos.append("activarId", idCoordinacion);
    datos.append("activarCoordinacion", nuevoEstado);  // Enviar el nuevo estado

    $.ajax({
        url: "ajax/coordinacion.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
            if(respuesta.coordinacion == "ok"){
                // Actualizar la UI
                if(nuevoEstado == 1){
                    $(this).removeClass('btn-danger');
                    $(this).addClass('btn-success');
                    $(this).html('Activado');
                    $(this).attr('estadoCoordinacion', 1);
                } else {
                    $(this).removeClass('btn-success');
                    $(this).addClass('btn-danger');
                    $(this).html('Desactivado');
                    $(this).attr('estadoCoordinacion', 0);
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





/* Revisar si coordinacion ya esta registrado */

$("#nuevoCoordinacion").change(function(){

	$(".alert").remove();

	var usuario = $(this).val();

	var datos = new FormData();
	datos.append("validarCoordinacion", usuario);

	 $.ajax({
	    url:"ajax/coordinacion.ajax.php",
	    method:"POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success:function(respuesta){
	    	
	    	if(respuesta){

	    		$("#nuevoCoordinacion").parent().after('<div class="alert alert-warning">Ya existe en la base de datos</div>');

	    		$("#nuevoCoordinacion").val("");

	    	}

	    }

	})
})

/* Eliminar */
$(".tablas").on("click", ".btnEliminarCoordinacion", function(){

  var idCoordinacion = $(this).attr("idCoordinacion");
  var coordinacion = $(this).attr("coordinacion");

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
      window.location = "index.php?ruta=coordinacion&idCoordinacion=" + idCoordinacion;
	  
    }
  });
})



