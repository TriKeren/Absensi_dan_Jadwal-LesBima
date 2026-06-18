<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/dashboard_admin.css">
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
                <li class="active"><a href="dashboard.php"><span class="material-symbols-outlined">home</span> Dashboard</a></li>
                <li><a href="laporan_guru.php"><span class="material-symbols-outlined">calendar_month</span> Laporan Guru</a></li>
                <li><a href="laporan_murid.php"><span class="material-symbols-outlined">description</span> Laporan Murid</a></li>
                <li><a href="pertemuan.php"><span class="material-symbols-outlined">description</span> Pertemuan</a></li>
                <li><a href="absensi_admin.php"><span class="material-symbols-outlined">fact_check</span> Absensi</a></li>
                <li><a href="kontrolguru.php"><span class="material-symbols-outlined">person_pin</span> Guru</a></li>
                <li><a href="kontrolmurid.php"><span class="material-symbols-outlined">groups</span> Murid</a></li>
            </ul>

            <span class="menu-title" style="margin-top: auto; padding-top: 20px;">AKUN</span>
            <ul class="menu">
                <li><a href="#"><span class="material-symbols-outlined">manage_accounts</span> Profil</a></li>
                <li class="logout"><a href="#"><span class="material-symbols-outlined">logout</span> Logout</a></li>
            </ul>
        </div>

        <div class="dashboard-content">

            <div class="page-header">
                <h1>Dashboard Admin</h1>
                <p>Beranda / Dashboard</p>
            </div>

            <div class="stats-grid">

                <div class="stat-card">
                    <div class="icon blue">
                        <i class="fa-solid fa-book"></i>
                    </div>
                    <div>
                        <h2>6</h2>
                        <span>Mata Pelajaran</span>
                        <a href="#">Lihat Detail</a>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="icon green">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div>
                        <h2>12</h2>
                        <span>Paket Kursus</span>
                        <a href="#">Lihat Detail</a>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="icon purple">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div>
                        <h2>8</h2>
                        <span>Guru</span>
                        <a href="#">Lihat Detail</a>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="icon orange">
                        <i class="fa-solid fa-user-group"></i>
                    </div>
                    <div>
                        <h2>28</h2>
                        <span>Murid</span>
                        <a href="#">Lihat Detail</a>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="icon cyan">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                    <div>
                        <h2>16</h2>
                        <span>Jadwal Aktif</span>
                        <a href="#">Lihat Detail</a>
                    </div>
                </div>

            </div>

            <div class="dashboard-grid">

                <!-- Kehadiran -->
                <div class="dashboard-card">
                    <h3>Statistik Kehadiran Bulan Ini</h3>

                    <div class="attendance-box">
                        <div class="circle">
                            <span>85%</span>
                        </div>

                        <div class="legend">
                            <p><span class="green-dot"></span> Hadir 85%</p>
                            <p><span class="yellow-dot"></span> Izin 10%</p>
                            <p><span class="red-dot"></span> Alpha 5%</p>
                        </div>
                    </div>

                    <div class="footer-stat">
                        <div>
                            <strong>48</strong>
                            <span>Total Pertemuan</span>
                        </div>

                        <div>
                            <strong>480</strong>
                            <span>Total Absensi</span>
                        </div>
                    </div>
                </div>

                <!-- Pendaftaran -->
                <div class="dashboard-card">
                    <h3>Pendaftaran Terbaru</h3>

                    <div class="list-item">
                        <div>
                            <strong>Andi Pratama</strong>
                            <p>Matematika Dasar</p>
                        </div>
                        <span class="badge">Baru</span>
                    </div>

                    <div class="list-item">
                        <div>
                            <strong>Bella Putri</strong>
                            <p>Fisika SMP</p>
                        </div>
                        <span class="badge">Baru</span>
                    </div>

                    <div class="list-item">
                        <div>
                            <strong>Citra Lestari</strong>
                            <p>Kimia SMA</p>
                        </div>
                        <span class="badge">Baru</span>
                    </div>

                    <a href="#" class="lihat">Lihat semua pendaftaran →</a>
                </div>

                <!-- Jadwal -->
                <div class="dashboard-card">
                    <h3>Jadwal Hari Ini</h3>

                    <div class="schedule-item">
                        <span>08:00</span>
                        <div>
                            <strong>Matematika Dasar</strong>
                            <p>5 Murid</p>
                        </div>
                    </div>

                    <div class="schedule-item">
                        <span>10:30</span>
                        <div>
                            <strong>Fisika SMP</strong>
                            <p>6 Murid</p>
                        </div>
                    </div>

                    <div class="schedule-item">
                        <span>13:00</span>
                        <div>
                            <strong>Kimia SMA</strong>
                            <p>7 Murid</p>
                        </div>
                    </div>
                    <a href="#" class="lihat">Lihat semua jadwal →</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>