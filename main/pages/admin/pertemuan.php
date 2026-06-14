<?php
// ============================================================
//  KONEKSI DATABASE — sesuaikan kredensial di bawah
// ============================================================
$host     = "localhost";
$db       = "les_bima_db";   // ← ganti
$user     = "root";            // ← ganti
$password = "";                // ← ganti

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// Helper: prepare dengan error handling
function safe_prepare($conn, $sql) {
    $st = $conn->prepare($sql);
    if ($st === false) {
        die("<pre style='color:red;padding:20px;'>
<b>Query Error:</b> " . htmlspecialchars($conn->error) . "
<b>SQL:</b> " . htmlspecialchars($sql) . "
</pre>");
    }
    return $st;
}

// ============================================================
//  HANDLE AKSI POST (Tambah / Edit / Hapus)
// ============================================================
$aksi  = $_POST['aksi'] ?? $_GET['aksi'] ?? '';
$pesan = '';
$tipe  = '';

if ($aksi === 'tambah' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_jadwal    = (int)($_POST['id_jadwal']    ?? 0);
    $pertemuan_ke = (int)($_POST['pertemuan_ke'] ?? 0);
    $tanggal      = trim($_POST['tanggal']       ?? '');

    if ($id_jadwal > 0 && $pertemuan_ke > 0 && $tanggal !== '') {
        $st = safe_prepare($conn, "INSERT INTO pertemuan (id_jadwal, pertemuan_ke, tanggal) VALUES (?,?,?)");
        $st->bind_param("iis", $id_jadwal, $pertemuan_ke, $tanggal);
        $st->execute();
        $pesan = $st->affected_rows > 0 ? 'Pertemuan berhasil ditambahkan.' : 'Gagal menambahkan data.';
        $tipe  = $st->affected_rows > 0 ? 'success' : 'error';
        $st->close();
    } else {
        $pesan = 'Semua field wajib diisi.';
        $tipe  = 'error';
    }
}

if ($aksi === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id           = (int)($_POST['id_pertemuan'] ?? 0);
    $id_jadwal    = (int)($_POST['id_jadwal']    ?? 0);
    $pertemuan_ke = (int)($_POST['pertemuan_ke'] ?? 0);
    $tanggal      = trim($_POST['tanggal']       ?? '');

    if ($id > 0 && $id_jadwal > 0 && $pertemuan_ke > 0 && $tanggal !== '') {
        $st = safe_prepare($conn, "UPDATE pertemuan SET id_jadwal=?, pertemuan_ke=?, tanggal=? WHERE id_pertemuan=?");
        $st->bind_param("iisi", $id_jadwal, $pertemuan_ke, $tanggal, $id);
        $st->execute();
        $pesan = 'Pertemuan berhasil diperbarui.';
        $tipe  = 'success';
        $st->close();
    } else {
        $pesan = 'Semua field wajib diisi.';
        $tipe  = 'error';
    }
}

if ($aksi === 'hapus' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    if ($id > 0) {
        $st = safe_prepare($conn, "DELETE FROM pertemuan WHERE id_pertemuan=?");
        $st->bind_param("i", $id);
        $st->execute();
        $pesan = $st->affected_rows > 0 ? 'Pertemuan berhasil dihapus.' : 'Data tidak ditemukan.';
        $tipe  = $st->affected_rows > 0 ? 'success' : 'error';
        $st->close();
    }
}

// ============================================================
//  PAGINATION & FILTER
// ============================================================
$per_page      = 5;
$page          = isset($_GET['page']) && is_numeric($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset        = ($page - 1) * $per_page;
$filter_jadwal = isset($_GET['id_jadwal']) ? (int)$_GET['id_jadwal'] : 0;

// Total data
if ($filter_jadwal > 0) {
    $sc = safe_prepare($conn, "SELECT COUNT(*) FROM pertemuan WHERE id_jadwal=?");
    $sc->bind_param("i", $filter_jadwal);
} else {
    $sc = safe_prepare($conn, "SELECT COUNT(*) FROM pertemuan");
}
$sc->execute();
$sc->bind_result($total_data);
$sc->fetch();
$sc->close();
$total_pages = max(1, ceil($total_data / $per_page));

// Data tabel — JOIN hanya jika tabel jadwal ada, pakai LEFT JOIN agar aman
if ($filter_jadwal > 0) {
    $st = safe_prepare($conn, "
        SELECT p.id_pertemuan, p.id_jadwal,
               CONCAT(j.hari, ' ', j.jam_mulai, ' - ', j.jam_selesai) AS nama_jadwal,
               p.pertemuan_ke, p.tanggal
        FROM pertemuan p
        LEFT JOIN jadwal j ON p.id_jadwal = j.id_jadwal
        WHERE p.id_jadwal = ?
        ORDER BY p.pertemuan_ke ASC
        LIMIT ? OFFSET ?
    ");
    $st->bind_param("iii", $filter_jadwal, $per_page, $offset);
} else {
    $st = safe_prepare($conn, "
        SELECT p.id_pertemuan, p.id_jadwal,
               CONCAT(j.hari, ' ', j.jam_mulai, ' - ', j.jam_selesai) AS nama_jadwal,
               p.pertemuan_ke, p.tanggal
        FROM pertemuan p
        LEFT JOIN jadwal j ON p.id_jadwal = j.id_jadwal
        ORDER BY p.id_jadwal ASC, p.pertemuan_ke ASC
        LIMIT ? OFFSET ?
    ");
    $st->bind_param("ii", $per_page, $offset);
}
$st->execute();
$rows = $st->get_result();
$st->close();

// Dropdown jadwal — cek dulu apakah tabel jadwal ada
$jadwal_list   = [];
$tabel_cek     = $conn->query("SHOW TABLES LIKE 'jadwal'");
$jadwal_exists = $tabel_cek && $tabel_cek->num_rows > 0;

if ($jadwal_exists) {
    $res = $conn->query("SELECT id_jadwal, CONCAT(hari, ' ', jam_mulai, ' - ', jam_selesai) AS nama_jadwal FROM jadwal ORDER BY hari ASC");
    if ($res) {
        while ($jd = $res->fetch_assoc()) {
            $jadwal_list[] = $jd;
        }
    }
}

$start_row = $total_data > 0 ? $offset + 1 : 0;
$end_row   = min($offset + $per_page, $total_data);

$bulan_id = [
    1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
    5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
    9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
];

function fmt_tgl($tgl_str, $bulan_id) {
    if (!$tgl_str || $tgl_str === '0000-00-00') return '-';
    $d = new DateTime($tgl_str);
    return $d->format('d') . ' ' . $bulan_id[(int)$d->format('n')] . ' ' . $d->format('Y');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Kursus & Absensi - Pertemuan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; font-family:"Poppins",sans-serif; }
        body { background:#f1f5f9; overflow:hidden; }
        .canvas-container { width:100%; height:100vh; display:flex; }

        /* SIDEBAR */
        .sidebar { width:240px; height:100vh; background:#031e3d; color:#fff; padding:20px 16px; display:flex; flex-direction:column; flex-shrink:0; overflow:hidden; }
        .sidebar-header { display:flex; align-items:center; gap:12px; padding-bottom:20px; border-bottom:1px solid rgba(255,255,255,.1); margin-bottom:20px; }
        .sidebar-header .material-symbols-outlined { font-size:32px; }
        .sidebar-header .header-text h3 { font-size:13px; font-weight:700; letter-spacing:.5px; line-height:1.3; }
        .sidebar-header .header-text p  { font-size:10px; color:#a0aec0; margin-top:2px; }
        .menu-title { font-size:11px; font-weight:600; color:#718096; padding-left:10px; display:block; margin-bottom:8px; margin-top:10px; }
        .menu { list-style:none; width:100%; }
        .menu li { margin-bottom:4px; }
        .menu li a { display:flex; align-items:center; gap:10px; padding:10px 12px; color:#b2c2d4; text-decoration:none; font-size:13px; border-radius:6px; transition:all .2s; }
        .menu li a .material-symbols-outlined { font-size:20px; }
        .menu li a:hover { background:rgba(255,255,255,.07); color:#fff; }
        .menu li.active a { background:linear-gradient(90deg,#1e70e4,#1557b7); color:#fff; font-weight:600; }
        .menu li.logout a { color:#ff6b6b; margin-top:10px; }
        .menu li.logout a:hover { background:rgba(255,107,107,.1); }

        /* MAIN */
        .main-content { flex-grow:1; padding:30px; overflow-y:auto; background:#f8fafc; }
        .page-header h2 { font-size:18px; font-weight:700; color:#0f172a; letter-spacing:.5px; }
        .breadcrumb { display:flex; align-items:center; gap:6px; font-size:12px; margin-top:4px; color:#94a3b8; }
        .breadcrumb a { color:#64748b; text-decoration:none; }
        .breadcrumb a:hover { color:#1e70e4; }

        /* ALERT */
        .alert { display:flex; align-items:center; gap:8px; padding:12px 16px; border-radius:8px; font-size:13px; margin-top:16px; }
        .alert .material-symbols-outlined { font-size:18px; }
        .alert-success { background:#f0fdf4; color:#166534; border:1px solid #bbf7d0; }
        .alert-error   { background:#fff1f2; color:#be123c; border:1px solid #fecdd3; }

        /* TABLE CARD */
        .table-card { background:#fff; border-radius:10px; margin-top:25px; padding:24px; box-shadow:0 4px 6px -1px rgba(0,0,0,.05),0 2px 4px -1px rgba(0,0,0,.03); }
        .action-bar { display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; }
        .dropdown-filter { padding:10px 35px 10px 16px; font-size:13px; color:#334155; border:1px solid #e2e8f0; border-radius:6px; background:#fff; min-width:200px; cursor:pointer; outline:none; appearance:none; background-image:url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e"); background-repeat:no-repeat; background-position:right 12px center; background-size:14px; }
        .dropdown-filter:focus { border-color:#1e70e4; }
        .btn-tambah { display:flex; align-items:center; gap:6px; background:#1e70e4; color:#fff; border:none; padding:10px 16px; font-size:13px; font-weight:500; border-radius:6px; cursor:pointer; transition:background .2s; }
        .btn-tambah:hover { background:#1557b7; }
        .btn-tambah .material-symbols-outlined { font-size:18px; }

        /* TABLE */
        .table-responsive { width:100%; overflow-x:auto; }
        .data-table { width:100%; border-collapse:collapse; text-align:left; font-size:13px; }
        .data-table th { background:#f8fafc; color:#1e293b; font-weight:600; padding:14px 16px; border-bottom:2px solid #edf2f7; white-space:nowrap; }
        .data-table td { color:#475569; padding:14px 16px; border-bottom:1px solid #f1f5f9; }
        .data-table tbody tr:hover { background:#f8fafc; }
        .btn-action { display:inline-flex; align-items:center; gap:4px; padding:5px 11px; border-radius:6px; font-size:12px; font-weight:500; cursor:pointer; border:none; text-decoration:none; transition:all .2s; }
        .btn-action .material-symbols-outlined { font-size:15px; }
        .btn-edit   { background:#f0f9ff; color:#0284c7; }
        .btn-edit:hover   { background:#0284c7; color:#fff; }
        .btn-delete { background:#fff1f2; color:#e11d48; margin-left:6px; }
        .btn-delete:hover { background:#e11d48; color:#fff; }
        .empty-state { text-align:center; padding:48px 16px; color:#94a3b8; font-size:13px; }
        .empty-state .material-symbols-outlined { font-size:48px; display:block; margin-bottom:12px; color:#cbd5e1; }

        /* PAGINATION */
        .table-footer { display:flex; justify-content:space-between; align-items:center; margin-top:20px; font-size:12px; color:#64748b; }
        .pagination { display:flex; align-items:center; gap:4px; }
        .pagination a, .pagination span { display:flex; align-items:center; justify-content:center; width:32px; height:32px; border:1px solid #e2e8f0; background:#fff; color:#64748b; border-radius:6px; font-size:12px; font-weight:500; text-decoration:none; transition:all .2s; }
        .pagination a:hover { border-color:#1e70e4; color:#1e70e4; }
        .pagination a.active { background:#1e70e4; border-color:#1e70e4; color:#fff; }
        .pagination span.disabled { opacity:.4; cursor:default; }
        .pagination .ellipsis { border:none; background:transparent; width:auto; }
        .pagination .material-symbols-outlined { font-size:18px; }

        /* MODAL */
        .modal-overlay { position:fixed; inset:0; background:rgba(15,23,42,.45); display:flex; align-items:center; justify-content:center; z-index:1000; opacity:0; pointer-events:none; transition:opacity .2s ease; }
        .modal-overlay.active { opacity:1; pointer-events:all; }
        .modal { background:#fff; border-radius:12px; padding:28px 32px; width:100%; max-width:480px; box-shadow:0 20px 40px -8px rgba(15,23,42,.2); transform:translateY(12px); transition:transform .25s ease; }
        .modal-overlay.active .modal { transform:translateY(0); }
        .modal-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; }
        .modal-header h3 { font-size:15px; font-weight:700; color:#0f172a; }
        .btn-close { background:none; border:none; cursor:pointer; color:#94a3b8; display:flex; padding:4px; border-radius:6px; transition:all .2s; }
        .btn-close:hover { background:#f1f5f9; color:#475569; }
        .btn-close .material-symbols-outlined { font-size:20px; }
        .form-group { margin-bottom:18px; }
        .form-group label { display:block; font-size:13px; font-weight:600; color:#1e293b; margin-bottom:6px; }
        .form-group select, .form-group input { width:100%; padding:10px 14px; font-size:13px; color:#334155; border:1px solid #e2e8f0; border-radius:6px; outline:none; transition:border-color .2s; background:#fff; }
        .form-group select { appearance:none; background-image:url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e"); background-repeat:no-repeat; background-position:right 12px center; background-size:14px; padding-right:36px; }
        .form-group select:focus, .form-group input:focus { border-color:#1e70e4; box-shadow:0 0 0 3px rgba(30,112,228,.08); }
        .modal-footer { display:flex; justify-content:flex-end; gap:10px; margin-top:24px; }
        .btn-modal-cancel { padding:9px 18px; border-radius:6px; font-size:13px; font-weight:500; border:1px solid #e2e8f0; background:#fff; color:#64748b; cursor:pointer; transition:all .2s; }
        .btn-modal-cancel:hover { background:#f1f5f9; }
        .btn-modal-save { display:flex; align-items:center; gap:6px; padding:9px 18px; border-radius:6px; font-size:13px; font-weight:500; border:none; background:#1e70e4; color:#fff; cursor:pointer; transition:background .2s; }
        .btn-modal-save:hover { background:#1557b7; }
        .btn-modal-save .material-symbols-outlined { font-size:17px; }
        .confirm-icon { width:52px; height:52px; border-radius:50%; background:#fff1f2; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; }
        .confirm-icon .material-symbols-outlined { font-size:26px; color:#e11d48; }
        .confirm-body { text-align:center; }
        .confirm-body h3 { font-size:15px; font-weight:700; color:#0f172a; margin-bottom:8px; }
        .confirm-body p { font-size:13px; color:#64748b; }
        .confirm-footer { display:flex; justify-content:center; gap:10px; margin-top:24px; }
        .btn-hapus-confirm { display:flex; align-items:center; gap:6px; padding:9px 20px; border-radius:6px; font-size:13px; font-weight:500; border:none; background:#e11d48; color:#fff; cursor:pointer; transition:background .2s; text-decoration:none; }
        .btn-hapus-confirm:hover { background:#be123c; }

        /* DEBUG BOX */
        .debug-box { background:#1e293b; color:#94a3b8; font-family:monospace; font-size:12px; padding:16px 20px; border-radius:8px; margin-top:16px; }
        .debug-box b { color:#f8fafc; }
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
            <li><a href="jadwal_admin.php"><span class="material-symbols-outlined">calendar_month</span> Jadwal</a></li>
            <li class="active"><a href="pertemuan.php"><span class="material-symbols-outlined">description</span> Pertemuan</a></li>
            <li><a href="absensi.php"><span class="material-symbols-outlined">fact_check</span> Absensi</a></li>
            <li><a href="kontrolguru.php"><span class="material-symbols-outlined">person_pin</span> Guru</a></li>
            <li><a href="kontrolmurid.php"><span class="material-symbols-outlined">groups</span> Murid</a></li>
        </ul>
        <span class="menu-title" style="margin-top:auto;padding-top:20px;">AKUN</span>
        <ul class="menu">
            <li><a href="profil.php"><span class="material-symbols-outlined">manage_accounts</span> Profil</a></li>
            <li class="logout"><a href="logout.php"><span class="material-symbols-outlined">logout</span> Logout</a></li>
        </ul>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="page-header">
            <h2>PERTEMUAN</h2>
            <div class="breadcrumb">
                <a href="dashboard.php">Beranda</a> <span>/</span> <span>Pertemuan</span>
            </div>
        </div>

        <?php if ($pesan): ?>
        <div class="alert alert-<?= $tipe ?>">
            <span class="material-symbols-outlined"><?= $tipe === 'success' ? 'check_circle' : 'error' ?></span>
            <?= htmlspecialchars($pesan) ?>
        </div>
        <?php endif; ?>

        <?php if (!$jadwal_exists): ?>
        <div class="debug-box">
            <b>⚠ Tabel <code>jadwal</code> tidak ditemukan.</b><br>
            Dropdown filter dan nama jadwal tidak akan tampil.<br>
            Pastikan nama tabel sudah benar atau sesuaikan query JOIN di kode ini.
        </div>
        <?php endif; ?>

        <div class="table-card">
            <div class="action-bar">
                <form method="GET" action="pertemuan.php">
                    <select class="dropdown-filter" name="id_jadwal" onchange="this.form.submit()">
                        <option value="0">Semua Jadwal</option>
                        <?php foreach ($jadwal_list as $jd): ?>
                        <option value="<?= $jd['id_jadwal'] ?>" <?= $filter_jadwal == $jd['id_jadwal'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($jd['nama_jadwal']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </form>
                <button class="btn-tambah" onclick="openModalTambah()">
                    <span class="material-symbols-outlined">add</span> Tambah Pertemuan
                </button>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:60px;">No</th>
                            <th>Jadwal</th>
                            <th style="width:130px;">Pertemuan Ke</th>
                            <th style="width:155px;">Tanggal</th>
                            <th style="width:155px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($rows && $rows->num_rows > 0):
                        $no = $start_row;
                        while ($row = $rows->fetch_assoc()): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['nama_jadwal']) ?></td>
                            <td><?= (int)$row['pertemuan_ke'] ?></td>
                            <td><?= fmt_tgl($row['tanggal'], $bulan_id) ?></td>
                            <td>
                                <button class="btn-action btn-edit"
                                    onclick="openModalEdit(<?= (int)$row['id_pertemuan'] ?>, <?= (int)$row['id_jadwal'] ?>, <?= (int)$row['pertemuan_ke'] ?>, '<?= htmlspecialchars($row['tanggal']) ?>')">
                                    <span class="material-symbols-outlined">edit</span> Edit
                                </button>
                                <button class="btn-action btn-delete"
                                    onclick="openModalHapus(<?= (int)$row['id_pertemuan'] ?>)">
                                    <span class="material-symbols-outlined">delete</span> Hapus
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; else: ?>
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <span class="material-symbols-outlined">description</span>
                                    Belum ada data pertemuan.
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="table-footer">
                <div>
                    <?php if ($total_data > 0): ?>
                        Menampilkan <?= $start_row ?> sampai <?= $end_row ?> dari <?= $total_data ?> data
                    <?php else: ?>
                        Tidak ada data
                    <?php endif; ?>
                </div>
                <?php if ($total_pages > 1):
                    $qs = $filter_jadwal > 0 ? "&id_jadwal={$filter_jadwal}" : ''; ?>
                <div class="pagination">
                    <?php if ($page <= 1): ?>
                        <span class="disabled"><span class="material-symbols-outlined">chevron_left</span></span>
                    <?php else: ?>
                        <a href="?page=<?= $page-1 ?><?= $qs ?>"><span class="material-symbols-outlined">chevron_left</span></a>
                    <?php endif;

                    $sp = max(1, $page-2); $ep = min($total_pages, $page+2);
                    if ($sp > 1) { echo "<a href='?page=1{$qs}'>1</a>"; if ($sp > 2) echo "<span class='ellipsis'>…</span>"; }
                    for ($i=$sp; $i<=$ep; $i++) echo "<a href='?page={$i}{$qs}'" . ($i==$page?" class='active'":"") . ">{$i}</a>";
                    if ($ep < $total_pages) { if ($ep < $total_pages-1) echo "<span class='ellipsis'>…</span>"; echo "<a href='?page={$total_pages}{$qs}'>{$total_pages}</a>"; }

                    if ($page >= $total_pages): ?>
                        <span class="disabled"><span class="material-symbols-outlined">chevron_right</span></span>
                    <?php else: ?>
                        <a href="?page=<?= $page+1 ?><?= $qs ?>"><span class="material-symbols-outlined">chevron_right</span></a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH -->
<div class="modal-overlay" id="modalTambah">
    <div class="modal">
        <div class="modal-header">
            <h3>Tambah Pertemuan</h3>
            <button class="btn-close" onclick="closeModal('modalTambah')"><span class="material-symbols-outlined">close</span></button>
        </div>
        <form method="POST" action="pertemuan.php?page=<?= $page ?>&id_jadwal=<?= $filter_jadwal ?>">
            <input type="hidden" name="aksi" value="tambah">
            <div class="form-group">
                <label>Jadwal</label>
                <select name="id_jadwal" id="t_jadwal" required>
                    <option value="">-- Pilih Jadwal --</option>
                    <?php foreach ($jadwal_list as $jd): ?>
                    <option value="<?= $jd['id_jadwal'] ?>"><?= htmlspecialchars($jd['nama_jadwal']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Pertemuan Ke</label>
                <input type="number" name="pertemuan_ke" id="t_pertemuan_ke" min="1" placeholder="Contoh: 1" required>
            </div>
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" id="t_tanggal" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeModal('modalTambah')">Batal</button>
                <button type="submit" class="btn-modal-save"><span class="material-symbols-outlined">save</span> Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT -->
<div class="modal-overlay" id="modalEdit">
    <div class="modal">
        <div class="modal-header">
            <h3>Edit Pertemuan</h3>
            <button class="btn-close" onclick="closeModal('modalEdit')"><span class="material-symbols-outlined">close</span></button>
        </div>
        <form method="POST" action="pertemuan.php?page=<?= $page ?>&id_jadwal=<?= $filter_jadwal ?>">
            <input type="hidden" name="aksi" value="edit">
            <input type="hidden" name="id_pertemuan" id="e_id">
            <div class="form-group">
                <label>Jadwal</label>
                <select name="id_jadwal" id="e_jadwal" required>
                    <option value="">-- Pilih Jadwal --</option>
                    <?php foreach ($jadwal_list as $jd): ?>
                    <option value="<?= $jd['id_jadwal'] ?>"><?= htmlspecialchars($jd['nama_jadwal']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Pertemuan Ke</label>
                <input type="number" name="pertemuan_ke" id="e_pertemuan_ke" min="1" required>
            </div>
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" id="e_tanggal" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeModal('modalEdit')">Batal</button>
                <button type="submit" class="btn-modal-save"><span class="material-symbols-outlined">save</span> Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL HAPUS -->
<div class="modal-overlay" id="modalHapus">
    <div class="modal" style="max-width:380px;">
        <div class="confirm-body">
            <div class="confirm-icon"><span class="material-symbols-outlined">delete</span></div>
            <h3>Hapus Pertemuan?</h3>
            <p>Data yang dihapus tidak dapat dikembalikan.</p>
        </div>
        <div class="confirm-footer">
            <button class="btn-modal-cancel" onclick="closeModal('modalHapus')">Batal</button>
            <a id="hapus-link" href="#" class="btn-hapus-confirm">
                <span class="material-symbols-outlined" style="font-size:16px;">delete</span> Ya, Hapus
            </a>
        </div>
    </div>
</div>

<script>
function openModal(id)  { document.getElementById(id).classList.add('active'); }
function closeModal(id) { document.getElementById(id).classList.remove('active'); }

document.querySelectorAll('.modal-overlay').forEach(o => {
    o.addEventListener('click', e => { if (e.target === o) closeModal(o.id); });
});
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') document.querySelectorAll('.modal-overlay.active').forEach(m => m.classList.remove('active'));
});

function openModalTambah() {
    document.getElementById('t_jadwal').value       = '';
    document.getElementById('t_pertemuan_ke').value = '';
    document.getElementById('t_tanggal').value      = '';
    openModal('modalTambah');
}

function openModalEdit(id, idJadwal, pertemuanKe, tanggal) {
    document.getElementById('e_id').value           = id;
    document.getElementById('e_jadwal').value       = idJadwal;
    document.getElementById('e_pertemuan_ke').value = pertemuanKe;
    document.getElementById('e_tanggal').value      = tanggal;
    openModal('modalEdit');
}

function openModalHapus(id) {
    const qs = new URLSearchParams(window.location.search);
    qs.set('aksi', 'hapus');
    qs.set('id', id);
    document.getElementById('hapus-link').href = 'pertemuan.php?' + qs.toString();
    openModal('modalHapus');
}
</script>

</body>
</html>
<?php $conn->close(); ?>
