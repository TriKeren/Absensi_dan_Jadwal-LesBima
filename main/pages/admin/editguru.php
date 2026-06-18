<?php
$host     = "localhost";
$username = "root";
$password = "";
$database = "les_bima_db";
$koneksi = mysqli_connect($host, $username, $password, $database);

// 1. Ambil data lama berdasarkan ID di URL untuk ditampilkan di Form
if (isset($_GET['id'])) {
    $id_guru = (int) $_GET['id'];
    $query_ambil = "SELECT * FROM guru WHERE id_guru = $id_guru";
    $result_ambil = mysqli_query($koneksi, $query_ambil);
    $data = mysqli_fetch_assoc($result_ambil);
    if (!$data) {
        die("Data guru tidak ditemukan!");
    }
} else {
    header("Location: cobaeditpisah.php");
    exit;
}

// 2. Proses Update Data ketika Form disubmit
if (isset($_POST['btn_update'])) {
    $id_guru   = (int) $_POST['id_guru'];
    $id_role   = (int) $_POST['id_role'];
    $username  = mysqli_real_escape_string($koneksi, $_POST['username']);
    $nama_guru = mysqli_real_escape_string($koneksi, $_POST['nama_guru']);
    $no_telp   = mysqli_real_escape_string($koneksi, $_POST['no_telp']);
    if (!empty($_POST['password'])) {
        $password = mysqli_real_escape_string($koneksi, $_POST['password']);
        $query_update = "UPDATE guru SET id_role='$id_role', username='$username', password='$password', nama_guru='$nama_guru', no_telp='$no_telp' WHERE id_guru=$id_guru";
    } else {
        $query_update = "UPDATE guru SET id_role='$id_role', username='$username', nama_guru='$nama_guru', no_telp='$no_telp' WHERE id_guru=$id_guru";
    }
    if (mysqli_query($koneksi, $query_update)) {
        header("Location: cobaeditpisah.php");
        exit;
    } else {
        echo "<script>alert('Gagal mengupdate data!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Guru</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #f8fafc; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .form-container { background-color: #ffffff; border-radius: 12px; padding: 32px; width: 480px; box-shadow: 0 20px 60px rgba(0,0,0,0.05); }
        .form-container h3 { font-size: 18px; color: #1e293b; font-weight: 700; margin-bottom: 24px; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }
        .form-control { width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; outline: none; transition: border-color 0.2s; color: #1e293b; }
        .form-control:focus { border-color: #1d4ed8; box-shadow: 0 0 0 3px rgba(29,78,216,0.1); }
        .form-row { display: flex; gap: 14px; }
        .form-row .form-group { flex: 1; }
        .form-footer { display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; }
        .btn-batal { text-decoration: none; padding: 10px 22px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; background-color: white; color: #374151; text-align: center; }
        .btn-batal:hover { background-color: #f9fafb; }
        .btn-simpan { padding: 10px 22px; border: none; border-radius: 8px; font-size: 14px; background-color: #1d4ed8; color: white; cursor: pointer; font-weight: 600; }
        .btn-simpan:hover { background-color: #1e40af; }
    </style>
</head>
<body>

<div class="form-container">
    <h3>Edit Data Guru</h3>
    <form action="editguru.php" method="POST">
        <input type="hidden" name="id_guru" value="<?= $data['id_guru']; ?>">
        
        <div class="form-row">
            <div class="form-group">
                <label>ID Role</label>
                <input type="number" name="id_role" class="form-control" value="<?= $data['id_role']; ?>" required>
            </div>
            <div class="form-group">
                <label>No. Telepon</label>
                <input type="text" name="no_telp" class="form-control" value="<?= $data['no_telp']; ?>">
            </div>
        </div>

        <div class="form-group">
            <label>Nama Guru</label>
            <input type="text" name="nama_guru" class="form-control" value="<?= $data['nama_guru']; ?>" required>
        </div>

        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?= $data['username']; ?>" required>
        </div>

        <div class="form-group">
            <label>Password <span style="font-size:11px; color:#94a3b8; font-weight: 400;">(kosongkan jika tidak diubah)</span></label>
            <input type="password" name="password" class="form-control" placeholder="Password baru...">
        </div>
        
        <div class="form-footer">
            <a href="cobaeditpisah.php" class="btn-batal">Batal</a>
            <button type="submit" name="btn_update" class="btn-simpan">Simpan Perubahan</button>
        </div>
    </form>
</div>

</body>
</html>