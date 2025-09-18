<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Radar Cidadão - Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #121212;
            color: #eee;
        }
        .sidebar {
            width: 215px;
            height: 100vh;
            background: #1e1e1e;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px;
        }
        .sidebar h2 {
            color: #ff7b00;
            margin-bottom: 30px;
        }
        .sidebar a {
            display: block;
            color: #bbb;
            padding: 10px;
            text-decoration: none;
            border-radius: 6px;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background: #333;
            color: #fff;
        }
        .content {
            margin-left: 245px;
            padding: 20px;
        }
        .header {
            background: #1e1e1e;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        .card {
            background: #1e1e1e;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 0px 10px #0005;
        }
        .card h3 {
            margin: 0;
            font-size: 1.2rem;
            color: #ff7b00;
        }
        .card p {
            font-size: 2rem;
            margin: 10px 0 0;
        }
        .chart-box {
            background: #1e1e1e;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 0px 10px #0005;
        }
        canvas {
            max-width: 100%;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Radar Cidadão</h2>
        <a href="#">Dashboard</a>
        <a href="#">Relatórios</a>
        <a href="#">Mapa</a>
        <a href="#">Configurações</a>
    </div>

    <div class="content">
        <div class="header">
            <h1>Bem-vindo, Usuário</h1>
        </div>

        <div class="cards">
            <div class="card">
                <h3>Total de Crimes</h3>
                <p>12.543</p>
            </div>
            <div class="card">
                <h3>Cidades Monitoradas</h3>
                <p>497</p>
            </div>
            <div class="card">
                <h3>Relatos Recentes</h3>
                <p>231</p>
            </div>
        </div>

        <!-- Caixa para o gráfico -->
        <div class="chart-box">
            <h2 style="color:#ff7b00; margin-bottom:16px;">Top 10 Municípios com mais Crimes</h2>
            <canvas id="topCitiesChart" height="120"></canvas>
            <div id="chartError" style="color:#f88;display:none;margin-top:12px"></div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script>
        async function loadTopCitiesChart() {
            try {
                const res = await fetch('/api/top-cities'); // ajuste se a rota estiver em /top-cities
                if (!res.ok) throw new Error('Falha ao buscar dados: ' + res.status);
                const data = await res.json();

                const labels = data.map(d => d.municipio || '(sem nome)');
                const values = data.map(d => Number(d.total) || 0);

                const ctx = document.getElementById('topCitiesChart').getContext('2d');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Quantidade de crimes',
                            data: values,
                            backgroundColor: 'rgba(255, 123, 0, 0.8)',
                            borderRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                            tooltip: { mode: 'index' }
                        },
                        scales: {
                            x: {
                                ticks: { color: '#ddd' },
                                grid: { display:false }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: { color: '#ddd' },
                                grid: { color:'rgba(255,255,255,0.1)' }
                            }
                        }
                    }
                });

            } catch (err) {
                document.getElementById('chartError').style.display = 'block';
                document.getElementById('chartError').textContent = err.message;
                console.error(err);
            }
        }

        document.addEventListener('DOMContentLoaded', loadTopCitiesChart);
    </script>
</body>
</html>
