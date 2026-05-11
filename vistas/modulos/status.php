<?php


if($_SESSION["perfil"] != "Administrador" &&
   $_SESSION["id_coordinacion"] != "9"			//Centro deAtencion
   
     
   ){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>


<div class="content-wrapper">

  <section class="content-header">

    <h1>Administrar Status</h1>

    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar usuarios</li>
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarStatus">Agregar Status</button>
      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Status</th>
           <th>Color</th>
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

        $status = ControladorStatus::ctrMostrarStatus($item, $valor);

       foreach ($status as $key => $value){
         
          echo ' <tr>
                  <td>'.($key+1).'</td>
                  <td>'.$value["status"].'</td>
                  <td><div style="background-color: '.$value["color"].'; height: 18px; width: 60px"></div></td>';

                  if($value["estado"] != 0){

                    echo '<td><button class="btn btn-success btn-xs btnActivar" idStatus="'.$value["id"].'" estadoStatus="0">Activado</button></td>';

                  }else{

                    echo '<td><button class="btn btn-danger btn-xs btnActivar" idStatus="'.$value["id"].'" estadoStatus="1">Desactivado</button></td>';

                  }             

                  echo '<td>'.$value["modificacion"].'</td>
                        <td>'.$value["fecha"].'</td>
                  <td>

                    <div class="btn-group">
                        
                      <button class="btn btn-sm btn-warning btnEditarStatus" idStatus="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarStatus"><i class="fa fa-pencil"></i></button>

                  ';  
                  if($_SESSION["perfil"] == "Administrador"){
                  echo '
                      <button class="btn btn-sm btn-danger btnEliminarStatus" idStatus="'.$value["id"].'" status="'.$value["status"].'"><i class="fa fa-times"></i></button>
                  ';}
                  
                  echo'
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

<div id="modalAgregarStatus" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">

        <!--- Cabezal del modal --->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h5 class="modal-title">Agregar Status</h5>
        </div>

        <!--- Cuerpo del modal --->

        <div class="modal-body">
          <div class="box-body">

            <!-- ENTRADA PARA PRUEBA -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-tag"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevoStatus" id="nuevoStatus" placeholder="Ingresar status" required>
              </div>
            </div>

            <!-- ENTRADA PARA COLOR -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-arrows-alt"></i></span> 
                <input type="color" class="form-control input-lg" name="nuevoColor" value="#3c8dbc" />
             
              </div>
            </div>



          </div>
        </div>

        <!--- Pie del Modal --->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar status</button>
        </div>

        <?php
          $crearStatus = new ControladorStatus();
          $crearStatus -> ctrCrearStatus();
        ?>

      </form>
    </div>
  </div>
</div>

























<!-- Modal de editar --->

<div id="modalEditarStatus" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">

        <!--- Cabeza del Modal --->

        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Status</h4>
        </div>

        <!--- Cuerpo del modal --->

        <div class="modal-body">
          <div class="box-body">

            <!-- ENTRADA PARA PRUEBA (READONLY) -->
            
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-tag"></i></span> 
                <input type="text" class="form-control input-lg" id="editarStatus" name="editarStatus" value="">
                <input type="hidden" id="idStatus" name="idStatus" value="">
              </div>
            </div>

            <!-- ENTRADA PARA COLOR -->
            
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-arrows-alt"></i></span> 
                
                <input type="color" class="form-control input-lg" id="editarColor" name="editarColor" value="">
              </div>
            </div>



          </div>
        </div>

        <!--- Pie de Modal --->

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Modificar status</button>
        </div>

        <?php

          $editarStatus = new ControladorStatus();
          $editarStatus -> ctrEditarStatus();

        ?> 

      </form>
    </div>
  </div>
</div>





<?php

  $borrar = new ControladorStatus();
  $borrar -> ctrBorrarStatus();

?> 

