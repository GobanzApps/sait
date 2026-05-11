<div class="content-wrapper" style="min-height: 460.2px;">
    <section class="content-header">
      <h1>
        Tabla de Solicitudes
        <small>Filtros: Entidad | Medio | Prioridad | Estado | Rango Fechas</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Solicitudes con filtros múltiples</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-filter"></i> Panel de filtros combinados</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="filter-buttons">
                <!-- Filtro Entidad -->
                <div class="btn-group">
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" id="btnEntidadFilter" aria-expanded="false"><i class="fa fa-building"></i> Entes <span class="caret"></span></button>
                  <ul class="dropdown-menu" role="menu" id="filterEntidadMenu">
                    <li><a href="#" data-entidad="all">Todas las entidades</a></li>
                    <li class="divider"></li>
                    <?php
                    $entes = ControladorEntes::ctrMostrarEntes(null, null);
                    foreach ($entes as $key => $value){
                      if ($value["estado"] != "1") continue;
                      echo '<li><a href="#" data-entidad="'.$value["entes"].'">'.$value["entes"].'</a></li>';
                    }
                    ?>
                  </ul>
                </div>

                <!-- Filtro Medio -->
                <div class="btn-group">
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" id="btnMedioFilter" aria-expanded="false"><i class="fa fa-phone"></i> Medio <span class="caret"></span></button>
                  <ul class="dropdown-menu" role="menu" id="filterMedioMenu">
                    <li><a href="#" data-medio="all">Todos los medios</a></li>
                    <li class="divider"></li>
                    <?php
                    $medio = ControladorMedio::ctrMostrarMedio(null, null);
                    foreach ($medio as $key => $value){
                      if ($value["estado"] != "1") continue;
                      echo '<li><a href="#" data-medio="'.$value["medio"].'">'.$value["medio"].'</a></li>';
                    }
                    ?>
                  </ul>
                </div>

                <!-- Filtro Prioridad -->
                <div class="btn-group">
                  <button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" id="btnPrioridadFilter" aria-expanded="false"><i class="fa fa-flag"></i> Prioridad <span class="caret"></span></button>
                  <ul class="dropdown-menu" role="menu" id="filterPrioridadMenu">
                    <li><a href="#" data-prioridad="all">Todas las prioridades</a></li>
                    <li class="divider"></li>
                    <?php
                    $prioridad = ControladorPrioridad::ctrMostrarPrioridad(null, null);
                    foreach ($prioridad as $key => $value){
                      if ($value["estado"] != "1") continue;
                      echo '<li><a href="#" data-prioridad="'.$value["prioridad"].'">'.$value["prioridad"].'</a></li>';
                    }
                    ?>
                  </ul>
                </div>

                <!-- Filtro Estado -->
                <div class="btn-group">
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" id="btnStatusFilter" aria-expanded="false"><i class="fa fa-check-circle"></i> Estado <span class="caret"></span></button>
                  <ul class="dropdown-menu" role="menu" id="filterStatusMenu">
                    <li><a href="#" data-status="all">Todos los estados</a></li>
                    <li class="divider"></li>
                    <?php
                    $status = ControladorStatus::ctrMostrarStatus(null, null);
                    foreach ($status as $key => $value){
                      if ($value["estado"] != "1") continue;
                      echo '<li><a href="#" data-status="'.$value["status"].'">'.$value["status"].'</a></li>';
                    }
                    ?>
                  </ul>
                </div>

                <!-- Rango de fechas -->
                <div class="date-range-group">
                  <label><i class="fa fa-calendar"></i> Rango fecha:</label>
                  <input type="text" id="dateRangePicker" class="form-control input-sm" style="width: 240px; display: inline-block;" placeholder="Seleccionar rango de fechas">
                  <button type="button" id="clearDateBtn" class="clear-date-btn" title="Limpiar filtro de fecha">
                    <i class="fa fa-times-circle"></i>
                  </button>
                </div>

                <button id="clearAllFiltersBtn" class="btn btn-danger"><i class="fa fa-eraser"></i> Limpiar todos los filtros</button>
                <span id="activeFiltersBadge" class="label label-info" style="padding: 8px; margin-left: 5px; background-color: rgb(91, 192, 222);">Sin filtros activos</span>
              </div>
              <hr>
              <div class="row">
                <div class="col-md-3 col-sm-6">
                  <div class="info-box bg-aqua">
                    <span class="info-box-icon"><i class="fa fa-list-alt"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Total registros</span>
                      <span class="info-box-number" id="totalRegistros">5</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-eye"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Registros visibles</span>
                      <span class="info-box-number" id="visibleRegistros">5</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- SECCIÓN DE GRÁFICOS ESTILO BROWSER USAGE -->
          <div class="row">
            <div class="col-md-6">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-pie-chart"></i> Distribución por Ente</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <canvas id="enteChart" width="400" height="300"></canvas>
                  <div id="enteLegend" class="chart-legend"></div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-pie-chart"></i> Distribución por Medio</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <canvas id="medioChart" width="400" height="300"></canvas>
                  <div id="medioLegend" class="chart-legend"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-pie-chart"></i> Distribución por Prioridad</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <canvas id="prioridadChart" width="400" height="300"></canvas>
                  <div id="prioridadLegend" class="chart-legend"></div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-pie-chart"></i> Distribución por Estado</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <canvas id="statusChart" width="400" height="300"></canvas>
                  <div id="statusLegend" class="chart-legend"></div>
                </div>
              </div>
            </div>
          </div>

          <!-- Tabla con DataTables -->
          <div class="box box-solid box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Listado de solicitudes</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div>

            <div class="box-body">
              <div id="solicitudesTable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="dataTables_length" id="solicitudesTable_length">

                        </div>
                    </div>
                    
                    <div class="col-sm-6">
                        <div id="solicitudesTable_filter" class="dataTables_filter">

                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                        <table id="solicitudesTable" class="table table-bordered table-striped table-hover dataTable dt-responsive tablas" role="grid" aria-describedby="solicitudesTable_info">
                <thead>
                  <tr role="row">
                    <th aria-label="#: activate to sort column ascending" class="sorting sorting_desc" tabindex="0" aria-controls="solicitudesTable" rowspan="1" colspan="1" style="width: 10.8125px;" aria-sort="descending">#</th>
                    <th aria-label="Ente: activate to sort column ascending" class="sorting" tabindex="0" aria-controls="solicitudesTable" rowspan="1" colspan="1" style="width: 89.325px;">Ente</th>
                    <th aria-label="Solicitante: activate to sort column ascending" class="sorting" tabindex="0" aria-controls="solicitudesTable" rowspan="1" colspan="1" style="width: 77.925px;">Solicitante</th>
                    <th aria-label="Medio: activate to sort column ascending" class="sorting" tabindex="0" aria-controls="solicitudesTable" rowspan="1" colspan="1" style="width: 48.7125px;">Medio</th>
                    <th aria-label="Descripción: activate to sort column ascending" class="sorting" tabindex="0" aria-controls="solicitudesTable" rowspan="1" colspan="1" style="width: 110.625px;">Descripción</th>
                    <th aria-label="Prioridad: activate to sort column ascending" class="sorting" tabindex="0" aria-controls="solicitudesTable" rowspan="1" colspan="1" style="width: 67.9875px;">Prioridad</th>
                    <th aria-label="Status: activate to sort column ascending" class="sorting" tabindex="0" aria-controls="solicitudesTable" rowspan="1" colspan="1" style="width: 54.525px;">Status</th>
                    <th aria-label="Creado por: activate to sort column ascending" class="sorting" tabindex="0" aria-controls="solicitudesTable" rowspan="1" colspan="1" style="width: 82.0625px;">Creado por</th>
                    <th aria-label="Fecha: activate to sort column ascending" class="sorting" tabindex="0" aria-controls="solicitudesTable" rowspan="1" colspan="1" style="width: 117.55px;">Fecha</th>
                  </td>
                </thead>
                <tbody>

                  <?php

                  $item = null;
                  $valor = null;
                  
                  $ticket = ControladorTicket::ctrMostrarTicket($item, $valor);

                  foreach ($ticket as $key => $value){

                    $destino = "index.php?ruta=ticket&id=" . $value["id"];
                  
                    echo '<tr>
                            <td>'.$value["id"].'</td>';
                    echo    '<td>'.obtenerNombreEnte($value["id_ente"]).'</td>';
                    echo    '<td>'.$value["solicitante"].'</td>';
                    echo    '<td>'.obtenerNombreMedio($value["id_medio"]).'</td>
                            <td>'.$value["descripcion"].'</td>';
                    $datosPrioridad = obtenerDatosPrioridad($value["id_prioridad"]);
                    echo '<td><span class="btn btn-xs" style="color: white; background-color: ' . $datosPrioridad["color"] . ';">' . $datosPrioridad["prioridad"] . '</span></td>';
                    $datosStatus = obtenerDatosStatus($value["id_status"]);
                    echo '<td><span class="btn btn-xs" style="color: white; background-color: ' . $datosStatus["color"] . ';">' . $datosStatus["status"] . '</span></td>';
                    echo    '<td>'.obtenerNombreUsuario($value["id_usuario"]).'</td>';
                    echo    '<td>'.$value["fecha"].'</td>
                          </tr>';
                  }

                  ?> 

                </tbody>

                <tfoot>
                </tfoot>
             
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-5">
                <div class="dataTables_info" id="solicitudesTable_info" role="status" aria-live="polite"></div>
            </div>
        <div class="col-sm-7">
            <div class="dataTables_paginate paging_simple_numbers" id="solicitudesTable_paginate">

            </div>
        </div>
    </div>
</div>
 
    </div>
          </div>
        </div>
      </div>
    </section>
  </div>



<!-- Date Range Picker -->
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<!-- Chart.js para gráficos -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<script>




$(document).ready(function() {
    // ====================== VARIABLES DE FILTRO ======================
    let activeEntidad = 'all';
    let activeMedio = 'all';
    let activePrioridad = 'all';
    let activeStatus = 'all';
    let dateRange = { startDate: null, endDate: null };
    
    // Variables para los gráficos
    let enteChart = null;
    let medioChart = null;
    let prioridadChart = null;
    let statusChart = null;
    
    // Inicializar DataTable
    var table = $('#solicitudesTable').DataTable({
      "order": [[0, "desc"]],
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
      },
      "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "Todos"]],
      "pageLength": 25,
      "columnDefs": [
        { "orderable": true, "targets": [0,1,2,3,4,5,6,7,8] }
      ],
      "drawCallback": function() {
        updateCounters();
        updateAllCharts(); // Esto ya está bien, asegura que se actualicen los gráficos
      }
    });
    
    function updateCounters() {
      let info = table.page.info();
      $('#visibleRegistros').text(info.recordsDisplay);
      $('#totalRegistros').text(info.recordsTotal);
    }
    
    // Función para parsear fecha de la celda (columna 8 - índice 8)
    function parseFechaFromCell(fechaStr) {
      if (!fechaStr) return null;
      let datePart = fechaStr.split(' ')[0];
      return moment(datePart, 'YYYY-MM-DD');
    }
    
    function isDateInRange(fechaStr, start, end) {
      if (!start || !end) return true;
      const fechaMoment = parseFechaFromCell(fechaStr);
      if (!fechaMoment || !fechaMoment.isValid()) return true;
      return fechaMoment.isSameOrAfter(start, 'day') && fechaMoment.isSameOrBefore(end, 'day');
    }
    
    // Remover el filtro anterior si existe
    if ($.fn.dataTable.ext.search.length > 0) {
        let customFilters = $.fn.dataTable.ext.search.filter(fn => {
            return fn.toString().indexOf('activeEntidad') === -1;
        });
        $.fn.dataTable.ext.search = customFilters;
    }
    
    // Agregar el nuevo filtro
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
      // data indices: 0=ID, 1=Ente, 2=Solicitante, 3=Medio, 4=Descripcion, 5=Prioridad, 6=Status, 7=Creado, 8=Fecha
      let enteCol = data[1];
      let medioCol = data[3];
      let prioridadCol = data[5];
      let statusCol = data[6];
      let fechaCol = data[8];
      
      let enteMatch = (activeEntidad === 'all') || (enteCol === activeEntidad);
      let medioMatch = (activeMedio === 'all') || (medioCol === activeMedio);
      let prioridadMatch = (activePrioridad === 'all') || (prioridadCol === activePrioridad);
      let statusMatch = (activeStatus === 'all') || (statusCol === activeStatus);
      
      let dateMatch = true;
      if (dateRange.startDate && dateRange.endDate) {
        dateMatch = isDateInRange(fechaCol, dateRange.startDate, dateRange.endDate);
      }
      
      return enteMatch && medioMatch && prioridadMatch && statusMatch && dateMatch;
    });
    
    // Función para aplicar todos los filtros y actualizar UI de botones
    function applyAllFilters() {
      table.draw();
      updateActiveFiltersBadge();
      updateButtonStyles();
      // Los gráficos se actualizarán automáticamente en el drawCallback de DataTable
    }
    
    function updateButtonStyles() {
        $('#btnEntidadFilter, #btnMedioFilter, #btnPrioridadFilter, #btnStatusFilter')
            .removeClass('btn-filter-active btn-primary')
            .addClass('btn-default');
        
        if (activeEntidad !== 'all') {
            $('#btnEntidadFilter').removeClass('btn-default').addClass('btn-filter-active');
        }
        if (activeMedio !== 'all') {
            $('#btnMedioFilter').removeClass('btn-default').addClass('btn-filter-active');
        }
        if (activePrioridad !== 'all') {
            $('#btnPrioridadFilter').removeClass('btn-default').addClass('btn-filter-active');
        }
        if (activeStatus !== 'all') {
            $('#btnStatusFilter').removeClass('btn-default').addClass('btn-filter-active');
        }
    }
    
    // Actualizar badge con todos los filtros activos
    function updateActiveFiltersBadge() {
      let filtersText = [];
      if (activeEntidad !== 'all') filtersText.push(`Entidad: ${activeEntidad}`);
      if (activeMedio !== 'all') filtersText.push(`Medio: ${activeMedio}`);
      if (activePrioridad !== 'all') filtersText.push(`Prioridad: ${activePrioridad}`);
      if (activeStatus !== 'all') filtersText.push(`Estado: ${activeStatus}`);
      if (dateRange.startDate && dateRange.endDate) {
        let startFmt = dateRange.startDate.format('DD/MM/YYYY');
        let endFmt = dateRange.endDate.format('DD/MM/YYYY');
        filtersText.push(`Fecha: ${startFmt} - ${endFmt}`);
      }
      if (filtersText.length === 0) {
        $('#activeFiltersBadge').text('Sin filtros activos').removeClass('active-filter-badge').addClass('label-info');
        $('#activeFiltersBadge').css('background-color', '#5bc0de');
      } else {
        $('#activeFiltersBadge').text(`Filtros: ${filtersText.join(' | ')}`).removeClass('label-info').addClass('active-filter-badge');
        $('#activeFiltersBadge').css('background-color', '#dd4b39');
      }
    }
    
    // ====================== FUNCIONES PARA GRÁFICOS ======================
    function getVisibleData() {
      let data = {
        entes: {},
        medios: {},
        prioridades: {},
        statuses: {}
      };
      
      // Recorrer todas las filas visibles de la tabla
      table.rows({ search: 'applied' }).every(function(rowIdx, tableLoop, rowLoop) {
        let rowData = this.data();
        let ente = rowData[1];
        let medio = rowData[3];
        let prioridad = rowData[5];
        let status = rowData[6];
        
        // Contar entes
        data.entes[ente] = (data.entes[ente] || 0) + 1;
        // Contar medios
        data.medios[medio] = (data.medios[medio] || 0) + 1;
        // Contar prioridades (limpiar HTML)
        let prioridadClean = prioridad.replace(/<[^>]*>/g, '').trim();
        data.prioridades[prioridadClean] = (data.prioridades[prioridadClean] || 0) + 1;
        // Contar status (limpiar HTML)
        let statusClean = status.replace(/<[^>]*>/g, '').trim();
        data.statuses[statusClean] = (data.statuses[statusClean] || 0) + 1;
      });
      
      return data;
    }
    
    // Colores predefinidos para los gráficos
    const colorPalette = [
      '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40',
      '#8A2BE2', '#5F9EA0', '#D2691E', '#DC143C', '#00CED1', '#FFD700',
      '#ADFF2F', '#FF69B4', '#CD5C5C', '#90EE90', '#FFB6C1', '#20B2AA'
    ];
    
    function updateAllCharts() {
      let visibleData = getVisibleData();
      
      // Actualizar gráfico de Entes
      updateOrCreateChart(enteChart, 'enteChart', visibleData.entes, 'Distribución por Ente');
      
      // Actualizar gráfico de Medios
      updateOrCreateChart(medioChart, 'medioChart', visibleData.medios, 'Distribución por Medio');
      
      // Actualizar gráfico de Prioridades
      updateOrCreateChart(prioridadChart, 'prioridadChart', visibleData.prioridades, 'Distribución por Prioridad');
      
      // Actualizar gráfico de Status
      updateOrCreateChart(statusChart, 'statusChart', visibleData.statuses, 'Distribución por Estado');
    }
    
    function updateOrCreateChart(chart, chartId, data, title) {
      let labels = Object.keys(data);
      let values = Object.values(data);
      let colors = labels.map((_, i) => colorPalette[i % colorPalette.length]);
      
      // Si no hay datos, mostrar un mensaje
      if (labels.length === 0) {
        labels = ['Sin datos'];
        values = [1];
        colors = ['#CCCCCC'];
      }
      
      if (chart) {
        // Actualizar gráfico existente
        chart.data.labels = labels;
        chart.data.datasets[0].data = values;
        chart.data.datasets[0].backgroundColor = colors;
        chart.update();
      } else {
        // Crear nuevo gráfico
        let ctx = document.getElementById(chartId).getContext('2d');
        chart = new Chart(ctx, {
          type: 'pie',
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
                labels: {
                  font: { size: 11 }
                }
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
        
        // Guardar referencia según el ID del canvas
        switch(chartId) {
          case 'enteChart': 
            enteChart = chart; 
            break;
          case 'medioChart': 
            medioChart = chart; 
            break;
          case 'prioridadChart': 
            prioridadChart = chart; 
            break;
          case 'statusChart': 
            statusChart = chart; 
            break;
        }
      }
    }
    
    // ====================== CONFIGURACIÓN DATE RANGE PICKER ======================
    $('#dateRangePicker').daterangepicker({
      autoUpdateInput: false,
      locale: {
        format: 'YYYY-MM-DD',
        separator: ' - ',
        applyLabel: 'Aplicar',
        cancelLabel: 'Cancelar',
        fromLabel: 'Desde',
        toLabel: 'Hasta',
        customRangeLabel: 'Personalizado',
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
      var start = picker.startDate;
      var end = picker.endDate;
      $(this).val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      dateRange.startDate = start;
      dateRange.endDate = end;
      applyAllFilters();
    });
    
    $('#dateRangePicker').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
      dateRange.startDate = null;
      dateRange.endDate = null;
      applyAllFilters();
    });
    
    $('#clearDateBtn').on('click', function() {
      $('#dateRangePicker').val('');
      dateRange.startDate = null;
      dateRange.endDate = null;
      applyAllFilters();
    });
    
    // ====================== FILTROS ======================
    // Entidad
    $('#filterEntidadMenu a').on('click', function(e) {
      e.preventDefault();
      let val = $(this).data('entidad');
      activeEntidad = val;
      let newText = (val === 'all') ? 'Entidad' : val;
      $('#btnEntidadFilter').html(`<i class="fa fa-building"></i> ${newText} <span class="caret"></span>`);
      applyAllFilters();
    });
    
    // Medio
    $('#filterMedioMenu a').on('click', function(e) {
      e.preventDefault();
      let val = $(this).data('medio');
      activeMedio = val;
      let newText = (val === 'all') ? 'Medio' : val;
      $('#btnMedioFilter').html(`<i class="fa fa-phone"></i> ${newText} <span class="caret"></span>`);
      applyAllFilters();
    });
    
    // Prioridad
    $('#filterPrioridadMenu a').on('click', function(e) {
      e.preventDefault();
      let val = $(this).data('prioridad');
      activePrioridad = val;
      let newText = (val === 'all') ? 'Prioridad' : val;
      $('#btnPrioridadFilter').html(`<i class="fa fa-flag"></i> ${newText} <span class="caret"></span>`);
      applyAllFilters();
    });
    
    // Estado
    $('#filterStatusMenu a').on('click', function(e) {
      e.preventDefault();
      let val = $(this).data('status');
      activeStatus = val;
      let newText = (val === 'all') ? 'Estado' : val;
      $('#btnStatusFilter').html(`<i class="fa fa-check-circle"></i> ${newText} <span class="caret"></span>`);
      applyAllFilters();
    });
    
    // Botón limpiar todos los filtros
    $('#clearAllFiltersBtn').on('click', function() {
      activeEntidad = 'all';
      activeMedio = 'all';
      activePrioridad = 'all';
      activeStatus = 'all';
      
      $('#btnEntidadFilter').html(`<i class="fa fa-building"></i> Entidad <span class="caret"></span>`);
      $('#btnMedioFilter').html(`<i class="fa fa-phone"></i> Medio <span class="caret"></span>`);
      $('#btnPrioridadFilter').html(`<i class="fa fa-flag"></i> Prioridad <span class="caret"></span>`);
      $('#btnStatusFilter').html(`<i class="fa fa-check-circle"></i> Estado <span class="caret"></span>`);
      
      $('#dateRangePicker').val('');
      dateRange.startDate = null;
      dateRange.endDate = null;
      
      applyAllFilters();
    });
    
    // Eventos de DataTables para actualizar contadores y gráficos
    table.on('search.dt draw.dt', function() {
      updateCounters();
      updateAllCharts(); // Aseguramos que los gráficos se actualicen en cada búsqueda/dibujo
    });
    
    // Inicializar contadores y estilos
    updateCounters();
    updateActiveFiltersBadge();
    updateButtonStyles();
    
    // Inicializar gráficos después de que la tabla esté lista
    setTimeout(function() {
      updateAllCharts();
    }, 100);
    
    // Forzar el dibujo inicial de la tabla
    table.draw();
    
    console.log('Filtros y gráficos inicializados correctamente');
});




</script>

<style>
    .content-wrapper {
      background-color: #ecf0f5;
    }
    .filter-buttons {
      margin-bottom: 15px;
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      align-items: center;
    }
    .filter-buttons .btn-group,
    .filter-buttons .date-range-group {
      margin-right: 5px;
      margin-bottom: 5px;
    }
    .date-range-group {
      display: inline-flex;
      align-items: center;
      background: #f9f9f9;
      padding: 5px 12px;
      border-radius: 4px;
      border: 1px solid #ddd;
    }
    .date-range-group label {
      margin-right: 8px;
      margin-bottom: 0;
      font-weight: 500;
      color: #333;
    }
    #dateRangePicker {
      background-color: #fff;
      border: 1px solid #ccc;
      border-radius: 4px;
      padding: 5px 10px;
      cursor: pointer;
      width: 240px;
    }
    .clear-date-btn {
      margin-left: 8px;
      background: none;
      border: none;
      color: #d9534f;
      cursor: pointer;
    }
    .clear-date-btn:hover {
      color: #c9302c;
    }
    .active-filter-badge {
      background-color: #dd4b39;
      color: white;
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 12px;
    }
    .info-box {
      cursor: default;
    }
    .filter-group-title {
      font-weight: 600;
      margin-right: 5px;
      color: #3c8dbc;
    }
    @media (max-width: 767px) {
      .filter-buttons {
        flex-direction: column;
        align-items: stretch;
      }
      .date-range-group {
        justify-content: space-between;
      }
      #dateRangePicker {
        width: 100%;
      }
    }
    .btn-filter-active,
    .btn-filter-active:focus,
    .btn-filter-active:hover {
      background-color: #3c8dbc !important;
      color: white !important;
      border-color: #367fa9 !important;
    }
    .chart-legend {
      margin-top: 10px;
      text-align: center;
    }
    canvas {
      max-height: 300px;
    }
</style>