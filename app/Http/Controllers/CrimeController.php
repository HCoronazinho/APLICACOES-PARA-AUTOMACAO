<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CrimeController extends Controller
{
    // Renders the dashboard view (se você usa blade)
    public function index()
    {
        return view('dashboard'); // ajuste se o nome da view for outro
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
}
