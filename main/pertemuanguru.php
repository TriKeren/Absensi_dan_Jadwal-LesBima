<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sidebar Guru</title>

    <!-- Google Icon -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <style>
        *{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}


body{
    background:#0a0a0a;
}

.ap_container {
    display: flex;
    height: 100vh;
    overflow: hidden;
}
/* SIDEBAR */
.sidebar{
    width:260px;
    height:100vh;
    background:linear-gradient(to bottom,#003c96,#001d59);
    padding:20px 15px;
    color:white;
}

/* LOGO */
.logo-box{
    display:flex;
    align-items:center;
    gap:12px;
    margin-bottom:25px;
}

.logo-box .material-symbols-outlined{
    font-size:45px;
}

.logo-text h2{
    font-size:22px;
    font-weight:bold;
    line-height:1.2;
}

.logo-text p{
    font-size:14px;
    opacity:0.9;
}

/* ROLE BUTTON */
.role-btn{
    width:100%;
    background:linear-gradient(to right,#2c7dff,#2568df);
    border:none;
    color:white;
    font-size:22px;
    font-weight:bold;
    padding:15px;
    border-radius:18px;
    margin-bottom:25px;
    cursor:pointer;
    box-shadow:0 4px 10px rgba(0,0,0,0.3);
}

/* MENU */
.menu{
    list-style:none;
}

.menu li{
    margin-bottom:10px;
}

.menu a{
    display:flex;
    align-items:center;
    gap:14px;
    text-decoration:none;
    color:white;
    padding:14px 16px;
    border-radius:14px;
    font-size:18px;
    transition:0.3s;
}

/* ACTIVE */
.menu a.active{
    background:linear-gradient(to right,#1f63db,#245ec5);
    box-shadow:0 3px 10px rgba(0,0,0,0.2);
}

/* HOVER */
.menu a:hover{
    background:rgba(255,255,255,0.08);
    transform:translateX(5px);
}

.menu .material-symbols-outlined{
    font-size:28px;
}
.content {
    flex: 1;
    background-color: #ECF3F6;
    padding: 30px;
    overflow-y: auto;
}
.placeholder-card {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    margin-top: 20px;
}
.content-header {
    color: #333333;
}

.hori {
    display: flex;
    padding: 15px 20px;
    gap: 20px;
    align-items: center;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}
.hori label {
    font-weight: bold;
    color: #444;
    white-space: nowrap;
}
.dropdown {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    flex: 1;               /* Membuat dropdown mengambil sisa ruang yang tersedia */
    max-width: 400px;      /* Membatasi lebar maksimal dropdown */
    outline: none;
}
.tambah-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    background-color: #1a73e8; /* Warna biru Google/Bootstrap */
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 500;
    transition: 0.3s;
}
.tambah-btn:hover {
    background-color: #1557b0;
}
/* Container tabel agar memiliki jarak */
.table-container {
    margin-top: 30px;
    background: white;
    border-radius: 12px;
    overflow: hidden; /* Agar sudut tabel tumpul mengikuti container */
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}

.pertemuan-table {
    width: 100%;
    border-collapse: collapse; /* Menghilangkan jarak antar garis */
}

/* Header Tabel */
.pertemuan-table thead tr {
    background-color: #f8fafd; /* Warna biru sangat muda untuk header */
    border-bottom: 2px solid #edf2f7;
}

.pertemuan-table th {
    padding: 18px;
    color: #2d3748;
    font-weight: bold;
    text-align: center;
}

/* Body Tabel */
.pertemuan-table td {
    padding: 15px;
    text-align: center;
    color: #4a5568;
    border-bottom: 1px solid #edf2f7;
}

/* Kolom Aksi */
.aksi-cell {
    display: flex;
    justify-content: center;
    gap: 10px;
}

/* Tombol Edit (Hijau) */
.btn-edit {
    background-color: #2fb380;
    color: white;
    border: none;
    padding: 6px;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
}

/* Tombol Delete (Merah) */
.btn-delete {
    background-color: #e53e3e;
    color: white;
    border: none;
    padding: 6px;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
}

/* Ukuran Ikon dalam tombol */
.material-symbols-outlined {
    font-size: 20px;
}
    </style>
</head>

<body>
    <div class="ap_container">
        <asside class="sidebar">

            <!-- LOGO -->
            <div class="logo-box">
                <span class="material-symbols-outlined">school</span>
                <div class="logo-text">
                    <h2>SISTEM INFORMASI</h2>
                    <p>KURSUS & ABSENSI</p>
                </div>
            </div>

            <!-- ROLE -->
            <button class="role-btn">GURU</button>

            <!-- MENU -->
            <ul class="menu">
                <li><a href="dashboardguru.php">
                        <span class="material-symbols-outlined">home</span>
                        Dashboard
                    </a></li>

                <li><a href="#">
                        <span class="material-symbols-outlined">calendar_month</span>
                        Jadwal
                    </a></li>

                <li><a href="#" class="active">
                        <span class="material-symbols-outlined">description</span>
                        Pertemuan
                    </a></li>

                <li><a href="#">
                        <span class="material-symbols-outlined">fact_check</span>
                        Absensi
                    </a></li>

                <li><a href="#">
                        <span class="material-symbols-outlined">groups</span>
                        Murid
                    </a></li>

                <li><a href="#">
                        <span class="material-symbols-outlined">person</span>
                        Profil
                    </a></li>

                <li><a href="#">
                        <span class="material-symbols-outlined">logout</span>
                        Logout
                    </a></li>
            </ul>

        </asside>
        <main class="content">
            <header class="content-header">
                <h1>Daftar Pertemuan</h1>
            </header>
            <section class="content-body">
                <div class="placeholder-card">
                    <div class="hori">
                        <label for="Jadwal">pilih Jadwal</label>
                        <select id="kelas" class="dropdown">
                            <option>Matematika Dasar - Senin (08:00 - 10:00)</option>
                            <option>Matematika Lanjutan - Selasa (10:00 - 12:00)</option>
                        </select>
                        <button class="tambah-btn">
                            <span class="material-symbols-outlined">add</span>
                            tambah pertemuan
                        </button>
                    </div>
                    <div class="table-container">
                        <table class="pertemuan-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pertemuan Ke</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>06 Mei 2024</td>
                                    <td>Pertemuan 1</td>
                                    <td class="aksi-cell">
                                        <button class="btn-edit"><span
                                                class="material-symbols-outlined">edit_square</span></button>
                                        <button class="btn-delete"><span
                                                class="material-symbols-outlined">delete</span></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>2</td>
                                    <td>13 Mei 2024</td>
                                    <td>Pertemuan 2</td>
                                    <td class="aksi-cell">
                                        <button class="btn-edit"><span
                                                class="material-symbols-outlined">edit_square</span></button>
                                        <button class="btn-delete"><span
                                                class="material-symbols-outlined">delete</span></button>
                                    </td>
                                </tr>
                                 <tr>
                                    <td>2</td>
                                    <td>2</td>
                                    <td>13 Mei 2024</td>
                                    <td>Pertemuan 2</td>
                                    <td class="aksi-cell">
                                        <button class="btn-edit"><span
                                                class="material-symbols-outlined">edit_square</span></button>
                                        <button class="btn-delete"><span
                                                class="material-symbols-outlined">delete</span></button>
                                    </td>
                                </tr>
                                 <tr>
                                    <td>2</td>
                                    <td>2</td>
                                    <td>13 Mei 2024</td>
                                    <td>Pertemuan 2</td>
                                    <td class="aksi-cell">
                                        <button class="btn-edit"><span
                                                class="material-symbols-outlined">edit_square</span></button>
                                        <button class="btn-delete"><span
                                                class="material-symbols-outlined">delete</span></button>
                                    </td>
                                </tr>
                                 <tr>
                                    <td>2</td>
                                    <td>2</td>
                                    <td>13 Mei 2024</td>
                                    <td>Pertemuan 2</td>
                                    <td class="aksi-cell">
                                        <button class="btn-edit"><span
                                                class="material-symbols-outlined">edit_square</span></button>
                                        <button class="btn-delete"><span
                                                class="material-symbols-outlined">delete</span></button>
                                    </td>
                                </tr>
                                 <tr>
                                    <td>2</td>
                                    <td>2</td>
                                    <td>13 Mei 2024</td>
                                    <td>Pertemuan 2</td>
                                    <td class="aksi-cell">
                                        <button class="btn-edit"><span
                                                class="material-symbols-outlined">edit_square</span></button>
                                        <button class="btn-delete"><span
                                                class="material-symbols-outlined">delete</span></button>
                                    </td>
                                </tr>
                                 <tr>
                                    <td>2</td>
                                    <td>2</td>
                                    <td>13 Mei 2024</td>
                                    <td>Pertemuan 2</td>
                                    <td class="aksi-cell">
                                        <button class="btn-edit"><span
                                                class="material-symbols-outlined">edit_square</span></button>
                                        <button class="btn-delete"><span
                                                class="material-symbols-outlined">delete</span></button>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </main>
    </div>

</body>

</html>