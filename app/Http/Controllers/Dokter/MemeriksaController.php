<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\DetailPeriksa;
use App\Models\JadwalPeriksa;
use App\Models\JanjiPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use Illuminate\Http\Request;

class MemeriksaController extends Controller
{

    public function index()
    {
        $jadwalPeriksa = JadwalPeriksa::where('id_dokter', auth()->user()->id)
            ->where('status', true)
            ->first();
        $janjiPeriksa = JanjiPeriksa::where('id_jadwal_periksa', $jadwalPeriksa->id)->get();
        $data = [
            'title' => 'Memeriksa Pasien',
            'jadwalPeriksa' => $jadwalPeriksa,
            'janjiPeriksa' => $janjiPeriksa,
        ];
        return view('dokter.memeriksa.index', $data);
    }

    public function periksa($id)
    {
        $janjiPeriksa = JanjiPeriksa::findOrFail($id);
        $obats = Obat::all();
        $data = [
            'title' => 'Memeriksa Pasien',
            'janjiPeriksa' => $janjiPeriksa,
            'obats' => $obats,
        ];
        return view('dokter.memeriksa.periksa', $data);
    }

    public function store(Request $request, $id)
    {
        $request->merge([
            'total_biaya' => preg_replace('/\D/', '', $request->total_biaya)
        ]);
        $validated = $request->validate([
            'tgl_periksa' => 'required|date',
            'catatan' => 'required|string|max:255',
            'biaya_periksa' => 'required|numeric|min:0',
            'total_biaya' => 'required|numeric|min:0',
            'obats' => 'array',
            'obats.*' => 'exists:obats,id',
        ]);

        $janjiPeriksa = JanjiPeriksa::findOrFail($id);

        $periksa = Periksa::create([
            'id_janji_periksa' => $janjiPeriksa->id,
            'tgl_periksa' => $validated['tgl_periksa'],
            'catatan' => $validated['catatan'],
            'biaya_periksa' => $validated['biaya_periksa'],
            'total_biaya' => $validated['biaya_periksa'],
        ]);

        foreach ($validated['obats'] as $obatId) {
            DetailPeriksa::create([
                'id_periksa' => $periksa->id,
                'id_obat' => $obatId,
            ]);
        }

        return redirect()->route('dokter.memeriksa.index')->with('alert', 'Periksa pasien berhasil dilakukan.');
    }

    public function edit($id)
    {
        $janjiPeriksa = JanjiPeriksa::findOrFail($id);
        $obats = Obat::all();
        $data = [
            'title' => 'Edit Periksa Pasien',
            'janjiPeriksa' => $janjiPeriksa,
            'obats' => $obats,
        ];
        return view('dokter.memeriksa.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->merge([
            'total_biaya' => preg_replace('/\D/', '', $request->total_biaya)
        ]);
        $validated = $request->validate([
            'tgl_periksa' => 'required|date',
            'catatan' => 'required|string|max:255',
            'biaya_periksa' => 'required|numeric|min:0',
            'total_biaya' => 'required|numeric|min:0',
            'obats' => 'array',
            'obats.*' => 'exists:obats,id',
        ]);


        $janjiPeriksa = JanjiPeriksa::findOrFail($id);
        $periksa = Periksa::where('id_janji_periksa', $janjiPeriksa->id)->first();

        if ($periksa) {
            $periksa->update([
                'tgl_periksa' => $validated['tgl_periksa'],
                'catatan' => $validated['catatan'],
                'biaya_periksa' => $validated['biaya_periksa'],
                'total_biaya' => $validated['total_biaya'],
            ]);
        } else {
            return redirect()->back()->with('alert', 'Periksa tidak ditemukan.');
        }

        // Hapus detail periksa lama
        DetailPeriksa::where('id_periksa', $periksa->id)->delete();

        // Tambah detail periksa baru
        foreach ($validated['obats'] as $obatId) {
            DetailPeriksa::create([
                'id_periksa' => $periksa->id,
                'id_obat' => $obatId,
            ]);
        }

        return redirect()->route('dokter.memeriksa.index')->with('alert', 'Periksa pasien berhasil diperbarui.');
    }
}
