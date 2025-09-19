<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- ✅ Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ✅ Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />


    <link rel="stylesheet" href="./../assets/compiled/css/login-regis.css">
    <title>Login | Sistem Informasi</title>

</head>

<body>

    <!-- ✅ Notifikasi -->
    @if (session('error'))
    <div class="mt-3 alert alert-danger alert-dismissible fade show notif-alert" role="alert" id="alertError">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session('success'))
    <div class="mt-3 alert alert-success alert-dismissible fade show notif-alert" role="alert" id="alertSuccess">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if ($errors->any())
    <div class="mt-3 alert alert-danger alert-dismissible fade show notif-alert" role="alert" id="alertValidation">
        <ul class="mb-0">
            @foreach ($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <!-- ✅ End Notifikasi -->


    <div class="container" id="container">
        <!-- Register -->
        <div class="form-container sign-up">

            <form action="{{ route('register.process') }}" method="POST">
                @csrf
                <h1 class="mb-1">Daftar Akun</h1>

                <input type="text" name="username" class="form-control p-3 mb-2" placeholder="Nama Lengkap" required />
                <input type="email" name="email" class="form-control p-3 mb-2" placeholder="Alamat Email" required />
                <input type="password" name="password" class="form-control p-3 mb-2" placeholder="Kata Sandi" required />
                <input type="password" name="password_confirmation" class="form-control p-3 mb-2" placeholder="Konfirmasi Kata Sandi" required />
                <select name="level_user" class="form-control p-3 mb-2" required>
                    <option value="" disabled selected>Pilih Afdeling</option>
                    <option value="afdeling 01">Afdeling 01</option>
                    <option value="afdeling 02">Afdeling 02</option>
                    <option value="afdeling 03">Afdeling 03</option>
                    <option value="afdeling 04">Afdeling 04</option>
                </select>

                <button class="btn btn-primary mt-2 py-2 px-5">Daftar</button>
            </form>
        </div>

        <!-- Login -->
        <div class="form-container sign-in">
            <form action="{{ route('login.process') }}" method="POST">
                @csrf
                <h1 class="mb-4">Masuk</h1>
                <input type="text" name="sap" class="form-control p-3" placeholder="Kode SAP" required />
                <input type="password" name="password" class="form-control p-3" placeholder="Kata Sandi" required />
                <button class="btn btn-primary mt-4 py-2 px-5">Login</button>
            </form>
        </div>


        <!-- Toggle Panel -->
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Selamat Datang Kembali</h1>
                    <p>Silakan masuk dengan akun Anda untuk melanjutkan</p>
                    <button class="btn btn-outline-light mt-2" id="login">Login</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hallo</h1>
                    <p>Selamat datang di SiMoPu, Sistem Monitoring Pupuk.</p>
                    <button class="btn btn-outline-light mt-2 d-none" id="register">Daftar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        const container = document.getElementById("container");
        const registerBtn = document.getElementById("register");
        const loginBtn = document.getElementById("login");

        registerBtn.addEventListener("click", () => container.classList.add("active"));
        loginBtn.addEventListener("click", () => container.classList.remove("active"));

        // 🎨 Efek background mengikuti cursor
        document.addEventListener("mousemove", (e) => {
            let x = (e.clientX / window.innerWidth) * 100;
            let y = (e.clientY / window.innerHeight) * 100;
            document.body.style.setProperty("--x", `${x}%`);
            document.body.style.setProperty("--y", `${y}%`);
        });
    </script>
    <script>
        // Tutup otomatis semua alert bootstrap setelah 3 detik
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach((alert) => {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 3000);
    </script>

    <!-- agar regis teteap terbuka -->
    @if(session('showRegister'))
    <script>
        document.getElementById("container").classList.add("active");
    </script>
    @endif


</body>

</html>