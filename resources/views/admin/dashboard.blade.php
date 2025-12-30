@extends('components.layouts.app')

@section('content')
<div class="container-fluid px-4 mt-4">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="mb-4">Halo Selamat Datang Admin</h1>

            @if(isset($outOfStockMedicines) && $outOfStockMedicines->count() > 0)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="fas fa-exclamation-triangle"></i> Stok Obat Habis!</strong>
                    <p class="mb-2">Obat berikut telah habis stok dan perlu segera diisi ulang:</p>
                    <ul class="mb-0">
                        @foreach($outOfStockMedicines as $medicine)
                            <li><strong>{{ $medicine->nama_obat }}</strong> - Perlu restock segera</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(isset($lowStockMedicines) && $lowStockMedicines->count() > 0)
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong><i class="fas fa-exclamation-circle"></i> Stok Obat Menipis!</strong>
                    <p class="mb-2">Obat berikut memiliki stok rendah (≤ 5):</p>
                    <ul class="mb-0">
                        @foreach($lowStockMedicines as $medicine)
                            <li><strong>{{ $medicine->nama_obat }}</strong> - Stok tersisa: {{ $medicine->stock }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="fas fa-user-md fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Dokter</h5>
                            <p class="card-text">Kelola data dokter</p>
                            <a href="{{ route('dokter.index') }}" class="btn btn-primary">Kelola Dokter</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="fas fa-hospital fa-3x text-success mb-3"></i>
                            <h5 class="card-title">Poli</h5>
                            <p class="card-text">Kelola data poli</p>
                            <a href="{{ route('polis.index') }}" class="btn btn-success">Kelola Poli</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="fas fa-users fa-3x text-info mb-3"></i>
                            <h5 class="card-title">Pasien</h5>
                            <p class="card-text">Kelola data pasien</p>
                            <a href="{{ route('pasien.index') }}" class="btn btn-info">Kelola Pasien</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="fas fa-pills fa-3x text-warning mb-3"></i>
                            <h5 class="card-title">Obat</h5>
                            <p class="card-text">Kelola data obat</p>
                            <a href="{{ route('obat.index') }}" class="btn btn-warning">Kelola Obat</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
