<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Les Bima</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/first.css">
</head>

<body>
    <div class="text-center w-100">
        <h1 class="fw-bold mb-2">Selamat Datang</h1>
        <h5 class="mb-4 fw-normal">Sistem Informasi Jadwal dan Absensi Les Bima</h5>

        <div class="card card-main mx-auto shadow-lg">
            <p class="mb-4">Silahkan klik tombol ini untuk login ke aplikasi</p>
            <button class="btn btn-navy fw-bold" data-bs-toggle="modal" data-bs-target="#loginModal">
                Login
            </button>
        </div>
    </div>

    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content shadow">
                <div class="modal-header justify-content-center">
                    <h5 class="modal-title fw-bold text-dark">Pilih Login</h5>
                </div>
                <div class="modal-body text-center p-3">
                    <a href="login_guru.php" class="btn btn-guru w-100 py-2">
                        Login Guru
                    </a>
                    <a href="login_murid.php" class="btn btn-murid w-100 py-2">
                        Login Murid
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>