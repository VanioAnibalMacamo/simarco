<!-- resources/views/home.blade.php -->

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
@stop

@section('content')
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $numMedicos }}</h3>
                    <p>Médicos</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ route('medicoIndex') }}" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>

            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $numPacientes }}</h3>
                    <p>Pacientes</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ route('pacienteIndex') }}"class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $numConsultas }}</h3>
                    <p>Consultas</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ route('agendamentosMarcados') }}" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $numMedicamentos }}</h3>
                    <p>Medicamentos</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{ route('medicamentoIndex') }}"class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Gráfico de Área -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Área do Gráfico</h3>
                </div>
                <div class="card-body">
                    <canvas id="areaChart" style="height: 350px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico de Pizza -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gráfico de Pizza</h3>
                </div>
                <div class="card-body">
                    <canvas id="pieChart" style="height: 350px;"></canvas>
                </div>
            </div>
        </div>
         <!-- Gráfico de Barras -->
         <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gráfico de Barras</h3>
                </div>
                <div class="card-body">
                    <canvas id="barChart" style="height: 350px;"></canvas>
                </div>
            </div>
        </div>

            <!-- Donut Chart -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Donut Chart</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="donutChart" style="height: 350px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<!-- Incluindo o Chart.js via CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script> console.log('Hi!'); </script>
<script src="{{ asset('js/Chart.js') }}"></script>
<script>
    // Dados fictícios para o gráfico de área
    var areaChartData = {
        labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho'],
        datasets: [
            {
                label: 'Vendas',
                data: [10, 20, 15, 30, 25, 40, 35],
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: false,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
            },
        ]
    };

    // Opções do gráfico de área
    var areaChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            display: false
        },
        scales: {
            xAxes: [{
                gridLines: {
                    display: false,
                }
            }],
            yAxes: [{
                gridLines: {
                    display: false,
                }
            }]
        }
    };

    // Gráfico de área
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d');
    var areaChart = new Chart(areaChartCanvas, {
        type: 'line',
        data: areaChartData,
        options: areaChartOptions
    });
</script>

<script>
// Dados fictícios para o gráfico de pizza
var pieChartData = {
    labels: ['Vermelho', 'Verde', 'Azul'],
    datasets: [
        {
            data: [30, 50, 20],
            backgroundColor: ['#f56954', '#00a65a', '#f39c12'],
        },
    ]
};

// Opções do gráfico de pizza
var pieChartOptions = {
    maintainAspectRatio: false,
    responsive: true,
};

// Gráfico de pizza
var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
var pieChart = new Chart(pieChartCanvas, {
    type: 'pie',
    data: pieChartData,
    options: pieChartOptions
});
</script>

<script>
// Dados fictícios para o gráfico de barras
var barChartData = {
    labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho'],
    datasets: [
        {
            label: 'Vendas',
            data: [10, 20, 15, 30, 25, 40, 35],
            backgroundColor: '#007bff',
        },
    ]
};

// Dados fictícios para o Donut Chart
var donutChartData = {
        labels: ['Categoria 1', 'Categoria 2', 'Categoria 3'],
        datasets: [
            {
                data: [40, 30, 30],
                backgroundColor: ['#007bff', '#dc3545', '#ffc107'],
            },
        ]
    };

// Opções comuns para os gráficos
var commonChartOptions = {
    maintainAspectRatio: false,
    responsive: true,
};

// Gráfico de barras
var barChartCanvas = $('#barChart').get(0).getContext('2d');
var barChart = new Chart(barChartCanvas, {
    type: 'bar',
    data: barChartData,
    options: commonChartOptions
});

// Donut Chart
var donutChartCanvas = $('#donutChart').get(0).getContext('2d');
    var donutChart = new Chart(donutChartCanvas, {
        type: 'doughnut',
        data: donutChartData,
        options: commonChartOptions
    });
</script>
@stop




