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

    <h1>Administrar Medio</h1>

    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar usuarios</li>
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarMedio">Agregar Medio</button>
      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Medio</th>
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

        $medio = ControladorMedio::ctrMostrarMedio($item, $valor);

       foreach ($medio as $key => $value){
         
          echo ' <tr>
                  <td>'.($key+1).'</td>
                  <td>'.$value["medio"].'</td>
                  <td><div style="background-color: '.$value["color"].'; height: 18px; width: 60px"></div></td>';

                  if($value["estado"] != 0){

                    echo '<td><button class="btn btn-success btn-xs btnActivar" idMedio="'.$value["id"].'" estadoMedio="0">Activado</button></td>';

                  }else{

                    echo '<td><button class="btn btn-danger btn-xs btnActivar" idMedio="'.$value["id"].'" estadoMedio="1">Desactivado</button></td>';

                  }             

                  echo '<td>'.$value["modificacion"].'</td>
                        <td>'.$value["fecha"].'</td>
                  <td>

                    <div class="btn-group">
                        
                      <button class="btn btn-sm btn-warning btnEditarMedio" idMedio="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarMedio"><i class="fa fa-pencil"></i></button>
                  ';
                  if($_SESSION["perfil"] == "Administrador"){
                    echo '    
                      <button class="btn btn-sm btn-danger btnEliminarMedio" idMedio="'.$value["id"].'" medio="'.$value["medio"].'"><i class="fa fa-times"></i></button>
                    ';
                  }
                  echo '
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

<div id="modalAgregarMedio" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">

        <!--- Cabezal del modal --->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h5 class="modal-title">Agregar Medio</h5>
        </div>

        <!--- Cuerpo del modal --->

        <div class="modal-body">
          <div class="box-body">

            <!-- ENTRADA PARA PRUEBA -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-tag"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevoMedio" id="nuevoMedio" placeholder="Ingresar medio" required>
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
          <button type="submit" class="btn btn-primary">Guardar medio</button>
        </div>

        <?php
          $crearMedio = new ControladorMedio();
          $crearMedio -> ctrCrearMedio();
        ?>

      </form>
    </div>
  </div>
</div>

























<!-- Modal de editar --->

<div id="modalEditarMedio" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">

        <!--- Cabeza del Modal --->

        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Medio</h4>
        </div>

        <!--- Cuerpo del modal --->

        <div class="modal-body">
          <div class="box-body">

            <!-- ENTRADA PARA PRUEBA (READONLY) -->
            
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-tag"></i></span> 
                <input type="text" class="form-control input-lg" id="editarMedio" name="editarMedio" value="">
                <input type="hidden" id="idMedio" name="idMedio" value="">
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
          <button type="submit" class="btn btn-primary">Modificar medio</button>
        </div>

        <?php

          $editarMedio = new ControladorMedio();
          $editarMedio -> ctrEditarMedio();

        ?> 

      </form>
    </div>
  </div>
</div>





<?php

  $borrar = new ControladorMedio();
  $borrar -> ctrBorrarMedio();

?> 

