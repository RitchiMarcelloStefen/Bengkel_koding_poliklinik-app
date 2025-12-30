@extends('components.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Detail Pemeriksaan Pasien</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-xl font-semibold mb-4">Informasi Pasien</h2>
                <p><strong>Nama Pasien:</strong> {{ $periksa->daftarPoli->pasien->nama }}</p>
                <p><strong>No Antrian:</strong> {{ $periksa->daftarPoli->no_antrian }}</p>
                <p><strong>Keluhan:</strong> {{ $periksa->daftarPoli->keluhan }}</p>
                @if($periksa->daftarPoli->poli)
                <p><strong>Poli:</strong> {{ $periksa->daftarPoli->poli->nama_poli }}</p>
                @endif
                <p><strong>Tanggal Periksa:</strong> {{ $periksa->tgl_periksa }}</p>
            </div>

            <div>
                <h2 class="text-xl font-semibold mb-4">Catatan Dokter</h2>
                <p>{{ $periksa->catatan }}</p>
            </div>
        </div>

        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4">Obat yang Diresepkan</h2>
            @if($periksa->detailPeriksas->count() > 0)
                <ul class="list-disc list-inside">
                    @foreach($periksa->detailPeriksas as $detail)
                        <li>{{ $detail->obat->nama_obat }} - Rp {{ number_format($detail->obat->harga, 0, ',', '.') }}</li>
                    @endforeach
                </ul>
            @else
                <p>Tidak ada obat yang diresepkan.</p>
            @endif
        </div>

        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4">Total Biaya Pemeriksaan</h2>
            <p class="text-2xl font-bold text-green-600">Rp {{ number_format($periksa->biaya_periksa, 0, ',', '.') }}</p>
        </div>

        <div class="mt-8">
            <a href="{{ route('riwayat-pasien.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Kembali ke Riwayat Pasien
            </a>
        </div>
    </div>
</div>
@endsection
