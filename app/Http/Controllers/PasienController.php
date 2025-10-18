<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dimana role adalah pasien
        $pasiens = User::where('role', 'pasien')->get();
        return view('admin.pasien.index', compact('pasiens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pasien.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //1. membuat validasi
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_ktp' => 'required|string|max:16|unique:users,no_ktp',
            'no_hp' => 'required|string|max:15',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|min:6',
        ]);
        // dd($data);

        User::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_ktp' => $request->no_ktp,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pasien',
        ]);

        return redirect()->route('pasien.index')
            ->with('message', 'Data Pasien Berhasil di tambahkan')
            ->with('type', 'success');
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
    public function edit(User $pasien)
    {
        return view('admin.pasien.edit', compact('pasien'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $pasien)
    {
        $request->validate([
            'nama'   => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_ktp' => 'required|string|max:16|unique:users,no_ktp,' . $pasien->id,
            // Email harus unik, tapi jangan hitung email si pasien yang ini.
            'no_hp'  => 'required|string|max:15',
            'email' => 'required|string|unique:users,email,' . $pasien->id,
            // No KTP harus unik, tapi jangan hitung NO KTP si pasien yang ini.
            'password' => 'nullable|string|min:6',
        ]);

        $updateData = [
            'nama'   => $request->nama,
            'alamat' => $request->alamat,
            'no_ktp' => $request->no_ktp,
            'no_hp'  => $request->no_hp,
            'email' => $request->email,
        ];

        // update password bila password diisi
        if ($request->filled('password')) {
            $pasien->password = Hash::make($request->password);
        }

        // disimpan
        $pasien->update($updateData);

        return redirect()->route('pasien.index')
            ->with('message', 'Data Pasien Berhasil di ubah')
            ->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
