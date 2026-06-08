<?php
session_start();
include(__DIR__ . '/../../connection/koneksi.php');

if (!isset($_SESSION['id_murid'])) {
    header("Location: ../../login.php");
    exit;
}

$id_murid = $_SESSION['id_murid'];

/* Simpan perubahan */
if (isset($_POST['simpan'])) {

    $nama_murid = mysqli_real_escape_string($koneksi, $_POST['nama_murid']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $no_telp = mysqli_real_escape_string($koneksi, $_POST['no_telp']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);

    mysqli_query($koneksi, "
        UPDATE murid
        SET
            nama_murid = '$nama_murid',
            alamat = '$alamat',
            no_telp = '$no_telp',
            username = '$username'
        WHERE id_murid = '$id_murid'
    ");

    echo "
    <script>
        alert('Profil berhasil diperbarui');
        window.location='profil.php';
    </script>";
}

/* Ambil data murid */
$queryMurid = mysqli_query($koneksi, "
    SELECT *
    FROM murid
    WHERE id_murid='$id_murid'
");

$dataMurid = mysqli_fetch_assoc($queryMurid);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Saya - Sistem Informasi Kursus</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/profil_murid.css">
</head>

<body>

    <aside class="sidebar">
        <div class="sidebar-brand">
            <i class="fa-solid fa-graduation-cap"></i>
            <div class="brand-text">
                <h2>Sistem Informasi</h2>
                <span>Kursus & Absensi</span>
            </div>
        </div>

        <div class="role-tag">MURID</div>

        <ul class="sidebar-menu">
            <li>
                <a href="dashboard.php"><i class="fa-solid fa-house"></i> Dashboard</a>
            </li>
            <li>
                <a href="jadwal.php"><i class="fa-solid fa-calendar-days"></i> Jadwal Saya</a>
            </li>
            <li>
                <a href="pertemuan.php"><i class="fa-solid fa-chalkboard-user"></i> Pertemuan</a>
            </li>
            <li>
                <a href="absensi.php"><i class="fa-solid fa-user-check"></i> Absensi Saya</a>
            </li>
            <li class="active">
                <a href="profil.php"><i class="fa-solid fa-user"></i> Profil</a>
            </li>
            <li style="margin-top: 20px;">
                <a href="#"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
            </li>
        </ul>

        <div class="sidebar-user">
            <div class="user-avatar">
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="user-info">
                <h4><?= $dataMurid['nama_murid']; ?></h4>
                <p>Murid</p>
                <div class="status-online">Online</div>
            </div>
        </div>
    </aside>

    <main class="main-content">
        <div class="profile-container">

            <div class="profile-header">
                <i class="fa-solid fa-user-graduate profile-icon"></i>

                <div>
                    <h2><?= $dataMurid['nama_murid']; ?></h2>
                    <p>Murid Aktif</p>
                </div>
            </div>

            <form method="POST">

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input
                        type="text"
                        name="nama_murid"
                        value="<?= $dataMurid['nama_murid']; ?>"
                        required>
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <input
                        type="text"
                        name="username"
                        value="<?= $dataMurid['username']; ?>"
                        required>
                </div>

                <div class="form-group">
                    <label>No Telepon</label>
                    <input
                        type="text"
                        name="no_telp"
                        value="<?= $dataMurid['no_telp']; ?>">
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea
                        name="alamat"
                        rows="4"><?= $dataMurid['alamat']; ?></textarea>
                </div>

                <button
                    type="submit"
                    name="simpan"
                    class="btn-simpan">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Simpan Perubahan
                </button>

            </form>

        </div>
    </main>

</body>

</html>