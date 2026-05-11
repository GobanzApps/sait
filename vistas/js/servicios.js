/* Editar */

$(".tablas").on("click", ".btnEditarServicios", function(){

	var idServicios = $(this).attr("idServicios");
	
	var datos = new FormData();
	datos.append("idServicios", idServicios);

	$.ajax({

		url:"ajax/servicios.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			
			$("#editarServicios").val(respuesta["servicios"]);
			$("#idServicios").val(respuesta["id"]);
			
			// CORRECCIÓN: Asignar el valor de la coordinación guardada al select
			if(respuesta["id_coordinacion"] != null && respuesta["id_coordinacion"] != ""){
				$("#editarIdCoordinacion").val(respuesta["id_coordinacion"]).trigger('change');
			} else {
				$("#editarIdCoordinacion").val("").trigger('change');
			}

		}

	});

})

/* Activar Servicios */

$(".tablas").on("click", ".btnActivar", function(){

    var idServicios = $(this).attr("idServicios");
    var estadoActual = $(this).attr("estadoServicios");
    
    // Determinar el nuevo estado (invertir el actual)
    var nuevoEstado = (estadoActual == 0) ? 1 : 0;

    var datos = new FormData();
    datos.append("activarId", idServicios);
    datos.append("activarServicios", nuevoEstado);  // Enviar el nuevo estado

    $.ajax({
        url: "ajax/servicios.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
            if(respuesta.servicios == "ok"){
                // Actualizar la UI
                if(nuevoEstado == 1){
                    $(this).removeClass('btn-danger');
                    $(this).addClass('btn-success');
                    $(this).html('Activado');
                    $(this).attr('estadoServicios', 1);
                } else {
                    $(this).removeClass('btn-success');
                    $(this).addClass('btn-danger');
                    $(this).html('Desactivado');
                    $(this).attr('estadoServicios', 0);
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

/* Revisar si servicios ya esta registrado */

$("#nuevoServicios").change(function(){

	$(".alert").remove();

	var usuario = $(this).val();

	var datos = new FormData();
	datos.append("validarServicios", usuario);

	 $.ajax({
	    url:"ajax/servicios.ajax.php",
	    method:"POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success:function(respuesta){
	    	
	    	if(respuesta){

	    		$("#nuevoServicios").parent().after('<div class="alert alert-warning">Ya existe en la base de datos</div>');

	    		$("#nuevoServicios").val("");

	    	}

	    }

	})
})

/* Eliminar */
$(".tablas").on("click", ".btnEliminarServicios", function(){

  var idServicios = $(this).attr("idServicios");
  var servicios = $(this).attr("servicios");

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
      window.location = "index.php?ruta=servicios&idServicios=" + idServicios;
	  
    }
  });
})