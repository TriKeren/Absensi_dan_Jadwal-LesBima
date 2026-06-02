<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Saya - Sistem Informasi Kursus</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* --- RESET & BASE STYLES --- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #f8fafc;
            color: #1e293b;
            display: flex;
            min-height: 100vh;
        }

        /* --- SIDEBAR STYLES --- */
        .sidebar {
            width: 280px;
            background-color: #ffffff;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .sidebar-brand {
            background-color: #007f4e; /* Hijau Dashboard asli */
            padding: 24px;
            color: white;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-brand i {
            font-size: 2rem;
        }

        .brand-text h2 {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            line-height: 1.2;
        }

        .brand-text span {
            font-size: 0.75rem;
            font-weight: 400;
            opacity: 0.9;
        }

        .role-tag {
            background-color: #00663e;
            color: white;
            padding: 8px 24px;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 16px;
            flex-grow: 1;
        }

        .sidebar-menu li {
            margin-bottom: 8px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 16px;
            color: #475569;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .sidebar-menu a:hover {
            background-color: #f1f5f9;
            color: #007f4e;
        }

        .sidebar-menu li.active a {
            background-color: #e6f2ed;
            color: #007f4e;
            font-weight: 600;
        }

        /* User Profile Card di Sidebar */
        .sidebar-user {
            padding: 16px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 16px;
            background-color: #f8fafc;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: #cbd5e1;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .user-avatar i {
            color: #64748b;
            font-size: 1.2rem;
        }

        .user-info h4 {
            font-size: 0.9rem;
            font-weight: 600;
        }

        .user-info p {
            font-size: 0.75rem;
            color: #64748b;
        }

        .status-online {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.75rem;
            color: #22c55e;
            font-weight: 500;
        }

        .status-online::before {
            content: '';
            width: 8px;
            height: 8px;
            background-color: #22c55e;
            border-radius: 50%;
        }

        /* --- MAIN CONTENT STYLES --- */
        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        /* Top Navigation */
        .top-nav {
            background-color: #ffffff;
            padding: 16px 32px;
            display: flex;
            align-items: center;
            gap: 16px;
            border-bottom: 1px solid #e2e8f0;
        }

        .menu-toggle {
            background: #f1f5f9;
            border: none;
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1rem;
            color: #334155;
        }

        .welcome-text {
            font-size: 1rem;
            font-weight: 500;
            color: #1e293b;
        }

        /* Content Body */
        .content-body {
            padding: 32px;
            max-width: 1100px;
            width: 100%;
            margin: 0 auto;
        }

        .section-header {
            margin-bottom: 28px;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 4px;
        }

        .badge-icon {
            background-color: #007f4e;
            color: white;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
        }

        .section-title h1 {
            font-size: 1.35rem;
            font-weight: 700;
            color: #0f172a;
        }

        .section-subtitle {
            font-size: 0.9rem;
            color: #64748b;
            margin-left: 40px;
        }

        /* --- ATTENDANCE STATS CARDS --- */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }

        .icon-present { background-color: #dcfce7; color: #16a34a; }
        .icon-permit { background-color: #fef9c3; color: #ca8a04; }
        .icon-absent { background-color: #fee2e2; color: #dc2626; }
        .icon-total { background-color: #e0f2fe; color: #0284c7; }

        .stat-info p {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-info h2 {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1e293b;
            margin-top: 2px;
        }

        /* --- TABLE STYLE --- */
        .table-container {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .table-header {
            padding: 16px 20px;
            border-bottom: 1px solid #e2e8f0;
            background-color: #ffffff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-header h3 {
            font-size: 1rem;
            font-weight: 600;
            color: #1e293b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.9rem;
        }

        th {
            background-color: #f8fafc;
            color: #64748b;
            padding: 14px 20px;
            font-weight: 600;
            border-bottom: 1px solid #e2e8f0;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }

        td {
            padding: 14px 20px;
            border-bottom: 1px solid #e2e8f0;
            color: #334155;
        }

        tr:last-child td {
            border-bottom: none;
        }

        /* Status Badge Khusus Absensi */
        .absensi-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .badge-hadir { background-color: #dcfce7; color: #15803d; }
        .badge-izin { background-color: #fef9c3; color: #a16207; }
        .badge-alfa { background-color: #fee2e2; color: #b91c1c; }

        .text-muted {
            font-size: 0.8rem;
            color: #94a3b8;
        }

        /* --- RESPONSIVE MEDIA QUERIES --- */
        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                border-bottom: 1px solid #e2e8f0;
            }

            .sidebar-user {
                margin: 12px 16px;
            }

            .top-nav {
                padding: 12px 20px;
            }

            .content-body {
                padding: 20px;
            }

            .section-subtitle {
                margin-left: 0;
            }

            /* Responsive Table Stack */
            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead {
                display: none;
            }

            tr {
                border-bottom: 1px solid #e2e8f0;
                padding: 16px 20px;
            }

            td {
                border-bottom: none;
                padding: 6px 0;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #64748b;
                font-size: 0.8rem;
                text-transform: uppercase;
            }
        }
    </style>
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
            <li>
                <a href="#"><i class="fa-solid fa-calendar-days"></i> Jadwal Saya</a>
            </li>
            <li>
                <a href="./pertemuan.php"><i class="fa-solid fa-chalkboard-user"></i> Pertemuan</a>
            </li>
            <li class="active">
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

    <main class="main-content">
        <header class="top-nav">
            <button class="menu-toggle"><i class="fa-solid fa-bars"></i></button>
            <div class="welcome-text">Selamat datang, <strong>Andi Pratama</strong></div>
        </header>

        <div class="content-body">
            <div class="section-header">
                <div class="section-title">
                    <div class="badge-icon"><i class="fa-solid fa-user-check"></i></div>
                    <h1>Absensi Saya</h1>
                </div>
                <p class="section-subtitle">Rekapitulasi presensi kehadiran kelas kursus Anda</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon icon-total">
                        <i class="fa-solid fa-calculator"></i>
                    </div>
                    <div class="stat-info">
                        <p>Total Kelas</p>
                        <h2>12 Kali</h2>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon icon-present">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div class="stat-info">
                        <p>Hadir</p>
                        <h2>10 Kali</h2>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon icon-permit">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div class="stat-info">
                        <p>Izin / Sakit</p>
                        <h2>1 Kali</h2>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon icon-absent">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </div>
                    <div class="stat-info">
                        <p>Tanpa Alasan</p>
                        <h2>1 Kali</h2>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <div class="table-header">
                    <h3>Log Kehadiran Bulan Ini</h3>
                    <span class="text-muted">Persentase Kehadiran: <strong>83.3%</strong></span>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Mata Pelajaran</th>
                            <th>Waktu Absen</th>
                            <th>Keterangan Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td data-label="Tanggal">Senin, 18 Mei 2026</td>
                            <td data-label="Mata Pelajaran" style="font-weight: 600;">Matematika Dasar</td>
                            <td data-label="Waktu Absen">07:55 WIB <span class="text-muted">(Tepat Waktu)</span></td>
                            <td data-label="Keterangan Status">
                                <span class="absensi-badge badge-hadir"><i class="fa-solid fa-check"></i> Hadir</span>
                            </td>
                        </tr>
                        <tr>
                            <td data-label="Tanggal">Selasa, 19 Mei 2026</td>
                            <td data-label="Mata Pelajaran" style="font-weight: 600;">Fisika SMP</td>
                            <td data-label="Waktu Absen">10:40 WIB <span class="text-muted">(Terlambat)</span></td>
                            <td data-label="Keterangan Status">
                                <span class="absensi-badge badge-hadir"><i class="fa-solid fa-check"></i> Hadir</span>
                            </td>
                        </tr>
                        <tr>
                            <td data-label="Tanggal">Rabu, 13 Mei 2026</td>
                            <td data-label="Mata Pelajaran" style="font-weight: 600;">Kimia SMA</td>
                            <td data-label="Waktu Absen">-</td>
                            <td data-label="Keterangan Status">
                                <span class="absensi-badge badge-alfa"><i class="fa-solid fa-xmark"></i> Alfa</span>
                            </td>
                        </tr>
                        <tr>
                            <td data-label="Tanggal">Senin, 11 Mei 2026</td>
                            <td data-label="Mata Pelajaran" style="font-weight: 600;">Matematika Dasar</td>
                            <td data-label="Waktu Absen">07:45 WIB <span class="text-muted">(Surat Dokter)</span></td>
                            <td data-label="Keterangan Status">
                                <span class="absensi-badge badge-izin"><i class="fa-solid fa-envelope"></i> Sakit</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </main>

</body>
</html>