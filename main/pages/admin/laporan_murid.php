<?php
include(__DIR__ . '/../../connection/koneksi.php');

// 1. QUERY UTAMA: Menggabungkan tabel murid, pendaftaran (penghubung), dan paket_kursus
$queryMuridPaket = mysqli_query($koneksi, "
    SELECT
        murid.id_murid,
        murid.nama_murid,
        COUNT(pendaftaran.id_paket) as jumlah_paket,
        GROUP_CONCAT(
            DISTINCT paket_kursus.nama_paket
            SEPARATOR '<br>'
        ) as paket_diambil
    FROM murid
    LEFT JOIN pendaftaran
        ON murid.id_murid = pendaftaran.id_murid
    LEFT JOIN paket_kursus
        ON pendaftaran.id_paket = paket_kursus.id_paket
    GROUP BY murid.id_murid
    ORDER BY murid.nama_murid
");

// 2. QUERY STATISTIK (Menghitung Total Murid & Murid Aktif Kursus)
$totalMurid = mysqli_fetch_assoc(
    mysqli_query($koneksi,"
        SELECT COUNT(*) as total
        FROM murid
    ")
);

$muridAktif = mysqli_fetch_assoc(
    mysqli_query($koneksi,"
        SELECT COUNT(DISTINCT id_murid) as total
        FROM pendaftaran
    ")
);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Murid</title>
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
                <li><a href="laporan_guru.php"><span class="material-symbols-outlined">calendar_month</span> Laporan Guru</a></li>
                <li class="active"><a href="laporan_murid.php"><span class="material-symbols-outlined">description</span> Laporan Murid</a></li>
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

                <div class="header-section">
                    <div class="title-area">
                        <h1>Laporan Murid</h1>
                        <div class="breadcrumb">
                            Beranda / <span>Laporan Murid</span>
                        </div>
                    </div>

                    <div class="action-area">
                        <div class="search-container">
                            <i class="fa-solid fa-search search-icon"></i>
                            <input type="text" id="searchInput" class="search-input" placeholder="Cari murid...">
                        </div>
                    </div>
                </div>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <h2><?= $totalMurid['total']; ?></h2>
                            <p>Total Murid Terdaftar</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon green">
                            <i class="fa-solid fa-user-check"></i>
                        </div>
                        <div class="stat-info">
                            <h2><?= $muridAktif['total']; ?></h2>
                            <p>Murid Aktif Kursus</p>
                        </div>
                    </div>
                </div>

                <div class="table-container">
                    <table id="muridTable">
                        <thead>
                            <tr>
                                <th width="60">No</th>
                                <th width="250">Nama Murid</th>
                                <th width="150">Jumlah Paket</th>
                                <th>Paket Yang Diambil</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($queryMuridPaket)) {
                            ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td>
                                        <i class="fa-solid fa-user" style="color:#2563eb; margin-right: 8px;"></i>
                                        <?= htmlspecialchars($row['nama_murid']); ?>
                                    </td>
                                    <td>
                                        <span class="badge-jumlah">
                                            <?= $row['jumlah_paket']; ?> Paket
                                        </span>
                                    </td>
                                    <td>
                                        <?= $row['paket_diambil'] ? $row['paket_diambil'] : '<span style="color:#aaa; font-style:italic;">Belum ambil paket</span>'; ?>
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
        document.getElementById("searchInput").addEventListener("keyup", function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll("#muridTable tbody tr");

            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(filter) ? "" : "none";
            });
        });
    </script>
</body>
</html>