<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sidebar Guru</title>

    <!-- Google Icon -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="css/pertemuanguru.css">
  
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