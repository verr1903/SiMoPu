<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <h3>Kelola Profile</h3>
        </div>
        <div class="page-content">
            <section class="row">
                <div class="col-12 col-lg-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-body px-4 py-4">
                                    <div class="row">
                                        <div class="col-12">
                                            {{-- Notifikasi Sukses --}}
                                            @if(session('success'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                {{ session('success') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                            @endif

                                            {{-- Notifikasi Error Validasi --}}
                                            @if($errors->any())
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <ul class="mb-0">
                                                    @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                            @endif

                                            <form action="{{ route('profile.update') }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="mb-3">
                                                    <label>Username</label>
                                                    <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label>SAP</label>
                                                    <input type="number" name="sap" class="form-control" value="{{ old('sap', $user->sap) }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label>Level User</label>
                                                    <select name="level_user" class="form-select" required>
                                                        <option value="administrator" {{ $user->level_user=='administrator'?'selected':'' }}>Administrator</option>
                                                        <option value="administrasi" {{ $user->level_user=='administrasi'?'selected':'' }}>Administrasi</option>
                                                        <option value="afdeling 01" {{ $user->level_user=='afdeling 01'?'selected':'' }}>Afdeling 01</option>
                                                        <option value="afdeling 02" {{ $user->level_user=='afdeling 02'?'selected':'' }}>Afdeling 02</option>
                                                        <option value="afdeling 03" {{ $user->level_user=='afdeling 03'?'selected':'' }}>Afdeling 03</option>
                                                        <option value="afdeling 04" {{ $user->level_user=='afdeling 04'?'selected':'' }}>Afdeling 04</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label>Unit</label>
                                                    <select name="kodeunit" class="form-select" required>
                                                        @foreach($units as $unit)
                                                        <option value="{{ $unit->kodeunit }}" {{ $user->kodeunit==$unit->kodeunit?'selected':'' }}>
                                                            {{ $unit->kodeunit }} - {{ $unit->namaunit }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label>Password <small>(Kosongkan jika tidak ingin diubah)</small></label>
                                                    <input type="password" name="password" class="form-control">
                                                </div>

                                                <div class="mb-3">
                                                    <label>Konfirmasi Password</label>
                                                    <input type="password" name="password_confirmation" class="form-control">
                                                </div>

                                                <button class="btn btn-primary">Update Profile</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </div>
</x-layout>