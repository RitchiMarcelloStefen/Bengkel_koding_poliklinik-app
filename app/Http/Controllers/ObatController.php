<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $obats = Obat::all();
        $outOfStockMedicines = Obat::where('stock', '=', 0)->get();
        $lowStockMedicines = Obat::where('stock', '>', 0)->where('stock', '<=', 5)->get();
        return view('admin.obat.index', compact('obats', 'outOfStockMedicines', 'lowStockMedicines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.obat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kemasan' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        Obat::create($validated);
        return redirect()->route('obat.index')->with('success', 'Obat berhasil di tambahkan')->with('type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $obat = Obat::findOrFail($id);
        return view('admin.obat.edit', compact('obat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kemasan' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $obat = Obat::findOrFail($id);
        $obat->update($validated);
        return redirect()->route('obat.index')->with('success', 'Obat berhasil di update')->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();
        return redirect()->route('obat.index')->with('success', 'Obat berhasil di hapus')->with('type', 'success');
    }

    /**
     * Add stock to the specified resource.
     */
    public function addStock(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $obat = Obat::findOrFail($id);
        $obat->increment('stock', $request->quantity);
        return redirect()->route('obat.index')->with('success', 'Stok berhasil ditambahkan')->with('type', 'success');
    }

    /**
     * Reduce stock from the specified resource.
     */
    public function reduceStock(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $obat = Obat::findOrFail($id);
        if ($obat->stock >= $request->quantity) {
            $obat->decrement('stock', $request->quantity);
            return redirect()->route('obat.index')->with('success', 'Stok berhasil dikurangi')->with('type', 'success');
        } else {
            return redirect()->route('obat.index')->with('error', 'Stok tidak cukup')->with('type', 'danger');
        }
    }
}
