@extends('layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <!-- Total unidades del mes -->
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-line fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Total unidades del mes</p>
                    <h6 class="mb-0">{{ $totalUnidadesMes }}</h6>
                </div>
            </div>
        </div>
        <!-- Total monto del mes -->
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-bar fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Total del mes</p>
                    <h6 class="mb-0">{{ formatNumber($totalMontoMes) }}</h6>
                </div>
            </div>
        </div>
        <!-- Total de clientes -->
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-pie fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Total de clientes</p>
                    <h6 class="mb-0">{{ $totalClientes }}</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-4">
        <!-- Gráfico de ventas mensuales -->
        <div class="col-12 col-xl-6">
            <div class="bg-secondary text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Ventas mensuales</h6>
                    <a href="#">Mostrar todo</a>
                </div>
                <canvas id="sales-chart"></canvas>
            </div>
        </div>
        <!-- Gráfico de comparación de ventas -->
        <div class="col-12 col-xl-6">
            <div class="bg-secondary text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Comparación de ventas</h6>
                    <a href="#">Mostrar todo</a>
                </div>
                <canvas id="revenue-chart"></canvas>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-4">
        <!-- Tabla de productos más vendidos -->
        <div class="col-12">
            <div class="bg-secondary text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Más Vendidos</h6>
                    <a href="#">Mostrar todo</a>
                </div>
                <div class="table-responsive">
                    <table class="table text-start align-middle table-bordered table-hover mb-0">
                        <thead>
                            <tr class="text-white">
                                <th scope="col">SKU</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Total Unidades</th>
                                <th scope="col">Vendidas en el Mes</th>
                                <th scope="col">Pendientes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productosMasVendidos as $producto)
                                <tr>
                                    <td>{{ $producto->producto->sku }}</td>
                                    <td>{{ $producto->producto->nombre }}</td>
                                    <td>{{ $producto->totalUnidades }}</td>
                                    <td>{{ $producto->unidadesMes }}</td>
                                    <td>{{ $producto->unidadesPorDespachar }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx1 = document.getElementById('sales-chart').getContext('2d');
        var salesChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: {!! json_encode($ventasMensuales->pluck('mes')->map(function($mes) { return DateTime::createFromFormat('!m', $mes)->format('F'); })) !!},
                datasets: [{
                    label: 'Ventas Mensuales',
                    data: {!! json_encode($ventasMensuales->pluck('totalMonto')) !!},
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: 'rgb(255, 99, 132)'
                        }
                    }
                }
            }
        });

        var ctx2 = document.getElementById('revenue-chart').getContext('2d');
        var revenueChart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: ['Mes Pasado', 'Mes Actual'],
                datasets: [{
                    label: 'Comparación de Ventas',
                    data: [{{ $ventasMesPasado }}, {{ $ventasMesActual }}],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: 'rgb(54, 162, 235)'
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
