

/* Editar */

$(".tablas").on("click", ".btnEditarMedio", function(){

	var idMedio = $(this).attr("idMedio");
	
	var datos = new FormData();
	datos.append("idMedio", idMedio);

	$.ajax({

		url:"ajax/medio.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			
			$("#editarMedio").val(respuesta["medio"]);
			$("#editarColor").val(respuesta["color"]);
			$("#idMedio").val(respuesta["id"]);

		}

	});

})



/* Activar Medio */

$(".tablas").on("click", ".btnActivar", function(){

    var idMedio = $(this).attr("idMedio");
    var estadoActual = $(this).attr("estadoMedio");
    
    // Determinar el nuevo estado (invertir el actual)
    var nuevoEstado = (estadoActual == 0) ? 1 : 0;

    var datos = new FormData();
    datos.append("activarId", idMedio);
    datos.append("activarMedio", nuevoEstado);  // Enviar el nuevo estado

    $.ajax({
        url: "ajax/medio.ajax.php",
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
                    $(this).attr('estadoMedio', 1);
                } else {
                    $(this).removeClass('btn-success');
                    $(this).addClass('btn-danger');
                    $(this).html('Desactivado');
                    $(this).attr('estadoMedio', 0);
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





/* Revisar si medio ya esta registrado */

$("#nuevoMedio").change(function(){

	$(".alert").remove();

	var usuario = $(this).val();

	var datos = new FormData();
	datos.append("validarMedio", usuario);

	 $.ajax({
	    url:"ajax/medio.ajax.php",
	    method:"POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success:function(respuesta){
	    	
	    	if(respuesta){

	    		$("#nuevoMedio").parent().after('<div class="alert alert-warning">Ya existe en la base de datos</div>');

	    		$("#nuevoMedio").val("");

	    	}

	    }

	})
})

/* Eliminar */
$(".tablas").on("click", ".btnEliminarMedio", function(){

  var idMedio = $(this).attr("idMedio");
  var medio = $(this).attr("medio");

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
      window.location = "index.php?ruta=medios&idMedio=" + idMedio;
	  
    }
  });
})



