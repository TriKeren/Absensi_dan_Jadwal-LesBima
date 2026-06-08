<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pendaftaran</title>
    <link rel="stylesheet" href="pendaftaran_admin.css">
</head>
<body>

<div class="container">

    <div class="sidebar">
        <h2>PENDAFTARAN</h2>

        <ul>
            <li class="active">Profil Sistem</li>
            <li>Alur Admin</li>
            <li>Master Data</li>
            <li>Pengaturan Lainnya</li>
        </ul>
    </div>

    <div class="content">

        <div class="card">
            <h3>Pengaturan</h3>

            <form>

                <label>Nama Sistem</label>
                <input type="text" value="Sistem Informasi Kursus & Absensi">

                <label>Deskripsi</label>
                <textarea rows="4">Sistem untuk mengelola kursus, jadwal, dan absensi murid</textarea>

                <label>Logo Sistem</label>
                <input type="file">

                <div class="button-group">
                    <button type="reset" class="btn-secondary">
                        Batal
                    </button>

                    <button type="submit" class="btn-primary">
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>

    </div>

</div>

</body>
</html>