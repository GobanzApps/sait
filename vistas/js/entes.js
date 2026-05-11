

/* Editar */

$(".tablas").on("click", ".btnEditarEntes", function(){

	var idEntes = $(this).attr("idEntes");
	
	var datos = new FormData();
	datos.append("idEntes", idEntes);

	$.ajax({

		url:"ajax/entes.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			
			$("#editarEntes").val(respuesta["entes"]);
			$("#idEntes").val(respuesta["id"]);

		}

	});

})



/* Activar Entes */

$(".tablas").on("click", ".btnActivar", function(){

    var idEntes = $(this).attr("idEntes");
    var estadoActual = $(this).attr("estadoEntes");
    
    // Determinar el nuevo estado (invertir el actual)
    var nuevoEstado = (estadoActual == 0) ? 1 : 0;

    var datos = new FormData();
    datos.append("activarId", idEntes);
    datos.append("activarEntes", nuevoEstado);  // Enviar el nuevo estado

    $.ajax({
        url: "ajax/entes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
            if(respuesta.entes == "ok"){
                // Actualizar la UI
                if(nuevoEstado == 1){
                    $(this).removeClass('btn-danger');
                    $(this).addClass('btn-success');
                    $(this).html('Activado');
                    $(this).attr('estadoEntes', 1);
                } else {
                    $(this).removeClass('btn-success');
                    $(this).addClass('btn-danger');
                    $(this).html('Desactivado');
                    $(this).attr('estadoEntes', 0);
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





/* Revisar si entes ya esta registrado */

$("#nuevoEntes").change(function(){

	$(".alert").remove();

	var usuario = $(this).val();

	var datos = new FormData();
	datos.append("validarEntes", usuario);

	 $.ajax({
	    url:"ajax/entes.ajax.php",
	    method:"POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success:function(respuesta){
	    	
	    	if(respuesta){

	    		$("#nuevoEntes").parent().after('<div class="alert alert-warning">Ya existe en la base de datos</div>');

	    		$("#nuevoEntes").val("");

	    	}

	    }

	})
})

/* Eliminar */
$(".tablas").on("click", ".btnEliminarEntes", function(){

  var idEntes = $(this).attr("idEntes");
  var entes = $(this).attr("entes");

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
      window.location = "index.php?ruta=entes&idEntes=" + idEntes;
	  
    }
  });
})



