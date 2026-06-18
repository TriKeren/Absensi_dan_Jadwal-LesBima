<?php
$host     = "localhost";
$username = "root";
$password = "";
$database = "les_bima_db";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Proses READ data tetap di sini
$query      = "SELECT * FROM guru";
$result     = mysqli_query($koneksi, $query);
$total_data = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Kursus & Absensi - Guru</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0; 
            box-sizing: border-box; 
            font-family: 'Poppins', sans-serif; 
        }
        body { 
            background-color: #0a0a0a;
             overflow : hidden;
              margin : 0; 
            }
        .canvas-container {
             width: 100%; 
             height: 100vh; 
             display: flex; 
             background: #f8fafc; 
            }
        .sidebar { 
            width: 240px; 
            height: 100vh; 
            background-color: #031e3d; 
            color: #ffffff; 
            padding: 20px 16px; 
            display: flex; 
            flex-direction: column; 
            flex-shrink: 0; 
            overflow: hidden; 
        }
        .sidebar-header { 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            padding-bottom: 20px; 
            border-bottom: 1px solid rgba(255,255,255,0.1); 
            margin-bottom: 20px; 
        }
        .sidebar-header .material-symbols-outlined {
             font-size: 32px; 
             color: #fff; 
            }
        .sidebar-header .header-text h3 { 
            font-size: 13px; 
            font-weight: 700; 
            letter-spacing: 0.5px; 
            line-height: 1.3; }
        .sidebar-header .header-text p { 
            font-size: 10px; 
            color: #a0aec0; 
            margin-top: 2px; 
        }
        .menu-title { 
            font-size: 11px; 
            font-weight: 600; 
            color: #718096; 
            padding-left: 10px; 
            display: block; 
            margin-bottom: 8px; 
            margin-top: 10px; 
        }
        .menu { 
            list-style: none;
            width: 100%; 
        }
        .menu li { margin-bottom: 4px; }
        .menu li a { display: flex; align-items: center; gap: 10px; padding: 10px 12px; color: #b2c2d4; text-decoration: none; font-size: 13px; border-radius: 6px; transition: all 0.2s ease; }
        .menu li a .material-symbols-outlined { font-size: 20px; }
        .menu li a:hover { background-color: rgba(255,255,255,0.07); color: #ffffff; }
        .menu li.active a { background: linear-gradient(90deg, #1e70e4, #1557b7); color: #ffffff; font-weight: 600; }
        .menu li.logout a { color: #ff6b6b; margin-top: 10px; }
        .menu li.logout a:hover { background-color: rgba(255, 107, 107, 0.1); }
        .main-content { flex-grow: 1; padding: 40px 50px; display: flex; flex-direction: column; background-color: #f8fafc; overflow-y: auto; }
        .header-section { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 35px; }
        .title-area h1 { font-size: 28px; color: #1e293b; font-weight: 700; margin-bottom: 5px; }
        .breadcrumb { font-size: 14px; color: #94a3b8; }
        .breadcrumb span { color: #64748b; }
        .action-area { display: flex; gap: 15px; align-items: center; }
        
        .btn-tambah { 
            background-color: #1d4ed8; color: white; border: none; padding: 12px 24px; border-radius: 8px; 
            font-size: 14px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px; 
            text-decoration: none; transition: background 0.2s; 
        }
        .btn-tambah:hover { background-color: #1e40af; }
        
        .search-container { position: relative; }
        .search-input { padding: 12px 16px 12px 40px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; width: 260px; outline: none; background-color: white; transition: border-color 0.2s; font-family: 'Poppins', sans-serif; }
        .search-input:focus { border-color: #1d4ed8; }
        .search-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 15px; pointer-events: none; }
        .table-container { background-color: white; border-radius: 12px; padding: 30px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { color: #1e293b; font-weight: 600; font-size: 14px; padding: 16px; border-bottom: 2px solid #edf2f7; }
        td { color: #475569; font-size: 14px; padding: 18px 16px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        .col-no { width: 5%; } .col-role { width: 10%; } .col-nama { width: 22%; } .col-username { width: 20%; } .col-password { width: 18%; } .col-telp { width: 18%; } .col-aksi { width: 12%; text-align: center; } th.col-aksi { text-align: center; }
        .action-buttons { display: flex; gap: 8px; justify-content: center; align-items: center; }
        
        .btn-action { width: 36px; height: 36px; border: none; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; color: white !important; font-size: 14px; text-decoration: none; line-height: 1; transition: opacity 0.2s, transform 0.1s; flex-shrink: 0; }
        .btn-action:hover { opacity: 0.85; } .btn-action:active { transform: scale(0.95); }
        .btn-edit { background-color: #f59e0b; } .btn-delete { background-color: #ef233c; }
        .table-footer { font-size: 13px; color: #64748b; margin-top: 20px; }
    </style>
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
            <li><a href="#"><span class="material-symbols-outlined">calendar_month</span> Jadwal</a></li>
            <li><a href="pertemuan.php"><span class="material-symbols-outlined">description</span> Pertemuan</a></li>
            <li><a href="#"><span class="material-symbols-outlined">fact_check</span> Absensi</a></li>
            <li class="active"><a href="kontrolguru.php"><span class="material-symbols-outlined">person_pin</span> Guru</a></li>
            <li><a href="kontrolmurid.php"><span class="material-symbols-outlined">groups</span> Murid</a></li>
        </ul>
        <span class="menu-title" style="margin-top: auto; padding-top: 20px;">AKUN</span>
        <ul class="menu">
            <li><a href="#"><span class="material-symbols-outlined">manage_accounts</span> Profil</a></li>
            <li class="logout"><a href="#"><span class="material-symbols-outlined">logout</span> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header-section">
            <div class="title-area">
                <h1>Guru</h1>
                <div class="breadcrumb">Beranda / <span>Guru</span></div>
            </div>
            <div class="action-area">
                <a href="tambahguru.php" class="btn-tambah">
                    <i class="fa-solid fa-plus"></i> Tambah Guru
                </a>
                <div class="search-container">
                    <i class="fa-solid fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Cari guru..." id="searchInput">
                </div>
            </div>
        </div>

        <div class="table-container">
            <table id="guruTable">
                <thead>
                    <tr>
                        <th class="col-no">No</th>
                        <th class="col-role">id Role</th>
                        <th class="col-nama">Nama Guru</th>
                        <th class="col-username">Username</th>
                        <th class="col-password">Password</th>  
                        <th class="col-telp">No. Telepon</th>
                        <th class="col-aksi">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($total_data > 0) {
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['id_role']); ?></td>
                            <td><?= htmlspecialchars($row['nama_guru']); ?></td>
                            <td><?= htmlspecialchars($row['username']); ?></td>
                            <td><?= htmlspecialchars($row['password']); ?></td>
                            <td><?= htmlspecialchars($row['no_telp']); ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="editguru.php?id=<?= $row['id_guru']; ?>" class="btn-action btn-edit" title="Edit">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <a href="hapusguru.php?id=<?= $row['id_guru']; ?>" class="btn-action btn-delete" title="Hapus"
                                       onclick="return confirm('Yakin ingin menghapus data <?= htmlspecialchars($row['nama_guru'], ENT_QUOTES); ?>?');">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='7' style='text-align:center; color:#94a3b8; padding: 40px;'>Belum ada data guru.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <div class="table-footer">
                Menampilkan <?= $total_data > 0 ? '1' : '0'; ?> sampai <?= $total_data; ?> dari <?= $total_data; ?> data
            </div>
        </div>
    </div>
</div>

</body>
</html>