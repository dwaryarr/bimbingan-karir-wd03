<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\JanjiPeriksa;
use Illuminate\Http\Request;

class RiwayatPeriksaController extends Controller
{
    public function index()
    {
        $janjiPeriksa = JanjiPeriksa::where('id_pasien', auth()->user()->id)
            // ->with(['dokter', 'jadwal'])
            ->get();
        return view('pasien.riwayat-periksa.index')->with([
            'janjiPeriksa' => $janjiPeriksa,
        ]);
    }

    public function detail($id)
    {
        $janjiPeriksa = JanjiPeriksa::with(['jadwalPeriksa', 'periksa'])->findOrFail($id);

        return view('pasien.riwayat-periksa.detail')->with([
            'janjiPeriksa' => $janjiPeriksa,
        ]);
    }

    public function riwayat($id)
    {
        $janjiPeriksa = JanjiPeriksa::where('id_pasien', auth()->user()->id)
            ->with(['jadwalPeriksa', 'periksa'])
            ->findOrFail($id);

        return view('pasien.riwayat-periksa.riwayat')->with([
            'janjiPeriksa' => $janjiPeriksa,
        ]);
    }
}
