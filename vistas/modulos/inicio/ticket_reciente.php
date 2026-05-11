<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Tickets Recientes</h3>

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
            <table id="ticketsRecientesTable" class="table table-bordered table-striped table-hover dataTable dt-responsive" width="100%" role="grid">
                <thead>
                    <tr role="row">
                        <th>Ticket</th>
                        <th>Ente</th>
                        <th>Solicitante</th>
                        <th>Descripción</th>
                        <th>Prioridad</th>
                        <th>Status</th>
                        <th>Fecha</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Array para evitar duplicados
                    $ticketsMostrados = array();
                    $ticketsRecientes = array();
                    
                    // Obtener todos los tickets de coordinación
                    $ticketcoordinacion = ControladorTicketcoordinacion::ctrMostrarTicketcoordinacion(null, null);
                    
                    // Primero, obtener todos los tickets de coordinación válidos
                    if ($ticketcoordinacion) {
                        foreach ($ticketcoordinacion as $value) {
                            // Verificar si ya se mostró este ticket
                            if (in_array($value["id_ticket"], $ticketsMostrados)) {
                                continue;
                            }
                            
                            // Validar permisos según perfil
                            if ($_SESSION["id_coordinacion"] != "9" && $_SESSION["perfil"] != "Administrador") {
                                if (isset($value["id_coordinacion"]) && $value["id_coordinacion"] != $_SESSION["id_coordinacion"] && $value["id_coordinacion"] != $_SESSION["id_apoyo"]) {
                                    continue;
                                }
                            }
                            
                            // Obtener datos del ticket
                            $datosTicket = ControladorTicket::ctrMostrarTicket("id", $value["id_ticket"]);
                            
                            if ($datosTicket) {
                                // ========== NUEVA VALIDACIÓN ==========
                                // Verificar si el ticket NO está finalizado
                                // Si está finalizado (finalizado = "si"), se omite esta fila
                                if (isset($datosTicket["finalizado"]) && $datosTicket["finalizado"] == "si") {
                                    continue; // Omitir este ticket (está finalizado)
                                }
                                // ======================================
                                
                                $ticketsRecientes[] = array(
                                    'id' => $value["id_ticket"],
                                    'ente_id' => $datosTicket["id_ente"],
                                    'solicitante' => $datosTicket["solicitante"],
                                    'descripcion' => $datosTicket["descripcion"],
                                    'prioridad_id' => $datosTicket["id_prioridad"],
                                    'fecha' => $value["fecha"]
                                );
                                $ticketsMostrados[] = $value["id_ticket"];
                            }
                        }
                    }
                    
                    // Ordenar tickets por fecha (más recientes primero)
                    usort($ticketsRecientes, function($a, $b) {
                        return strtotime($b['fecha']) - strtotime($a['fecha']);
                    });
                    
                    // Limitar a los últimos 25 tickets
                    $ticketsRecientes = array_slice($ticketsRecientes, 0, 25);
                    
                    // Obtener todos los status para procesarlos fuera del bucle
                    $todosLosStatus = ControladorTicketstatus::ctrMostrarTicketstatus(null, null);
                    $ultimoStatusPorTicket = array();
                    
                    if ($todosLosStatus) {
                        foreach ($todosLosStatus as $statusItem) {
                            $idTicket = $statusItem["id_ticket"];
                            $ultimoStatusPorTicket[$idTicket] = $statusItem["id_status"];
                        }
                    }
                    
                    // Mostrar los tickets
                    foreach ($ticketsRecientes as $ticket) {
                        $destino = "index.php?ruta=ticket&id=" . $ticket['id'];
                        
                        // Obtener nombre del ente
                        $nombreEnte = obtenerNombreEnte($ticket['ente_id']);
                        
                        // Obtener prioridad
                        $datosPrioridad = obtenerDatosPrioridad($ticket['prioridad_id']);
                        
                        // Obtener status
                        $resultado = 1; // Status por defecto
                        if (isset($ultimoStatusPorTicket[$ticket['id']])) {
                            $resultado = $ultimoStatusPorTicket[$ticket['id']];
                        }
                        $datosStatus2 = obtenerDatosStatus($resultado);
                        
                        // Limitar la descripción a 50 caracteres
                        $descripcionCorta = strlen($ticket['descripcion']) > 50 
                            ? substr($ticket['descripcion'], 0, 50) . '...' 
                            : $ticket['descripcion'];
                        ?>
                        <tr>
                            <td><?php echo $ticket['id']; ?></td>
                            <td><?php echo $nombreEnte; ?></td>
                            <td><?php echo htmlspecialchars($ticket['solicitante']); ?></td>
                            <td><?php echo htmlspecialchars($descripcionCorta); ?></td>
                            <td>
                                <span class="btn btn-xs" style="color: white; background-color: <?php echo $datosPrioridad["color"]; ?>;">
                                    <?php echo $datosPrioridad["prioridad"]; ?>
                                </span>
                            </td>
                            <td>
                                <span class="btn btn-xs" style="color: white; background-color: <?php echo $datosStatus2["color"]; ?>;">
                                    <?php echo $datosStatus2["status"]; ?>
                                </span>
                            </td>
                            <td><?php echo date('d/m/Y H:i', strtotime($ticket['fecha'])); ?></td>
                            <td>
                                <button class="btn btn-xs btn-info" onclick="window.location.href='<?php echo $destino; ?>';">
                                    <i class="fa fa-info-circle"></i> Info
                                </button>
                            </td>
                        </tr>
                        <?php
                    }
                    
                    // Si no hay tickets para mostrar
                    if (empty($ticketsRecientes)) {
                        echo '<tr><td colspan="8" class="text-center">No hay tickets recientes para mostrar, Felicidades. ! Su Coordinacion es muy eficiente</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Inicializar DataTable solo para esta tabla si no existe ya
    if ($.fn.dataTable.isDataTable('#ticketsRecientesTable')) {
        $('#ticketsRecientesTable').DataTable().destroy();
    }
    
    $('#ticketsRecientesTable').DataTable({
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        "responsive": true,
        "autoWidth": false,
        "order": [[6, 'desc']],
        "pageLength": 10
    });
});
</script>