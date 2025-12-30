@extends('components.layouts.app')

@section('content')
<div class="container-fluid px-4 mt-4">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="mb-4">Periksa Pasien</h1>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Nama Pasien</th>
                            <th>Keluhan</th>
                            <th>No Antrian</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($daftar_polis as $daftar)
                            <tr>
                                <td>{{ $daftar->id }}</td>
                                <td>{{ $daftar->pasien->nama }}</td>
                                <td>{{ $daftar->keluhan }}</td>
                                <td>{{ $daftar->no_antrian }}</td>
                                <td>
                                    <a href="{{ route('periksa-pasien.createWithPatient', $daftar->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-stethoscope"></i> Periksa
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="5">
                                    Tidak ada pasien yang perlu diperiksa
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
