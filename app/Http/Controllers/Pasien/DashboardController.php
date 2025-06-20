<?php

namespace App\Http\Controllers\pasien;

use App\Http\Controllers\Controller;
use App\Models\JanjiPeriksa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $janjiPeriksa = JanjiPeriksa::where('id_pasien', auth()->user()->id)
            ->whereDoesntHave('periksa')
            ->get();
        return view('pasien.dashboard')->with([
            'janjiPeriksa' => $janjiPeriksa,
        ]);
    }
}
