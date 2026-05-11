<?php

if( $_SESSION["perfil"] != "Administrador"  &&
    $_SESSION["perfil"] != "Coordinacion"    &&
    $_SESSION["id_coordinacion"] != "11"    &&  //Archivo
    $_SESSION["id_coordinacion"] != "9"     &&  //centro de atencion
    $_SESSION["usuario"] != "agamardo"                    //Angie
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
        Tabla de Tickets por Servicios
        <small>Filtro: Rango Fechas | Gráficos por Servicio y por Item (Suma de Cantidades)</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Tickets por Servicios</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-filter"></i> Panel de filtros</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="filter-buttons">
                <div class="date-range-group">
                  <label><i class="fa fa-calendar"></i> Rango fecha:</label>
                  <input type="text" id="dateRangePicker" class="form-control input-sm" style="width: 240px; display: inline-block;" placeholder="Seleccionar rango de fechas">
                  <button type="button" id="clearDateBtn" class="clear-date-btn" title="Limpiar filtro de fecha">
                    <i class="fa fa-times-circle"></i>
                  </button>
                </div>
                <div class="coordinacion-filter-group">
                  <label><i class="fa fa-building"></i> Coordinación:</label>
                  <select id="coordinacionFilter" class="form-control input-sm" style="width: 200px; display: inline-block;">
                    <option value="">Todas las coordinaciones</option>
                    <?php
                    $coordinaciones = ControladorCoordinacion::ctrMostrarCoordinacion(null, null);
                    foreach ($coordinaciones as $key => $value) {
                      echo '<option value="'.$value["id"].'">'.$value["coordinacion"].'</option>';
                    }
                    ?>
                  </select>
                  <button type="button" id="clearCoordinacionBtn" class="clear-filter-btn" title="Limpiar filtro de coordinación">
                    <i class="fa fa-times-circle"></i>
                  </button>
                </div>
                <button id="clearDateFilterBtn" class="btn btn-danger"><i class="fa fa-eraser"></i> Limpiar filtro de fecha</button>
                <button id="clearAllFiltersBtn" class="btn btn-warning"><i class="fa fa-filter"></i> Limpiar todos los filtros</button>
                <span id="activeFiltersBadge" class="label label-info" style="padding: 8px; margin-left: 5px; background-color: rgb(91, 192, 222);">Sin filtros activos</span>
              </div>
              <hr>
              <div class="row">
                <div class="col-md-3 col-sm-6">
                  <div class="info-box bg-aqua">
                    <span class="info-box-icon"><i class="fa fa-list-alt"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Total registros</span>
                      <span class="info-box-number" id="totalRegistros">0</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-eye"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Registros visibles</span>
                      <span class="info-box-number" id="visibleRegistros">0</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="info-box bg-yellow">
                    <span class="info-box-icon"><i class="fa fa-ticket"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Tickets únicos</span>
                      <span class="info-box-number" id="ticketsUnicos">0</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="info-box bg-red">
                    <span class="info-box-icon"><i class="fa fa-calculator"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Suma Cantidades</span>
                      <span class="info-box-number" id="sumaCantidades">0</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-pie-chart"></i> Distribución por Servicio (Suma de Cantidades)</h3>
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
            <div class="col-md-6">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-pie-chart"></i> Distribución por Item (Suma de Cantidades)</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <canvas id="itemChart" width="400" height="400"></canvas>
                  <div id="itemLegend" class="chart-legend"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="box box-solid box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Listado de tickets por servicios</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div>

            <div class="box-body">
              <table id="ticketsTable" class="table table-bordered table-striped table-hover dataTable dt-responsive tablas" role="grid">
                <thead>
                  <tr role="row">
                    <th style="width:10px">#</th>
                    <th>Ticket</th>
                    <th>Servicio</th>
                    <th>Coordinación</th>
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
                  ?>
                  <tr>
                    <td><?php echo ($key+1); ?></td>
                    <td><?php echo $value["id_ticket"]; ?></td>
                    <td><?php echo $value["nombre_servicio"]; ?></td>
                    <td><?php echo $value["nombre_coordinacion"] ?? 'No asignada'; ?></td>
                    <td><?php echo $value["nombre_item"]; ?></td>
                    <td><?php echo $value["cantidad"]; ?></td>
                    <td><?php echo $value["fecha"]; ?></td>
                  </tr>
                  <?php } ?> 
                </tbody>
              </table>
            </div>
            
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-5">
                  <div class="dataTables_info" id="ticketsTable_info" role="status" aria-live="polite"></div>
                </div>
                <div class="col-sm-7">
                  <div class="dataTables_paginate paging_simple_numbers" id="ticketsTable_paginate"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

  <script>
    $(document).ready(function() {
        let dateRange = { startDate: null, endDate: null };
        let servicioChart = null;
        let itemChart = null;
        let currentCoordinacionFilter = '';
        
        // Mapeo de nombres de coordinación a IDs para el filtro
        let coordinacionMap = new Map();
        <?php
        $coordinaciones = ControladorCoordinacion::ctrMostrarCoordinacion(null, null);
        foreach ($coordinaciones as $key => $value) {
          echo "coordinacionMap.set('".addslashes($value["coordinacion"])."', ".$value["id"].");\n";
        }
        ?>
        
        var table = $('#ticketsTable').DataTable({
          retrieve: true,
          "order": [[6, "desc"]],
          "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
          },
          "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "Todos"]],
          "pageLength": 25,
          "columnDefs": [
            { "orderable": true, "targets": [0,1,2,3,4,5,6] }
          ],
          "drawCallback": function() {
            updateCounters();
            updateTicketsUnicos();
            updateCantidadTotal();
            updateCharts();
          }
        });
        
        function updateCounters() {
          let info = table.page.info();
          $('#visibleRegistros').text(info.recordsDisplay);
          $('#totalRegistros').text(info.recordsTotal);
        }
        
        function updateTicketsUnicos() {
          let ticketsSet = new Set();
          
          table.rows({ search: 'applied' }).every(function(rowIdx, tableLoop, rowLoop) {
            let rowData = this.data();
            let ticket = rowData[1];
            if (ticket && ticket.trim() !== '') {
              ticketsSet.add(ticket);
            }
          });
          
          $('#ticketsUnicos').text(ticketsSet.size);
        }
        
        function updateCantidadTotal() {
          let sumaTotal = 0;
          
          table.rows({ search: 'applied' }).every(function(rowIdx, tableLoop, rowLoop) {
            let rowData = this.data();
            let cantidad = parseFloat(rowData[5]) || 0;
            sumaTotal += cantidad;
          });
          
          $('#sumaCantidades').text(sumaTotal);
        }
        
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
        
        // Limpiar filtros existentes
        if ($.fn.dataTable.ext.search.length > 0) {
            let customFilters = $.fn.dataTable.ext.search.filter(fn => {
                return fn.toString().indexOf('dateRange') === -1 && fn.toString().indexOf('coordinacionFilter') === -1;
            });
            $.fn.dataTable.ext.search = customFilters;
        }
        
        // Filtro de fecha
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
          let fechaCol = data[6];
          let dateMatch = true;
          if (dateRange.startDate && dateRange.endDate) {
            dateMatch = isDateInRange(fechaCol, dateRange.startDate, dateRange.endDate);
          }
          return dateMatch;
        });
        
        // Filtro de coordinación
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
          if (!currentCoordinacionFilter || currentCoordinacionFilter === '') {
            return true;
          }
          
          let coordinacionNombre = data[3];
          
          // Obtener el ID de coordinación desde el nombre usando el mapa
          let coordinacionId = coordinacionMap.get(coordinacionNombre);
          
          // Comparar con el filtro seleccionado
          return coordinacionId == currentCoordinacionFilter;
        });
        
        function applyDateFilter() {
          table.draw();
          updateActiveFiltersBadge();
        }
        
        function applyCoordinacionFilter() {
          table.draw();
          updateActiveFiltersBadge();
        }
        
        function updateActiveFiltersBadge() {
          let filtersText = [];
          
          if (dateRange.startDate && dateRange.endDate) {
            let startFmt = dateRange.startDate.format('DD/MM/YYYY');
            let endFmt = dateRange.endDate.format('DD/MM/YYYY');
            filtersText.push(`Fecha: ${startFmt} - ${endFmt}`);
          }
          
          if (currentCoordinacionFilter && currentCoordinacionFilter !== '') {
            let coordinacionText = $('#coordinacionFilter option:selected').text();
            filtersText.push(`Coordinación: ${coordinacionText}`);
          }
          
          if (filtersText.length === 0) {
            $('#activeFiltersBadge').text('Sin filtros activos').removeClass('active-filter-badge').addClass('label-info');
            $('#activeFiltersBadge').css('background-color', '#5bc0de');
          } else {
            $('#activeFiltersBadge').text(`Filtros: ${filtersText.join(' | ')}`).removeClass('label-info').addClass('active-filter-badge');
            $('#activeFiltersBadge').css('background-color', '#dd4b39');
          }
        }
        
        function getVisibleData() {
          let data = {
            servicios: {},
            items: {}
          };
          
          table.rows({ search: 'applied' }).every(function(rowIdx, tableLoop, rowLoop) {
            let rowData = this.data();
            let servicio = rowData[2];
            let item = rowData[4];
            let cantidad = parseFloat(rowData[5]) || 0;
            
            data.servicios[servicio] = (data.servicios[servicio] || 0) + cantidad;
            data.items[item] = (data.items[item] || 0) + cantidad;
          });
          
          return data;
        }
        
        const colorPalette = [
          '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40',
          '#8A2BE2', '#5F9EA0', '#D2691E', '#DC143C', '#00CED1', '#FFD700',
          '#ADFF2F', '#FF69B4', '#CD5C5C', '#90EE90', '#FFB6C1', '#20B2AA'
        ];
        
        function updateCharts() {
          let visibleData = getVisibleData();
          updateOrCreateChart(servicioChart, 'servicioChart', visibleData.servicios, 'Distribución por Servicio (Suma de Cantidades)');
          updateOrCreateChart(itemChart, 'itemChart', visibleData.items, 'Distribución por Item (Suma de Cantidades)');
        }
        
        function updateOrCreateChart(chart, chartId, data, title) {
          let labels = Object.keys(data);
          let values = Object.values(data);
          let colors = labels.map((_, i) => colorPalette[i % colorPalette.length]);
          
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
            let newChart = new Chart(ctx, {
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
                      font: { size: 12 }
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
            
            if(chartId === 'servicioChart') {
              servicioChart = newChart;
            } else if(chartId === 'itemChart') {
              itemChart = newChart;
            }
          }
        }
        
        // Configuración del date range picker
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
          applyDateFilter();
        });
        
        $('#dateRangePicker').on('cancel.daterangepicker', function(ev, picker) {
          $(this).val('');
          dateRange.startDate = null;
          dateRange.endDate = null;
          applyDateFilter();
        });
        
        // Eventos para el filtro de coordinación
        $('#coordinacionFilter').on('change', function() {
          currentCoordinacionFilter = $(this).val();
          applyCoordinacionFilter();
        });
        
        $('#clearCoordinacionBtn').on('click', function() {
          $('#coordinacionFilter').val('').trigger('change');
        });
        
        $('#clearDateBtn').on('click', function() {
          $('#dateRangePicker').val('');
          dateRange.startDate = null;
          dateRange.endDate = null;
          applyDateFilter();
        });
        
        $('#clearDateFilterBtn').on('click', function() {
          $('#dateRangePicker').val('');
          dateRange.startDate = null;
          dateRange.endDate = null;
          applyDateFilter();
        });
        
        $('#clearAllFiltersBtn').on('click', function() {
          // Limpiar filtro de fecha
          $('#dateRangePicker').val('');
          dateRange.startDate = null;
          dateRange.endDate = null;
          
          // Limpiar filtro de coordinación
          $('#coordinacionFilter').val('').trigger('change');
          
          applyDateFilter();
        });
        
        table.on('search.dt draw.dt', function() {
          updateCounters();
          updateTicketsUnicos();
          updateCantidadTotal();
          updateCharts();
        });
        
        updateCounters();
        updateTicketsUnicos();
        updateCantidadTotal();
        updateActiveFiltersBadge();
        
        setTimeout(function() {
          updateCharts();
        }, 100);
        
        table.draw();
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
    .filter-buttons .date-range-group,
    .filter-buttons .coordinacion-filter-group {
      margin-right: 5px;
      margin-bottom: 5px;
    }
    .date-range-group, .coordinacion-filter-group {
      display: inline-flex;
      align-items: center;
      background: #f9f9f9;
      padding: 5px 12px;
      border-radius: 4px;
      border: 1px solid #ddd;
    }
    .date-range-group label, .coordinacion-filter-group label {
      margin-right: 8px;
      margin-bottom: 0;
      font-weight: 500;
      color: #333;
    }
    #dateRangePicker, #coordinacionFilter {
      background-color: #fff;
      border: 1px solid #ccc;
      border-radius: 4px;
      padding: 5px 10px;
      cursor: pointer;
    }
    .clear-date-btn, .clear-filter-btn {
      margin-left: 8px;
      background: none;
      border: none;
      color: #d9534f;
      cursor: pointer;
    }
    .clear-date-btn:hover, .clear-filter-btn:hover {
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
    @media (max-width: 767px) {
      .filter-buttons {
        flex-direction: column;
        align-items: stretch;
      }
      .date-range-group, .coordinacion-filter-group {
        justify-content: space-between;
      }
      #dateRangePicker, #coordinacionFilter {
        width: 100%;
      }
    }
    .chart-legend {
      margin-top: 10px;
      text-align: center;
    }
    canvas {
      max-height: 400px;
    }
  </style>

  <?php
    $borrar = new ControladorTicketservicios();
    $borrar -> ctrBorrarTicketservicios();
  ?>
</div>