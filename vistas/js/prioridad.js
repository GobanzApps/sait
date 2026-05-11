

/* Editar */

$(".tablas").on("click", ".btnEditarPrioridad", function(){

	var idPrioridad = $(this).attr("idPrioridad");
	
	var datos = new FormData();
	datos.append("idPrioridad", idPrioridad);

	$.ajax({

		url:"ajax/prioridad.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			
			$("#editarPrioridad").val(respuesta["prioridad"]);
			$("#editarColor").val(respuesta["color"]);
			$("#idPrioridad").val(respuesta["id"]);

		}

	});

})



/* Activar Prioridad */

$(".tablas").on("click", ".btnActivar", function(){

    var idPrioridad = $(this).attr("idPrioridad");
    var estadoActual = $(this).attr("estadoPrioridad");
    
    // Determinar el nuevo estado (invertir el actual)
    var nuevoEstado = (estadoActual == 0) ? 1 : 0;

    var datos = new FormData();
    datos.append("activarId", idPrioridad);
    datos.append("activarPrioridad", nuevoEstado);  // Enviar el nuevo estado

    $.ajax({
        url: "ajax/prioridad.ajax.php",
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
                    $(this).attr('estadoPrioridad', 1);
                } else {
                    $(this).removeClass('btn-success');
                    $(this).addClass('btn-danger');
                    $(this).html('Desactivado');
                    $(this).attr('estadoPrioridad', 0);
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





/* Revisar si prioridad ya esta registrado */

$("#nuevoPrioridad").change(function(){

	$(".alert").remove();

	var usuario = $(this).val();

	var datos = new FormData();
	datos.append("validarPrioridad", usuario);

	 $.ajax({
	    url:"ajax/prioridad.ajax.php",
	    method:"POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success:function(respuesta){
	    	
	    	if(respuesta){

	    		$("#nuevoPrioridad").parent().after('<div class="alert alert-warning">Ya existe en la base de datos</div>');

	    		$("#nuevoPrioridad").val("");

	    	}

	    }

	})
})

/* Eliminar */
$(".tablas").on("click", ".btnEliminarPrioridad", function(){

  var idPrioridad = $(this).attr("idPrioridad");
  var prioridad = $(this).attr("prioridad");

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
      window.location = "index.php?ruta=prioridad&idPrioridad=" + idPrioridad;
	  
    }
  });
})



