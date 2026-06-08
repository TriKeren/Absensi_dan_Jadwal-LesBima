<?php
session_start();
include(__DIR__ . '/../../connection/koneksi.php');

if (!isset($_SESSION['id_murid'])) {
    header("Location: ../../login.php");
    exit;
}

$id_murid = $_SESSION['id_murid'];

$queryMurid = mysqli_query($koneksi, "
    SELECT *
    FROM murid
    WHERE id_murid='$id_murid'
");

$dataMurid = mysqli_fetch_assoc($queryMurid);

$queryStatistik = mysqli_query($koneksi, "
    SELECT
        COUNT(absensi.id_absensi) AS total_kelas,
        SUM(
            CASE
                WHEN absensi.status='Hadir'
                THEN 1 ELSE 0
            END
        ) AS hadir,
        SUM(
            CASE
                WHEN absensi.status='Izin'
                OR absensi.status='Sakit'
                THEN 1 ELSE 0
            END
        ) AS izin_sakit,
        SUM(
            CASE
                WHEN absensi.status='Alfa'
                THEN 1 ELSE 0
            END
        ) AS alfa
    FROM absensi
    INNER JOIN pendaftaran
        ON absensi.id_daftar = pendaftaran.id_daftar
    WHERE pendaftaran.id_murid='$id_murid'
");

$statistik = mysqli_fetch_assoc($queryStatistik);

$totalKelas = $statistik['total_kelas'] ?? 0;
$totalHadir = $statistik['hadir'] ?? 0;
$totalIzinSakit = $statistik['izin_sakit'] ?? 0;
$totalAlfa = $statistik['alfa'] ?? 0;

if ($totalKelas > 0) {
    $persentase = round(($totalHadir / $totalKelas) * 100, 1);
} else {
    $persentase = 0;
}

$queryAbsensi = mysqli_query($koneksi, "
    SELECT
        absensi.*,
        pertemuan.tanggal,
        mata_pelajaran.nama_mapel
    FROM absensi
    INNER JOIN pendaftaran
        ON absensi.id_daftar = pendaftaran.id_daftar
    INNER JOIN paket_kursus
        ON pendaftaran.id_paket = paket_kursus.id_paket
    INNER JOIN mata_pelajaran
        ON paket_kursus.id_mapel = mata_pelajaran.id_mapel
    INNER JOIN pertemuan
        ON absensi.id_pertemuan = pertemuan.id_pertemuan
    WHERE pendaftaran.id_murid='$id_murid'
    ORDER BY pertemuan.tanggal DESC
");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Saya - Sistem Informasi Kursus</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/absensi_murid.css">
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
            <li class="active">
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
            <div class="welcome-text">Selamat datang,
                <strong><?= $dataMurid['nama_murid']; ?></strong>
            </div>
        </header>

        <div class="content-body">
            <div class="section-header">
                <div class="section-title">
                    <div class="badge-icon"><i class="fa-solid fa-user-check"></i></div>
                    <h1>Absensi Saya</h1>
                </div>
                <p class="section-subtitle">Rekapitulasi presensi kehadiran kelas kursus Anda</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon icon-total">
                        <i class="fa-solid fa-calculator"></i>
                    </div>
                    <div class="stat-info">
                        <p>Total Kelas</p>
                        <h2><?= $totalKelas; ?> Kali</h2>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon icon-present">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div class="stat-info">
                        <p>Hadir</p>
                        <h2><?= $totalHadir; ?> Kali</h2>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon icon-permit">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div class="stat-info">
                        <p>Izin / Sakit</p>
                        <h2><?= $totalIzinSakit; ?> Kali</h2>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon icon-absent">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </div>
                    <div class="stat-info">
                        <p>Tanpa Alasan</p>
                        <h2><?= $totalAlfa; ?> Kali</h2>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <div class="table-header">
                    <h3>Log Kehadiran Bulan Ini</h3>
                    <span class="text-muted">Persentase Kehadiran: <strong><?= $persentase; ?>%</strong></span>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Mata Pelajaran</th>
                            <th>Waktu Absen</th>
                            <th>Keterangan Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if (mysqli_num_rows($queryAbsensi) > 0) {

                            while ($absensi = mysqli_fetch_assoc($queryAbsensi)) {
                        ?>

                                <tr>
                                    <td data-label="Tanggal">
                                        <?= date('d-m-Y', strtotime($absensi['tanggal'])); ?>
                                    </td>
                                    <td data-label="Mata Pelajaran" style="font-weight:600;">
                                        <?= $absensi['nama_mapel']; ?>
                                    </td>
                                    <td data-label="Waktu Absen">
                                        -
                                    </td>
                                    <td data-label="Keterangan Status">
                                        <?php
                                        if ($absensi['status'] == 'Hadir') {
                                        ?>
                                            <span class="absensi-badge badge-hadir">
                                                <i class="fa-solid fa-check"></i>
                                                Hadir
                                            </span>

                                        <?php
                                        } elseif (
                                            $absensi['status'] == 'Izin' ||
                                            $absensi['status'] == 'Sakit'
                                        ) {
                                        ?>
                                            <span class="absensi-badge badge-izin">
                                                <i class="fa-solid fa-envelope"></i>
                                                <?= $absensi['status']; ?>
                                            </span>

                                        <?php
                                        } else {
                                        ?>
                                            <span class="absensi-badge badge-alfa">
                                                <i class="fa-solid fa-xmark"></i>
                                                Alfa
                                            </span>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="4" style="text-align:center;">
                                    Belum ada data absensi
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </main>

</body>

</html>