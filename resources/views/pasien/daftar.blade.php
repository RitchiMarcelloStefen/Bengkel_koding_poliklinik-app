@extends('components.layouts.app')

@section('content')
<div class="container-fluid px-4 mt-4">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <h1 class="mb-4">Daftar Poli</h1>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('pasien.daftar.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="no_rm" class="form-label">No. Rekam Medis</label>
                                    <input type="text" class="form-control" id="no_rm" name="no_rm" value="{{ Auth::user()->id }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="nama_pasien" class="form-label">Nama Pasien</label>
                                    <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" value="{{ Auth::user()->nama }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="id_poli" class="form-label">Pilih Poli <span class="text-danger">*</span></label>
                                    <select class="form-control" id="id_poli" name="id_poli">
                                        <option value="">-- Pilih Poli --</option>
                                        @foreach($polis as $poli)
                                            <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="id_jadwal" class="form-label">Pilih Jadwal Periksa <span class="text-danger">*</span></label>
                                    <select class="form-control @error('id_jadwal') is-invalid @enderror" id="id_jadwal" name="id_jadwal" required>
                                        <option value="">-- Pilih Jadwal --</option>
                                        @foreach($jadwalPeriksas as $jadwal)
                                            <option value="{{ $jadwal->id }}" data-poli="{{ $jadwal->dokter->id_poli }}" style="display: none;">
                                                {{ $jadwal->dokter->nama }} - {{ $jadwal->hari }} ({{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_jadwal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="keluhan" class="form-label">Keluhan <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('keluhan') is-invalid @enderror" id="keluhan" name="keluhan" rows="4" required>{{ old('keluhan') }}</textarea>
                            @error('keluhan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Daftar
                            </button>
                            <a href="{{ route('pasien.dashboard') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
document.getElementById('id_poli').addEventListener('change', function() {
    var selectedPoli = this.value;
    var jadwalOptions = document.querySelectorAll('#id_jadwal option');

    jadwalOptions.forEach(function(option) {
        if (option.value === '') {
            option.style.display = 'block'; // Always show the default option
        } else if (option.getAttribute('data-poli') === selectedPoli) {
            option.style.display = 'block';
        } else {
            option.style.display = 'none';
        }
    });

    // Reset jadwal selection
    document.getElementById('id_jadwal').value = '';
});
</script>
