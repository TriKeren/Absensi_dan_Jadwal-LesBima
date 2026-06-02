<?php
session_start();
include(__DIR__ . '/../../connection/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id_daftar = $_POST['id_daftar'];
    $id_pertemuan = $_POST['id_pertemuan'];
    $status = $_POST['status'];

    $cek = mysqli_query($koneksi,"
        SELECT *
        FROM absensi
        WHERE id_daftar='$id_daftar'
        AND id_pertemuan='$id_pertemuan'
    ");

    if(mysqli_num_rows($cek) == 0){

        mysqli_query($koneksi,"
            INSERT INTO absensi(
                id_daftar,
                id_pertemuan,
                status
            )
            VALUES(
                '$id_daftar',
                '$id_pertemuan',
                '$status'
            )
        ");

        echo "
        <script>
            alert('Absensi berhasil disimpan');
            window.location='jadwal.php';
        </script>";
        exit;
    } else {

        echo "
        <script>
            alert('Absensi sudah pernah diisi');
        </script>";
    }
}

$id_murid = $_SESSION['id_murid'];

$queryJadwal = mysqli_query($koneksi, "
    SELECT
        jadwal.id_jadwal,
        jadwal.hari,
        jadwal.jam_mulai,
        jadwal.jam_selesai,
        guru.nama_guru,
        paket_kursus.nama_paket,
        paket_kursus.jumlah_pertemuan,
        mata_pelajaran.nama_mapel,
        pendaftaran.id_daftar
    FROM pendaftaran
    INNER JOIN paket_kursus
        ON pendaftaran.id_paket = paket_kursus.id_paket
    INNER JOIN jadwal
        ON paket_kursus.id_paket = jadwal.id_paket
    INNER JOIN guru
        ON jadwal.id_guru = guru.id_guru
    INNER JOIN mata_pelajaran
        ON paket_kursus.id_mapel = mata_pelajaran.id_mapel
    WHERE pendaftaran.id_murid = '$id_murid'
    AND pendaftaran.status_pendaftaran = 'Aktif'
");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Saya</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/jadwal_murid.css">
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
                <a href="./dashboard.php"><i class="fa-solid fa-house"></i> Dashboard</a>
            </li>
            <li class="active">
                <a href="#"><i class="fa-solid fa-calendar-days"></i> Jadwal Saya</a>
            </li>
            <li>
                <a href="./pertemuan.php"><i class="fa-solid fa-chalkboard-user"></i> Pertemuan</a>
            </li>
            <li">
                <a href="#"><i class="fa-solid fa-user-check"></i> Absensi Saya</a>
            </li>
            <li>
                <a href="#"><i class="fa-solid fa-user"></i> Profil</a>
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
                <h4>Andi Pratama</h4>
                <p>Murid</p>
                <div class="status-online">Online</div>
            </div>
        </div>
    </aside>

    <main class="content">

        <div class="header">
            <h2>Jadwal Saya</h2>
            <p>Daftar kelas yang Anda ikuti</p>
        </div>

        <div class="filter-section">
            <input type="text" placeholder="Cari Mata Pelajaran...">

            <select>
                <option>Semua Hari</option>
                <option>Senin</option>
                <option>Selasa</option>
                <option>Rabu</option>
                <option>Kamis</option>
                <option>Jumat</option>
            </select>
        </div>

        <div class="jadwal-container">
            <?php while ($jadwal = mysqli_fetch_assoc($queryJadwal)) { ?>
                <div class="jadwal-card">
                    <div class="icon matematika">
                        <i class="fa-solid fa-book"></i>
                    </div>
                    <div class="jadwal-info">
                        <h3><?= $jadwal['nama_mapel']; ?></h3>
                        <p>
                            <?= $jadwal['nama_paket']; ?>
                            (<?= $jadwal['jumlah_pertemuan']; ?> Pertemuan)
                        </p>
                        <div class="detail">
                            <span>
                                <i class="fa-regular fa-calendar"></i>
                                <?= $jadwal['hari']; ?>
                            </span>
                            <span>
                                <i class="fa-regular fa-clock"></i>
                                <?= substr($jadwal['jam_mulai'], 0, 5); ?>
                                -
                                <?= substr($jadwal['jam_selesai'], 0, 5); ?>
                            </span>
                        </div>
                        <div class="guru">
                            <i class="fa-solid fa-user"></i>
                            <?= $jadwal['nama_guru']; ?>
                        </div>
                    </div>
                    <button
                        class="btn-detail btn-absen"
                        data-daftar="<?= $jadwal['id_daftar']; ?>"
                        data-jadwal="<?= $jadwal['id_jadwal']; ?>"
                        data-mapel="<?= $jadwal['nama_mapel']; ?>">
                        <i class="fa-solid fa-user-check"></i>
                    </button>
                </div>
            <?php } ?>
        </div>
    </main>

    <!-- Pop Up -->
    <div class="modal" id="modalAbsen">

        <div class="modal-content">

            <div class="modal-header">
                <h3>Isi Kehadiran</h3>
                <span class="close">&times;</span>
            </div>

            <form method="POST">

                <input
                    type="hidden"
                    name="id_daftar"
                    id="id_daftar">

                <div class="form-group">
                    <label>Mata Pelajaran</label>
                    <input
                        type="text"
                        id="nama_mapel"
                        readonly>
                </div>

                <div class="form-group">
                    <label>Pertemuan</label>

                    <select name="id_pertemuan" required>

                        <?php
                        $queryPertemuan = mysqli_query($koneksi, "
                        SELECT *
                        FROM pertemuan
                    ");

                        while ($pertemuan = mysqli_fetch_assoc($queryPertemuan)) {
                        ?>
                            <option
                                value="<?= $pertemuan['id_pertemuan']; ?>">
                                Pertemuan <?= $pertemuan['pertemuan_ke']; ?>
                            </option>
                        <?php } ?>

                    </select>
                </div>

                <div class="form-group">
                    <label>Status Kehadiran</label>

                    <select name="status" required>
                        <option value="Hadir">Hadir</option>
                        <option value="Izin">Izin</option>
                        <option value="Sakit">Sakit</option>
                    </select>
                </div>

                <button type="submit" class="btn-submit">
                    Simpan Kehadiran
                </button>

            </form>

        </div>

    </div>
</body>

<script>
    const modal = document.getElementById("modalAbsen");

    document.querySelectorAll(".btn-absen")
        .forEach(button => {

            button.addEventListener("click", function() {

                document.getElementById("id_daftar").value =
                    this.dataset.daftar;

                document.getElementById("nama_mapel").value =
                    this.dataset.mapel;

                modal.style.display = "block";
            });

        });

    document.querySelector(".close")
        .addEventListener("click", function() {

            modal.style.display = "none";

        });

    window.onclick = function(event) {

        if (event.target == modal) {
            modal.style.display = "none";
        }

    }
</script>

</html>