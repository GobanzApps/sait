<script>
$(document).ready(function() {
    // Inicializar Select2 para los selects en los modales
    function inicializarSelect2() {
        // Selects del modal de crear
        $('#nuevoId_servicios').select2({
            theme: 'bootstrap',
            placeholder: 'Buscar servicio...',
            language: 'es',
            dropdownParent: $('#modalAgregarTicketservicios'),
            width: '100%'
        });
        
        $('#nuevoId_item').select2({
            theme: 'bootstrap',
            placeholder: 'Buscar item...',
            language: 'es',
            dropdownParent: $('#modalAgregarTicketservicios'),
            width: '100%'
        });
        
        // Selects del modal de editar
        $('#editarId_servicios').select2({
            theme: 'bootstrap',
            placeholder: 'Buscar servicio...',
            language: 'es',
            dropdownParent: $('#modalEditarTicketservicios'),
            width: '100%'
        });
        
        $('#editarId_item').select2({
            theme: 'bootstrap',
            placeholder: 'Buscar item...',
            language: 'es',
            dropdownParent: $('#modalEditarTicketservicios'),
            width: '100%'
        });
    }
    
    // Inicializar cuando el documento esté listo
    inicializarSelect2();
    
    // Reinicializar cuando se abre el modal de crear
    $('#modalAgregarTicketservicios').on('shown.bs.modal', function() {
        $('#nuevoId_servicios').select2('open').select2('close');
        $('#nuevoId_item').select2('open').select2('close');
    });
    
    // Reinicializar cuando se abre el modal de editar
    $('#modalEditarTicketservicios').on('shown.bs.modal', function() {
        $('#editarId_servicios').select2('open').select2('close');
        $('#editarId_item').select2('open').select2('close');
    });

    // Eliminar ticket coordinación
    $('.btnEliminarTicketservicios').on('click', function() {
        var idTicketservicios = $(this).attr('idTicketservicios');
        var idTicket = $(this).attr('idTicket'); 
        
        swal({
            title: '¿Está seguro?',
            text: "¡No podrás revertir esto!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then(function(result) {
            if (result.value) {
                window.location = "index.php?ruta=ticket&id=" + idTicket + "&idTicketservicios=" + idTicketservicios;
            }
        });
    });

    // Editar ticket servicios
    $('.btnEditarTicketservicios').on('click', function() {
        var idTicketservicios = $(this).attr('idTicketservicios');
        
        var datos = new FormData();
        datos.append("idTicketservicios", idTicketservicios);
        
        $.ajax({
            url: "ajax/ticketservicios.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta) {
                $("#editarId").val(respuesta["id"]);
                
                // Asignar valores a los selects y actualizar Select2
                $("#editarId_servicios").val(respuesta["id_servicios"]).trigger('change');
                $("#editarId_item").val(respuesta["id_item"]).trigger('change');
                $("#editarDescripcion").val(respuesta["descripcion"]);
                $("#editarCantidad").val(respuesta["cantidad"]);
                $("#modalEditarTicketservicios").modal("show");
            }
        });
    });
    
    // Guardar edición
    $("#guardarEdicion").on("click", function() {
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
            success: function(respuesta) {
                if(respuesta.respuesta == "ok") {
                    swal({
                        type: "success",
                        title: "¡Actualizado correctamente!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then(function(result) {
                        if(result.value) {
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
});
</script>

<div class="box box-danger">
  <div class="box-header with-border">
    <h3 class="box-title">Servicios    

<?php 
if($ticketInfo["finalizado"] != "si") {

echo'

      <button type="button" class="btn btn-xs" data-toggle="modal" data-target="#modalAgregarTicketservicios">
      <i class="fa fa-plus"></i> Añadir</button>

      ';}
      ?>

    </h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>

  <div class="box-body">
    <ul class="timeline">
        <?php
        $ticketservicios = null;
        $valor = null;
        $ticketservicios = ControladorTicketservicios::ctrMostrarTicketservicios($ticketservicios, $valor);
        $servicios = ControladorServicios::ctrMostrarServicios(null, null);

        foreach ($ticketservicios as $key => $value){
            if ($value["id_ticket"] != $ticketInfo["id"]) continue;

            // Obtener el servicio y su coordinación para mostrar en el timeline
            $servicioInfo = null;
            foreach ($servicios as $servicioItem) {
                if ($servicioItem['id'] == $value["id_servicios"]) {
                    $servicioInfo = $servicioItem;
                    break;
                }
            }
            
            $nombreCoordinacion = '';
            if ($servicioInfo && !empty($servicioInfo["id_coordinacion"])) {
                $nombreCoordinacion = obtenerNombreCoordinacion($servicioInfo["id_coordinacion"]);
            }
            
            $nombreServicioMostrar = $nombreCoordinacion ? $nombreCoordinacion . ' - ' . obtenerNombreServicios($value["id_servicios"]) : obtenerNombreServicios($value["id_servicios"]);
            // <a href="#">'.$nombreServicioMostrar.'</a> 

            echo'
                <li>
                    <i class="fa fa-cogs bg-red"></i>
                    <div class="timeline-item">
                        <h3 class="timeline-header">
                            <a href="#">'.obtenerNombreServicios($value["id_servicios"]).'</a> 
                            <i class="glyphicon glyphicon-chevron-right"></i>
                            <a href="#">'.obtenerNombreItem($value["id_item"]).'</a>
                            <span class="label label-primary pull-right">Cantidad: '.$value["cantidad"].'</span>
                        </h3>
                        <div class="timeline-body">'.$value["descripcion"].'</div>
                        <span class="time"><i class="fa fa-clock-o"></i> '.$value["fecha"].'</span>
                        <div class="timeline-footer">

                        ';
if($ticketInfo["finalizado"] != "si") {

echo'
                            <button class="btn btn-xs btn-warning btnEditarTicketservicios" 
                                idTicketservicios="'.$value["id"].'">
                                <i class="fa fa-pencil"></i> Editar
                            </button>
                            <button class="btn btn-xs btn-danger btnEliminarTicketservicios" 
                                idTicketservicios="'.$value["id"].'" 
                                idTicket="'.$value["id_ticket"].'">
                                <i class="fa fa-times"></i>
                            </button>

                            ';} else {echo '<br>';}

                            echo'
                        </div>
                    </div>
                </li>
            ';
        }
        ?>
    </ul>
  </div>
</div>

<!-- Modal de crear -->
<div id="modalAgregarTicketservicios" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h5 class="modal-title"><i class="fa fa-cogs"></i> Agregar Servicios</h5>
        </div>

        <div class="modal-body">
          <div class="box-body">
            <input type="hidden" class="form-control input-lg" name="nuevoId_ticket" value="<?php echo $ticketInfo["id"];?>" required>

            <div class="form-group">
                <label><i class="fa fa-cogs"></i> Seleccionar Servicios</label>
                <select class="form-control" id="nuevoId_servicios" name="nuevoId_servicios" required style="width:100%;">
                    <option value="">Seleccionar Servicio</option>
                    <?php
                    $servicios = ControladorServicios::ctrMostrarServicios(null, null);
                    foreach ($servicios as $key => $valueServicio){
                        if ($valueServicio["estado"] != "1") continue;
                        
                        // Obtener el nombre de la coordinación asociada a este servicio
                        $nombreCoordinacion = '';
                        if (!empty($valueServicio["id_coordinacion"])) {
                            $nombreCoordinacion = obtenerNombreCoordinacion($valueServicio["id_coordinacion"]);
                        }
                        
                        // Formatear el texto como "coordinacion - servicio"
                        $textoMostrar = $valueServicio["servicios"];
                        if (!empty($nombreCoordinacion)) {
                            $textoMostrar = $nombreCoordinacion . ' - ' . $valueServicio["servicios"];
                        }
                        
                        echo '<option value="'.$valueServicio["id"].'">'.$textoMostrar.'</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label><i class="fa fa-building"></i> Seleccionar Item</label>
                <select class="form-control" id="nuevoId_item" name="nuevoId_item" required style="width:100%;">
                    <option value="">Seleccionar Item</option>
                    <?php
                    $item = ControladorItem::ctrMostrarItem(null, null);
                    foreach ($item as $key => $valueCoordinacion){
                        if ($valueCoordinacion["estado"] != "1") continue;
                        echo '<option value="'.$valueCoordinacion["id"].'">'.$valueCoordinacion["item"].'</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label><i class="fa fa-sort-numeric-asc"></i> Cantidad:</label>
                <input type="number" name="nuevoCantidad" class="form-control" min="1" value="1" required>
            </div>

            <div class="form-group">
                <label for="descripcionTextArea">Descripción detallada:</label>
                <textarea name="nuevoDescripcion" class="form-control" id="descripcionTextArea" rows="4" placeholder="Escribe una descripción amplia del servicio o item seleccionado..."  required></textarea>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar ticketservicios</button>
        </div>

        <?php
          $crearTicketservicios = new ControladorTicketservicios();
          $crearTicketservicios -> ctrCrearTicketservicios();
        ?>
      </form>
    </div>
  </div>
</div>

<!-- Modal de editar -->
<div id="modalEditarTicketservicios" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background:#f39c12; color:white">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><i class="fa fa-pencil"></i> Editar Servicios</h5>
      </div>
      <div class="modal-body">
        <div class="box-body">
          <input type="hidden" id="editarId">
          
          <div class="form-group">
            <label><i class="fa fa-cogs"></i> Seleccionar Servicios</label>
            <select class="form-control" id="editarId_servicios" required style="width:100%;">
                <option value="">Seleccionar Servicio</option>
                <?php
                $servicios = ControladorServicios::ctrMostrarServicios(null, null);
                foreach ($servicios as $key => $valueServicio){
                    if ($valueServicio["estado"] != "1") continue;
                    
                    // Obtener el nombre de la coordinación asociada a este servicio
                    $nombreCoordinacion = '';
                    if (!empty($valueServicio["id_coordinacion"])) {
                        $nombreCoordinacion = obtenerNombreCoordinacion($valueServicio["id_coordinacion"]);
                    }
                    
                    // Formatear el texto como "coordinacion - servicio"
                    $textoMostrar = $valueServicio["servicios"];
                    if (!empty($nombreCoordinacion)) {
                        $textoMostrar = $nombreCoordinacion . ' - ' . $valueServicio["servicios"];
                    }
                    
                    echo '<option value="'.$valueServicio["id"].'">'.$textoMostrar.'</option>';
                }
                ?>
            </select>
          </div>
          
          <div class="form-group">
            <label><i class="fa fa-building"></i> Seleccionar Item</label>
            <select class="form-control" id="editarId_item" required style="width:100%;">
                <option value="">Seleccionar Item</option>
                <?php
                $item = ControladorItem::ctrMostrarItem(null, null);
                foreach ($item as $key => $valueCoordinacion){
                    if ($valueCoordinacion["estado"] != "1") continue;
                    echo '<option value="'.$valueCoordinacion["id"].'">'.$valueCoordinacion["item"].'</option>';
                }
                ?>
            </select>
          </div>
          
          <div class="form-group">
            <label><i class="fa fa-sort-numeric-asc"></i> Cantidad:</label>
            <input type="number" id="editarCantidad" class="form-control" min="1" required>
          </div>
          
          <div class="form-group">
            <label>Descripción detallada:</label>
            <textarea id="editarDescripcion" class="form-control" rows="4" placeholder="Escribe una descripción amplia del servicio o item seleccionado..."  required></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-warning" id="guardarEdicion">Actualizar</button>
      </div>
    </div>
  </div>
</div>