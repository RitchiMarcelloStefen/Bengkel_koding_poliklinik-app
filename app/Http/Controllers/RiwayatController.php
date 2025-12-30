<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periksa;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        $doctorId = Auth::id();

        $periksas = Periksa::with(['daftarPoli.pasien', 'daftarPoli.jadwalPeriksa.dokter'])
            ->whereHas('daftarPoli.jadwalPeriksa', function($query) use ($doctorId) {
                $query->where('id_dokter', $doctorId);
            })
            ->get();

        return view('dokter.riwayat-pasien.index', compact('periksas'));
    }

    public function show($id)
    {
        $periksa = Periksa::with(['daftarPoli.pasien', 'daftarPoli.poli', 'daftarPoli.jadwalPeriksa.dokter', 'detailPeriksas.obat'])
            ->findOrFail($id);

        // Ensure the periksa belongs to the logged-in doctor
        if ($periksa->daftarPoli->jadwalPeriksa->id_dokter !== Auth::id()) {
            abort(403);
        }

        return view('dokter.riwayat-pasien.show', compact('periksa'));
    }

    public function destroy($id)
    {
        $periksa = Periksa::findOrFail($id);

        // Ensure the periksa belongs to the logged-in doctor
        if ($periksa->daftarPoli->jadwalPeriksa->id_dokter !== Auth::id()) {
            abort(403);
        }

        $periksa->delete();

        return redirect()->route('riwayat-pasien.index')->with('success', 'Riwayat pasien berhasil dihapus.');
    }
}
