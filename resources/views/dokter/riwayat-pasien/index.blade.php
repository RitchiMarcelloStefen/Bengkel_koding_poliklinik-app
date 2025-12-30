@extends('components.layouts.app')

@section('content')
<div class="container-fluid px-4 mt-4">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="mb-4">Riwayat Pasien</h1>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>No Antrian</th>
                            <th>Nama Pasien</th>
                            <th>Keluhan</th>
                            <th>Tanggal Periksa</th>
                            <th>Biaya</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($periksas as $periksa)
                        <tr>
                            <td>{{ $periksa->daftarPoli->no_antrian }}</td>
                            <td>{{ $periksa->daftarPoli->pasien->nama }}</td>
                            <td>{{ $periksa->daftarPoli->keluhan }}</td>
                            <td>{{ $periksa->tgl_periksa }}</td>
                            <td>Rp {{ number_format($periksa->biaya_periksa, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('riwayat-pasien.show', $periksa->id) }}" class="btn btn-primary btn-sm">
                                    Detail
                                </a>
                                <form action="{{ route('riwayat-pasien.destroy', $periksa->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus riwayat pasien ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center" colspan="6">
                                Tidak ada riwayat pasien
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
