<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use Illuminate\Http\Request;

class JadwalPeriksaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jadwalPeriksas = JadwalPeriksa::where('id_dokter', auth()->user()->id)->get();
        $data = [
            'title' => 'Jadwal Periksa Dokter',
            'jadwalPeriksas' => $jadwalPeriksas,
        ];
        return view('dokter.jadwal-periksa.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dokter.jadwal-periksa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'hari' => 'required|string|max:10',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        // cek apakah sudah mempunyai jadwal yg sama
        if (JadwalPeriksa::where('id_dokter', auth()->user()->id)
            ->where('hari', $validated['hari'])
            ->where('jam_mulai', $validated['jam_mulai'])
            ->where('jam_selesai', $validated['jam_selesai'])
            ->exists()
        ) {
            return redirect()->back()->withErrors(['alert' => 'Jadwal sudah ada']);
        }

        JadwalPeriksa::create([
            'id_dokter' => auth()->user()->id,
            'hari' => $validated['hari'],
            'jam_mulai' => $validated['jam_mulai'],
            'jam_selesai' => $validated['jam_selesai'],
            'status' => 0,
        ]);

        return redirect()->route('dokter.jadwal-periksa.index')->with('alert', 'Jadwal periksa berhasil ditambahkan');
    }

    public function update($id)
    {
        $jadwalPeriksa = JadwalPeriksa::findOrFail($id);

        if (!$jadwalPeriksa->status) {
            JadwalPeriksa::where('id_dokter', auth()->user()->id)->update(['status' => 0,]);

            //memgaktifkan jadwal periksa
            $jadwalPeriksa->status = true;
            $jadwalPeriksa->save();

            return redirect()->route('dokter.jadwal-periksa.index')->with('alert', 'Jadwal periksa berhasil diaktifkan');
        }

        $jadwalPeriksa->status = false;
        $jadwalPeriksa->save();
        return redirect()->route('dokter.jadwal-periksa.index')->with('alert', 'Jadwal periksa berhasil dinonaktifkan');
    }
}
