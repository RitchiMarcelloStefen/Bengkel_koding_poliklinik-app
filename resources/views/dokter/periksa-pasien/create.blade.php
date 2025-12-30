@extends('components.layouts.app')

@section('content')
<div class="container-fluid px-4 mt-4">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="mb-4">Periksa Pasien</h1>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('periksa-pasien.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_daftar_poli" value="{{ $daftar_poli->id }}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Pasien</label>
                                    <p class="form-control-plaintext">{{ $daftar_poli->pasien->nama }} - {{ $daftar_poli->keluhan }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="obat" class="form-label">Pilih Obat</label>
                                    <select id="obat" class="form-control">
                                        <option value="">-- Pilih Obat --</option>
                                        @foreach($obats as $obat)
                                            <option value="{{ $obat->id }}" data-harga="{{ $obat->harga }}" data-stock="{{ $obat->stock }}">{{ $obat->nama_obat }} - Rp {{ number_format($obat->harga, 0, ',', '.') }} (Stok: {{ $obat->stock }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">&nbsp;</label><br>
                                    <button type="button" id="add-obat" class="btn btn-primary">Tambahkan Obat</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                @if(isset($outOfStockMedicines) && $outOfStockMedicines->count() > 0)
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong><i class="fas fa-exclamation-triangle"></i> Stok Obat Habis!</strong>
                                        <p class="mb-2">Obat berikut telah habis stok dan tidak dapat diresepkan:</p>
                                        <ul class="mb-0">
                                            @foreach($outOfStockMedicines as $medicine)
                                                <li><strong>{{ $medicine->nama_obat }}</strong> - Stok habis</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                @if(isset($lowStockWarnings) && $lowStockWarnings->count() > 0)
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong><i class="fas fa-exclamation-circle"></i> Stok Obat Menipis!</strong>
                                        <p class="mb-2">Obat berikut memiliki stok rendah (≤ 5):</p>
                                        <ul class="mb-0">
                                            @foreach($lowStockWarnings as $warning)
                                                <li>{{ $warning->nama_obat }} (Stok: {{ $warning->stock }})</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                @error('obat_data')
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Error:</strong> {{ $message }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @enderror
                                <div id="selected-obat">
                                    <h5>Obat yang Dipilih</h5>
                                    <table class="table table-bordered" id="obat-table">
                                        <thead>
                                            <tr>
                                                <th>Nama Obat</th>
                                                <th>Harga</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="obat-list">
                                        </tbody>
                                    </table>
                                    <p class="fw-bold">Total Biaya Obat: Rp <span id="total-biaya">0</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="catatan" class="form-label">Catatan</label>
                                    <textarea name="catatan" id="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="3"></textarea>
                                    @error('catatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="obat_data" id="obat-data">
                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <a href="{{ route('periksa-pasien.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    var selectedObat = [];
    var totalBiaya = 0;
    var addButton = document.getElementById('add-obat');

    addButton.addEventListener('click', function(e) {
        e.preventDefault();

        var select = document.getElementById('obat');
        var selectedOption = select.options[select.selectedIndex];

        if (!selectedOption.value || selectedOption.value === '') {
            alert('Pilih obat terlebih dahulu!');
            return;
        }

        var id = selectedOption.value;
        var text = selectedOption.textContent || selectedOption.innerText;
        var nama = text.split(' - ')[0].trim();
        var harga = parseInt(selectedOption.getAttribute('data-harga'));
        var stock = parseInt(selectedOption.getAttribute('data-stock'));

        // Check stock availability
        if (stock <= 0) {
            alert('Stok obat habis!');
            return;
        }

        // Check if obat already selected
        var alreadySelected = false;
        for (var i = 0; i < selectedObat.length; i++) {
            if (selectedObat[i].id == id) {
                alreadySelected = true;
                break;
            }
        }

        if (alreadySelected) {
            alert('Obat sudah dipilih!');
            return;
        }

        selectedObat.push({id: id, nama: nama, harga: harga});
        totalBiaya += harga;
        updateList();

        // Reset select
        select.selectedIndex = 0;
    });

    function updateList() {
        var tbody = document.getElementById('obat-list');
        tbody.innerHTML = '';

        for (var i = 0; i < selectedObat.length; i++) {
            var obat = selectedObat[i];
            var tr = document.createElement('tr');

            var tdNama = document.createElement('td');
            tdNama.textContent = obat.nama;
            tr.appendChild(tdNama);

            var tdHarga = document.createElement('td');
            tdHarga.textContent = 'Rp ' + obat.harga.toLocaleString();
            tr.appendChild(tdHarga);

            var tdAksi = document.createElement('td');
            var removeBtn = document.createElement('button');
            removeBtn.textContent = 'Hapus';
            removeBtn.className = 'btn btn-danger btn-sm';
            removeBtn.type = 'button';
            removeBtn.addEventListener('click', (function(index, harga) {
                return function() {
                    selectedObat.splice(index, 1);
                    totalBiaya -= harga;
                    updateList();
                };
            })(i, obat.harga));
            tdAksi.appendChild(removeBtn);
            tr.appendChild(tdAksi);

            tbody.appendChild(tr);
        }

        document.getElementById('total-biaya').textContent = totalBiaya.toLocaleString();
        document.getElementById('obat-data').value = JSON.stringify(selectedObat);
    }
});
</script>
