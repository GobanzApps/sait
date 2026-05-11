                    <?php
                    // Obtener el mes y año actual
                    $mesActual = date('m');
                    $anioActual = date('Y');

                    $countTicket = 0;
                    $ResueltoStatus = 0;
                    $NoResueltoStatus = 0;
                    $PausaStatus = 0;
                    
                    $ticketsMostrados = array();
                    $ticketcoordinacion = null;
                    $valor = null;
                    $ticketcoordinacion = ControladorTicketcoordinacion::ctrMostrarTicketcoordinacion($ticketcoordinacion, $valor);

                    // Obtener todos los status una sola vez fuera del bucle
                    $todosLosStatus = ControladorTicketstatus::ctrMostrarTicketstatus(null, null);
                    
                    // Crear un array asociativo para acceso rápido al último status de cada ticket
                    $ultimoStatusPorTicket = array();
                    if ($todosLosStatus) {
                        foreach ($todosLosStatus as $statusItem) {
                            $idTicket = $statusItem["id_ticket"];
                            // Guardar el último status encontrado (sobrescribe para mantener el último)
                            $ultimoStatusPorTicket[$idTicket] = $statusItem["id_status"];
                        }
                    }

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
                            if ($value["id_coordinacion"] != $_SESSION["id_coordinacion"] && $value["id_coordinacion"] != $_SESSION["id_apoyo"]) {
                                continue;
                            }
                        }

                        $ticketsMostrados[] = $value["id_ticket"];


                        // CONTEO DE TICKET POR MES
                        if($value["id_ticket"] != null) {
                            $countTicket++;
                        }

                        // Obtener el último status del ticket
                        $resultado = 1; // Status por defecto
                        if (isset($ultimoStatusPorTicket[$value["id_ticket"]])) {
                            $resultado = $ultimoStatusPorTicket[$value["id_ticket"]];
                        }

                        $datosStatus2 = obtenerDatosStatus($resultado);

                        if ($datosStatus2["status"] == "Resuelto") { $ResueltoStatus++; }
                        if ($datosStatus2["status"] == "En proceso" ||
                            $datosStatus2["status"] == "Pendiente" ||
                            $datosStatus2["status"] == "Nuevo" ||
                            $datosStatus2["status"] == ""
                            ) {$NoResueltoStatus++;}
                        if ($datosStatus2["status"] == "En Pausa") { $PausaStatus++; }


                    }
                    
                    // Si no hay tickets en el mes actual, mostrar mensaje
                    if (empty($ticketsMostrados)) {
                        echo '<tr><td colspan="7" class="text-center">No hay tickets registrados en el mes actual</td><tr>';
                    }
                    ?>
      

<div class="row">
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?php echo $countTicket; ?></h3>
                <p>Tickets del Mes</p>
            </div>
            <div class="icon">
                <i class="fa fa-ticket"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?php echo $ResueltoStatus; ?></h3>
                <p>Resueltos</p>
            </div>
            <div class="icon">
                <i class="fa fa-check-circle"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3><?php echo $NoResueltoStatus; ?></h3>
                <p>Nuevo / Pendiente / En proceso</p>
            </div>
            <div class="icon">
                <i class="fa fa-clock-o"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
            <div class="inner">
                <h3><?php echo $PausaStatus; ?></h3>
                <p>En Pausa</p>
            </div>
            <div class="icon">
                <i class="fa fa-minus-circle"></i>
            </div>
        </div>
    </div>
</div>