<?php
$host     = "localhost";
$username = "root";
$password = "";
$database = "les_bima_db";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// TAMBAH GURU
if (isset($_POST['btn_simpan'])) {
    $id_role   = (int) $_POST['id_role'];
    $username  = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $nama_guru = mysqli_real_escape_string($koneksi, $_POST['nama_guru']);
    $no_telp   = mysqli_real_escape_string($koneksi, $_POST['no_telp']);

    $query_tambah = "INSERT INTO guru (id_role, username, password, nama_guru, no_telp) 
                     VALUES ('$id_role', '$username', '$password', '$nama_guru', '$no_telp')";
    $hasil_tambah = mysqli_query($koneksi, $query_tambah);

    if ($hasil_tambah) {
        header("Location: kontrolguru.php");
        exit;
    } else {
        echo "<script>alert('Gagal menambahkan data! Username mungkin sudah dipakai.');</script>";
    }
}

// UPDATE GURU
if (isset($_POST['btn_update'])) {
    $id_guru   = (int) $_POST['id_guru'];
    $id_role   = (int) $_POST['id_role'];
    $username  = mysqli_real_escape_string($koneksi, $_POST['username']);
    $nama_guru = mysqli_real_escape_string($koneksi, $_POST['nama_guru']);
    $no_telp   = mysqli_real_escape_string($koneksi, $_POST['no_telp']);

    // Jika password diisi, update password. Jika kosong, biarkan password lama
    if (!empty($_POST['password'])) {
        $password = mysqli_real_escape_string($koneksi, $_POST['password']);
        $query_update = "UPDATE guru SET id_role='$id_role', username='$username', password='$password', nama_guru='$nama_guru', no_telp='$no_telp' WHERE id_guru=$id_guru";
    } else {
        $query_update = "UPDATE guru SET id_role='$id_role', username='$username', nama_guru='$nama_guru', no_telp='$no_telp' WHERE id_guru=$id_guru";
    }

    $hasil_update = mysqli_query($koneksi, $query_update);

    if ($hasil_update) {
        header("Location: kontrolguru.php");
        exit;
    } else {
        echo "<script>alert('Gagal mengupdate data! Username mungkin sudah dipakai.');</script>";
    }
}

// HAPUS GURU
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus' && isset($_GET['id'])) {
    $id_guru     = (int) $_GET['id'];
    $query_hapus = "DELETE FROM guru WHERE id_guru = $id_guru";
    $hasil_hapus = mysqli_query($koneksi, $query_hapus);

    if ($hasil_hapus) {
        header("Location: kontrolguru.php");
        exit;
    } else {
        echo "<script>alert('Gagal menghapus data!');</script>";
    }
}

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

        /* ===== SIDEBAR ===== */
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
            line-height: 1.3;
        }

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

        .menu li {
            margin-bottom: 4px;
        }

        .menu li a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            color: #b2c2d4;
            text-decoration: none;
            font-size: 13px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .menu li a .material-symbols-outlined {
            font-size: 20px;
        }

        .menu li a:hover {
            background-color: rgba(255,255,255,0.07);
            color: #ffffff;
        }

        .menu li.active a {
            background: linear-gradient(90deg, #1e70e4, #1557b7);
            color: #ffffff;
            font-weight: 600;
        }

        .menu li.logout a {
            color: #ff6b6b;
            margin-top: 10px;
        }

        .menu li.logout a:hover {
            background-color: rgba(255, 107, 107, 0.1);
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            flex-grow: 1;
            padding: 40px 50px;
            display: flex;
            flex-direction: column;
            background-color: #f8fafc;
            overflow-y: auto;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 35px;
        }

        .title-area h1 {
            font-size: 28px;
            color: #1e293b;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .breadcrumb {
            font-size: 14px;
            color: #94a3b8;
        }

        .breadcrumb span {
            color: #64748b;
        }

        .action-area {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .btn-tambah {
            background-color: #1d4ed8;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s;
        }

        .btn-tambah:hover { background-color: #1e40af; }

        .search-container { position: relative; }

        .search-input {
            padding: 12px 16px 12px 40px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            width: 260px;
            outline: none;
            background-color: white;
            transition: border-color 0.2s;
            font-family: 'Poppins', sans-serif;
        }

        .search-input:focus { border-color: #1d4ed8; }

        .search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 15px;
            pointer-events: none;
        }

        /* ===== TABLE ===== */
        .table-container {
            background-color: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            color: #1e293b;
            font-weight: 600;
            font-size: 14px;
            padding: 16px;
            border-bottom: 2px solid #edf2f7;
        }

        td {
            color: #475569;
            font-size: 14px;
            padding: 18px 16px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        tr:last-child td { border-bottom: none; }

        .col-no       { width: 5%; }
        .col-role     { width: 10%; }
        .col-nama     { width: 22%; }
        .col-username { width: 20%; }
        .col-password { width: 18%; }
        .col-telp     { width: 18%; }
        .col-aksi     { width: 12%; text-align: center; }
        th.col-aksi   { text-align: center; }

        /* ===== TOMBOL AKSI ===== */
        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
            align-items: center;
        }

        .btn-action {
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: white !important;
            font-size: 14px;
            text-decoration: none;
            line-height: 1;
            transition: opacity 0.2s, transform 0.1s;
            flex-shrink: 0;
        }

        .btn-action:hover  { opacity: 0.85; }
        .btn-action:active { transform: scale(0.95); }
        .btn-edit   { background-color: #f59e0b; }
        .btn-delete { background-color: #ef233c; }

        .table-footer {
            font-size: 13px;
            color: #64748b;
            margin-top: 20px;
        }

        /* ===== MODAL ===== */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background-color: rgba(0,0,0,0.5);
            z-index: 999;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 32px;
            width: 480px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        }

        .modal-content h3 {
            font-size: 18px;
            color: #1e293b;
            font-weight: 700;
            margin-bottom: 24px;
        }

        .form-group { margin-bottom: 16px; }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-group .hint {
            font-size: 11px;
            color: #94a3b8;
            font-weight: 400;
            margin-left: 4px;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            outline: none;
            transition: border-color 0.2s;
            color: #1e293b;
        }

        .form-control:focus {
            border-color: #1d4ed8;
            box-shadow: 0 0 0 3px rgba(29,78,216,0.1);
        }

        .form-row {
            display: flex;
            gap: 14px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 24px;
        }

        .btn-batal {
            padding: 10px 22px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            background-color: white;
            color: #374151;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-batal:hover { background-color: #f9fafb; }

        .btn-simpan {
            padding: 10px 22px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            background-color: #1d4ed8;
            color: white;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.2s;
        }

        .btn-simpan:hover { background-color: #1e40af; }
    </style>
</head>
<body>

<div class="canvas-container">

    <!-- SIDEBAR -->
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

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <div class="header-section">
            <div class="title-area">
                <h1>Guru</h1>
                <div class="breadcrumb">Beranda / <span>Guru</span></div>
            </div>
            <div class="action-area">
                <button class="btn-tambah" id="openModalBtn">
                    <i class="fa-solid fa-plus"></i> Tambah Guru
                </button>
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
                                    <button class="btn-action btn-edit" title="Edit"
                                        data-id="<?= $row['id_guru']; ?>"
                                        data-role="<?= $row['id_role']; ?>"
                                        data-nama="<?= htmlspecialchars($row['nama_guru'], ENT_QUOTES); ?>"
                                        data-username="<?= htmlspecialchars($row['username'], ENT_QUOTES); ?>"
                                        data-password="<?= htmlspecialchars($row['password'], ENT_QUOTES); ?>"
                                        data-telp="<?= htmlspecialchars($row['no_telp'], ENT_QUOTES); ?>"
                                        onclick="bukaModalEdit(this)">
                                        <i class="fa-solid fa-pencil"></i>
                                    </button>
                                    <a href="kontrolguru.php?aksi=hapus&id=<?= $row['id_guru']; ?>"
                                       class="btn-action btn-delete"
                                       title="Hapus"
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

<!-- MODAL TAMBAH GURU -->
<div id="tambahModal" class="modal">
    <div class="modal-content">
        <h3>Tambah Data Guru</h3>
        <form action="kontrolguru.php" method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label>ID Role</label>
                    <input type="number" name="id_role" class="form-control" placeholder="Contoh: 1" min="1" required>
                </div>
                <div class="form-group">
                    <label>No. Telepon</label>
                    <input type="text" name="no_telp" class="form-control" placeholder="Contoh: 0812-xxxx-xxxx">
                </div>
            </div>
            <div class="form-group">
                <label>Nama Guru</label>
                <input type="text" name="nama_guru" class="form-control" placeholder="Contoh: Bapak Anto" required>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" placeholder="Contoh: bapak.anto" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-batal" id="closeModalBtn">Batal</button>
                <button type="submit" name="btn_simpan" class="btn-simpan">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT GURU -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <h3>Edit Data Guru</h3>
        <form action="kontrolguru.php" method="POST">
            <input type="hidden" name="id_guru" id="edit_id">
            <div class="form-row">
                <div class="form-group">
                    <label>ID Role</label>
                    <input type="number" name="id_role" id="edit_role" class="form-control" min="1" required>
                </div>
                <div class="form-group">
                    <label>No. Telepon</label>
                    <input type="text" name="no_telp" id="edit_telp" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label>Nama Guru</label>
                <input type="text" name="nama_guru" id="edit_nama" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" id="edit_username" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password <span class="hint">(kosongkan jika tidak ingin mengubah)</span></label>
                <input type="password" name="password" id="edit_password" class="form-control" placeholder="Password baru...">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-batal" id="closeEditModalBtn">Batal</button>
                <button type="submit" name="btn_update" class="btn-simpan">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    const modal        = document.getElementById("tambahModal");
    const editModal    = document.getElementById("editModal");
    const btnOpen      = document.getElementById("openModalBtn");
    const btnClose     = document.getElementById("closeModalBtn");
    const btnCloseEdit = document.getElementById("closeEditModalBtn");

    btnOpen.onclick      = () => modal.style.display     = "flex";
    btnClose.onclick     = () => modal.style.display     = "none";
    btnCloseEdit.onclick = () => editModal.style.display = "none";

    window.onclick = (e) => {
        if (e.target === modal)     modal.style.display     = "none";
        if (e.target === editModal) editModal.style.display = "none";
    };

    function bukaModalEdit(btn) {
        document.getElementById("edit_id").value       = btn.dataset.id;
        document.getElementById("edit_role").value     = btn.dataset.role;
        document.getElementById("edit_nama").value     = btn.dataset.nama;
        document.getElementById("edit_username").value = btn.dataset.username;
        document.getElementById("edit_telp").value     = btn.dataset.telp;
        document.getElementById("edit_password").value = "";
        editModal.style.display = "flex";
    }

    document.getElementById("searchInput").addEventListener("keyup", function() {
        const keyword = this.value.toLowerCase();
        const rows = document.querySelectorAll("#guruTable tbody tr");
        rows.forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(keyword) ? "" : "none";
        });
    });
</script>

</body>
</html>