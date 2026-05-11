 <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - Sistem Informasi</title>

    <!-- Google Icon -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="css/dashboardguru.css">
</head>
<body>

<div class="app-container">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <!-- LOGO -->
        <div class="logo-box">
            <span class="material-symbols-outlined">school</span>
            <div class="logo-text">
                <h2>SISTEM INFORMASI</h2>
                <p>KURSUS & ABSENSI</p>
            </div>
        </div>

        <!-- ROLE INDICATOR -->
        <div class="role-container">
            <button class="role-btn">GURU</button>
        </div>

        <!-- MENU NAVIGASI -->
        <nav class="sidebar-nav">
            <ul class="menu">
                <li><a href="#" class="active">
                    <span class="material-symbols-outlined">home</span>
                    <span>Dashboard</span>
                </a></li>
                <li><a href="#">
                    <span class="material-symbols-outlined">calendar_month</span>
                    <span>Jadwal</span>
                </a></li>
                <li><a href="pertemuanguru.php">
                    <span class="material-symbols-outlined">description</span>
                    <span>Pertemuan</span>
                </a></li>
                <li><a href="#">
                    <span class="material-symbols-outlined">fact_check</span>
                    <span>Absensi</span>
                </a></li>
                <li><a href="#">
                    <span class="material-symbols-outlined">groups</span>
                    <span>Murid</span>
                </a></li>
                <li><a href="#">
                    <span class="material-symbols-outlined">person</span>
                    <span>Profil</span>
                </a></li>
                <li><a href="#" class="logout-item">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Logout</span>
                </a></li>
            </ul>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="content">
        <!-- Section 1: Stats -->
        <section class="stats-grid">
           <div class="stats-grid">
    <div class="stat-card purple">
        <span class="material-symbols-outlined">calendar_today</span> <!-- Ikon Jadwal -->
        <div class="stat-number">6</div>
        <div class="stat-label">Jadwal Hari ini</div>
    </div>
    
    <div class="stat-card light-purple">
        <span class="material-symbols-outlined">assignment_ind</span> <!-- Ikon Murid -->
        <div class="stat-number">28</div>
        <div class="stat-label">Total Murid</div>
    </div>
    
    <div class="stat-card green">
        <span class="material-symbols-outlined">verified_user</span> <!-- Ikon Hadir -->
        <div class="stat-number">26</div>
        <div class="stat-label">Hadir Hari Ini</div>
    </div>
    
    <div class="stat-card orange">
        <span class="material-symbols-outlined">pending_actions</span> <!-- Ikon Pending -->
        <div class="stat-number">2</div>
        <div class="stat-label">Jadwal Hari Ini</div>
    </div>
</div>
        </section>

        <!-- Section 2: Middle Content -->
        <section class="middle-section">
            <div class="info-card">
                <div class="card-header">
                    <h3>Jadwal Saya Hari Ini</h3>
                    <a href="#" class="sub-text">Lihat Semua</a>
                </div>
                <ul class="schedule-list">
                    <li>
                        <label>
                            <input type="checkbox" checked> 
                            <span>08:00-10:00 Matematika Dasar</span>
                        </label>
                    </li>
                    <li>
                        <label>
                            <input type="checkbox"> 
                            <span>13:00-15:00 Matematika Lanjutan</span>
                        </label>
                    </li>
                </ul>
            </div>

            <div class="info-card">
                <h3>Absensi Hari Ini</h3>
                <div class="chart-placeholder">
                    <div class="circle">28 <br> <span>Total</span></div>
                </div>
            </div>
        </section>

        <!-- Section 3: Table -->
        <section class="table-card">
            <h3>Jadwal Minggu Ini</h3>
            <div class="table-container">
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
                            <td>08:00-10:00</td>
                        </tr>
                        <tr>
                        <td>Senin</td>
                            <td>Matematika Lanjutan</td>
                            <td>Kelas A</td>
                            <td>13:00-15:00</td>
                        </tr>
                    </tbody>
                            
                </table>
            </div>
        </section>
    </main>
</div>

</body>
</html>