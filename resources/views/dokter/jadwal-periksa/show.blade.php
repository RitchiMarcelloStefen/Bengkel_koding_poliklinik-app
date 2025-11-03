@extends('components.layouts.app')

@section('content')
<div class="container-fluid px-4 mt-4">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <h1 class="mb-4">Detail Jadwal Periksa</h1>
            <div class="card">
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>ID</th>
                            <td>{{ $jadwalPeriksa->id }}</td>
                        </tr>
                        <tr>
                            <th>Hari</th>
                            <td>{{ $jadwalPeriksa->hari }}</td>
                        </tr>
                        <tr>
                            <th>Jam Mulai</th>
                            <td>{{ $jadwalPeriksa->jam_mulai }}</td>
                        </tr>
                        <tr>
                            <th>Jam Selesai</th>
                            <td>{{ $jadwalPeriksa->jam_selesai }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <a href="{{ route('jadwal-periksa.index') }}" class="btn btn-secondary mt-3">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
