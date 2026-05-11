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
    <h1>Administrar Ticket Servicios</h1>
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
               <th>Servicios</th>
               <th>Item</th>
               <th>Cantidad</th>
               <th>Fecha</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $ticketservicios = null;
            $valor = null;
            $ticketservicios = ControladorTicketservicios::ctrMostrarTicketservicios($ticketservicios, $valor);

            foreach ($ticketservicios as $key => $value){
              echo '<tr>
                <td>'.($key+1).'</td>
                <td>'.$value["id_ticket"].'</td>
                <td>'.obtenerNombreServicios($value["id_servicios"]).'</td>
                <td>'.obtenerNombreItem($value["id_item"]).'</td>
                <td>'.$value["cantidad"].'</td>
                <td>'.$value["fecha"].'</td>
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
  $borrar = new ControladorTicketservicios();
  $borrar -> ctrBorrarTicketservicios();
?>