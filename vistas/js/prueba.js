

/* Editar */

$(".tablas").on("click", ".btnEditarPrueba", function(){

	var idPrueba = $(this).attr("idPrueba");
	
	var datos = new FormData();
	datos.append("idPrueba", idPrueba);

	$.ajax({

		url:"ajax/prueba.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			
			$("#editarPrueba").val(respuesta["prueba"]);
			$("#editarItem_i").val(respuesta["item_i"]);
			$("#editarItem_s").val(respuesta["item_s"]);
			$("#idPrueba").val(respuesta["id"]);

		}

	});

})



/* Activar Prueba */

$(".tablas").on("click", ".btnActivar", function(){

    var idPrueba = $(this).attr("idPrueba");
    var estadoActual = $(this).attr("estadoPrueba");
    
    // Determinar el nuevo estado (invertir el actual)
    var nuevoEstado = (estadoActual == 0) ? 1 : 0;

    var datos = new FormData();
    datos.append("activarId", idPrueba);
    datos.append("activarPrueba", nuevoEstado);  // Enviar el nuevo estado

    $.ajax({
        url: "ajax/prueba.ajax.php",
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
                    $(this).attr('estadoPrueba', 1);
                } else {
                    $(this).removeClass('btn-success');
                    $(this).addClass('btn-danger');
                    $(this).html('Desactivado');
                    $(this).attr('estadoPrueba', 0);
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





/* Revisar si prueba ya esta registrado */

$("#nuevoPrueba").change(function(){

	$(".alert").remove();

	var usuario = $(this).val();

	var datos = new FormData();
	datos.append("validarPrueba", usuario);

	 $.ajax({
	    url:"ajax/prueba.ajax.php",
	    method:"POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success:function(respuesta){
	    	
	    	if(respuesta){

	    		$("#nuevoPrueba").parent().after('<div class="alert alert-warning">Ya existe en la base de datos</div>');

	    		$("#nuevoPrueba").val("");

	    	}

	    }

	})
})

/* Eliminar */
$(".tablas").on("click", ".btnEliminarPrueba", function(){

  var idPrueba = $(this).attr("idPrueba");
  var prueba = $(this).attr("prueba");

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
      window.location = "index.php?ruta=prueba&idPrueba=" + idPrueba;
	  
    }
  });
})



