<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <div class="page-title">
                <div class="row mb-4">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Pengeluaran</h3>
                    </div>
                </div>
            </div>

            <!-- Alert Notifikasi -->
            {{-- Alert Success --}}
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
                setTimeout(function() {
                    const alertElement = document.getElementById('successAlert');
                    if (alertElement) {
                        const alert = new bootstrap.Alert(alertElement);
                        alert.close();
                    }
                }, 2500);
            </script>
            @endif

            {{-- Alert Error --}}
            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorAlert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
                setTimeout(function() {
                    const alertElement = document.getElementById('errorAlert');
                    if (alertElement) {
                        const alert = new bootstrap.Alert(alertElement);
                        alert.close();
                    }
                }, 2500);
            </script>
            @endif
            <!-- End Alert Notifikasi -->

            <section class="section">
                <div class="row table-responsive" id="table-hover-row">
                    <div class="col-12">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-content">

                                    <!-- Form Search + Sorting -->
                                    <div class="d-flex mt-3 flex-column flex-md-row justify-content-between align-items-md-center px-5 pt-3 gap-2">
                                        <!-- Form Search + Sorting -->
                                        <form action="{{ route('pengeluaran') }}" method="GET"
                                            class="d-flex flex-wrap flex-md-nowrap w-100 gap-2">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Cari pengeluaran..."
                                                value="{{ request('search') }}">

                                            <!-- Sort Field -->
                                            <select name="sort" class="form-select">
                                                <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Tanggal Input</option>
                                                <option value="uraian_material" {{ request('sort') == 'uraian_material' ? 'selected' : '' }}>Nama Pupuk</option>
                                                <option value="tanggal_keluar" {{ request('sort') == 'tanggal_keluar' ? 'selected' : '' }}>Tanggal Keluar</option>
                                                <option value="saldo_keluar" {{ request('sort') == 'saldo_keluar' ? 'selected' : '' }}>Saldo Keluar</option>
                                                <option value="sumber" {{ request('sort') == 'sumber' ? 'selected' : '' }}>BLOK</option>
                                            </select>

                                            <!-- Sort Order -->
                                            <select name="order" class="form-select">
                                                <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Terkecil → Terbesar</option>
                                                <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Terbesar → Terkecil</option>
                                            </select>

                                            <button type="submit"
                                                class="btn btn-primary d-flex align-items-center justify-content-center w-md-auto"
                                                style="height: 45px;">
                                                <i class="bi bi-sort-alpha-down mb-2 me-1"></i> Urutkan
                                            </button>

                                            @if(request('search') || request('sort') || request('order'))
                                            <a href="{{ route('pengeluaran') }}"
                                                class="btn btn-secondary d-flex align-items-center justify-content-center w-md-auto"
                                                style="height: 45px;">
                                                <i class="bi bi-x mb-2 me-1"></i> Reset
                                            </a>
                                            @endif
                                        </form>

                                        <!-- Tombol Tambah (Kanan di desktop, bawah di mobile) -->
                                        @auth
                                        @if(Str::contains(Auth::user()->level_user, 'afdeling') || Auth::user()->level_user === 'administrator')
                                        <button type="button"
                                            class="btn btn-success d-flex align-items-center justify-content-center mt-2 mt-md-0 w-md-auto"
                                            style=" height: 45px;"
                                            data-bs-toggle="modal" data-bs-target="#tambah">
                                            <i class="bi bi-plus mb-2 me-1"></i>Pengajuan
                                        </button>
                                        @endif
                                        @endauth
                                    </div>


                                    <!-- table hover -->
                                    <div class="table-responsive p-5">

                                        {{-- 🔹 Tabel dengan STATUS & AKSI --}}
                                        @auth
                                        @if(in_array(Auth::user()->level_user, ['administrasi', 'administrator', 'manager', 'ktu']))
                                        <table class="table table-hover mb-4 text-center">
                                            <thead>
                                                <tr>
                                                    <th>AU 58</th>
                                                    <th>NAMA PUPUK</th>
                                                    <th>TANGGAL KELUAR</th>
                                                    <th>SALDO KELUAR</th>
                                                    <th>AFDELING</th>
                                                    <th>BLOK</th>
                                                    @auth
                                                    @if(in_array(Auth::user()->level_user, ['administrasi', 'administrator']))
                                                    <th>AKSI</th>
                                                    @endif
                                                    @endauth
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($Pengeluarans as $item)
                                                <tr>
                                                    <td>{{ $item->au58 }}</td>
                                                    <td>{{ $item->material->uraian_material }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_keluar)->translatedFormat('d M Y') }}</td>
                                                    <td>{{ $item->saldo_keluar }} {{ $item->material->satuan }}</td>
                                                    <td>{{ $item->user->level_user ?? '-' }}</td>
                                                    <td>{{ implode(', ', (array) $item->sumber) }}</td>
                                                    @auth
                                                    @if(in_array(Auth::user()->level_user, ['administrasi', 'administrator']))
                                                    <td>
                                                        @if($item->status == 'menunggu')
                                                        <form action="{{ route('pengeluaran.updateStatus', $item->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="diterima">
                                                            <input type="hidden" name="penerima" value="{{ auth()->id() }}">
                                                            <button type="submit" class="btn btn-success btn-sm mb-1" style="min-width: 100px;">
                                                                <i class="bi bi-check-circle"></i> Terima
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('pengeluaran.updateStatus', $item->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="ditolak">
                                                            <input type="hidden" name="penerima" value="{{ auth()->id() }}">
                                                            <button type="submit" class="btn btn-danger btn-sm mb-1" style="min-width: 100px;">
                                                                <i class="bi bi-x-circle"></i> Tolak
                                                            </button>
                                                        </form>
                                                        @elseif($item->status == 'diterima')
                                                        <button class="btn btn-success btn-sm disabled" style="pointer-events: none;">
                                                            <i class="bi bi-check-circle"></i> Diterima
                                                        </button>
                                                        @elseif($item->status == 'ditolak')
                                                        <span class="btn btn-danger btn-sm disabled" style="pointer-events: none;">
                                                            <i class="bi bi-x-circle"></i> Ditolak
                                                        </span>
                                                        @endif
                                                    </td>
                                                    @endif
                                                    @endauth
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="6">Tidak ada data pengeluaran</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        <!-- 📄 Pagination -->
                                        <div class="mt-3">
                                            {{ $Pengeluarans->links('pagination::bootstrap-5') }}
                                        </div>
                                        @endif
                                        @endauth

                                        {{-- 🔹 Tabel tanpa STATUS AKSI --}}
                                        @auth
                                        @if(Str::contains(Auth::user()->level_user, 'afdeling'))
                                        <table class="table table-hover mb-4 text-center">
                                            <thead>
                                                <tr>
                                                    <th>AU 58</th>
                                                    <th>NAMA PUPUK</th>
                                                    <th>TANGGAL KELUAR</th>
                                                    <th>SALDO KELUAR</th>
                                                    <th>BLOK</th>
                                                    <th>STATUS</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($PengeluaransDiterima as $item)
                                                <tr>
                                                    <td>{{ $item->au58 }}</td>
                                                    <td>{{ $item->material->uraian_material }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_terima)->translatedFormat('d M Y') }}</td>
                                                    <td>{{ $item->saldo_keluar }} {{ $item->material->satuan }}</td>
                                                    <td>{{ implode(', ', (array) $item->sumber) }}</td>
                                                    <td>
                                                        @if($item->status == 'diterima')
                                                        <button class="btn btn-success btn-sm disabled" style="pointer-events: none; min-width:120px;">
                                                            <i class="bi bi-check-circle"></i> Diterima
                                                        </button>
                                                        @elseif($item->status == 'menunggu')
                                                        <span class="btn btn-warning btn-sm disabled" style="pointer-events: none; min-width:120px;">
                                                            <i class="bi bi-hourglass-split"></i> Menunggu
                                                        </span>
                                                        @elseif($item->status == 'ditolak')
                                                        <span class="btn btn-danger btn-sm disabled" style="pointer-events: none; min-width:120px;">
                                                            <i class="bi bi-x-circle"></i> Ditolak
                                                        </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="5">Tidak ada data pengeluaran</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        <!-- 📄 Pagination -->
                                        <div class="mt-3">
                                            {{ $PengeluaransDiterima->links('pagination::bootstrap-5') }}
                                        </div>
                                        @endif
                                        @endauth



                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
        </div>
    </div>

    <!-- Modal Tambah Pengeluaran -->
    <div class="modal fade text-left" id="tambah" tabindex="-1" role="dialog" aria-labelledby="tambahLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title text-white" id="tambahLabel">Pengajuan Pengeluaran</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <form action="{{ route('pengeluaran.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="material_id" class="form-label">Pilih Material</label>
                            <select class="form-select @error('material_id') is-invalid @enderror"
                                name="material_id" id="material_id" required>
                                <option value="">-- Pilih Material --</option>
                                @foreach($materials as $material)
                                <option value="{{ $material->id }}" {{ old('material_id') == $material->id ? 'selected' : '' }}>
                                    {{ $material->kode_material }} - {{ $material->uraian_material }}
                                    (Saldo: {{ $material->total_saldo }} {{ $material->satuan }})
                                </option>
                                @endforeach
                            </select>
                            @error('material_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_keluar" class="form-label">Tanggal Pengeluaran</label>
                            <input type="date" class="form-control @error('tanggal_keluar') is-invalid @enderror"
                                name="tanggal_keluar" id="tanggal_keluar" value="{{ old('tanggal_keluar') }}" required>
                            @error('tanggal_keluar')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="saldo_keluar" class="form-label">Jumlah Saldo Keluar /Kg</label>
                            <input type="number" min="1" class="form-control @error('saldo_keluar') is-invalid @enderror"
                                name="saldo_keluar" id="saldo_keluar" value="{{ old('saldo_keluar') }}" placeholder="Contoh: 50" required>
                            @error('saldo_keluar')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="au58" class="form-label">Au 58</label>
                            <input type="text" class="form-control @error('au58') is-invalid @enderror"
                                name="au58" id="au58" value="{{ old('au58') }}" placeholder="Contoh: INV/2025/09/001" required>
                            @error('au58')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label for="sumber" class="form-label">Kode Blok</label>
                            <div id="sumber-container">
                                <div class="input-group mb-2 sumber-input">
                                    <select name="sumber[]" class="form-select @error('sumber') is-invalid @enderror" required>
                                        <option value="">-- Pilih Kode Blok --</option>
                                        @foreach($blokUser as $blok)
                                        <option value="{{ $blok }}">{{ $blok }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-danger remove-sumber d-none">Hapus</button>
                                </div>
                            </div>
                            <button type="button" id="add-sumber" class="btn btn-primary btn-sm mt-2">
                                + Tambah Kode Blok
                            </button>
                            @error('sumber')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>



                        <!-- Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                <i class="bi bi-x"></i> Keluar
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Tambah Pengeluaran -->


</x-layout>

<!-- script modal tambah -->
@if ($errors->any())
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var myModal = new bootstrap.Modal(document.getElementById('tambah'));
        myModal.show();
    });
</script>
@endif

<!-- script tambah input blok -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('sumber-container');
        const addBtn = document.getElementById('add-sumber');

        addBtn.addEventListener('click', function() {
            const firstInputGroup = container.querySelector('.sumber-input');
            const clone = firstInputGroup.cloneNode(true);

            // Reset value
            clone.querySelector('select').value = '';
            clone.querySelector('.remove-sumber').classList.remove('d-none');

            container.appendChild(clone);
        });

        // Event delegation untuk remove
        container.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-sumber')) {
                e.target.closest('.sumber-input').remove();
            }
        });
    });
</script>