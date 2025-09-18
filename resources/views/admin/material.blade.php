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
                        <h3>Material</h3>
                    </div>

                </div>
            </div>
            <!-- Alert Notifikasi -->
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
                // Tunggu 5 detik (5000ms), lalu tutup alert
                setTimeout(function() {
                    const alertElement = document.getElementById('successAlert');
                    if (alertElement) {
                        const alert = new bootstrap.Alert(alertElement);
                        alert.close();
                    }
                }, 2500);
            </script>
            @endif

            <!-- Hoverable rows start -->
            <section class="section">
                <div class="row table-responsive" id="table-hover-row">
                    <div class="col-12">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-content">

                                    <!-- Form Search + Sorting -->
                                    <div class="d-flex mt-3 flex-column flex-md-row justify-content-between align-items-md-center px-5 pt-3 gap-2">
                                        <!-- Form Search + Sorting -->
                                        <form action="{{ route('materials') }}" method="GET"
                                            class="d-flex flex-wrap flex-md-nowrap w-100 gap-2">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Cari pengeluaran..."
                                                value="{{ request('search') }}">

                                            <!-- Kolom Sort -->
                                            <select name="sort" class="form-select">
                                                <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Tanggal Input</option>
                                                <option value="kode_material" {{ request('sort') == 'kode_material' ? 'selected' : '' }}>Kode Material</option>
                                                <option value="total_saldo" {{ request('sort') == 'total_saldo' ? 'selected' : '' }}>Total Saldo</option>
                                                <option value="uraian_material" {{ request('sort') == 'uraian_material' ? 'selected' : '' }}>Uraian Material</option>
                                            </select>

                                            <!-- Order (Terkecil/Terbesar) -->
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
                                            <a href="{{ route('materials') }}"
                                                class="btn btn-secondary d-flex align-items-center justify-content-center w-md-auto"
                                                style="height: 45px;">
                                                <i class="bi mb-2 bi-x"></i> Reset
                                            </a>
                                            @endif
                                        </form>

                                        <!-- Tombol Tambah (Kanan) -->
                                        @auth
                                        @if(in_array(Auth::user()->level_user, ['administrasi', 'administrator']))
                                        <button type="button"
                                            class="btn btn-success d-flex align-items-center justify-content-center mt-2 mt-md-0 w-md-auto"
                                            style=" height: 45px;" data-bs-toggle="modal"
                                            data-bs-target="#tambah">
                                            <i class="bi bi-plus mb-2 me-1"></i>Tambah
                                        </button>
                                        @endif
                                        @endauth
                                    </div>


                                    <!-- table hover -->
                                    <div class="table-responsive px-5 pt-4 pb-5">
                                        @auth
                                        @if(in_array(Auth::user()->level_user, ['administrator']))
                                        <table class="table table-hover mb-0 text-center">
                                            <thead>
                                                <tr>
                                                    <th>NO</th>
                                                    <th>NAMA UNIT</th>
                                                    <th>KODE MATERIAL</th>
                                                    <th>NAMA PUPUK</th>
                                                    <th>TOTAL SALDO</th>
                                                    <th>SATUAN</th>
                                                    <th>AKSI</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($materials as $index => $material)
                                                <tr>
                                                    <td>{{ $materials->firstItem() + $index }}</td>
                                                    <td>{{ $material->unit->namaunit ?? '-' }}</td>
                                                    <td>{{ $material->kode_material }}</td>
                                                    <td class="text-bold-500">{{ $material->uraian_material }}</td>
                                                    <td>{{ $material->total_saldo }}</td>
                                                    <td class="text-bold-500">{{ $material->satuan }}</td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <!-- Tombol Edit -->
                                                            <!-- Tombol Edit Material -->
                                                            <button
                                                                type="button"
                                                                title="Edit"
                                                                style="border-radius: 50%;"
                                                                class="btn btn-warning btn-sm btn-edit me-1 text-white"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editModal"
                                                                data-id="{{ $material->id }}"
                                                                data-plant="{{ $material->plant }}"
                                                                data-kode="{{ $material->kode_material }}"
                                                                data-uraian="{{ $material->uraian_material }}"
                                                                data-satuan="{{ $material->satuan }}"
                                                                data-total_saldo="{{ $material->total_saldo }}">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>


                                                            <!-- Tombol Hapus -->
                                                            <form id="delete-form-{{ $material->id }}" action="{{ route('material.destroy', $material->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn btn-sm btn-danger rounded-circle"
                                                                    title="Hapus"
                                                                    data-id="{{ $material->id }}"
                                                                    onclick="confirmDelete(this)">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>

                                                            </form>



                                                        </div>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="6">Tidak ada data material</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        <!-- Pagination -->
                                        <div class="mt-3">
                                            {{ $materials->links('pagination::bootstrap-5') }}
                                        </div>
                                        <!-- end pagination -->
                                        @endif
                                        @endauth

                                        @auth
                                        @if(in_array(Auth::user()->level_user, ['administrasi']))
                                        <table class="table table-hover mb-0 text-center">
                                            <thead>
                                                <tr>
                                                    <th>NO</th>
                                                    <th>NAMA UNIT</th>
                                                    <th>KODE MATERIAL</th>
                                                    <th>NAMA PUPUK</th>
                                                    <th>TOTAL SALDO</th>
                                                    <th>SATUAN</th>
                                                    <th>AKSI</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($unitAdministrasi as $index => $material)
                                                <tr>
                                                    <td>{{ $materials->firstItem() + $index }}</td>
                                                    <td>{{ $material->unit->namaunit ?? '-' }}</td>
                                                    <td>{{ $material->kode_material }}</td>
                                                    <td class="text-bold-500">{{ $material->uraian_material }}</td>
                                                    <td>{{ $material->total_saldo }}</td>
                                                    <td class="text-bold-500">{{ $material->satuan }}</td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <!-- Tombol Edit -->
                                                            <!-- Tombol Edit Material -->
                                                            <button
                                                                type="button"
                                                                title="Edit"
                                                                style="border-radius: 50%;"
                                                                class="btn btn-warning btn-sm btn-edit me-1 text-white"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editModal"
                                                                data-id="{{ $material->id }}"
                                                                data-plant="{{ $material->plant }}"
                                                                data-kode="{{ $material->kode_material }}"
                                                                data-uraian="{{ $material->uraian_material }}"
                                                                data-satuan="{{ $material->satuan }}"
                                                                data-total_saldo="{{ $material->total_saldo }}">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>


                                                            <!-- Tombol Hapus -->
                                                            <form id="delete-form-{{ $material->id }}" action="{{ route('material.destroy', $material->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn btn-sm btn-danger rounded-circle"
                                                                    title="Hapus"
                                                                    data-id="{{ $material->id }}"
                                                                    onclick="confirmDelete(this)">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>

                                                            </form>



                                                        </div>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="6">Tidak ada data material</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        <!-- Pagination -->
                                        <div class="mt-3">
                                            {{ $unitAdministrasi->links('pagination::bootstrap-5') }}
                                        </div>
                                        <!-- end pagination -->
                                        @endif
                                        @endauth

                                        @auth
                                        @if(Str::contains(Auth::user()->level_user, 'afdeling'))
                                        <table class="table table-hover mb-0 text-center">
                                            <thead>
                                                <tr>
                                                    <th>NO</th>
                                                    <th>NAMA UNIT</th>
                                                    <th>KODE MATERIAL</th>
                                                    <th>NAMA PUPUK</th>
                                                    <th>TOTAL SALDO</th>
                                                    <th>SATUAN</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($materials as $index => $material)
                                                <tr>
                                                    <td>{{ $materials->firstItem() + $index }}</td>
                                                    <td>{{ $material->unit->namaunit ?? '-' }}</td>
                                                    <td>{{ $material->kode_material }}</td>
                                                    <td class="text-bold-500">{{ $material->uraian_material }}</td>
                                                    <td>{{ $material->total_saldo }}</td>
                                                    <td class="text-bold-500">{{ $material->satuan }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="4">Tidak ada data material</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        <!-- Pagination -->
                                        <div class="mt-3">
                                            {{ $materials->links('pagination::bootstrap-5') }}
                                        </div>
                                        <!-- end pagination -->
                                        @endif
                                        @endauth



                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
            <!-- Hoverable rows end -->

        </div>
    </div>

    <!-- Modal Tambah Material -->
    <div class="modal fade text-left" id="tambah" tabindex="-1" role="dialog" aria-labelledby="tambahLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title text-white" id="tambahLabel">Tambah Material</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <form action="{{ route('material.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="plant" class="form-label">Nama Unit</label>
                            <select class="form-select @error('plant') is-invalid @enderror"
                                name="plant" id="plant" required>
                                <option value="">-- Pilih Unit --</option>
                                @foreach($units as $unit)
                                <option value="{{ $unit->kodeunit }}"
                                    {{ old('plant') == $unit->kodeunit ? 'selected' : '' }}>
                                    {{ $unit->namaunit }}
                                </option>
                                @endforeach
                            </select>
                            @error('plant')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label for="kode_material" class="form-label">Kode Material</label>
                            <input type="text" class="form-control @error('kode_material') is-invalid @enderror"
                                name="kode_material" id="kode_material" value="{{ old('kode_material') }}" placeholder="Contoh: 40005941" required>
                            @error('kode_material')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="uraian_material" class="form-label">Nama Pupuk</label>
                            <input type="text" class="form-control @error('uraian_material') is-invalid @enderror"
                                name="uraian_material" id="uraian_material" value="{{ old('uraian_material') }}" placeholder="Contoh: DOLOMITE" required>
                            @error('uraian_material')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="total_saldo" class="form-label">Saldo Awal /Kg</label>
                            <input type="number" class="form-control @error('total_saldo') is-invalid @enderror"
                                name="total_saldo" id="total_saldo" value="{{ old('total_saldo') }}" placeholder="Contoh: DOLOMITE" required>
                            @error('total_saldo')
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



    <!-- Modal Edit Material -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title text-white" id="editLabel">Edit Material</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="edit_id" name="id">

                        <div class="mb-3">
                            <label for="edit_plant" class="form-label">Nama Unit</label>
                            <select class="form-select" id="edit_plant" name="plant" required>
                                <option value="">-- Pilih Unit --</option>
                                @foreach($units as $unit)
                                <option value="{{ $unit->kodeunit }}">
                                    {{ $unit->namaunit }}
                                </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="edit_kode_material" class="form-label">Kode Material</label>
                            <input type="text" class="form-control" id="edit_kode_material" name="kode_material">
                        </div>

                        <div class="mb-3">
                            <label for="edit_uraian_material" class="form-label">Uraian Material</label>
                            <input type="text" class="form-control" id="edit_uraian_material" name="uraian_material">
                        </div>

                        <div class="mb-3">
                            <label for="edit_total_saldo" class="form-label">Total Saldo</label>
                            <input type="text" class="form-control" id="edit_total_saldo" name="total_saldo">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            <i class="bi bi-x"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-warning text-white">
                            <i class="bi bi-check"></i> Update
                        </button>
                    </div>
                </form>
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

<script>
    // script untuk sweetalert hapus
    function confirmDelete(button) {
        const id = button.getAttribute("data-id");
        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Data ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
    // end script swwet alert hapus

    // script untuk modal edit
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.btn-edit');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Ambil data dari atribut tombol
                const id = this.getAttribute('data-id');
                const kode = this.getAttribute('data-kode');
                const plant = this.getAttribute('data-plant');
                const uraian = this.getAttribute('data-uraian');
                const saldoAwal = this.getAttribute('data-total_saldo');

                // Isi form di modal
                document.getElementById('edit_id').value = id;
                document.getElementById('edit_kode_material').value = kode;
                document.getElementById('edit_plant').value = plant;
                document.getElementById('edit_uraian_material').value = uraian;
                document.getElementById('edit_total_saldo').value = saldoAwal;

                // Ganti action form sesuai id
                document.getElementById('editForm').action = "/material/" + id;
            });
        });
    });
    // end script untuk modal edit

    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.btn-edit');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const plant = this.getAttribute('data-plant');
                const kode = this.getAttribute('data-kode');
                const uraian = this.getAttribute('data-uraian');
                const saldoAwal = this.getAttribute('data-total_saldo');

                // Isi form modal
                document.getElementById('edit_id').value = id;
                document.getElementById('edit_kode_material').value = kode;
                document.getElementById('edit_uraian_material').value = uraian;
                document.getElementById('edit_total_saldo').value = saldoAwal;

                // Set selected value untuk dropdown plant
                document.getElementById('edit_plant').value = plant;

                // Ganti action form sesuai id
                document.getElementById('editForm').action = "/material/" + id;
            });
        });
    });
</script>