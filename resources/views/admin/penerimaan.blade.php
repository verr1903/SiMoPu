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
                        <h3>Penerimaan</h3>
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
                        <div class="card">
                            <div class="card-content">

                                <!-- 🔍 Search & Sort -->
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center px-5 pt-3 gap-2">
                                    <form action="{{ route('penerimaan') }}" method="GET"
                                        class="d-flex flex-wrap flex-md-nowrap w-100 gap-2">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Cari pengeluaran..."
                                            value="{{ request('search') }}">

                                        <select name="sort" class="form-select">
                                            <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Tanggal Input</option>
                                            <option value="kode_material" {{ request('sort') == 'kode_material' ? 'selected' : '' }}>Kode Material</option>
                                            <option value="tanggal_terima" {{ request('sort') == 'tanggal_terima' ? 'selected' : '' }}>Tanggal Terima</option>
                                            <option value="qty" {{ request('sort') == 'qty' ? 'selected' : '' }}>QTY</option>
                                            <option value="sumber" {{ request('sort') == 'sumber' ? 'selected' : '' }}>Sumber</option>
                                        </select>

                                        <select name="order" class="form-select">
                                            <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Terkecil → Terbesar</option>
                                            <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Terbesar → Terkecil</option>
                                        </select>

                                        <button type="submit"
                                            class="btn btn-primary d-flex align-items-center justify-content-center w-md-auto"
                                            style="height: 45px;">
                                            <i class="bi mb-2 bi-sort-alpha-down"></i> Urutkan
                                        </button>

                                        @if(request('search') || request('sort') || request('order'))
                                        <a href="{{ route('penerimaan') }}"
                                            class="btn btn-secondary d-flex align-items-center justify-content-center w-md-auto"
                                            style="height: 45px;">
                                            <i class="bi mb-2 bi-x"></i> Reset
                                        </a>
                                        @endif
                                    </form>
                                    <!-- Tombol Tambah (Kanan di desktop, bawah di mobile) -->
                                    @auth
                                    @if(in_array(Auth::user()->level_user, ['administrasi', 'administrator']))
                                    <button type="button"
                                        class="btn btn-success d-flex align-items-center justify-content-center mt-2 mt-md-0 w-md-auto"
                                        style=" height: 45px;"
                                        data-bs-toggle="modal" data-bs-target="#tambah">
                                        <i class="bi bi-plus mb-2 me-1"></i>Tambah
                                    </button>
                                    @endif
                                    @endauth
                                </div>

                                <!-- 📊 Table -->
                                <div class="table-responsive p-5">
                                    <table class="table table-hover mb-0 text-center">
                                        <thead>
                                            <tr>
                                                <th>KODE MATERIAL</th>
                                                <th>TANGGAL TERIMA</th>
                                                <th>SALDO MASUK</th>
                                                <th>SUMBER</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($penerimaan as $data)
                                            <tr>
                                                <td>{{ $data->material->kode_material }}</td>
                                                <td class="text-bold-500">{{ $data->tanggal_terima }}</td>
                                                <td>{{ $data->saldo_masuk }} {{ $data->material->satuan }}</td>
                                                <td>{{ $data->sumber }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4">Tidak ada data penerimaan</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>

                                    <!-- 📄 Pagination -->
                                    <div class="mt-3">
                                        {{ $penerimaan->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Modal Tambah Material -->
    <div class="modal fade text-left" id="tambah" tabindex="-1" role="dialog" aria-labelledby="tambahLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title text-white" id="tambahLabel">Tambah Penerimaan</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <form action="{{ route('penerimaan.store') }}" method="POST">
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
                            <label for="tanggal_terima" class="form-label">Tanggal Penerimaan</label>
                            <input type="date" class="form-control @error('tanggal_terima') is-invalid @enderror"
                                name="tanggal_terima" id="tanggal_terima" value="{{ old('tanggal_terima') }}" required>
                            @error('tanggal_terima')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="saldo_masuk" class="form-label">Jumlah Saldo Masuk /Kg</label>
                            <input type="number" min="1" class="form-control @error('saldo_masuk') is-invalid @enderror"
                                name="saldo_masuk" id="saldo_masuk" value="{{ old('saldo_masuk') }}" placeholder="Contoh: 100" required>
                            @error('saldo_masuk')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sumber" class="form-label">Sumber</label>
                            <input type="text" class="form-control @error('sumber') is-invalid @enderror"
                                name="sumber" id="sumber" value="{{ old('sumber') }}" placeholder="Contoh: Supplier A" required>
                            @error('sumber')
                            <div class="invalid-feedback">{{ $message }}</div>
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
    <!-- End Modal Tambah Material -->

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