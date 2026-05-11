
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Tickets Recientes - <?php echo strftime("%B %Y"); ?></h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>
    
    <div class="box-body">
        <div class="box-body">
            <table id="ticketsTable" class="table table-bordered table-striped table-hover dataTable dt-responsive tablas" role="grid">
                <thead>
                    <tr role="row">
                        <th>Ticket</th>
                        <th>Ente</th>
                        <th>Descripcion</th>
                        <th>Prioridad</th>
                        <th>Status</th>
                        <th>Fecha</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Obtener el mes y año actual
                    $mesActual = date('m');
                    $anioActual = date('Y');
                    
                    $ticketsMostrados = array();
                    $ticketcoordinacion = null;
                    $valor = null;
                    $ticketcoordinacion = ControladorTicketcoordinacion::ctrMostrarTicketcoordinacion($ticketcoordinacion, $valor);

                    foreach ($ticketcoordinacion as $key => $value) {
                        // Filtrar por mes actual
                        $fechaTicket = $value["fecha"];
                        $mesTicket = date('m', strtotime($fechaTicket));
                        $anioTicket = date('Y', strtotime($fechaTicket));
                        
                        // Solo mostrar tickets del mes y año actual
                        if ($mesTicket != $mesActual || $anioTicket != $anioActual) {
                            continue;
                        }
                        
                        if (in_array($value["id_ticket"], $ticketsMostrados)) {
                            continue; // Saltar este ticket si ya está duplicado
                        }
                        
                        // Obtener nombre de coordinación
                        $nombreCoordinacion = isset($value["id_coordinacion"]) ? $value["id_coordinacion"] : 'Sin asignar';
                        
                        // Obtener datos del ticket completo incluyendo id_prioridad
                        $datosTicket = obtenerDatosTicket($value["id_ticket"]);
                        
                        // Obtener prioridad usando el id_prioridad del ticket
                        $idPrioridad = $datosTicket["id_prioridad"];
                        $datosPrioridad = obtenerDatosPrioridad($idPrioridad);
                        
                        $destino = "index.php?ruta=ticket&id=" . $value["id_ticket"];

                        if ($_SESSION["id_coordinacion"] != "9" && $_SESSION["perfil"] != "Administrador") {
                            if ($value["id_coordinacion"] != $_SESSION["id_coordinacion"]) {
                                continue;
                            }
                        }

                        $ticketsMostrados[] = $value["id_ticket"];
                        ?>
                        <tr>
                            <td><?php echo $value["id_ticket"]; ?></td>
                            <td><?php echo obtenerNombreEnte($value["id_ticket"]); ?></td>
                            <td><?php echo $datosTicket["descripcion"]; ?></td>
                            <td>
                                <span class="btn btn-xs" style="color: white; background-color: <?php echo $datosPrioridad["color"]; ?>;">
                                    <?php echo $datosPrioridad["prioridad"]; ?>
                                </span>
                            </td>
                            <?php 
                            $valuestatus = ControladorTicketstatus::ctrMostrarTicketstatus(null, null);
                            $ultimoValor = null;

                            foreach ($valuestatus as $key => $valuestatus2) {
                                if ($valuestatus2["id_ticket"] != $value["id"]) {
                                    continue;
                                }
                                $ultimoValor = $valuestatus2;
                            }

                            if ($ultimoValor === null) {
                                $resultado = 1;
                            } else {
                                $resultado = $ultimoValor["id_status"];
                            }

                            $datosStatus2 = obtenerDatosStatus($resultado);
                            ?>
                            <td>
                                <span class="btn btn-xs" style="color: white; background-color: <?php echo $datosStatus2["color"]; ?>;">
                                    <?php echo $datosStatus2["status"]; ?>
                                </span>
                            </td>
                            <td><?php echo date('d/m/Y', strtotime($value["fecha"])); ?></td>
                            <td>
                                <button class="btn btn-xs btn-info" onclick="window.location.href='<?php echo $destino; ?>';">Info</button>
                            </td>
                        </tr>
                        <?php
                    }
                    
                    // Si no hay tickets en el mes actual, mostrar mensaje
                    if (empty($ticketsMostrados)) {
                        echo '<tr><td colspan="7" class="text-center">No hay tickets registrados en el mes actual</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



