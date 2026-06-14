<?php
$host     = "localhost";
$username = "root";
$password = "";
$database = "les_bima_db";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// TAMBAH PERTEMUAN
if (isset($_POST['btn_simpan'])) {
    $id_jadwal    = (int) $_POST['id_jadwal'];
    $pertemuan_ke = (int) $_POST['pertemuan_ke'];
    $tanggal      = mysqli_real_escape_string($koneksi, $_POST['tanggal']);

    $query_tambah = "INSERT INTO pertemuan (id_jadwal, pertemuan_ke, tanggal) VALUES ('$id_jadwal', '$pertemuan_ke', '$tanggal')";
    $hasil_tambah = mysqli_query($koneksi, $query_tambah);

    if ($hasil_tambah) {
        header("Location: pertemuanguru.php?id_jadwal=" . $id_jadwal);
        exit;
    } else {
        echo "<script>alert('Gagal menambahkan pertemuan!');</script>";
    }
}

// UPDATE PERTEMUAN
if (isset($_POST['btn_update'])) {
    $id_pertemuan = (int) $_POST['id_pertemuan'];
    $pertemuan_ke = (int) $_POST['pertemuan_ke'];
    $tanggal      = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
    $id_jadwal    = (int) $_POST['id_jadwal_hidden'];

    $query_update = "UPDATE pertemuan SET pertemuan_ke='$pertemuan_ke', tanggal='$tanggal' WHERE id_pertemuan=$id_pertemuan";
    $hasil_update = mysqli_query($koneksi, $query_update);

    if ($hasil_update) {
        header("Location: pertemuanguru.php?id_jadwal=" . $id_jadwal);
        exit;
    } else {
        echo "<script>alert('Gagal mengupdate pertemuan!');</script>";
    }
}

// HAPUS PERTEMUAN
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus' && isset($_GET['id'])) {
    $id_pertemuan = (int) $_GET['id'];
    $id_jadwal    = (int) $_GET['id_jadwal'];

    $query_hapus = "DELETE FROM pertemuan WHERE id_pertemuan = $id_pertemuan";
    $hasil_hapus = mysqli_query($koneksi, $query_hapus);

    if ($hasil_hapus) {
        header("Location: pertemuanguru.php?id_jadwal=" . $id_jadwal);
        exit;
    } else {
        echo "<script>alert('Gagal menghapus pertemuan!');</script>";
    }
}

// AMBIL SEMUA JADWAL UNTUK DROPDOWN
$query_jadwal  = "SELECT * FROM jadwal";
$result_jadwal = mysqli_query($koneksi, $query_jadwal);

// FILTER PERTEMUAN BERDASARKAN JADWAL YANG DIPILIH
$id_jadwal_dipilih = isset($_GET['id_jadwal']) ? (int) $_GET['id_jadwal'] : 0;

// Jika belum ada jadwal dipilih, ambil jadwal pertama sebagai default
if ($id_jadwal_dipilih == 0 && mysqli_num_rows($result_jadwal) > 0) {
    mysqli_data_seek($result_jadwal, 0);
    $first = mysqli_fetch_assoc($result_jadwal);
    $id_jadwal_dipilih = $first['id_jadwal'];
    mysqli_data_seek($result_jadwal, 0);
}

$query_pertemuan  = "SELECT * FROM pertemuan WHERE id_jadwal = $id_jadwal_dipilih ORDER BY pertemuan_ke ASC";
$result_pertemuan = mysqli_query($koneksi, $query_pertemuan);
$total_pertemuan  = mysqli_num_rows($result_pertemuan);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pertemuan Guru</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../../css/pertemuanguru.css">

</head>
<body>

<div class="ap_container">

    <!-- SIDEBAR -->
    <aside class="sidebar">

            <div class="sidebar-brand">
                <i class="fa-solid fa-graduation-cap"></i>
                <div class="brand-text">
                    <h2>Sistem Informasi</h2>
                    <span>Kursus & Absensi</span>
                </div>
            </div>

            <div class="role-tag">GURU</div>

            <ul class="sidebar-menu">

                <li>
                    <a href="dashboardguru.php">
                        <i class="fa-solid fa-house"></i>
                        Dashboard
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="fa-solid fa-calendar-days"></i>
                        Jadwal
                    </a>
                </li>

                <li class="active">
                    <a href="pertemuanguru.php">
                        <i class="fa-solid fa-chalkboard-user"></i>
                        Pertemuan
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="fa-solid fa-user-check"></i>
                        Absensi
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="fa-solid fa-users"></i>
                        Murid
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="fa-solid fa-user"></i>
                        Profil
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Logout
                    </a>
                </li>

            </ul>

            <div class="sidebar-user">
                <div class="user-avatar">
                    <i class="fa-solid fa-user"></i>
                </div>

                <div class="user-info">
                    <h4>Bapak Andi</h4>
                    <p>Guru</p>
                    <div class="status-online">Online</div>
                </div>
            </div>

        </aside>

    <!-- MAIN CONTENT -->
    <main class="content">
        <div class="content-header">
            <h1>Daftar Pertemuan</h1>
            <p>Beranda / <span style="color:#64748b;">Pertemuan</span></p>
        </div>

        <section class="content-body">
            <div class="placeholder-card">

                <!-- TOOLBAR -->
                <div class="hori">
                    <label for="kelas">Pilih Jadwal</label>
                    <select id="kelas" class="dropdown" onchange="gantiJadwal(this.value)">
                        <?php
                        mysqli_data_seek($result_jadwal, 0);
                        while ($jadwal = mysqli_fetch_assoc($result_jadwal)) {
                            $selected = ($jadwal['id_jadwal'] == $id_jadwal_dipilih) ? 'selected' : '';
                            echo "<option value='{$jadwal['id_jadwal']}' $selected>";
                            // Tampilkan kolom yang ada di tabel jadwal kamu
                            echo htmlspecialchars($jadwal['id_jadwal']);
                            echo "</option>";
                        }
                        ?>
                    </select>
                    <button class="tambah-btn" id="openModalBtn">
                        <span class="material-symbols-outlined">add</span>
                        Tambah Pertemuan
                    </button>
                </div>

                <!-- TABEL -->
                <div class="table-container">
                    <table class="pertemuan-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pertemuan Ke</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($total_pertemuan > 0) {
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($result_pertemuan)) {
                                    $tanggal_format = date('d M Y', strtotime($row['tanggal']));
                            ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $row['pertemuan_ke']; ?></td>
                                    <td><?= $tanggal_format; ?></td>
                                    <td class="aksi-cell">
                                        <button class="btn-edit" title="Edit"
                                            data-id="<?= $row['id_pertemuan']; ?>"
                                            data-pertemuan="<?= $row['pertemuan_ke']; ?>"
                                            data-tanggal="<?= $row['tanggal']; ?>"
                                            onclick="bukaModalEdit(this)">
                                            <span class="material-symbols-outlined">edit_square</span>
                                        </button>
                                        <a href="pertemuanguru.php?aksi=hapus&id=<?= $row['id_pertemuan']; ?>&id_jadwal=<?= $id_jadwal_dipilih; ?>"
                                           class="btn-delete"
                                           title="Hapus"
                                           onclick="return confirm('Yakin ingin menghapus pertemuan ke-<?= $row['pertemuan_ke']; ?>?');">
                                            <span class="material-symbols-outlined">delete</span>
                                        </a>
                                    </td>
                                </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='4' class='empty-state'>Belum ada data pertemuan untuk jadwal ini.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </section>
    </main>
</div>

<!-- MODAL TAMBAH PERTEMUAN -->
<div id="tambahModal" class="modal">
    <div class="modal-content">
        <h3>Tambah Pertemuan</h3>
        <form action="pertemuanguru.php" method="POST">
            <input type="hidden" name="id_jadwal" value="<?= $id_jadwal_dipilih; ?>">
            <div class="form-group">
                <label>Pertemuan Ke</label>
                <input type="number" name="pertemuan_ke" class="form-control" placeholder="Contoh: 1" min="1" required>
            </div>
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-batal" id="closeModalBtn">Batal</button>
                <button type="submit" name="btn_simpan" class="btn-simpan">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT PERTEMUAN -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <h3>Edit Pertemuan</h3>
        <form action="pertemuanguru.php" method="POST">
            <input type="hidden" name="id_pertemuan" id="edit_id">
            <input type="hidden" name="id_jadwal_hidden" value="<?= $id_jadwal_dipilih; ?>">
            <div class="form-group">
                <label>Pertemuan Ke</label>
                <input type="number" name="pertemuan_ke" id="edit_pertemuan" class="form-control" min="1" required>
            </div>
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" id="edit_tanggal" class="form-control" required>
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
        document.getElementById("edit_id").value        = btn.dataset.id;
        document.getElementById("edit_pertemuan").value = btn.dataset.pertemuan;
        document.getElementById("edit_tanggal").value   = btn.dataset.tanggal;
        editModal.style.display = "flex";
    }

    // Ganti jadwal via dropdown → reload halaman dengan id_jadwal baru
    function gantiJadwal(id_jadwal) {
        window.location.href = "pertemuanguru.php?id_jadwal=" + id_jadwal;
    }
</script>

</body>
</html>