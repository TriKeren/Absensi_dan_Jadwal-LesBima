<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../../css/dashboard_guru.css">
</head>

<body>

    <div class="app-container">

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

                <li class="active">
                    <a href="#">
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

                <li>
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

        <!-- CONTENT -->
        <main class="content">

            <div class="dashboard-header">
                <div>
                    <h1>Dashboard Guru</h1>
                    <p>Selamat datang kembali, Bapak Andi 👋</p>
                </div>

                <button class="header-btn">
                    <i class="fa-solid fa-plus"></i>
                    Buat Pertemuan
                </button>
            </div>

            <!-- STATISTIK -->
            <section class="stats-grid">

                <div class="stat-card">
                    <div class="icon purple">
                        <i class="fa-solid fa-calendar-day"></i>
                    </div>

                    <div>
                        <h2>6</h2>
                        <span>Jadwal Hari Ini</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="icon blue">
                        <i class="fa-solid fa-users"></i>
                    </div>

                    <div>
                        <h2>28</h2>
                        <span>Total Murid</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="icon green">
                        <i class="fa-solid fa-user-check"></i>
                    </div>

                    <div>
                        <h2>26</h2>
                        <span>Hadir Hari Ini</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="icon orange">
                        <i class="fa-solid fa-clock"></i>
                    </div>

                    <div>
                        <h2>2</h2>
                        <span>Belum Absen</span>
                    </div>
                </div>

            </section>

            <!-- CONTENT TENGAH -->
            <section class="middle-section">

                <div class="info-card">

                    <div class="card-header">
                        <h3>Jadwal Saya Hari Ini</h3>
                        <a href="#">Lihat Semua</a>
                    </div>

                    <div class="schedule-item">
                        <span>08:00 - 10:00</span>
                        <strong>Matematika Dasar</strong>
                    </div>

                    <div class="schedule-item">
                        <span>13:00 - 15:00</span>
                        <strong>Matematika Lanjutan</strong>
                    </div>

                    <div class="schedule-item">
                        <span>16:00 - 18:00</span>
                        <strong>Fisika SMP</strong>
                    </div>

                </div>

                <div class="info-card">

                    <h3>Absensi Hari Ini</h3>

                    <div class="attendance-circle">
                        <div class="circle">
                            93%
                        </div>
                    </div>

                    <p class="attendance-text">
                        26 dari 28 murid hadir hari ini
                    </p>

                </div>

            </section>

            <!-- TABLE -->
            <section class="table-card">

                <div class="card-header">
                    <h3>Jadwal Minggu Ini</h3>
                </div>

                <table>

                    <thead>
                        <tr>
                            <th>Hari</th>
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Jam</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td>Senin</td>
                            <td>Matematika Dasar</td>
                            <td>Kelas A</td>
                            <td>08:00 - 10:00</td>
                        </tr>

                        <tr>
                            <td>Senin</td>
                            <td>Matematika Lanjutan</td>
                            <td>Kelas B</td>
                            <td>13:00 - 15:00</td>
                        </tr>

                        <tr>
                            <td>Selasa</td>
                            <td>Fisika SMP</td>
                            <td>Kelas A</td>
                            <td>08:00 - 10:00</td>
                        </tr>

                        <tr>
                            <td>Rabu</td>
                            <td>Kimia SMA</td>
                            <td>Kelas C</td>
                            <td>13:00 - 15:00</td>
                        </tr>

                    </tbody>

                </table>

            </section>

        </main>

    </div>

</body>

</html>