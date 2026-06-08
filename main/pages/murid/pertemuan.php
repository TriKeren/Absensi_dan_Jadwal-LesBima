<?php
session_start();
include(__DIR__ . '/../../connection/koneksi.php');

if (!isset($_SESSION['id_murid'])) {
    header("Location: login.php");
    exit;
}

$id_murid = $_SESSION['id_murid'];

$queryMurid = mysqli_query($koneksi, "
    SELECT *
    FROM murid
    WHERE id_murid='$id_murid'
");

$dataMurid = mysqli_fetch_assoc($queryMurid);

$queryPertemuan = mysqli_query($koneksi, "
    SELECT
        pertemuan.id_pertemuan,
        pertemuan.pertemuan_ke,
        pertemuan.tanggal,
        jadwal.jam_mulai,
        jadwal.jam_selesai,
        guru.nama_guru,
        mata_pelajaran.nama_mapel
    FROM pendaftaran
    INNER JOIN paket_kursus
        ON pendaftaran.id_paket = paket_kursus.id_paket
    INNER JOIN mata_pelajaran
        ON paket_kursus.id_mapel = mata_pelajaran.id_mapel
    INNER JOIN jadwal
        ON paket_kursus.id_paket = jadwal.id_paket
    INNER JOIN guru
        ON jadwal.id_guru = guru.id_guru
    INNER JOIN pertemuan
        ON jadwal.id_jadwal = pertemuan.id_jadwal
    WHERE pendaftaran.id_murid = '$id_murid'
    ORDER BY pertemuan.tanggal DESC
");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pertemuan - Sistem Informasi Kursus</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/pertemuan_murid.css">
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
            <li class="active">
                <a href="pertemuan.php"><i class="fa-solid fa-chalkboard-user"></i> Pertemuan</a>
            </li>
            <li>
                <a href="absensi.php"><i class="fa-solid fa-user-check"></i> Absensi Saya</a>
            </li>
            <li>
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
        <header class="top-nav">
            <button class="menu-toggle"><i class="fa-solid fa-bars"></i></button>
            <div class="welcome-text">
                Selamat datang,
                <strong><?= $dataMurid['nama_murid']; ?></strong>
            </div>
        </header>

        <div class="content-body">
            <div class="section-header">
                <div class="section-title">
                    <div class="badge-icon"><i class="fa-solid fa-video"></i></div>
                    <h1>Daftar Pertemuan</h1>
                </div>
                <p class="section-subtitle">Pantau riwayat dan jadwal pertemuan kelas Anda</p>
            </div>

            <div class="filter-container">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Cari kelas...">
                </div>
            </div>

            <div class="table-responsive-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Pertemuan</th>
                            <th>Mata Pelajaran</th>
                            <th>Tanggal & Waktu</th>
                            <th>Guru</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        while ($pertemuan = mysqli_fetch_assoc($queryPertemuan)) {
                            $tanggalPertemuan = strtotime($pertemuan['tanggal']);
                            $hariIni = strtotime(date('Y-m-d'));

                            if ($tanggalPertemuan < $hariIni) {
                                $status = "Selesai";
                                $classStatus = "status-done";
                                $aksi = "Detail";
                                $icon = "fa-eye";
                            } elseif ($tanggalPertemuan == $hariIni) {
                                $status = "Berjalan";
                                $classStatus = "status-ongoing";
                                $aksi = "Masuk";
                                $icon = "fa-right-to-bracket";
                            } else {
                                $status = "Mendatang";
                                $classStatus = "status-upcoming";
                                $aksi = "Ingatkan";
                                $icon = "fa-bell";
                            }
                        ?>
                            <tr>
                                <td data-label="Pertemuan">
                                    Ke-<?= $pertemuan['pertemuan_ke']; ?>
                                </td>
                                <td data-label="Mata Pelajaran"
                                    class="class-name">
                                    <?= $pertemuan['nama_mapel']; ?>
                                </td>
                                <td data-label="Tanggal & Waktu">
                                    <?= date('d M Y', strtotime($pertemuan['tanggal'])); ?>
                                    •
                                    <?= substr($pertemuan['jam_mulai'], 0, 5); ?>
                                </td>
                                <td data-label="Guru">
                                    <?= $pertemuan['nama_guru']; ?>
                                </td>
                                <td data-label="Status">
                                    <span class="status-badge <?= $classStatus; ?>">
                                        <?= $status; ?>
                                    </span>
                                </td>
                                <td data-label="Aksi">
                                    <a href="#"
                                        class="btn-action">
                                        <i class="fa-solid <?= $icon; ?>"></i>
                                        <?= $aksi; ?>
                                    </a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </main>

</body>

</html>