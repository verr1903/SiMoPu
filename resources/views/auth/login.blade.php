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
    <div class="container" id="container">
        <!-- Register -->
        <div class="form-container sign-up">
            <form>
                <h1 class="mb-4">Daftar Akun</h1>
                <input type="text" class="form-control p-3" placeholder="Nama Lengkap" />
                <input type="email" class="form-control p-3" placeholder="Alamat Email" />
                <input type="password" class="form-control p-3" placeholder="Kata Sandi" />
                <button class="btn btn-primary mt-3 py-2 px-5">Daftar</button>
            </form>
        </div>

        <!-- Login -->
        <div class="form-container sign-in">
            <form action="{{ route('login.process') }}" method="POST">
                @csrf
                <h1 class="mb-4">Masuk</h1>

                <!-- Alert Notifikasi -->
                @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorAlert" style="font-size: 0.85rem;">
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

                <input type="email" name="email" class="form-control p-3" placeholder="Alamat Email" required />
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
                    <p>Buat akun Anda sekarang untuk menggunakan semua fitur</p>
                    <button class="btn btn-outline-light mt-2" id="register">Daftar</button>
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

    

</body>

</html>