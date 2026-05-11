<?php
// Archivo: vistas/modulos/reportesActividad.php

if( $_SESSION["perfil"] != "Administrador"  &&
    $_SESSION["perfil"] != "Coordinacion"    &&
    $_SESSION["id_coordinacion"] != "11"    &&  //Archivo
    $_SESSION["id_coordinacion"] != "9"     &&  //centro de atencion
    $_SESSION["usuario"] != "agamardo"      //Angie
){

  echo '<script>
    window.location = "inicio";
  </script>';
  return;
}
?>

<div class="content-wrapper" style="min-height: 460.2px;">
    <section class="content-header">
      <h1>
        Reporte de Actividades
        <small>Filtros: Rango Fechas | Coordinación | Servicios | Entes | Usuarios</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Reporte de Actividades</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- Panel de filtros -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-filter"></i> Panel de filtros avanzados</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="filter-buttons">
                <!-- Filtro de rango de fechas -->
                <div class="date-range-group">
                  <label><i class="fa fa-calendar"></i> Rango fecha:</label>
                  <input type="text" id="dateRangePicker" class="form-control input-sm" style="width: 240px; display: inline-block;" placeholder="Seleccionar rango de fechas">
                  <button type="button" id="clearDateBtn" class="clear-filter-btn" title="Limpiar filtro de fecha">
                    <i class="fa fa-times-circle"></i>
                  </button>
                </div>

                <!-- Filtro de coordinación -->
                <div class="filter-group">
                  <label><i class="fa fa-building"></i> Coordinación:</label>
                  <select id="coordinacionFilter" class="form-control input-sm filter-select" style="width: 200px;">
                    <option value="">Todas las coordinaciones</option>
                    <?php
                    $coordinaciones = ControladorCoordinacion::ctrMostrarCoordinacion(null, null);
                    foreach ($coordinaciones as $value) {
                      echo '<option value="'.$value["id"].'">'.$value["coordinacion"].'</option>';
                    }
                    ?>
                  </select>
                  <button type="button" class="clear-filter-btn clearCoordinacionBtn" title="Limpiar">
                    <i class="fa fa-times-circle"></i>
                  </button>
                </div>

                <!-- Filtro de servicios (desde JSON) -->
                <div class="filter-group">
                  <label><i class="fa fa-cogs"></i> Servicio:</label>
                  <select id="servicioFilter" class="form-control input-sm filter-select" style="width: 200px;">
                    <option value="">Todos los servicios</option>
                  </select>
                  <button type="button" class="clear-filter-btn clearServicioBtn" title="Limpiar">
                    <i class="fa fa-times-circle"></i>
                  </button>
                </div>

                <!-- Filtro de entes (desde JSON) -->
                <div class="filter-group">
                  <label><i class="fa fa-institution"></i> Ente:</label>
                  <select id="enteFilter" class="form-control input-sm filter-select" style="width: 200px;">
                    <option value="">Todos los entes</option>
                  </select>
                  <button type="button" class="clear-filter-btn clearEnteBtn" title="Limpiar">
                    <i class="fa fa-times-circle"></i>
                  </button>
                </div>

                <!-- Filtro de usuarios (desde JSON) -->
                <div class="filter-group">
                  <label><i class="fa fa-users"></i> Usuario:</label>
                  <select id="usuarioFilter" class="form-control input-sm filter-select" style="width: 200px;">
                    <option value="">Todos los usuarios</option>
                  </select>
                  <button type="button" class="clear-filter-btn clearUsuarioBtn" title="Limpiar">
                    <i class="fa fa-times-circle"></i>
                  </button>
                </div>

                <!-- Botones de acción -->
                <button id="clearAllFiltersBtn" class="btn btn-warning btn-sm"><i class="fa fa-filter"></i> Limpiar todos</button>
                <button id="exportExcelBtn" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"></i> Exportar a Excel</button>
                <button id="exportPdfBtn" class="btn btn-danger btn-sm"><i class="fa fa-file-pdf-o"></i> Exportar a PDF</button>
                
                <!-- Badge de filtros activos -->
                <span id="activeFiltersBadge" class="label label-info" style="padding: 8px; margin-left: 5px;">Sin filtros activos</span>
              </div>
              <hr>

              <!-- Estadísticas rápidas -->
              <div class="row">
                <div class="col-md-3 col-sm-6">
                  <div class="info-box bg-aqua">
                    <span class="info-box-icon"><i class="fa fa-list-alt"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Total Actividades</span>
                      <span class="info-box-number" id="totalRegistros">0</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-eye"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Actividades Visibles</span>
                      <span class="info-box-number" id="visibleRegistros">0</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="info-box bg-yellow">
                    <span class="info-box-icon"><i class="fa fa-building"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Coordinaciones</span>
                      <span class="info-box-number" id="totalCoordinaciones">0</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="info-box bg-red">
                    <span class="info-box-icon"><i class="fa fa-users"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Usuarios Involucrados</span>
                      <span class="info-box-number" id="totalUsuariosUnicos">0</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Gráficos -->
          <div class="row">
            <div class="col-md-6">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-pie-chart"></i> Actividades por Coordinación</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <canvas id="coordinacionChart" width="400" height="400"></canvas>
                  <div id="coordinacionLegend" class="chart-legend"></div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-pie-chart"></i> Top Servicios Más Utilizados</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <canvas id="servicioChart" width="400" height="400"></canvas>
                  <div id="servicioLegend" class="chart-legend"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-pie-chart"></i> Top Entes Más Frecuentes</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <canvas id="enteChart" width="400" height="400"></canvas>
                  <div id="enteLegend" class="chart-legend"></div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-pie-chart"></i> Usuarios con Más Actividades</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <canvas id="usuarioChart" width="400" height="400"></canvas>
                  <div id="usuarioLegend" class="chart-legend"></div>
                </div>
              </div>
            </div>
          </div>

          <!-- Tabla de datos -->
          <div class="box box-solid box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Listado de Actividades</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div>

            <div class="box-body">
              <table id="actividadesTable" class="table table-bordered table-striped table-hover dataTable dt-responsive" width="100%">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Actividad</th>
                    <th>Coordinación</th>
                    <th>Servicios</th>
                    <th>Entes</th>
                    <th>Usuarios</th>
                    <th>Descripción</th>
                    <th>Creador</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $actividades = ControladorActividad::ctrMostrarActividad(null, null);
                  foreach ($actividades as $key => $value){
                    // Decodificar JSONs
                    $serviciosArray = json_decode($value["id_servicios"], true);
                    $entesArray = json_decode($value["id_ente"], true);
                    $usuariosArray = json_decode($value["id_usuario"], true);
                    
                    // Obtener nombres
                    $serviciosNombres = obtenerNombresServiciosPorIds($value["id_servicios"]);
                    $entesNombres = obtenerNombresEntesPorIds($value["id_ente"]);
                    $usuariosNombres = obtenerNombresUsuariosPorIds($value["id_usuario"]);
                    $coordinacionNombre = obtenerNombreCoordinacion($value["id_coordinacion"]);
                    $creadorNombre = obtenerNombreUsuario($value["id_usuario_creador"] ?? 0);
                    
                    // Crear atributos data- para filtros avanzados
                    $dataServicios = !empty($serviciosArray) ? implode(',', $serviciosArray) : '';
                    $dataEntes = !empty($entesArray) ? implode(',', $entesArray) : '';
                    $dataUsuarios = !empty($usuariosArray) ? implode(',', $usuariosArray) : '';
                    ?>
                    <tr data-id="<?php echo $value["id"]; ?>"
                        data-coordinacion="<?php echo $value["id_coordinacion"]; ?>"
                        data-servicios="<?php echo $dataServicios; ?>"
                        data-entes="<?php echo $dataEntes; ?>"
                        data-usuarios="<?php echo $dataUsuarios; ?>"
                        data-fecha="<?php echo $value["fecha"]; ?>"
                        data-estado="<?php echo $value["estado"]; ?>">
                      <td><?php echo $value["id"]; ?></td>
                      <td><?php echo htmlspecialchars($value["actividad"]); ?></td>
                      <td><?php echo $coordinacionNombre; ?></td>
                      <td><?php echo $serviciosNombres; ?></td>
                      <td><?php echo $entesNombres; ?></td>
                      <td><?php echo $usuariosNombres; ?></td>
                      <td><?php echo nl2br(htmlspecialchars(substr($value["descripcion"], 0, 100))) . (strlen($value["descripcion"]) > 100 ? '...' : ''); ?></td>
                      <td><?php echo $creadorNombre; ?></td>
                      <td><?php echo date('d/m/Y H:i', strtotime($value["fecha"])); ?></td>
                      <td><?php echo ($value["estado"] == 1) ? '<span class="label label-success">Activo</span>' : '<span class="label label-danger">Inactivo</span>'; ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>

  <script>
  $(document).ready(function() {
      // ==================== VARIABLES GLOBALES ====================
      let dateRange = { startDate: null, endDate: null };
      let currentCoordinacionFilter = '';
      let currentServicioFilter = '';
      let currentEnteFilter = '';
      let currentUsuarioFilter = '';
      
      // Variables para gráficos
      let coordinacionChart = null;
      let servicioChart = null;
      let enteChart = null;
      let usuarioChart = null;
      
      // Mapeos globales
      let serviciosMap = new Map();
      let entesMap = new Map();
      let usuariosMap = new Map();
      let coordinacionesMap = new Map();
      
      // ==================== CARGA DE DATOS DE MAPEOS ====================
      <?php
      // Cargar servicios para filtros
      $servicios = ControladorServicios::ctrMostrarServicios(null, null);
      foreach ($servicios as $serv) {
        if($serv["estado"] == 1) {
          echo "serviciosMap.set(".$serv["id"].", '".addslashes($serv["servicios"])."');\n";
        }
      }
      
      // Cargar entes
      $entes = ControladorEntes::ctrMostrarEntes(null, null);
      foreach ($entes as $ente) {
        if($ente["estado"] == 1) {
          echo "entesMap.set(".$ente["id"].", '".addslashes($ente["entes"])."');\n";
        }
      }
      
      // Cargar usuarios
      $usuarios = ControladorUsuarios::ctrMostrarUsuarios(null, null);
      foreach ($usuarios as $user) {
        if($user["estado"] == 1) {
          echo "usuariosMap.set(".$user["id"].", '".addslashes($user["nombre"]." ".$user["apellido"])."');\n";
        }
      }
      
      // Cargar coordinaciones
      $coordinaciones = ControladorCoordinacion::ctrMostrarCoordinacion(null, null);
      foreach ($coordinaciones as $coord) {
        echo "coordinacionesMap.set(".$coord["id"].", '".addslashes($coord["coordinacion"])."');\n";
      }
      ?>
      
      // ==================== INICIALIZAR SELECTS DE FILTROS ====================
      function initializeFilterSelects() {
        // Servicios
        let servicioSelect = $('#servicioFilter');
        serviciosMap.forEach((nombre, id) => {
          servicioSelect.append(`<option value="${id}">${nombre}</option>`);
        });
        
        // Entes
        let enteSelect = $('#enteFilter');
        entesMap.forEach((nombre, id) => {
          enteSelect.append(`<option value="${id}">${nombre}</option>`);
        });
        
        // Usuarios
        let usuarioSelect = $('#usuarioFilter');
        usuariosMap.forEach((nombre, id) => {
          usuarioSelect.append(`<option value="${id}">${nombre}</option>`);
        });
      }
      
      initializeFilterSelects();
      
      // ==================== INICIALIZAR DATATABLE ====================
      var table = $('#actividadesTable').DataTable({
        "order": [[8, "desc"]],
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
        },
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
        "pageLength": 25,
        "columnDefs": [
          { "orderable": true, "targets": [0,1,2,3,4,5,6,7,8,9] },
          { "visible": false, "targets": [] }
        ],
        "drawCallback": function() {
          updateCounters();
          updateTotalCoordinaciones();
          updateTotalUsuariosUnicos();
          updateCharts();
          updateActiveFiltersBadge();
        }
      });
      
      // ==================== FUNCIONES DE ACTUALIZACIÓN ====================
      function updateCounters() {
        let info = table.page.info();
        $('#visibleRegistros').text(info.recordsDisplay);
        $('#totalRegistros').text(info.recordsTotal);
      }
      
      function updateTotalCoordinaciones() {
        let coordinacionesSet = new Set();
        table.rows({ search: 'applied' }).every(function() {
          let rowData = this.data();
          let coordinacionNombre = rowData[2];
          if (coordinacionNombre && coordinacionNombre.trim() !== '') {
            coordinacionesSet.add(coordinacionNombre);
          }
        });
        $('#totalCoordinaciones').text(coordinacionesSet.size);
      }
      
      function updateTotalUsuariosUnicos() {
        let usuariosSet = new Set();
        table.rows({ search: 'applied' }).every(function() {
          let rowNode = this.node();
          let usuariosData = $(rowNode).data('usuarios');
          if (usuariosData && usuariosData !== '') {
            let usuariosArray = usuariosData.split(',');
            usuariosArray.forEach(u => {
              if (u && u.trim() !== '') usuariosSet.add(u);
            });
          }
        });
        $('#totalUsuariosUnicos').text(usuariosSet.size);
      }
      
      // ==================== FUNCIONES DE FILTRO ====================
      function parseFechaFromString(fechaStr) {
        if (!fechaStr) return null;
        return moment(fechaStr.split(' ')[0], 'YYYY-MM-DD');
      }
      
      function isDateInRange(fechaStr, start, end) {
        if (!start || !end) return true;
        const fechaMoment = parseFechaFromString(fechaStr);
        if (!fechaMoment || !fechaMoment.isValid()) return true;
        return fechaMoment.isSameOrAfter(start, 'day') && fechaMoment.isSameOrBefore(end, 'day');
      }
      
      // Verificar si un elemento está en un array de IDs (para JSON)
      function hasIdInJsonString(jsonDataStr, targetId) {
        if (!jsonDataStr || jsonDataStr === '' || !targetId) return true;
        let ids = jsonDataStr.split(',').map(id => id.trim());
        return ids.includes(targetId.toString());
      }
      
      // Buscar si existe coincidencia parcial (para filtros múltiples)
      function hasPartialMatch(jsonDataStr, targetId) {
        if (!targetId || targetId === '') return true;
        if (!jsonDataStr || jsonDataStr === '') return false;
        let ids = jsonDataStr.split(',').map(id => id.trim());
        return ids.includes(targetId.toString());
      }
      
      // Limpiar filtros personalizados existentes
      if ($.fn.dataTable.ext.search.length > 0) {
        $.fn.dataTable.ext.search = [];
      }
      
      // Filtro de fecha
      $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        let rowNode = table.row(dataIndex).node();
        let fecha = $(rowNode).data('fecha');
        let dateMatch = true;
        if (dateRange.startDate && dateRange.endDate) {
          dateMatch = isDateInRange(fecha, dateRange.startDate, dateRange.endDate);
        }
        return dateMatch;
      });
      
      // Filtro de coordinación
      $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        let rowNode = table.row(dataIndex).node();
        let coordinacionId = $(rowNode).data('coordinacion');
        if (!currentCoordinacionFilter || currentCoordinacionFilter === '') return true;
        return coordinacionId == currentCoordinacionFilter;
      });
      
      // Filtro de servicio
      $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        let rowNode = table.row(dataIndex).node();
        let serviciosData = $(rowNode).data('servicios');
        return hasPartialMatch(serviciosData, currentServicioFilter);
      });
      
      // Filtro de ente
      $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        let rowNode = table.row(dataIndex).node();
        let entesData = $(rowNode).data('entes');
        return hasPartialMatch(entesData, currentEnteFilter);
      });
      
      // Filtro de usuario
      $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        let rowNode = table.row(dataIndex).node();
        let usuariosData = $(rowNode).data('usuarios');
        return hasPartialMatch(usuariosData, currentUsuarioFilter);
      });
      
      function applyFilters() {
        table.draw();
      }
      
      function updateActiveFiltersBadge() {
        let filtersText = [];
        
        if (dateRange.startDate && dateRange.endDate) {
          filtersText.push(`Fecha: ${dateRange.startDate.format('DD/MM/YYYY')} - ${dateRange.endDate.format('DD/MM/YYYY')}`);
        }
        
        if (currentCoordinacionFilter && currentCoordinacionFilter !== '') {
          let coordinacionText = $('#coordinacionFilter option:selected').text();
          filtersText.push(`Coordinación: ${coordinacionText}`);
        }
        
        if (currentServicioFilter && currentServicioFilter !== '') {
          let servicioText = $('#servicioFilter option:selected').text();
          filtersText.push(`Servicio: ${servicioText}`);
        }
        
        if (currentEnteFilter && currentEnteFilter !== '') {
          let enteText = $('#enteFilter option:selected').text();
          filtersText.push(`Ente: ${enteText}`);
        }
        
        if (currentUsuarioFilter && currentUsuarioFilter !== '') {
          let usuarioText = $('#usuarioFilter option:selected').text();
          filtersText.push(`Usuario: ${usuarioText}`);
        }
        
        if (filtersText.length === 0) {
          $('#activeFiltersBadge').text('Sin filtros activos').removeClass('active-filter-badge').addClass('label-info');
          $('#activeFiltersBadge').css('background-color', '#5bc0de');
        } else {
          $('#activeFiltersBadge').text(`Filtros: ${filtersText.join(' | ')}`).removeClass('label-info').addClass('active-filter-badge');
          $('#activeFiltersBadge').css('background-color', '#dd4b39');
        }
      }
      
      // ==================== FUNCIONES DE GRÁFICOS ====================
      function getChartData() {
        let data = {
          coordinaciones: {},
          servicios: {},
          entes: {},
          usuarios: {}
        };
        
        table.rows({ search: 'applied' }).every(function() {
          let rowNode = this.node();
          let actividadesCount = 1;
          
          // Coordinación
          let coordinacionId = $(rowNode).data('coordinacion');
          let coordinacionNombre = coordinacionesMap.get(coordinacionId) || `Coordinación ${coordinacionId}`;
          data.coordinaciones[coordinacionNombre] = (data.coordinaciones[coordinacionNombre] || 0) + actividadesCount;
          
          // Servicios
          let serviciosData = $(rowNode).data('servicios');
          if (serviciosData && serviciosData !== '') {
            let serviciosIds = serviciosData.split(',');
            serviciosIds.forEach(id => {
              let servicioNombre = serviciosMap.get(parseInt(id)) || `Servicio ${id}`;
              data.servicios[servicioNombre] = (data.servicios[servicioNombre] || 0) + 1;
            });
          }
          
          // Entes
          let entesData = $(rowNode).data('entes');
          if (entesData && entesData !== '') {
            let entesIds = entesData.split(',');
            entesIds.forEach(id => {
              let enteNombre = entesMap.get(parseInt(id)) || `Ente ${id}`;
              data.entes[enteNombre] = (data.entes[enteNombre] || 0) + 1;
            });
          }
          
          // Usuarios
          let usuariosData = $(rowNode).data('usuarios');
          if (usuariosData && usuariosData !== '') {
            let usuariosIds = usuariosData.split(',');
            usuariosIds.forEach(id => {
              let usuarioNombre = usuariosMap.get(parseInt(id)) || `Usuario ${id}`;
              data.usuarios[usuarioNombre] = (data.usuarios[usuarioNombre] || 0) + 1;
            });
          }
        });
        
        return data;
      }
      
      const colorPalette = [
        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40',
        '#8A2BE2', '#5F9EA0', '#D2691E', '#DC143C', '#00CED1', '#FFD700',
        '#ADFF2F', '#FF69B4', '#CD5C5C', '#90EE90', '#FFB6C1', '#20B2AA'
      ];
      
      function updateOrCreateChart(chart, chartId, data, title, type = 'pie') {
        let labels = Object.keys(data);
        let values = Object.values(data);
        let colors = labels.map((_, i) => colorPalette[i % colorPalette.length]);
        
        // Limitar a top 10 para mejor visualización
        if (labels.length > 10) {
          let sorted = Object.entries(data).sort((a,b) => b[1] - a[1]);
          let top10 = sorted.slice(0, 10);
          let otros = sorted.slice(10).reduce((sum, item) => sum + item[1], 0);
          
          labels = top10.map(item => item[0]);
          values = top10.map(item => item[1]);
          if (otros > 0) {
            labels.push('Otros');
            values.push(otros);
          }
          colors = labels.map((_, i) => colorPalette[i % colorPalette.length]);
        }
        
        if (labels.length === 0) {
          labels = ['Sin datos'];
          values = [1];
          colors = ['#CCCCCC'];
        }
        
        if (chart) {
          chart.data.labels = labels;
          chart.data.datasets[0].data = values;
          chart.data.datasets[0].backgroundColor = colors;
          chart.update();
        } else {
          let ctx = document.getElementById(chartId).getContext('2d');
          chart = new Chart(ctx, {
            type: type,
            data: {
              labels: labels,
              datasets: [{
                data: values,
                backgroundColor: colors,
                borderWidth: 1
              }]
            },
            options: {
              responsive: true,
              maintainAspectRatio: true,
              plugins: {
                legend: {
                  position: 'bottom',
                  labels: { font: { size: 11 } }
                },
                tooltip: {
                  callbacks: {
                    label: function(context) {
                      let label = context.label || '';
                      let value = context.raw || 0;
                      let total = context.dataset.data.reduce((a, b) => a + b, 0);
                      let percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                      return `${label}: ${value} (${percentage}%)`;
                    }
                  }
                }
              }
            }
          });
        }
        return chart;
      }
      
      function updateCharts() {
        let chartData = getChartData();
        coordinacionChart = updateOrCreateChart(coordinacionChart, 'coordinacionChart', chartData.coordinaciones, 'Actividades por Coordinación');
        servicioChart = updateOrCreateChart(servicioChart, 'servicioChart', chartData.servicios, 'Top Servicios Más Utilizados');
        enteChart = updateOrCreateChart(enteChart, 'enteChart', chartData.entes, 'Top Entes Más Frecuentes');
        usuarioChart = updateOrCreateChart(usuarioChart, 'usuarioChart', chartData.usuarios, 'Usuarios con Más Actividades');
      }
      
      // ==================== EVENTOS DE FILTROS ====================
      $('#dateRangePicker').daterangepicker({
        autoUpdateInput: false,
        locale: {
          format: 'YYYY-MM-DD',
          separator: ' - ',
          applyLabel: 'Aplicar',
          cancelLabel: 'Cancelar',
          daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
          monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
          firstDay: 1
        },
        startDate: moment().subtract(30, 'days'),
        endDate: moment(),
        ranges: {
          'Hoy': [moment(), moment()],
          'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
          'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
          'Este mes': [moment().startOf('month'), moment().endOf('month')],
          'Mes anterior': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
      });
      
      $('#dateRangePicker').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        dateRange.startDate = picker.startDate;
        dateRange.endDate = picker.endDate;
        applyFilters();
      });
      
      $('#dateRangePicker').on('cancel.daterangepicker', function() {
        $(this).val('');
        dateRange.startDate = null;
        dateRange.endDate = null;
        applyFilters();
      });
      
      $('#coordinacionFilter').on('change', function() {
        currentCoordinacionFilter = $(this).val();
        applyFilters();
      });
      
      $('#servicioFilter').on('change', function() {
        currentServicioFilter = $(this).val();
        applyFilters();
      });
      
      $('#enteFilter').on('change', function() {
        currentEnteFilter = $(this).val();
        applyFilters();
      });
      
      $('#usuarioFilter').on('change', function() {
        currentUsuarioFilter = $(this).val();
        applyFilters();
      });
      
      $('.clearCoordinacionBtn').on('click', function() {
        $('#coordinacionFilter').val('').trigger('change');
      });
      
      $('.clearServicioBtn').on('click', function() {
        $('#servicioFilter').val('').trigger('change');
      });
      
      $('.clearEnteBtn').on('click', function() {
        $('#enteFilter').val('').trigger('change');
      });
      
      $('.clearUsuarioBtn').on('click', function() {
        $('#usuarioFilter').val('').trigger('change');
      });
      
      $('#clearDateBtn').on('click', function() {
        $('#dateRangePicker').val('');
        dateRange.startDate = null;
        dateRange.endDate = null;
        applyFilters();
      });
      
      $('#clearAllFiltersBtn').on('click', function() {
        $('#dateRangePicker').val('');
        $('#coordinacionFilter').val('');
        $('#servicioFilter').val('');
        $('#enteFilter').val('');
        $('#usuarioFilter').val('');
        dateRange.startDate = null;
        dateRange.endDate = null;
        currentCoordinacionFilter = '';
        currentServicioFilter = '';
        currentEnteFilter = '';
        currentUsuarioFilter = '';
        applyFilters();
      });
      
      // ==================== EXPORTAR A EXCEL ====================
      $('#exportExcelBtn').on('click', function() {
        let data = [];
        let headers = ['ID', 'Actividad', 'Coordinación', 'Servicios', 'Entes', 'Usuarios', 'Descripción', 'Creador', 'Fecha', 'Estado'];
        data.push(headers);
        
        table.rows().every(function() {
          let rowData = this.data();
          data.push([
            rowData[0], rowData[1], rowData[2], 
            $(rowData[3]).text() || rowData[3],
            $(rowData[4]).text() || rowData[4],
            $(rowData[5]).text() || rowData[5],
            rowData[6], rowData[7], rowData[8], rowData[9]
          ]);
        });
        
        let ws = XLSX.utils.aoa_to_sheet(data);
        let wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Actividades');
        XLSX.writeFile(wb, `reporte_actividades_${moment().format('YYYYMMDD_HHmmss')}.xlsx`);
      });
      
      // ==================== EXPORTAR A PDF ====================
      $('#exportPdfBtn').on('click', function() {
        const { jsPDF } = window.jspdf;
        let doc = new jsPDF('landscape');
        
        let data = [];
        table.rows().every(function() {
          let rowData = this.data();
          data.push([
            rowData[0], rowData[1], rowData[2], 
            $(rowData[3]).text() || rowData[3],
            $(rowData[4]).text() || rowData[4],
            $(rowData[5]).text() || rowData[5],
            rowData[7], rowData[8], rowData[9]
          ]);
        });
        
        doc.autoTable({
          head: [['ID', 'Actividad', 'Coordinación', 'Servicios', 'Entes', 'Usuarios', 'Creador', 'Fecha', 'Estado']],
          body: data,
          theme: 'striped',
          styles: { fontSize: 8, cellPadding: 2 },
          headStyles: { fillColor: [41, 128, 185] }
        });
        
        doc.save(`reporte_actividades_${moment().format('YYYYMMDD_HHmmss')}.pdf`);
      });
      
      // ==================== INICIALIZACIÓN FINAL ====================
      setTimeout(function() {
        updateCharts();
      }, 100);
      
      table.draw();
  });
  </script>

  <style>
    .content-wrapper { background-color: #ecf0f5; }
    .filter-buttons {
      margin-bottom: 15px;
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      align-items: center;
    }
    .filter-group {
      display: inline-flex;
      align-items: center;
      background: #f9f9f9;
      padding: 5px 12px;
      border-radius: 4px;
      border: 1px solid #ddd;
    }
    .filter-group label {
      margin-right: 8px;
      margin-bottom: 0;
      font-weight: 500;
    }
    .filter-select {
      background-color: #fff;
      border: 1px solid #ccc;
      border-radius: 4px;
      padding: 5px 10px;
      cursor: pointer;
    }
    .clear-filter-btn {
      margin-left: 8px;
      background: none;
      border: none;
      color: #d9534f;
      cursor: pointer;
    }
    .clear-filter-btn:hover { color: #c9302c; }
    .active-filter-badge {
      background-color: #dd4b39;
      color: white;
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 12px;
    }
    .info-box { cursor: default; }
    @media (max-width: 767px) {
      .filter-buttons { flex-direction: column; align-items: stretch; }
      .filter-group { justify-content: space-between; }
      .filter-select { width: 100% !important; }
    }
    .chart-legend { margin-top: 10px; text-align: center; max-height: 150px; overflow-y: auto; }
    canvas { max-height: 400px; }
  </style>
</div>