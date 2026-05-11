<script>

$(document).ready(function() {
    // Eliminar ticket coordinación
    $('.btnEliminarTicketcoordinacion').on('click', function() {
    var idTicketcoordinacion = $(this).attr('idTicketcoordinacion');
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
                        window.location = "index.php?ruta=ticket&id=" + idTicket + "&idTicketcoordinacion=" + idTicketcoordinacion;
            }
        });
    });
});

</script>


<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Coordinacion  
      
    <?php


      if($ticketInfo["finalizado"] != "si") {


        if($_SESSION["perfil"] == "Administrador" ||
		       $_SESSION["id_coordinacion"] == "9"			//Centro deAtencion
        ){
        echo'
          <button type="button" class="btn btn-xs" data-toggle="modal" data-target="#modalAgregarTicketcoordinacion">
          <i class="fa fa-plus"></i> Añadir</button>
        ';
        }

      }
    ?>
    </h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
 <!--     <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
        <i class="fa fa-times"></i> -->
    </div>
  </div>


  <div class="box-body">

    <div class="col-md-12">

      <?php

        $ticketcoordinacion = null;
        $valor = null;

        $ticketcoordinacion = ControladorTicketcoordinacion::ctrMostrarTicketcoordinacion($ticketcoordinacion, $valor);

        foreach ($ticketcoordinacion as $key => $value){

          if ($value["id_ticket"] != $ticketInfo["id"]) continue;
            
          echo '
              <button 
                  idTicketcoordinacion="'.$value["id"].'"
                  idTicket="'.$value["id_ticket"].'"
                  class="btn btn-xs btn-primary';

          if( $ticketInfo["finalizado"] != "si" && 
              ($_SESSION["perfil"] == "Administrador" || $_SESSION["id_coordinacion"] == "9") 
          ){
              echo ' btnEliminarTicketcoordinacion"><i class="fa fa-times"></i> ';
          } else { 
              echo '">'; 
          }

          echo ' ' . obtenerNombreCoordinacion($value["id_coordinacion"]) . '
              </button>';

      
        }

      ?>
    
    </div>

  </div>

</div>






<!--- Modal de crear --->

<div id="modalAgregarTicketcoordinacion" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">

        <!--- Cabezal del modal --->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h5 class="modal-title">Agregar Coordinacion</h5>
        </div>

        <!--- Cuerpo del modal --->

        <div class="modal-body">
          <div class="box-body">

            <!-- ENTRADA PARA PRUEBA -->

            <div class="form-group">
                <input type="hidden" class="form-control input-lg" name="nuevoId_ticket" value="<?php echo $ticketInfo["id"];?>" required>
                <label><i class="fa fa-building"></i> Seleccionar Coordinación</label>
                <select class="form-control" name="nuevoId_coordinacion">
                    <option value="0">Seleccionar Coordinacion</option>
                    <?php
                    $coordinacion = ControladorCoordinacion::ctrMostrarCoordinacion($null, null);
                    foreach ($coordinacion as $key => $valueCoordinacion){
                      if ($valueCoordinacion["estado"] != "1") continue;
                      echo '<option value="'.$valueCoordinacion["id"].'">'.$valueCoordinacion["coordinacion"].'</option>';
                    }
                    ?>
                </select>
            </div>

          </div>
        </div>

        <!--- Pie del Modal --->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar ticketcoordinacion</button>
        </div>

        <?php
          $crearTicketcoordinacion = new ControladorTicketcoordinacion();
          $crearTicketcoordinacion -> ctrCrearTicketcoordinacion();
        ?>

      </form>
    </div>
  </div>
</div>



