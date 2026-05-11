<?php


/* Ticket */
function obtenerDatosTicket($id_ticket) {
    static $tickets = null;
    
    if ($tickets === null) {
        $tickets = ControladorTicket::ctrMostrarTicket(null, null);
        $tickets = array_column($tickets, null, 'id');
    }
    
    return $tickets[$id_ticket] ?? ['id' => '', 'descripcion' => ''];
}

/* Entes */
function obtenerNombreEnte($id_ente) {
    static $entes = null;
    
    if ($entes === null) {
        $entes = ControladorEntes::ctrMostrarEntes(null, null);
        $entes = array_column($entes, 'entes', 'id');
    }
    
    return $entes[$id_ente] ?? '';
}

/* Medios */
function obtenerNombreMedio($id_medio) {
    static $medio = null;
    
    if ($medio === null) {
        $medio = ControladorMedio::ctrMostrarMedio(null, null);
        $medio = array_column($medio, 'medio', 'id');
    }
    
    return $medio[$id_medio] ?? '';
}

/* Prioridad */
function obtenerDatosPrioridad($id_prioridad) {
    static $prioridad = null;
    
    if ($prioridad === null) {
        $prioridad = ControladorPrioridad::ctrMostrarPrioridad(null, null);
        $prioridad = array_column($prioridad, null, 'id');
    }
    
    return $prioridad[$id_prioridad] ?? ['prioridad' => '', 'color' => ''];
}

/* Status */
function obtenerDatosStatus($id_status) {
    static $status = null;
    
    if ($status === null) {
        $status = ControladorStatus::ctrMostrarStatus(null, null);
        $status = array_column($status, null, 'id');
    }
    
    return $status[$id_status] ?? ['status' => '', 'color' => ''];
}

/* COORDINACION */
function obtenerNombreCoordinacion($id_coordinacion) {
    static $coordinacion = null;
    
    if ($coordinacion === null) {
        $coordinacion = ControladorCoordinacion::ctrMostrarCoordinacion(null, null);
        $coordinacion = array_column($coordinacion, 'coordinacion', 'id');
    }
    
    return $coordinacion[$id_coordinacion] ?? '';
}

/* APOYO - nueva función */
function obtenerNombreApoyo($id_apoyo) {
    static $apoyo = null;
    
    if ($apoyo === null) {
        $apoyo = ControladorCoordinacion::ctrMostrarCoordinacion(null, null);
        $apoyo = array_column($apoyo, 'coordinacion', 'id');
    }
    
    return $apoyo[$id_apoyo] ?? '';
}

/* USUARIO */
function obtenerNombreUsuario($id_usuario) {
    static $usuario = null;
    
    if ($usuario === null) {
        $usuario = ControladorUsuarios::ctrMostrarUsuarios(null, null);
        $usuario = array_column($usuario, 'usuario', 'id');
    }
    
    return $usuario[$id_usuario] ?? '';
}

/* SERVICIOS */
function obtenerNombreServicios($id_servicios) {
    static $servicios = null;
    
    if ($servicios === null) {
        $servicios = ControladorServicios::ctrMostrarServicios(null, null);
        $servicios = array_column($servicios, 'servicios', 'id');
    }
    
    return $servicios[$id_servicios] ?? '';
}

/* ITEMs */
function obtenerNombreItem($id_item) {
    static $item = null;
    
    if ($item === null) {
        $item = ControladorItem::ctrMostrarItem(null, null);
        $item = array_column($item, 'item', 'id');
    }
    
    return $item[$id_item] ?? '';
}

/* Status - Obtener datos completos del usuario */
function obtenerDatosUsuario($id_usuario) {
    static $usuario = null;
    
    if ($usuario === null) {
        $usuario = ControladorUsuarios::ctrMostrarUsuarios(null, null);
        $usuario = array_column($usuario, null, 'id');
    }
    
    return $usuario[$id_usuario] ?? ['usuario' => '', 'nombre' => '', 'apellido' => ''];
}

/* Tipo Docs */
function obtenerNombreTipodocs($id_tipodocs) {
    static $tipodocs = null;
    
    if ($tipodocs === null) {
        $tipodocs = ControladorTipodocs::ctrMostrarTipodocs(null, null);
        $tipodocs = array_column($tipodocs, 'tipodocs', 'id');
    }
    
    return $tipodocs[$id_tipodocs] ?? '';
}

/* Documentos - CORREGIDO: Ahora usa ControladorDocumento */
function obtenerNombreDocumento($id_documento) {
    static $documentos = null;
    
    if ($documentos === null) {
        $documentos = ControladorDocumento::ctrMostrarDocumento(null, null);
        $documentos = array_column($documentos, 'documento', 'id');
    }
    
    return $documentos[$id_documento] ?? '';
}

/* Obtener documentos por ID de ticket */
function obtenerDocumentosPorTicket($id_ticket) {
    static $documentosPorTicket = null;
    
    if ($documentosPorTicket === null) {
        $todosDocumentos = ControladorDocumento::ctrMostrarDocumento(null, null);
        $documentosPorTicket = [];
        foreach ($todosDocumentos as $doc) {
            if ($doc['id_ticket']) {
                $documentosPorTicket[$doc['id_ticket']][] = $doc;
            }
        }
    }
    
    return $documentosPorTicket[$id_ticket] ?? [];
}










/* USUARIOS - Obtener nombres a partir de un JSON de IDs */
function obtenerNombresUsuariosPorIds($json_ids) {
    $ids = json_decode($json_ids, true);
    if (empty($ids) || !is_array($ids)) return '<span class="text-muted">Ninguno</span>';
    
    $usuarios = ControladorUsuarios::ctrMostrarUsuarios(null, null);
    $usuarios_por_id = array_column($usuarios, null, 'id');
    
    $html = '';
    foreach ($ids as $id) {
        if (isset($usuarios_por_id[$id])) {
            $user = $usuarios_por_id[$id];
            $html .= '<li><i class="fa fa-user"></i> ' . htmlspecialchars($user['nombre'] . ' ' . $user['apellido']) . ' (' . htmlspecialchars($user['usuario']) . ')</li>';
        } else {
            $html .= '<li><i class="fa fa-user"></i> <span class="text-muted">ID: ' . $id . ' (No encontrado)</span></li>';
        }
    }
    return $html;
}

/* SERVICIOS - Obtener nombres a partir de un JSON de IDs */
function obtenerNombresServiciosPorIds($json_ids) {
    $ids = json_decode($json_ids, true);
    if (empty($ids) || !is_array($ids)) return '<span class="text-muted">Ninguno</span>';
    
    $servicios = ControladorServicios::ctrMostrarServicios(null, null);
    $servicios_por_id = array_column($servicios, null, 'id');
    
    $html = '';
    foreach ($ids as $id) {
        if (isset($servicios_por_id[$id])) {
            $serv = $servicios_por_id[$id];
            $html .= '<li><i class="fa fa-cogs"></i> ' . htmlspecialchars($serv['servicios']) . '</li>';
        } else {
            $html .= '<li><i class="fa fa-cogs"></i> <span class="text-muted">ID: ' . $id . ' (No encontrado)</span></li>';
        }
    }
    return $html;
}

/* ENTES - Obtener nombres a partir de un JSON de IDs */
function obtenerNombresEntesPorIds($json_ids) {
    $ids = json_decode($json_ids, true);
    if (empty($ids) || !is_array($ids)) return '<span class="text-muted">Ninguno</span>';
    
    $entes = ControladorEntes::ctrMostrarEntes(null, null);
    $entes_por_id = array_column($entes, null, 'id');
    
    $html = '';
    foreach ($ids as $id) {
        if (isset($entes_por_id[$id])) {
            $ente = $entes_por_id[$id];
            $html .= '<li><i class="fa fa-building"></i> ' . htmlspecialchars($ente['entes']) . '</li>';
        } else {
            $html .= '<li><i class="fa fa-building"></i> <span class="text-muted">ID: ' . $id . ' (No encontrado)</span></li>';
        }
    }
    return $html;
}


















?>