<?php
include(__DIR__ . '/../../connection/koneksi.php');

$queryGuruPaket = mysqli_query($koneksi, "
    SELECT
        guru.id_guru,
        guru.nama_guru,

        COUNT(jadwal.id_paket) as jumlah_paket,

        GROUP_CONCAT(
            DISTINCT CONCAT(
                mata_pelajaran.nama_mapel,
                ' (',
                paket_kursus.nama_paket,
                ')'
            )
            SEPARATOR '<br>'
        ) as paket_diajar

    FROM guru
    LEFT JOIN jadwal
        ON guru.id_guru = jadwal.id_guru
    LEFT JOIN paket_kursus
        ON jadwal.id_paket = paket_kursus.id_paket
    LEFT JOIN mata_pelajaran
        ON paket_kursus.id_mapel = mata_pelajaran.id_mapel
    GROUP BY guru.id_guru
    ORDER BY guru.nama_guru
");

$totalGuru = mysqli_fetch_assoc(
    mysqli_query($koneksi,"
        SELECT COUNT(*) as total
        FROM guru
    ")
);

$totalPaket = mysqli_fetch_assoc(
    mysqli_query($koneksi,"
        SELECT COUNT(*) as total
        FROM paket_kursus
    ")
);

$totalJadwal = mysqli_fetch_assoc(
    mysqli_query($koneksi,"
        SELECT COUNT(*) as total
        FROM jadwal
    ")
);

$guruAktif = mysqli_fetch_assoc(
    mysqli_query($koneksi,"
        SELECT COUNT(DISTINCT id_guru) as total
        FROM jadwal
    ")
);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Guru</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/laporan_guru.css">
</head>

<body>
    <div class="canvas-container">
        <div class="sidebar">
            <div class="sidebar-header">
                <span class="material-symbols-outlined">school</span>
                <div class="header-text">
                    <h3>SISTEM INFORMASI</h3>
                    <p>KURSUS &amp; ABSENSI</p>
                </div>
            </div>

            <span class="menu-title">MAIN MENU</span>
            <ul class="menu">
                <li><a href="dashboard.php"><span class="material-symbols-outlined">home</span> Dashboard</a></li>
                <li class="active"><a href="laporan_guru.php"><span class="material-symbols-outlined">calendar_month</span> Laporan Guru</a></li>
                <li><a href="laporan_murid.php"><span class="material-symbols-outlined">description</span> Laporan Murid</a></li>
                <li><a href="#"><span class="material-symbols-outlined">description</span> Pertemuan</a></li>
                <li><a href="#"><span class="material-symbols-outlined">fact_check</span> Absensi</a></li>
                <li><a href="kontrolguru.php"><span class="material-symbols-outlined">person_pin</span> Guru</a></li>
                <li><a href="kontrolmurid.php"><span class="material-symbols-outlined">groups</span> Murid</a></li>
            </ul>

            <span class="menu-title" style="margin-top: auto; padding-top: 20px;">AKUN</span>
            <ul class="menu">
                <li><a href="#"><span class="material-symbols-outlined">manage_accounts</span> Profil</a></li>
                <li class="logout"><a href="#"><span class="material-symbols-outlined">logout</span> Logout</a></li>
            </ul>
        </div>

        <div class="dashboard-content">



            <div class="dashboard-grid">

                <!-- Kehadiran -->
                <div class="header-section">

                    <div class="title-area">
                        <h1>Laporan Guru</h1>

                        <div class="breadcrumb">
                            Beranda /
                            <span>Laporan Guru</span>
                        </div>
                    </div>

                    <div class="action-area">
                        <div class="search-container">
                            <i class="fa-solid fa-search search-icon"></i>

                            <input
                                type="text"
                                id="searchInput"
                                class="search-input"
                                placeholder="Cari guru...">
                        </div>

                    </div>

                </div>

                <div class="stats-grid">

    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="fa-solid fa-user-tie"></i>
        </div>

        <div class="stat-info">
            <h2><?= $totalGuru['total']; ?></h2>
            <p>Total Guru</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon green">
            <i class="fa-solid fa-book-open"></i>
        </div>

        <div class="stat-info">
            <h2><?= $totalPaket['total']; ?></h2>
            <p>Total Paket</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon orange">
            <i class="fa-solid fa-calendar-days"></i>
        </div>

        <div class="stat-info">
            <h2><?= $totalJadwal['total']; ?></h2>
            <p>Jadwal Aktif</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon purple">
            <i class="fa-solid fa-chalkboard-user"></i>
        </div>

        <div class="stat-info">
            <h2><?= $guruAktif['total']; ?></h2>
            <p>Guru Mengajar</p>
        </div>
    </div>

</div>

                <div class="table-container">

                    <table id="guruTable">

                        <thead>

                            <tr>
                                <th width="60">No</th>
                                <th width="250">Nama Guru</th>
                                <th width="120">Jumlah Paket</th>
                                <th>Paket Yang Diajar</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php
                            $no = 1;

                            while ($row = mysqli_fetch_assoc($queryGuruPaket)) {
                            ?>

                                <tr>

                                    <td><?= $no++; ?></td>

                                    <td>

                                        <i
                                            class="fa-solid fa-user-tie"
                                            style="color:#2563eb;">
                                        </i>

                                        <?= $row['nama_guru']; ?>

                                    </td>

                                    <td>

                                        <span class="badge-jumlah">

                                            <?= $row['jumlah_paket']; ?>

                                            Paket

                                        </span>

                                    </td>

                                    <td>

                                        <?= $row['paket_diajar']; ?>

                                    </td>

                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("searchInput")
            .addEventListener("keyup", function() {

                let filter =
                    this.value.toLowerCase();

                let rows =
                    document.querySelectorAll(
                        "#guruTable tbody tr"
                    );

                rows.forEach(row => {

                    let text =
                        row.innerText.toLowerCase();

                    row.style.display =
                        text.includes(filter) ?
                        "" :
                        "none";

                });

            });
    </script>
</body>

</html>