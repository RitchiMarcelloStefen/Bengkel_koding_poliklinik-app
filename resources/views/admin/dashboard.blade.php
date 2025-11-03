@extends('components.layouts.app')

@section('content')
<div class="container-fluid px-4 mt-4">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="mb-4">Halo Selamat Datang Admin</h1>
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
