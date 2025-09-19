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
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-content">

                                    <!-- Form Search + Sorting -->
                                    <div class="d-flex mt-3 flex-column flex-md-row justify-content-between align-items-md-center px-5 pt-3 gap-2">
                                        <form action="{{ route('penerimaan') }}" method="GET"
                                            class="d-flex flex-wrap flex-md-nowrap w-100 gap-2">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Cari pengeluaran..."
                                                value="{{ request('search') }}">

                                            <select name="sort" class="form-select">
                                                <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Tanggal Input</option>
                                                <option value="kode_material" {{ request('sort') == 'kode_material' ? 'selected' : '' }}>Kode Material</option>
                                                <option value="tanggal_terima" {{ request('sort') == 'tanggal_terima' ? 'selected' : '' }}>Tanggal Terima</option>
                                                <option value="saldo_masuk" {{ request('sort') == 'saldo_masuk' ? 'selected' : '' }}>Saldo Masuk</option>
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
                                                    <th>NAMA PUPUK</th>
                                                    <th>TANGGAL TERIMA</th>
                                                    <th>SALDO MASUK</th>
                                                    <th>SUMBER</th>
                                                    <th>AKSI</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($penerimaan as $data)
                                                <tr>
                                                    <td>{{ $data->material->uraian_material }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($data->tanggal_terima)->translatedFormat('d M Y') }}</td>
                                                    <td>{{ $data->saldo_masuk }} {{ $data->material->satuan }}</td>
                                                    <td>{{ $data->sumber }}</td>
                                                    <!-- Tombol Edit & Hapus di table -->
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <!-- Edit -->
                                                            <button type="button"
                                                                style="border-radius: 50%;"
                                                                class="btn btn-warning btn-sm btn-edit me-1 text-white"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#editModal"
                                                                data-id="{{ $data->id }}"
                                                                data-material="{{ $data->material_id }}"
                                                                data-tanggal="{{ $data->tanggal_terima }}"
                                                                data-saldo="{{ $data->saldo_masuk }}"
                                                                data-sumber="{{ $data->sumber }}"
                                                                title="Edit">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>

                                                            <!-- Hapus -->
                                                            <form id="delete-form-{{ $data->id }}" action="{{ route('penerimaan.destroy', $data->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn btn-danger btn-sm rounded-circle"
                                                                    onclick="confirmDelete(this)" data-id="{{ $data->id }}">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>

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
                                name="sumber" id="sumber" value="{{ old('sumber') }}" placeholder="Contoh: CV A" required>
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

    <!-- modal edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editLabel">Edit Penerimaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">

                    <div class="mb-3">
                        <label for="edit_material_id" class="form-label">Pilih Material</label>
                        <select class="form-select" id="edit_material_id" name="material_id" required>
                            @foreach($materials as $material)
                                <option value="{{ $material->id }}">{{ $material->kode_material }} - {{ $material->uraian_material }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_tanggal" class="form-label">Tanggal Penerimaan</label>
                        <input type="date" class="form-control" id="edit_tanggal" name="tanggal_terima" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_saldo" class="form-label">Saldo Masuk /Kg</label>
                        <input type="number" min="1" class="form-control" id="edit_saldo" name="saldo_masuk" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_sumber" class="form-label">Sumber</label>
                        <input type="text" class="form-control" id="edit_sumber" name="sumber" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-white">Update</button>
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
    document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.btn-edit');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const material = this.getAttribute('data-material');
            const tanggal = this.getAttribute('data-tanggal');
            const saldo = this.getAttribute('data-saldo');
            const sumber = this.getAttribute('data-sumber');

            document.getElementById('edit_id').value = id;
            document.getElementById('edit_material_id').value = material;
            document.getElementById('edit_tanggal').value = tanggal;
            document.getElementById('edit_saldo').value = saldo;
            document.getElementById('edit_sumber').value = sumber;

            document.getElementById('editForm').action = "/penerimaan/" + id;
        });
    });
});

    function confirmDelete(button) {
        const id = button.dataset.id;
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
</script>