<?php


if($_SESSION["perfil"] != "Administrador" &&
   $_SESSION["id_coordinacion"] != "9"	  &&
   $_SESSION["usuario"] != "agamardo"            			//Angie		//Centro deAtencion
   
     
   ){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>



<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar Ticket
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar Tickets</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarTicket">
          
          Agregar Ticket

        </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Ticket</th>
           <th>Ente</th>
           <th>Solicitante</th>
           <th>Descripcion</th>
           <th>Medio</th>
           <th>Prioridad</th>
           <th>status</th>
           <th>Finalizado</th>
           <th>Estado</th>
           <th>Usuario creador</th>
           <th>Ultima Modificacion</th>
           <th>Acciones</th>

          </tr>

        </thead>

        <tbody>

        <?php

        $item = null;
        $valor = null;
        
        $ticket = ControladorTicket::ctrMostrarTicket($item, $valor);
        
        // Invertir el array para que el último ticket sea el primero
        $ticket = array_reverse($ticket);

        foreach ($ticket as $key => $value){

          $destino = "index.php?ruta=ticket&id=" . $value["id"];
         
          echo '<tr>
                    <td>'.($key+1).'</td>
                    <td>'.$value["id"].'</td>';

          echo    '<td>'.obtenerNombreEnte($value["id_ente"]).'</td>';
                 
          echo    '<td>'.$value["solicitante"].'</td>
                    <td>'.$value["descripcion"].'</td>';

          echo    '<td>'.obtenerNombreMedio($value["id_medio"]).'</td>';

          $datosPrioridad = obtenerDatosPrioridad($value["id_prioridad"]);

          echo '<td><span class="btn btn-xs" style="color: white; background-color: ' . $datosPrioridad["color"] . ';">' . $datosPrioridad["prioridad"] . '</span></td>';

          $valuestatus = ControladorTicketstatus::ctrMostrarTicketstatus(null, null);
          $ultimoValor = null;

          foreach ($valuestatus as $key => $valuestatus2){
              if ($valuestatus2["id_ticket"] != $value["id"]) continue;
              $ultimoValor = $valuestatus2;
          }

          if ($ultimoValor === null) {
              $resultado = 1;
          } else {
              $resultado = $ultimoValor["id_status"];
          }

          $datosStatus2 = obtenerDatosStatus($resultado);

          echo '<td><span class="btn btn-xs" style="color: white; background-color: ' . $datosStatus2["color"] . ';">' . $datosStatus2["status"] . ' </span></td>';
          
          // Mostrar estado de Finalizado
          if($value["finalizado"] == "si"){
              echo '<td><button class="btn btn-success btn-xs btnFinalizar" idTicket="'.$value["id"].'" finalizadoTicket="si">Finalizado</button></td>';
          }else{
              echo '<td><button class="btn btn-warning btn-xs btnFinalizar" idTicket="'.$value["id"].'" finalizadoTicket="no">No Finalizado</button></td>';
          }
          
          if($value["estado"] != 0){

            echo    '<td><button class="btn btn-success btn-xs btnActivar" idTicket="'.$value["id"].'" estadoTicket="0">Activado</button></td>';

          }else{

            echo    '<td><button class="btn btn-danger btn-xs btnActivar" idTicket="'.$value["id"].'" estadoTicket="1">Desactivado</button></td>';

          }             

          echo    '<td>'.obtenerNombreUsuario($value["id_usuario"]).'</td>';

          echo    '<td>'.$value["modificacion"].'</td>
                    <td>

                      <div class="btn-group">';

          if($_SESSION["perfil"] == "Administrador" ||
              $_SESSION["id_coordinacion"] == "9"){

          echo'          
                        <button class="btn btn-xs btn-warning btnEditarTicket" idTicket="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarTicket"><i class="fa fa-pencil"></i></button>
              ';}

          echo'
                        <button class="btn btn-xs btn-info" onclick="window.location.href=\'' . $destino . '\';">Info</button>

               ';
               if($_SESSION["perfil"] == "Administrador"){
               
          echo'              <button class="btn btn-xs btn-danger btnEliminarTicket" idTicket="'.$value["id"].'" ticket="'.$value["ticket"].'"><i class="fa fa-times"></i></button>

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


<?php 
include "modal/CrearTicket.php";
include "modal/EditarTicket.php";
?>

<?php

  $borrar = new ControladorTicket();
  $borrar -> ctrBorrarTicket();

?> 