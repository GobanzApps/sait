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

    <h1>Administrar Entes</h1>

    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar usuarios</li>
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarEntes">Agregar Entes</button>
      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Entes</th>
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

        $entes = ControladorEntes::ctrMostrarEntes($item, $valor);

       foreach ($entes as $key => $value){
         
          echo ' <tr>
                  <td>'.($key+1).'</td>
                  <td>'.$value["entes"].'</td>';

                  if($value["estado"] != 0){

                    echo '<td><button class="btn btn-success btn-xs btnActivar" idEntes="'.$value["id"].'" estadoEntes="0">Activado</button></td>';

                  }else{

                    echo '<td><button class="btn btn-danger btn-xs btnActivar" idEntes="'.$value["id"].'" estadoEntes="1">Desactivado</button></td>';

                  }             

                  echo '<td>'.$value["modificacion"].'</td>
                        <td>'.$value["fecha"].'</td>
                  <td>

                    <div class="btn-group">
                        
                      <button class="btn btn-sm btn-warning btnEditarEntes" idEntes="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarEntes"><i class="fa fa-pencil"></i></button>

                  ';  
                  if($_SESSION["perfil"] == "Administrador"){
                  echo '                      
                      <button class="btn btn-sm btn-danger btnEliminarEntes" idEntes="'.$value["id"].'" entes="'.$value["entes"].'"><i class="fa fa-times"></i></button>
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

<div id="modalAgregarEntes" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">

        <!--- Cabezal del modal --->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h5 class="modal-title">Agregar Entes</h5>
        </div>

        <!--- Cuerpo del modal --->

        <div class="modal-body">
          <div class="box-body">

            <!-- ENTRADA PARA PRUEBA -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-tag"></i></span> 
                <input type="text" class="form-control input-lg" name="nuevoEntes" id="nuevoEntes" placeholder="Ingresar entes" required>
              </div>
            </div>

          </div>
        </div>

        <!--- Pie del Modal --->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar entes</button>
        </div>

        <?php
          $crearEntes = new ControladorEntes();
          $crearEntes -> ctrCrearEntes();
        ?>

      </form>
    </div>
  </div>
</div>

























<!-- Modal de editar --->

<div id="modalEditarEntes" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">

        <!--- Cabeza del Modal --->

        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Entes</h4>
        </div>

        <!--- Cuerpo del modal --->

        <div class="modal-body">
          <div class="box-body">

            <!-- ENTRADA PARA PRUEBA (READONLY) -->
            
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-tag"></i></span> 
                <input type="text" class="form-control input-lg" id="editarEntes" name="editarEntes" value="">
                <input type="hidden" id="idEntes" name="idEntes" value="">
              </div>
            </div>

          </div>
        </div>

        <!--- Pie de Modal --->

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Modificar entes</button>
        </div>

        <?php

          $editarEntes = new ControladorEntes();
          $editarEntes -> ctrEditarEntes();

        ?> 

      </form>
    </div>
  </div>
</div>





<?php

  $borrar = new ControladorEntes();
  $borrar -> ctrBorrarEntes();

?> 

