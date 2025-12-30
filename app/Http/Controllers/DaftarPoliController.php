<?php

namespace App\Http\Controllers;

use App\Models\DaftarPoli;
use App\Models\JadwalPeriksa;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DaftarPoliController extends Controller
{
    public function index()
    {
        $jadwalPeriksas = JadwalPeriksa::with('dokter.poli')->get();
        $polis = Poli::all();
        return view('pasien.daftar', compact('jadwalPeriksas', 'polis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_poli' => 'required|exists:poli,id',
            'id_jadwal' => 'required|exists:jadwal_periksa,id',
            'keluhan' => 'required|string',
        ]);

        // Get the last queue number for the selected schedule
        $lastQueue = DaftarPoli::where('id_jadwal', $request->id_jadwal)->max('no_antrian') ?? 0;
        $no_antrian = $lastQueue + 1;

        DaftarPoli::create([
            'id_pasien' => Auth::id(),
            'id_jadwal' => $request->id_jadwal,
            'keluhan' => $request->keluhan,
            'no_antrian' => $no_antrian,
            'id_poli' => $request->id_poli,
        ]);

        return redirect()->route('pasien.dashboard')->with('success', 'Pendaftaran poli berhasil!');
    }
}
