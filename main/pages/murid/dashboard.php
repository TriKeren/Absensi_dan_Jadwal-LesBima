<?php
session_start();
include(__DIR__ . '/../../connection/koneksi.php');

// Cek apakah sudah login 
if (!isset($_SESSION['id_murid'])) {
    header("Location: login.php");
    exit;
}

//  Ambil data murid yang login
$id_murid = $_SESSION['id_murid'];

$queryMurid = mysqli_query($koneksi, "
    SELECT *
    FROM murid
    WHERE id_murid = '$id_murid'
");

$dataMurid = mysqli_fetch_assoc($queryMurid);

// Ambil data paket yang diambil
$queryTotalPaket = mysqli_query($koneksi, "
    SELECT COUNT(*) AS total_paket
    FROM pendaftaran
    WHERE id_murid = '$id_murid'
    AND status_pendaftaran = 'Aktif'
");

$totalPaket = mysqli_fetch_assoc($queryTotalPaket);

// Ambil data presensi
$queryPresensi = mysqli_query($koneksi, "
    SELECT
        COUNT(*) AS total_absensi,
        SUM(
            CASE
                WHEN absensi.status = 'Hadir'
                THEN 1
                ELSE 0
            END
        ) AS total_hadir
    FROM absensi
    INNER JOIN pendaftaran
        ON absensi.id_daftar = pendaftaran.id_daftar
    WHERE pendaftaran.id_murid = '$id_murid'
");

$dataPresensi = mysqli_fetch_assoc($queryPresensi);

$totalAbsensi = $dataPresensi['total_absensi'] ?? 0;
$totalHadir   = $dataPresensi['total_hadir'] ?? 0;

if ($totalAbsensi > 0) {
    $persentase = ($totalHadir / $totalAbsensi) * 100;
} else {
    $persentase = 0;
}

// Ambil hari sekarang
date_default_timezone_set('Asia/Jakarta');

$hariInggris = date('l');

$hariIndonesia = [
    'Monday'    => 'Senin',
    'Tuesday'   => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday'  => 'Kamis',
    'Friday'    => 'Jumat',
    'Saturday'  => 'Sabtu',
    'Sunday'    => 'Minggu'
];

$hariIni = $hariIndonesia[$hariInggris];

// Ambil jadwal hari ini
$queryJadwal = mysqli_query($koneksi, "
    SELECT
        jadwal.*,
        guru.nama_guru,
        paket_kursus.nama_paket,
        mata_pelajaran.nama_mapel
    FROM jadwal
    INNER JOIN guru
        ON jadwal.id_guru = guru.id_guru
    INNER JOIN paket_kursus
        ON jadwal.id_paket = paket_kursus.id_paket
    INNER JOIN mata_pelajaran
        ON paket_kursus.id_mapel = mata_pelajaran.id_mapel
    WHERE jadwal.hari = '$hariIni'
    ORDER BY jadwal.jam_mulai ASC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Murid - Sistem Informasi Kursus</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/dashboard_murid.css">
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
            <li class="active">
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

            <div class="welcome-banner">
                <div class="banner-text">
                    <h1>Halo, <?= $dataMurid['nama_murid']; ?>!</h1>
                    <p>Selamat datang kembali di panel kursus. Jangan lupa untuk memeriksa jadwal kelas dan mengisi daftar absensi pertemuan hari ini, ya!</p>
                </div>
                <i class="fa-solid fa-rocket banner-icon"></i>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-data">
                        <h3><?= $totalPaket['total_paket']; ?> Kelas</h3>
                        <p>Total Paket Aktif</p>
                    </div>
                    <div class="stat-badge-icon bg-light-green">
                        <i class="fa-solid fa-book-bookmark"></i>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-data">
                        <h3><?= round($persentase, 1); ?>%</h3>
                        <p>Rata-rata Presensi</p>
                    </div>
                    <div class="stat-badge-icon bg-light-blue">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-data">
                        <h3>2 Tugas</h3>
                        <p>Belum Dikerjakan</p>
                    </div>
                    <div class="stat-badge-icon bg-light-orange">
                        <i class="fa-solid fa-clipboard-list"></i>
                    </div>
                </div>
            </div>

            <div class="dashboard-layout">

                <div class="layout-left-column">
                    <h3 class="widget-title"><i class="fa-solid fa-calendar-day"></i> Jadwal Kelas Hari Ini</h3>

                    <div class="today-class-container">
                        <?php
                        if (mysqli_num_rows($queryJadwal) > 0) {
                            while ($jadwal = mysqli_fetch_assoc($queryJadwal)) {
                        ?>
                                <div class="today-class-item">
                                    <div class="class-info-side">
                                        <div class="class-color-bar"></div>
                                        <div>
                                            <h4>
                                                <?= $jadwal['nama_mapel']; ?>
                                            </h4>
                                            <p>
                                                <i class="fa-solid fa-user-tie"></i>
                                                <?= $jadwal['nama_guru']; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="class-time-side">
                                        <span class="time-badge">
                                            <?= date('H:i', strtotime($jadwal['jam_mulai'])); ?>
                                            -
                                            <?= date('H:i', strtotime($jadwal['jam_selesai'])); ?>
                                        </span>
                                    </div>
                                </div>
                            <?php
                            }
                        } else {
                            ?>
                            <div class="today-class-item">
                                <div style="padding:15px;">
                                    <h4>Tidak ada jadwal kelas hari ini</h4>
                                    <p>Silakan cek kembali besok.</p>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="layout-right-column">
                    <h3 class="widget-title"><i class="fa-solid fa-bullhorn"></i> Pengumuman</h3>

                    <div class="announcement-box">
                        <div class="announcement-item">
                            <span>24 Mei 2026</span>
                            <h5>Libur Nasional: Kelas hari Kamis besok ditiadakan dan diganti minggu depan.</h5>
                        </div>
                        <div class="announcement-item">
                            <span>18 Mei 2026</span>
                            <h5>Pemberitahuan: Modul materi rumus geometri bab 3 sudah diunggah di menu Pertemuan.</h5>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </main>
</body>
</html>