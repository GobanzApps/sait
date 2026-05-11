<?php


if($_SESSION["perfil"] != "Administrador" 

   
     
   ){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>

<div class="content-wrapper">

  <section class="content-header">

    <h1>Administrar Ticket Coordinacion</h1>

    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
    </ol>

  </section>

  <section class="content">

    <div class="box">



      <div class="box-body">
        

      
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Ticket</th>
           <th>Coordinacion</th>
           <th>Fecha</th>

         </tr> 

        </thead>

        <tbody>

        <?php

        $ticketcoordinacion = null;
        $valor = null;

        $ticketcoordinacion = ControladorTicketcoordinacion::ctrMostrarTicketcoordinacion($ticketcoordinacion, $valor);

       foreach ($ticketcoordinacion as $key => $value){
         
          echo ' <tr>
                  <td>'.($key+1).'</td>
                  <td>'.$value["id_ticket"].'</td>';
          echo '  <td>'.obtenerNombreCoordinacion($value["id_coordinacion"]).'</td>';
          echo '  <td>'.$value["fecha"].'</td>

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

  $borrar = new ControladorTicketcoordinacion();
  $borrar -> ctrBorrarTicketcoordinacion();

?> 

