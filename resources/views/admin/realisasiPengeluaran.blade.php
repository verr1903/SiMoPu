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
                            <h3>Realisasi Pengeluaran</h3>
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
                            <div class="card shadow">
                                <div class="card-content">

                                    <!-- Form Search + Sorting -->
                                    <div class="d-flex mt-3 flex-column flex-md-row justify-content-between align-items-md-center px-5 pt-3 gap-2">
                                        <form action="{{ route('realisasiPengeluaran') }}" method="GET"
                                            class="d-flex flex-wrap flex-md-nowrap w-100 gap-2">

                                            <input type="text" name="search" class="form-control"
                                                placeholder="Cari realisasi..."
                                                value="{{ request('search') }}">

                                            <!-- Sort Field -->
                                            <select name="sort" class="form-select">
                                                <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Tanggal Input</option>
                                                <option value="kode_material" {{ request('sort') == 'kode_material' ? 'selected' : '' }}>Kode Material</option>
                                                <option value="tanggal_keluar" {{ request('sort') == 'tanggal_keluar' ? 'selected' : '' }}>Tanggal Keluar</option>
                                                <option value="qty" {{ request('sort') == 'qty' ? 'selected' : '' }}>Saldo Keluar</option>
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
                                            <a href="{{ route('realisasiPengeluaran') }}"
                                                class="btn btn-secondary d-flex align-items-center justify-content-center w-md-auto"
                                                style="height: 45px;">
                                                <i class="bi bi-x mb-2 me-1"></i> Reset
                                            </a>
                                            @endif
                                        </form>

                                        <button type="button"
                                            class="btn btn-success d-flex align-items-center justify-content-center mt-2 mt-md-0 w-md-auto"
                                            style=" height: 45px;"
                                            data-bs-toggle="modal" data-bs-target="#tambah">
                                            <i class="bi bi-plus mb-2 me-1"></i>Tambah
                                        </button>

                                    </div>



                                    <!-- table hover -->
                                    <div class="table-responsive p-5">

                                        <table class="table table-hover mb-4 text-center">
                                            <thead>
                                                <tr>
                                                    <th>NAMA PUPUK</th>
                                                    <th>TANGGAL KELUAR</th>
                                                    <th>AFDELING</th>
                                                    <th>BLOK</th>
                                                    <th>SALDO KELUAR</th>
                                                    <th>DETAIL</th>
                                                    <th>SCAN KELUAR</th>
                                                    <th>SCAN SELESAI</th>
                                                    <th>PRINT</th>
                                                    <th>AKSI</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($realisasiPengeluarans as $realisasi)
                                                <tr>
                                                    <td>{{ $realisasi->pengeluaran->material->uraian_material }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($realisasi->created_at)->translatedFormat('d M Y') }}</td>
                                                    <td>{{ $realisasi->pengeluaran->user->level_user}}</td>
                                                    <td>{{ is_array($realisasi->pengeluaran->sumber) ? implode(', ', $realisasi->pengeluaran->sumber) : $realisasi->pengeluaran->sumber }}</td>

                                                    <td>{{ $realisasi->cicilan_pengeluaran }} Kg</td>

                                                    <!-- Detail -->
                                                    <td>
                                                        <button class="btn btn-sm btn-info btn-detail text-white"
                                                            data-au58="{{ $realisasi->pengeluaran->au58 }}"
                                                            data-level="{{ $realisasi->pengeluaran->user->level_user }}"
                                                            data-username="{{ $realisasi->pengeluaran->user->username }}"
                                                            data-sumber="{{ is_array($realisasi->pengeluaran->sumber) ? implode(', ', $realisasi->pengeluaran->sumber) : $realisasi->pengeluaran->sumber }}"
                                                            data-material="{{ $realisasi->pengeluaran->material->kode_material }}"
                                                            data-uraian="{{ $realisasi->pengeluaran->material->uraian_material }}"
                                                            data-total_saldo_keluar="{{ $realisasi->pengeluaran->saldo_keluar }}"
                                                            data-saldo_keluar="{{ $realisasi->cicilan_pengeluaran }}"
                                                            data-tanggal_permintaan="{{ \Carbon\Carbon::parse($realisasi->pengeluaran->tanggal_keluar)->translatedFormat('d F Y') }}"
                                                            data-tanggal_keluar="{{ \Carbon\Carbon::parse($realisasi->created_at)->translatedFormat('d F Y') }}"
                                                            data-bs-toggle="modal" data-bs-target="#detailModal">
                                                            <i class="bi bi-eye"></i> Detail
                                                        </button>
                                                    </td>

                                                    <!-- Scan keluar -->
                                                    <td>
                                                        {{ $realisasi->scan_keluar 
                                                            ? \Carbon\Carbon::parse($realisasi->scan_keluar)->timezone('Asia/Jakarta')->translatedFormat('H:i:s, d M Y ') : '-' 
                                                        }}
                                                    </td>

                                                    <!-- Scan selesai -->
                                                    <td>
                                                        {{ $realisasi->scan_akhir 
                                                            ? \Carbon\Carbon::parse($realisasi->scan_akhir)->timezone('Asia/Jakarta')->translatedFormat('H:i:s, d M Y ') : '-' 
                                                            }}
                                                    </td>
                                                    <!-- Print -->
                                                    <td>
                                                        <a href="{{ route('realisasi.print', $realisasi->id) }}" target="_blank" class="btn btn-sm btn-secondary">
                                                            <i class="bi bi-printer"></i> Print
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <!-- Tombol Edit -->
                                                            <button
                                                                type="button"
                                                                title="Edit"
                                                                style="border-radius: 50%;"
                                                                class="btn btn-warning btn-sm btn-edit me-1 text-white"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editRealisasiModal"
                                                                data-id="{{ $realisasi->id }}"
                                                                data-cicilan="{{ $realisasi->cicilan_pengeluaran }}">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>

                                                            <!-- Tombol Hapus -->
                                                            <form id="delete-form-{{ $realisasi->id }}" action="{{ route('realisasiPengeluaran.destroy', $realisasi->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn btn-sm btn-danger rounded-circle" title="Hapus" data-id="{{ $realisasi->id }}" onclick="confirmDelete(this)">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </form>

                                                        </div>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="10">Tidak ada data pengeluaran</td>
                                                </tr>
                                                @endforelse
                                            </tbody>

                                        </table>
                                        <!-- 📄 Pagination -->
                                        <div class="mt-3">
                                            {{ $realisasiPengeluarans->links('pagination::bootstrap-5') }}
                                        </div>




                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- Modal Tambah Realisasi Pengeluaran -->
        <div class="modal fade text-left" id="tambah" tabindex="-1" role="dialog" aria-labelledby="tambahLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                <div class="modal-content">
                    <!-- Header -->
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title text-white" id="tambahLabel">Tambah Realisasi Pengeluaran</h5>
                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body">
                        <form action="{{ route('realisasiPengeluaran.store') }}" method="POST">
                            @csrf

                            <!-- Pilih Pengeluaran yg sudah diterima -->
                            <div class="mb-3">
                                <label for="pengeluaran_id" class="form-label">Pilih Pengeluaran Yang Tersedia</label>
                                <select class="form-select @error('pengeluaran_id') is-invalid @enderror"
                                    name="pengeluaran_id" id="pengeluaran_id" required>
                                    <option value="">-- Pilih Pengeluaran --</option>
                                    @foreach($pengeluarans as $pengeluaran)
                                    <option value="{{ $pengeluaran->id }}"
                                        data-saldo-sisa="{{ $pengeluaran->saldo_sisa }}"
                                        {{ old('pengeluaran_id') == $pengeluaran->id ? 'selected' : '' }}>
                                        {{ $pengeluaran->material->kode_material }} -
                                        Tgl: {{ \Carbon\Carbon::parse($pengeluaran->tanggal_keluar)->translatedFormat('d M Y') }} |
                                        Total Saldo Keluar: {{ $pengeluaran->saldo_keluar }} Kg |
                                        Sisa Saldo Keluar: {{ $pengeluaran->saldo_sisa }} Kg |
                                        Dari: {{ $pengeluaran->user->level_user }} |
                                        Untuk Blok: {{ is_array($pengeluaran->sumber) ? implode(', ', $pengeluaran->sumber) : $pengeluaran->sumber }}
                                    </option>

                                    @endforeach
                                </select>
                                @error('pengeluaran_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Input Cicilan Pengeluaran -->
                            <div class="mb-3">
                                <label for="cicilan_pengeluaran" class="form-label">Cicilan Pengeluaran Per Kg</label>
                                <input type="number" min="1"
                                    class="form-control @error('cicilan_pengeluaran') is-invalid @enderror"
                                    name="cicilan_pengeluaran" id="cicilan_pengeluaran"
                                    value="{{ old('cicilan_pengeluaran') }}"
                                    placeholder="Contoh: 500000" required>
                                @error('cicilan_pengeluaran')
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
        <!-- End Modal -->

        <!-- Modal Detail -->
        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title" id="detailModalLabel">Detail Pengeluaran</h5>
                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Au 58:</strong> <span id="detailau58"></span></li>
                            <li class="list-group-item"><strong>Nama Pupuk:</strong> <span id="detailUraian"></span></li>
                            <li class="list-group-item"><strong>Kode Material:</strong> <span id="detailMaterial"></span></li>
                            <li class="list-group-item"><strong>Nama Pengaju:</strong> <span id="detailUsername"></span></li>
                            <li class="list-group-item"><strong>Afdeling:</strong> <span id="detailLevel"></span></li>
                            <li class="list-group-item"><strong>Blok:</strong> <span id="detailSumber"></span></li>
                            <li class="list-group-item"><strong>Total Saldo Keluar:</strong> <span id="detailTotalSaldoKeluar"></span> Kg</li>
                            <li class="list-group-item"><strong>Saldo Keluar:</strong> <span id="detailSaldoKeluar"></span> Kg</li>
                            <li class="list-group-item"><strong>Tanggal Permintaan Keluar:</strong> <span id="detailTanggalPermintaan"></span></li>
                            <li class="list-group-item"><strong>Tanggal Keluar:</strong> <span id="detailTanggalKeluar"></span></li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x"></i> Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal Detail -->

        <!-- Modal Edit Realisasi -->
        <div class="modal fade text-left" id="editRealisasiModal" tabindex="-1" role="dialog" aria-labelledby="editRealisasiLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title" id="editRealisasiLabel">Edit Realisasi Pengeluaran</h5>
                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="editRealisasiForm" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="edit_id" name="id">

                            <div class="mb-3">
                                <label for="edit_cicilan_pengeluaran" class="form-label">Cicilan Pengeluaran</label>
                                <input type="number" min="1" class="form-control" name="cicilan_pengeluaran" id="edit_cicilan_pengeluaran" required>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                    <i class="bi bi-x"></i> Keluar
                                </button>
                                <button type="button" class="btn btn-primary mt-2" onclick="confirmEdit()">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



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

    <!-- script menampilkan detail pada modal detail -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const detailButtons = document.querySelectorAll(".btn-detail");

            detailButtons.forEach(button => {
                button.addEventListener("click", function() {
                    document.getElementById("detailau58").textContent = this.dataset.au58;
                    document.getElementById("detailLevel").textContent = this.dataset.level;
                    document.getElementById("detailUsername").textContent = this.dataset.username;
                    document.getElementById("detailSumber").textContent = this.dataset.sumber;
                    document.getElementById("detailMaterial").textContent = this.dataset.material;
                    document.getElementById("detailUraian").textContent = this.dataset.uraian;
                    document.getElementById("detailTotalSaldoKeluar").textContent = this.dataset.total_saldo_keluar;
                    document.getElementById("detailSaldoKeluar").textContent = this.dataset.saldo_keluar;
                    document.getElementById("detailTanggalPermintaan").textContent = this.dataset.tanggal_permintaan;
                    document.getElementById("detailTanggalKeluar").textContent = this.dataset.tanggal_keluar;
                });
            });
        });
    </script>

    <!-- script agar men disabled button submit ketika cicilan melebihi total sisa saldo -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const pengeluaranSelect = document.getElementById('pengeluaran_id');
            const cicilanInput = document.getElementById('cicilan_pengeluaran');
            const submitButton = document.querySelector('#tambah button[type="submit"]');

            function checkSaldo() {
                const selectedOption = pengeluaranSelect.selectedOptions[0];
                const saldoSisa = selectedOption ? parseInt(selectedOption.dataset.saldoSisa) : 0;
                const cicilan = parseInt(cicilanInput.value) || 0;

                if (cicilan > saldoSisa || cicilan <= 0) {
                    submitButton.disabled = true;
                } else {
                    submitButton.disabled = false;
                }
            }

            pengeluaranSelect.addEventListener('change', checkSaldo);
            cicilanInput.addEventListener('input', checkSaldo);

            // Inisialisasi saat modal dibuka
            const tambahModal = document.getElementById('tambah');
            tambahModal.addEventListener('shown.bs.modal', checkSaldo);
        });
    </script>

    <!-- script modal edit -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const editButtons = document.querySelectorAll(".btn-edit");
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Ambil data dari atribut tombol
                    const id = this.getAttribute('data-id');
                    const cicilan = this.getAttribute('data-cicilan');

                    // Isi form di modal
                    document.getElementById('edit_id').value = id;
                    document.getElementById('edit_cicilan_pengeluaran').value = cicilan;

                    document.getElementById('editRealisasiForm').action = "/realisasi-pengeluaran/" + id;
                });
            });
        });

        function confirmEdit() {
            Swal.fire({
                title: 'Simpan perubahan?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('editRealisasiForm').submit();
                }
            });
        }
    </script>


    <!-- konfirmasi hapus -->
    <script>
        function confirmDelete(button) {
            Swal.fire({
                title: 'Apakah yakin ingin menghapus?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }
    </script>