@extends('components.layouts.app')

@section('content')
@if (session('success'))
    <div class="alert alert-success" id="alert">{{ session('success') }}</div>
@endif

<div class="container-fluid px-4 mt-4">
    <div class="row">
        <div class="col-lg-12">

            {{-- Alert flash message --}}
            @if (session('message'))
                <div class="alert alert-{{ session('type', 'success') }} alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <h1 class="mb-4">Data Pasien</h1>

            <a href="{{ route('pasien.create') }}" class="btn btn-primary mb-3">
                <i class="fas fa-plus"></i> Tambah Pasien
            </a>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No. KTP</th>
                            <th>No. HP</th>
                            <th>Email</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pasiens as $pasien )
                            <tr>
                                <td>{{ $pasien->id }}</td>
                                <td>{{ $pasien->nama }}</td>
                                <td>{{ $pasien->alamat }}</td>
                                <td>{{ $pasien->no_ktp }}</td>
                                <td>{{ $pasien->no_hp }}</td>
                                <td>{{ $pasien->email }}</td>
                                <td>
                                    <a href="{{ route('pasien.edit', $pasien->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>Edit
                                    </a>
                                    <form action="{{ route('pasien.destroy', $pasien->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus Pasien ini ?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="7">
                                    Belum ada Pasien
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    setTimeout(() => {
        const alert = document.getElementById('alert');
        if (alert) alert.remove();
    }, 3000);
</script>
@endsection
