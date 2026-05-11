<?php

if($_SESSION["perfil"] == "Especial" || $_SESSION["perfil"] == "Vendedor"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>
<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar Prueba
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar usuarios</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarPrueba">
          
          Agregar Prueba

        </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Prueba</th>
           <th>item_i</th>
           <th>item_s</th>
           <th>Estado</th>
           <th>Ultima Modificacion</th>
           <th>Fecha</th>
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php

        $item = null;
        $valor = null;

        $prueba = ControladorPrueba::ctrMostrarPrueba($item, $valor);

       foreach ($prueba as $key => $value){
         
          echo ' <tr>
                  <td>'.($key+1).'</td>
                  <td>'.$value["prueba"].'</td>
                  <td>'.$value["item_i"].'</td>
                  <td>'.$value["item_s"].'</td>';

                  if($value["estado"] != 0){

                    echo '<td><button class="btn btn-success btn-xs btnActivar" idPrueba="'.$value["id"].'" estadoPrueba="0">Activado</button></td>';

                  }else{

                    echo '<td><button class="btn btn-danger btn-xs btnActivar" idPrueba="'.$value["id"].'" estadoPrueba="1">Desactivado</button></td>';

                  }             

                  echo '<td>'.$value["modificacion"].'</td>
                        <td>'.$value["fecha"].'</td>
                  <td>

                    <div class="btn-group">
                        
                      <button class="btn btn-sm btn-warning btnEditarPrueba" idPrueba="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarPrueba"><i class="fa fa-pencil"></i></button>
                      
                      <button class="btn btn-sm btn-danger btnEliminarPrueba" idPrueba="'.$value["id"].'" prueba="'.$value["prueba"].'"><i class="fa fa-times"></i></button>
                    
                    </div>  

                  </td>

                </tr>';
        }


        ?> 

        </tbody>

       </table>

      </div>

    </div>

  </section>

</div>


















<!--- Modal de crear --->

<div id="modalAgregarPrueba" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">

        <!--- Cabezal del modal --->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h5 class="modal-title">Agregar Prueba</h5>
        </div>

        <!--- Cuerpo del modal --->

        <div class="modal-body">
          <div class="box-body">

            <!-- ENTRADA PARA PRUEBA -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-tag"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevoPrueba" id="nuevoPrueba" placeholder="Ingresar prueba" required>
              </div>
            </div>

            <!-- ENTRADA PARA ITEM_I -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevoItem_i" placeholder="Ingresar item_i" required>
              </div>
            </div>

            <!-- ENTRADA PARA ITEM_S (SELECT) -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-list"></i></span> 
                <select class="form-control input-lg" name="nuevoItem_s" required>
                  <option value="">Seleccionar item_s</option>
                  <option value="Opción 1">Opción 1</option>
                  <option value="Opción 2">Opción 2</option>
                  <option value="Opción 3">Opción 3</option>
                </select>
              </div>
            </div>

          </div>
        </div>

        <!--- Pie del Modal --->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar prueba</button>
        </div>

        <?php
          $crearPrueba = new ControladorPrueba();
          $crearPrueba -> ctrCrearPrueba();
        ?>

      </form>
    </div>
  </div>
</div>

























<!-- Modal de editar --->

<div id="modalEditarPrueba" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">

        <!--- Cabeza del Modal --->

        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Prueba</h4>
        </div>

        <!--- Cuerpo del modal --->

        <div class="modal-body">
          <div class="box-body">

            <!-- ENTRADA PARA PRUEBA (READONLY) -->
            
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-tag"></i></span> 
                <input type="text" class="form-control input-lg" id="editarPrueba" name="editarPrueba" value="" readonly>
                <input type="hidden" id="idPrueba" name="idPrueba" value="">
              </div>
            </div>

            <!-- ENTRADA PARA ITEM_I -->
            
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 
                <input type="text" class="form-control input-lg" id="editarItem_i" name="editarItem_i" value="" required>
              </div>
            </div>

            <!-- ENTRADA PARA ITEM_S (SELECT) -->

            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-list"></i></span> 
                <select class="form-control input-lg" id="editarItem_s" name="editarItem_s" required>
                  <option value="">Seleccionar item_s</option>
                  <option value="Opción 1">Opción 1</option>
                  <option value="Opción 2">Opción 2</option>
                  <option value="Opción 3">Opción 3</option>
                </select>
              </div>
            </div>

          </div>
        </div>

        <!--- Pie de Modal --->

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Modificar prueba</button>
        </div>

        <?php

          $editarPrueba = new ControladorPrueba();
          $editarPrueba -> ctrEditarPrueba();

        ?> 

      </form>
    </div>
  </div>
</div>





<?php

  $borrar = new ControladorPrueba();
  $borrar -> ctrBorrarPrueba();

?> 

