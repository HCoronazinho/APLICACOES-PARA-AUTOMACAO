<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Radar Cidadão - Lista de Crimes</title>
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

        .card {
            background: #1e1e1e;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 0px 10px #0005;
            margin-bottom: 20px;
        }

        /* ===== Form filtros ===== */
        .filter-form {
            display: grid;
            gap: 15px;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            margin-bottom: 20px;
        }

        .filter-form .filter-item {
            display: flex;
            flex-direction: column;
        }

        .filter-form label {
            margin-bottom: 5px;
            font-size: 0.85rem;
            color: #ccc;
        }

        .filter-form input,
        .filter-form select {
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #333;
            background-color: #1e1e1e;
            color: #eee;
        }

        .filter-form button,
        .filter-form a.btn-secondary {
            margin-top: 10px;
            padding: 8px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            color: #fff;
            transition: all 0.2s ease-in-out;
        }

        .filter-form button.btn-primary {
            background-color: #ff7b00;
        }

        .filter-form button.btn-primary:hover {
            background-color: #e65c00;
        }

        .filter-form a.btn-secondary {
            background-color: #333;
            text-align: center;
            display: inline-block;
            text-decoration: none;
            line-height: 1.8;
        }

        .filter-form a.btn-secondary:hover {
            background-color: #555;
        }

        /* ===== TABELA ===== */
        table {
            width: 100%;
            border-collapse: collapse;
            background: #181818;
            border-radius: 10px;
            overflow: hidden;
        }

        thead {
            background: #ff7b00;
            color: #fff;
            text-align: left;
        }

        thead th {
            padding: 12px 10px;
            font-weight: bold;
            font-size: 0.85rem;
        }

        tbody tr {
            border-bottom: 1px solid #2a2a2a;
            transition: background 0.2s ease-in-out;
        }

        tbody tr:nth-child(even) {
            background: #1f1f1f;
        }

        tbody tr:hover {
            background: #2a2a2a;
        }

        tbody td {
            padding: 8px 10px;
            font-size: 0.85rem;
        }

        /* ===== PAGINAÇÃO ===== */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 20px;
        }

        .pagination a,
        .pagination span {
            display: inline-block;
            padding: 6px 10px;
            background-color: #1e1e1e;
            color: #eee;
            text-decoration: none;
            border-radius: 6px;
            font-size: 0.85rem;
            transition: 0.2s;
        }

        .pagination a:hover {
            background-color: #ff7b00;
            color: #fff;
        }

        .pagination .active span {
            background-color: #ff7b00;
            color: #fff;
        }

    </style>
</head>

<body>

    <div class="sidebar">
        <h2>Radar Cidadão</h2>
        <a href="/dashboard">Dashboard</a>
        <a href="{{ route('dashboard.crimes') }}">Crimes</a>
        <a href="#">Relatórios</a>
        <a href="#">Mapa</a>
        <a href="#">Configurações</a>
    </div>

    <div class="content">
        <div class="header">
            <h1>📊 Lista de Crimes</h1>
        </div>

        {{-- Form de filtros --}}
        <form method="GET" action="{{ route('dashboard.crimes') }}" class="filter-form">
            <div class="filter-item">
                <label>Data inicial</label>
                <input type="date" name="data_inicio" value="{{ request('data_inicio') }}">
            </div>
            <div class="filter-item">
                <label>Data final</label>
                <input type="date" name="data_fim" value="{{ request('data_fim') }}">
            </div>
            <div class="filter-item">
                <label>Grupo Fato</label>
                <select name="grupo_fato">
                    <option value="">Todos</option>
                    @foreach($grupos as $g)
                    <option value="{{ $g }}" {{ request('grupo_fato') == $g ? 'selected' : '' }}>{{ $g }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-item">
                <label>Tipo Enquadramento</label>
                <select name="tipo_enquadramento">
                    <option value="">Todos</option>
                    @foreach($enquadramentos as $e)
                    <option value="{{ $e }}" {{ request('tipo_enquadramento') == $e ? 'selected' : '' }}>{{ $e }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-item">
                <label>Tipo Fato</label>
                <select name="tipo_fato">
                    <option value="">Todos</option>
                    @foreach($tipos as $t)
                    <option value="{{ $t }}" {{ request('tipo_fato') == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-item">
                <label>Município</label>
                <select name="municipio_fato">
                    <option value="">Todos</option>
                    @foreach($municipios as $m)
                    <option value="{{ $m }}" {{ request('municipio_fato') == $m ? 'selected' : '' }}>{{ $m }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-item">
                <label>Local Fato</label>
                <select name="local_fato">
                    <option value="">Todos</option>
                    @foreach($locais as $l)
                    <option value="{{ $l }}" {{ request('local_fato') == $l ? 'selected' : '' }}>{{ $l }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-item">
                <label>Quantidade de Vítimas</label>
                <input type="number" name="quant_vitimas" min="1" value="{{ request('quant_vitimas') }}">
            </div>
            <div class="filter-item">
                <label>Idade mínima</label>
                <input type="number" name="idade_min" value="{{ request('idade_min') }}">
            </div>
            <div class="filter-item">
                <label>Idade máxima</label>
                <input type="number" name="idade_max" value="{{ request('idade_max') }}">
            </div>
            <div class="filter-item">
                <label>Sexo da Vítima</label>
                <select name="sexo_vitima">
                    <option value="">Todos</option>
                    @foreach($sexos as $s)
                    <option value="{{ $s }}" {{ request('sexo_vitima') == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-item">
                <label>Cor da Vítima</label>
                <select name="cor_vitima">
                    <option value="">Todas</option>
                    @foreach($cores as $c)
                    <option value="{{ $c }}" {{ request('cor_vitima') == $c ? 'selected' : '' }}>{{ $c }}</option>
                    @endforeach
                </select>
            </div>

            <div class="filter-item" style="grid-column: span 2;">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a href="{{ route('dashboard.crimes') }}" class="btn btn-secondary">Limpar</a>
            </div>
        </form>

        {{-- Tabela completa --}}
        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Município</th>
                        <th>Grupo Fato</th>
                        <th>Tipo Enquadramento</th>
                        <th>Tipo Fato</th>
                        <th>Local</th>
                        <th>Bairro</th>
                        <th>Qtd. Vítimas</th>
                        <th>Idade Vítima</th>
                        <th>Sexo</th>
                        <th>Cor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($crimes as $crime)
                    <tr>
                        <td>{{ $crime->id_crime }}</td>
                        <td>{{ $crime->data_fato ?? '-' }}</td>
                        <td>{{ $crime->municipio_fato ?? '-' }}</td>
                        <td>{{ $crime->grupo_fato ?? '-' }}</td>
                        <td>{{ $crime->tipo_enquadramento ?? '-' }}</td>
                        <td>{{ $crime->tipo_fato ?? '-' }}</td>
                        <td>{{ $crime->local_fato ?? '-' }}</td>
                        <td>{{ $crime->bairro ?? '-' }}</td>
                        <td>{{ $crime->quant_vitimas ?? '-' }}</td>
                        <td>{{ $crime->idade_vitima ?? '-' }}</td>
                        <td>{{ $crime->sexo_vitima ?? '-' }}</td>
                        <td>{{ $crime->cor_vitima ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Paginação --}}
            <div class="pagination">
                {{ $crimes->links() }}
            </div>
        </div>
    </div>

</body>

</html>
