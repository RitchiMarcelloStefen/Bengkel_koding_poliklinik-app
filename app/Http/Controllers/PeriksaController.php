<?php

namespace App\Http\Controllers;

use App\Models\DaftarPoli;
use App\Models\Obat;
use App\Models\Periksa;
use App\Models\DetailPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeriksaController extends Controller
{
    public function index()
    {
        $daftar_polis = DaftarPoli::with(['pasien', 'jadwalPeriksa'])->whereDoesntHave('periksas')->get();
        return view('dokter.periksa-pasien.index', compact('daftar_polis'));
    }

    public function create()
    {
        $daftar_polis = DaftarPoli::with(['pasien', 'jadwalPeriksa'])->whereDoesntHave('periksas')->get();
        $obats = Obat::all();
        return view('dokter.periksa-pasien.create', compact('daftar_polis', 'obats'));
    }

    public function createWithPatient($id_daftar_poli)
    {
        $daftar_poli = DaftarPoli::with(['pasien', 'jadwalPeriksa'])->findOrFail($id_daftar_poli);
        $obats = Obat::where('stock', '>', 0)->get(); // Only show medicines with stock > 0
        $lowStockWarnings = Obat::where('stock', '>', 0)->where('stock', '<=', 5)->get(); // Warn for stock <= 5
        $outOfStockMedicines = Obat::where('stock', '=', 0)->get(); // Show out of stock medicines for notification
        return view('dokter.periksa-pasien.create', compact('daftar_poli', 'obats', 'lowStockWarnings', 'outOfStockMedicines'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_daftar_poli' => 'required|exists:daftar_poli,id',
            'catatan' => 'nullable|string',
            'obat_data' => 'nullable|string',
        ]);

        // Check stock availability before processing
        $insufficientStock = [];
        if ($validated['obat_data']) {
            $obatData = json_decode($validated['obat_data'], true);
            foreach ($obatData as $obat) {
                $obatModel = Obat::find($obat['id']);
                if (!$obatModel) {
                    return redirect()->back()->withInput()->withErrors(['obat_data' => 'Obat tidak ditemukan: ' . $obat['nama']]);
                }
                if ($obatModel->stock <= 0) {
                    $insufficientStock[] = $obatModel->nama_obat;
                }
            }
        }

        if (!empty($insufficientStock)) {
            return redirect()->back()->withInput()->withErrors(['obat_data' => 'Stok habis untuk obat: ' . implode(', ', $insufficientStock)]);
        }

        $biayaObat = 0;
        if ($validated['obat_data']) {
            $obatData = json_decode($validated['obat_data'], true);
            foreach ($obatData as $obat) {
                $biayaObat += $obat['harga'];
            }
        }

        $periksa = Periksa::create([
            'id_daftar_poli' => $validated['id_daftar_poli'],
            'tgl_periksa' => now(),
            'catatan' => $validated['catatan'],
            'biaya_periksa' => 150000 + $biayaObat,
        ]);

        if ($validated['obat_data']) {
            $obatData = json_decode($validated['obat_data'], true);
            foreach ($obatData as $obat) {
                DetailPeriksa::create([
                    'id_periksa' => $periksa->id,
                    'id_obat' => $obat['id'],
                ]);

                // Reduce stock automatically with additional safety check
                $obatModel = Obat::find($obat['id']);
                if ($obatModel && $obatModel->stock > 0) {
                    $obatModel->decrement('stock');
                } else {
                    // Log error if stock reduction fails (shouldn't happen due to validation above)
                    \Log::error('Failed to reduce stock for obat ID: ' . $obat['id'] . ' - insufficient stock');
                }
            }
        }

        return redirect()->route('periksa-pasien.index')->with('success', 'Pemeriksaan berhasil disimpan');
    }
}
