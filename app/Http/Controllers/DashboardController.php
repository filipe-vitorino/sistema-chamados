<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Responsavel;
use App\Models\Chamado;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            'responsaveisAtivos' =>
            Responsavel::where('ativo', true)->count(),

            'chamadosAbertos' =>
            Chamado::where('status', 'aberto')->count(),

            'chamadosAndamento' =>
            Chamado::where('status', 'em_andamento')->count(),

            'chamadosResolvidos' =>
            Chamado::where('status', 'resolvido')->count(),

            'ultimosChamados' => Chamado::latest()
                ->take(5)
                ->get(),
        ]);
    }
}
