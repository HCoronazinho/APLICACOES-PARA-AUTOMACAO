<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CrimeController extends Controller
{
    public function index(Request $request)
    {
        // Query base
        $query = DB::table('crimes');

        // --- FILTROS ---

        // intervalo de datas (data_fato é YYYY-MM-DD)
        if ($request->filled('data_inicio')) {
            $query->whereDate('data_fato', '>=', $request->input('data_inicio'));
        }
        if ($request->filled('data_fim')) {
            $query->whereDate('data_fato', '<=', $request->input('data_fim'));
        }

        // filtros por valores exatos
        if ($request->filled('grupo_fato')) {
            $query->where('grupo_fato', $request->input('grupo_fato'));
        }
        if ($request->filled('tipo_enquadramento')) {
            $query->where('tipo_enquadramento', $request->input('tipo_enquadramento'));
        }
        if ($request->filled('tipo_fato')) {
            $query->where('tipo_fato', $request->input('tipo_fato'));
        }
        if ($request->filled('municipio_fato')) {
            $query->where('municipio_fato', $request->input('municipio_fato'));
        }
        if ($request->filled('local_fato')) {
            $query->where('local_fato', $request->input('local_fato'));
        }

        // bairro (partial match)
        if ($request->filled('bairro')) {
            $query->where('bairro', 'ILIKE', '%' . $request->input('bairro') . '%');
        }

        // quantidade de vítimas (match exato)
        if ($request->filled('quant_vitimas')) {
            $query->where('quant_vitimas', $request->input('quant_vitimas'));
        }

        // idade vítima (range)
        if ($request->filled('idade_min')) {
            $query->where('idade_vitima', '>=', (int) $request->input('idade_min'));
        }
        if ($request->filled('idade_max')) {
            $query->where('idade_vitima', '<=', (int) $request->input('idade_max'));
        }

        // sexo e cor
        if ($request->filled('sexo_vitima')) {
            $query->where('sexo_vitima', $request->input('sexo_vitima'));
        }
        if ($request->filled('cor_vitima')) {
            $query->where('cor_vitima', $request->input('cor_vitima'));
        }

        // --- listas para os dropdowns (distincts) ---
        // Note: retiramos nulos para evitar opções vazias na UI.
        $grupos = DB::table('crimes')->whereNotNull('grupo_fato')->distinct()->orderBy('grupo_fato')->pluck('grupo_fato');
        $enquadramentos = DB::table('crimes')->whereNotNull('tipo_enquadramento')->distinct()->orderBy('tipo_enquadramento')->pluck('tipo_enquadramento');
        $tipos = DB::table('crimes')->whereNotNull('tipo_fato')->distinct()->orderBy('tipo_fato')->pluck('tipo_fato');
        $municipios = DB::table('crimes')->whereNotNull('municipio_fato')->distinct()->orderBy('municipio_fato')->pluck('municipio_fato');
        $locais = DB::table('crimes')->whereNotNull('local_fato')->distinct()->orderBy('local_fato')->pluck('local_fato');
        $sexos = DB::table('crimes')->whereNotNull('sexo_vitima')->distinct()->orderBy('sexo_vitima')->pluck('sexo_vitima');
        $cores = DB::table('crimes')->whereNotNull('cor_vitima')->distinct()->orderBy('cor_vitima')->pluck('cor_vitima');

        // Paginação (mantém query string para filtros nas páginas)
        $crimes = $query->orderByDesc('data_fato')->paginate(20)->withQueryString();

        // Retorna a view com todas as variáveis que o Blade usa
        return view('dashboard.crimes', compact(
            'crimes',
            'grupos',
            'enquadramentos',
            'tipos',
            'municipios',
            'locais',
            'sexos',
            'cores'
        ));
    }

    // Retorna JSON com top 10 municípios por número de crimes
    public function topCities(Request $request)
    {
        $rows = DB::table('crimes')
            ->select('municipio_fato as municipio', DB::raw('COUNT(*) as total'))
            ->groupBy('municipio_fato')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return response()->json($rows);
    }

    // Mostra todos os crimes em uma tabela Blade
    public function listCrimes(Request $request)
    {
        $query = DB::table('crimes');

        if ($request->filled('data_inicio')) {
            $query->whereDate('data_fato', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->whereDate('data_fato', '<=', $request->data_fim);
        }
        // Filtro por grupo_fato
        if ($request->filled('grupo_fato')) {
            $query->where('grupo_fato', $request->grupo_fato);
        }

        // Filtro por tipo enquadramento
        if ($request->filled('tipo_enquadramento')) {
            $query->where('tipo_enquadramento', $request->tipo_enquadramento);
        }

        // Filtro por tipo_fato
        if ($request->filled('tipo_fato')) {
            $query->where('tipo_fato', $request->tipo_fato);
        }

        // Filtro por município
        if ($request->filled('municipio_fato')) {
            $query->where('municipio_fato', $request->municipio_fato);
        }

        // Filtro por local_fato
        if ($request->filled('local_fato')) {
            $query->where('local_fato', $request->local_fato);
        }

        // Filtro por bairro (campo digitável)
        if ($request->filled('bairro')) {
            $query->where('bairro', 'ILIKE', '%' . $request->bairro . '%');
        }

        // Filtro por quantidade de vítimas
        if ($request->filled('quant_vitimas')) {
            $query->where('quant_vitimas', $request->quant_vitimas);
        }

        // Filtro por idade (alcance)
        if ($request->filled('idade_min') && $request->filled('idade_max')) {
            $query->whereBetween('idade_vitima', [$request->idade_min, $request->idade_max]);
        }

        // Filtro por sexo
        if ($request->filled('sexo_vitima')) {
            $query->where('sexo_vitima', $request->sexo_vitima);
        }

        // Filtro por cor
        if ($request->filled('cor_vitima')) {
            $query->where('cor_vitima', $request->cor_vitima);
        }

        $crimes = $query->paginate(20); // paginação para não sobrecarregar

        return view('dashboard.crimes', compact('crimes'));
    }

    public function showCrimes()
    {
        $grupos = DB::table('crimes')->distinct()->pluck('grupo_fato');
        $enquadramentos = DB::table('crimes')->distinct()->pluck('tipo_enquadramento');
        $tipos = DB::table('crimes')->distinct()->pluck('tipo_fato');
        $municipios = DB::table('crimes')->distinct()->pluck('municipio_fato');
        $locais = DB::table('crimes')->distinct()->pluck('local_fato');
        $sexos = DB::table('crimes')->distinct()->pluck('sexo_vitima');
        $cores = DB::table('crimes')->distinct()->pluck('cor_vitima');

        $crimes = DB::table('crimes')->paginate(20);

        return view('dashboard.crimes', compact(
            'crimes',
            'grupos',
            'enquadramentos',
            'tipos',
            'municipios',
            'locais',
            'sexos',
            'cores'
        ));
    }

    public function topViolentCities()
{
    $rows = DB::table('crimes as c')
        ->join('populacao_municipios as p', 'p.nome_municipio', '=', 'c.municipio_fato')
        ->join('crimes_violentos as v', DB::raw('LOWER(TRIM(c.tipo_enquadramento))'), '=', DB::raw('LOWER(TRIM(v.crime_violento))'))
        ->select(
            'c.municipio_fato as municipio',
            DB::raw('COUNT(*)::numeric / p.populacao_estimada::numeric * 100000 as crimes_por_100k'),
            DB::raw('COUNT(*) as total_crimes'),
            'p.populacao_estimada'
        )
        ->groupBy('c.municipio_fato', 'p.populacao_estimada')
        ->orderByDesc('crimes_por_100k')
        ->limit(10)
        ->get();

    return response()->json($rows);
}

}
