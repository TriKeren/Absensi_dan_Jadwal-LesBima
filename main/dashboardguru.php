 <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - Sistem Informasi</title>

    <!-- Google Icon -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <style>
        *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Arial, sans-serif;
}

body {
    background: #0a0a0a;
    overflow: hidden; /* Mencegah scroll pada seluruh halaman */
}

.app-container {
    display: flex;
    height: 100vh;
}

/* 2. SIDEBAR */
.sidebar {
    width: 260px;
    height: 100vh;
    background: linear-gradient(to bottom, #003c96, #001d59);
    padding: 20px 15px;
    color: white;
    flex-shrink: 0; /* Sidebar tidak akan mengecil */
}

.logo-box {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 25px;
}

.logo-box .material-symbols-outlined { font-size: 45px; }

.logo-text h2 { font-size: 20px; font-weight: bold; line-height: 1.2; }

.role-btn {
    width: 100%;
    background: linear-gradient(to right, #2c7dff, #2568df);
    border: none;
    color: white;
    font-size: 18px;
    font-weight: bold;
    padding: 12px;
    border-radius: 12px;
    margin-bottom: 25px;
    cursor: pointer;
}

.menu { list-style: none; }
.menu li { margin-bottom: 8px; }
.menu a {
    display: flex;
    align-items: center;
    gap: 14px;
    text-decoration: none;
    color: white;
    padding: 12px 16px;
    border-radius: 10px;
    transition: 0.3s;
}

.menu a.active { background: rgba(255, 255, 255, 0.2); }
.menu a:hover { background: rgba(255, 255, 255, 0.1); transform: translateX(5px); }

/* 3. AREA KONTEN UTAMA */
.content {
    flex: 1;
    padding: 30px;
    background-color: #f0f2f5;
    overflow-y: auto; /* Area ini saja yang bisa di-scroll */
}

/* 4. KARTU STATISTIK (Top Section) */
/* Container Utama Kartu Statistik */
.stats-grid {
    display: grid;
    /* Membuat 4 kolom dengan lebar yang sama persis */
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    /* Memberi jarak antar kartu agar tidak berdempetan */
    gap: 25px; 
    /* Memastikan grid menggunakan 100% lebar area konten kanan */
    width: 100%; 
    margin-bottom: 30px;
    justify-content: center;
}

/* Detail Kartu Statistik */
.stat-card {
    padding: 25px;
    border-radius: 20px;
    color: white;
    display: flex;
    flex-direction: column;
    align-items: flex-start; /* Teks dan ikon rata kiri */
    justify-content: center;
    min-height: 140px;
    height: 100%;
    /* Memberikan bayangan halus agar kartu terlihat terpisah dari background */
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    transition: transform 0.3s ease;
}

/* Ukuran Ikon di dalam Kartu */
.stat-card .material-symbols-outlined {
    font-size: 35px;
    margin-bottom: 15px; /* Memberi jarak antara ikon dan angka */
}

/* Ukuran Angka */
.stat-number {
    font-weight: bold;
    margin-bottom: 5px;
    font-size: 1.8rem;
}

/* Label Teks */
.stat-label {
    font-weight: 500;
    font-size: 0.85rem;
}
.stat-card:hover {
    transform: translateY(-5px);
}

/* Warna Kartu */
.purple { background: #6f42c1; }
.light-purple { background: #845ef7; }
.green { background: #2fb380; }
.orange { background: #fd7e14; }

/* 5. BAGIAN TENGAH (Jadwal & Absensi) */
.middle-section {
    display: grid;
    grid-template-columns: 1.5fr 1fr; /* Jadwal lebih lebar sedikit */
    gap: 20px;
    margin-bottom: 30px;
}

.info-card {
    background: white;
    color: #333;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.schedule-list li {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 15px 0;
    border-bottom: 1px solid #eee;
}

/* 6. GRAFIK ABSENSI */
.chart-placeholder {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

.circle {
    width: 130px;
    height: 130px;
    border: 12px solid #e0e0e0;
    border-top: 12px solid #2fb380;
    border-right: 12px solid #2fb380;
    border-radius: 50%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
}

.circle span { font-size: 14px; color: #888; }

/* 7. TABEL JADWAL */
.table-card {
    background: white;
    padding: 25px;
    border-radius: 15px;
    color: #333;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th {
    text-align: left;
    padding: 15px;
    background: #f8f9fa;
    color: #666;
    font-size: 13px;
    text-transform: uppercase;
}

td {
    padding: 15px;
    border-bottom: 1px solid #eee;
    font-size: 15px;
}

tr:hover { background: #f1f7ff; }
    </style>
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
        <div class="stat-label">Jadwal Hari Ini</div>
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