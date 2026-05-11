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
        Tabla de Tickets por Coordinación
        <small>Filtro: Rango Fechas | Gráfico por Coordinación</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Tickets por Coordinación</li>
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
                <button id="clearDateFilterBtn" class="btn btn-danger"><i class="fa fa-eraser"></i> Limpiar filtro de fecha</button>
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
                <!-- Nuevo apartado: Cantidad de tickets únicos -->
                <div class="col-md-3 col-sm-6">
                  <div class="info-box bg-yellow">
                    <span class="info-box-icon"><i class="fa fa-ticket"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Tickets únicos</span>
                      <span class="info-box-number" id="uniqueTickets">0</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-pie-chart"></i> Distribución por Coordinación</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <canvas id="coordinacionChart" width="800" height="400"></canvas>
                  <div id="coordinacionLegend" class="chart-legend"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="box box-solid box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-table"></i> Listado de tickets por coordinación</h3>
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
                    <th>Coordinación</th>
                    <th>Fecha</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $ticketcoordinacion = null;
                  $valor = null;
                  $ticketcoordinacion = ControladorTicketcoordinacion::ctrMostrarTicketcoordinacion($ticketcoordinacion, $valor);

                  foreach ($ticketcoordinacion as $key => $value){
                    // Obtener nombre de coordinación
                    $nombreCoordinacion = isset($value["id_coordinacion"]) ? $value["id_coordinacion"] : 'Sin asignar';
                  ?>
                  <tr>
                    <td><?php echo ($key+1); ?></td>
                    <td><?php echo $value["id_ticket"]; ?></td>
                    <td><?php echo obtenerNombreCoordinacion($value["id_coordinacion"]);?></td>
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
        let coordinacionChart = null;
        
        var table = $('#ticketsTable').DataTable({
          retrieve: true,
          "order": [[1, "desc"]],
          "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
          },
          "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "Todos"]],
          "pageLength": 25,
          "columnDefs": [
            { "orderable": true, "targets": [0,1,2,3] }
          ],
          "drawCallback": function() {
            updateCounters();
            updateCoordinacionChart();
          }
        });
        
        function updateCounters() {
          let info = table.page.info();
          $('#visibleRegistros').text(info.recordsDisplay);
          $('#totalRegistros').text(info.recordsTotal);
          
          // Calcular tickets únicos (sin duplicados)
          let uniqueTickets = new Set();
          table.rows({ search: 'applied' }).every(function(rowIdx, tableLoop, rowLoop) {
            let rowData = this.data();
            let ticketNumber = rowData[1]; // La columna del ticket
            if (ticketNumber && ticketNumber.trim() !== '') {
              uniqueTickets.add(ticketNumber);
            }
          });
          $('#uniqueTickets').text(uniqueTickets.size);
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
        
        if ($.fn.dataTable.ext.search.length > 0) {
            let customFilters = $.fn.dataTable.ext.search.filter(fn => {
                return fn.toString().indexOf('dateRange') === -1;
            });
            $.fn.dataTable.ext.search = customFilters;
        }
        
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
          let fechaCol = data[3];
          let dateMatch = true;
          if (dateRange.startDate && dateRange.endDate) {
            dateMatch = isDateInRange(fechaCol, dateRange.startDate, dateRange.endDate);
          }
          return dateMatch;
        });
        
        function applyDateFilter() {
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
            coordinaciones: {}
          };
          
          table.rows({ search: 'applied' }).every(function(rowIdx, tableLoop, rowLoop) {
            let rowData = this.data();
            let coordinacion = rowData[2];
            data.coordinaciones[coordinacion] = (data.coordinaciones[coordinacion] || 0) + 1;
          });
          
          return data;
        }
        
        const colorPalette = [
          '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40',
          '#8A2BE2', '#5F9EA0', '#D2691E', '#DC143C', '#00CED1', '#FFD700',
          '#ADFF2F', '#FF69B4', '#CD5C5C', '#90EE90', '#FFB6C1', '#20B2AA'
        ];
        
        function updateCoordinacionChart() {
          let visibleData = getVisibleData();
          updateOrCreateChart(coordinacionChart, 'coordinacionChart', visibleData.coordinaciones, 'Distribución por Coordinación');
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
            
            if(chartId === 'coordinacionChart') {
              coordinacionChart = chart;
            }
          }
        }
        
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
        
        table.on('search.dt draw.dt', function() {
          updateCounters();
          updateCoordinacionChart();
        });
        
        updateCounters();
        updateActiveFiltersBadge();
        
        setTimeout(function() {
          updateCoordinacionChart();
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
    /* Estilo para el nuevo apartado de tickets únicos */
    .bg-yellow {
      background-color: #f39c12 !important;
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
    .chart-legend {
      margin-top: 10px;
      text-align: center;
    }
    canvas {
      max-height: 400px;
    }
  </style>

  <?php
    $borrar = new ControladorTicketcoordinacion();
    $borrar -> ctrBorrarTicketcoordinacion();
  ?>
</div>