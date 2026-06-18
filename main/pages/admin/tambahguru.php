<?php
$host     = "localhost";
$username = "root";
$password = "";
$database = "les_bima_db";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

if (isset($_POST['btn_simpan'])) {
    $id_role   = (int) $_POST['id_role'];
    $username  = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password  = mysqli_real_escape_string($koneksi, $_POST['password']);
    $nama_guru = mysqli_real_escape_string($koneksi, $_POST['nama_guru']);
    $no_telp   = mysqli_real_escape_string($koneksi, $_POST['no_telp']);

    $query_tambah = "INSERT INTO guru (id_role, username, password, nama_guru, no_telp) 
                     VALUES ('$id_role', '$username', '$password', '$nama_guru', '$no_telp')";
    $hasil_tambah = mysqli_query($koneksi, $query_tambah);

    if ($hasil_tambah) {
        header("Location: kontrolguru.php");
        exit;
    } else {
        echo "<script>alert('Gagal menambahkan data! Username mungkin sudah digunakan.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Guru</title>
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
    <h3>Tambah Data Guru</h3>
    <form action="tambahguru.php" method="POST">
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
        <div class="form-footer">
            <a href="kontrolguru.php" class="btn-batal">Batal</a>
            <button type="submit" name="btn_simpan" class="btn-simpan">Simpan</button>
        </div>
    </form>
</div>

</body>
</html>