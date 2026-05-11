<!-- MODAL AGREGAR TICKET -->
     <div class="modal fade" id="modalAgregarTicket" tabindex="-1" role="dialog" aria-labelledby="modalAgregarTicketLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background-color: #3c8dbc; color: white;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" style="color: white;">&times;</span>
            </button>
            <h4 class="modal-title" id="modalAgregarTicketLabel">
              <i class="fa fa-ticket"></i> Agregar Nuevo Ticket
            </h4>
          </div>

          <form role="form" method="post" enctype="multipart/form-data">
          
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <!-- Select2 para ENTE -->
                  <div class="form-group">
                    <label for="ente"><i class="fa fa-building"></i> Ente</label>
                    <select class="form-control select2-ente" id="ente" name="nuevoEnte" style="width: 100%;" required>

                        <option value="">Seleccione un ente...</option>

                        <?php
                        $entes = ControladorEntes::ctrMostrarEntes(null, null);
                        foreach ($entes as $key => $value){
                        if ($value["estado"] != "1") continue;
                            echo '<option value="'.$value["id"].'">'.$value["entes"].'</option>';
                        }
                        ?>

                    </select>
                  </div>

                  <!-- Campo SOLICITANTE -->
                  <div class="form-group">
                    <label for="solicitante"><i class="fa fa-user"></i> Solicitante</label>
                    <input type="text" class="form-control" id="solicitante" name="nuevoSolicitante" placeholder="Nombre del solicitante" required>
                    <input type="hidden" class="form-control" name="nuevoTicket" required>
                  </div>


                </div>

                <div class="col-md-6">
                  <!-- Select2 para MEDIO -->
                  <div class="form-group">
                    <label for="medio"><i class="fa fa-phone"></i> Medio de Recepción</label>
                    <select class="form-control select2-medio" id="medio" name="nuevoMedio" style="width: 100%;" required>
                      <option value="">Seleccione un medio...</option>
                        <?php
                        $medio = ControladorMedio::ctrMostrarMedio(null, null);
                        foreach ($medio as $key => $valueMedio){
                        if ($valueMedio["estado"] != "1") continue;
                            echo '<option value="'.$valueMedio["id"].'">'.$valueMedio["medio"].'</option>';
                        }
                        ?>
                    </select>
                  </div>

                  <!-- Select2 para PRIORIDAD -->
                  <div class="form-group">
                    <label for="prioridad"><i class="fa fa-flag"></i> Prioridad</label>
                    <select class="form-control select2-prioridad" id="prioridad" name="nuevoPrioridad" style="width: 100%;" required>
                      <option value="">Seleccione una prioridad...</option>
                        <?php
                        $prioridad = ControladorPrioridad::ctrMostrarPrioridad(null, null);
                        foreach ($prioridad as $key => $valuePrioridad){
                        if ($valuePrioridad["estado"] != "1") continue;
                            echo '<option value="'.$valuePrioridad["id"].'" data-color="'.$valuePrioridad["color"].'">'.$valuePrioridad["prioridad"].'</option>';
                        }
                        ?>

                    </select>
                  </div>

                </div>
              </div>

             <div class="row">
                <div class="col-md-12">     
                  <!-- Campo DESCRIPCIÓN -->
                  <div class="form-group">
                    <label for="descripcion"><i class="fa fa-file-text"></i> Descripción</label>
                    <textarea class="form-control" id="descripcion" name="nuevoDescripcion" rows="4" placeholder="Describa el problema o solicitud..." required></textarea>
                  </div>
                
                </div>
             </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="alert alert-info alert-dismissible" style="margin-top: 10px;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fa fa-info-circle"></i> Información</h5>
                    Complete todos los campos marcados con <i class="fa fa-asterisk text-red"></i> para registrar el ticket.
                  </div>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                <i class="fa fa-times"></i> Cancelar
              </button>
              <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> Guardar Ticket
              </button>
            </div>
            
            <?php
                $crearTicket = new ControladorTicket();
                $crearTicket -> ctrCrearTicket();
            ?>

          </form>
        </div>
      </div>
    </div>



 <script>
  </script>

   <style>
    /* Estilos adicionales para mejorar la apariencia */
    .select2-container--bootstrap .select2-selection {
      border-radius: 4px;
    }
    .modal-header {
      border-bottom: none;
    }
    .box-body table th {
      background-color: #f4f4f4;
    }
    .select2-container--bootstrap .select2-results__option--highlighted[aria-selected] {
      background-color: #3c8dbc;
    }
  </style>
  