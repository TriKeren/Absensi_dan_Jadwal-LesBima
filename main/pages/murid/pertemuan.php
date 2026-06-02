<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pertemuan - Sistem Informasi Kursus</title>
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
            background: linear-gradient(135deg, #0f766e, #115e59);
            background-color: #007f4e; /* Hijau Dashboard */
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
            margin-bottom: 24px;
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

        /* --- TABLE & CARDS FILTER CONTROLS --- */
        .filter-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .search-box {
            position: relative;
            flex-grow: 1;
            max-width: 300px;
        }

        .search-box input {
            width: 100%;
            padding: 10px 16px 10px 40px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            font-size: 0.9rem;
            outline: none;
        }

        .search-box i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        /* --- RESPONSIVE TABLE STYLES --- */
        .table-responsive-wrapper {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            overflow: hidden;
            margin-bottom: 24px;
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
            padding: 16px;
            font-weight: 600;
            border-bottom: 1px solid #e2e8f0;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }

        td {
            padding: 16px;
            border-bottom: 1px solid #e2e8f0;
            color: #334155;
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background-color: #f8fafc;
        }

        .class-name {
            font-weight: 600;
            color: #1e293b;
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-done {
            background-color: #dcfce7;
            color: #15803d;
        }

        .status-ongoing {
            background-color: #fef9c3;
            color: #a16207;
        }

        .status-upcoming {
            background-color: #e0f2fe;
            color: #0369a1;
        }

        /* Action Button */
        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background-color: #ffffff;
            border: 1px solid #cbd5e1;
            padding: 6px 12px;
            border-radius: 6px;
            color: #334155;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .btn-action:hover {
            background-color: #007f4e;
            color: white;
            border-color: #007f4e;
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

            .filter-container {
                flex-direction: column;
                align-items: stretch;
            }

            .search-box {
                max-width: 100%;
            }

            /* Mengubah Table menjadi Kartu Stacked di Layar Kecil */
            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead {
                display: none; /* Sembunyikan header tabel di mobile */
            }

            tr {
                border-bottom: 1px solid #e2e8f0;
                padding: 16px;
                background: white;
            }

            td {
                border-bottom: none;
                padding: 6px 0;
                display: flex;
                justify-content: space-between;
                align-items: center;
                font-size: 0.85rem;
            }

            td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #64748b;
                font-size: 0.8rem;
                text-transform: uppercase;
            }
            
            .btn-action {
                width: 100%;
                justify-content: center;
                margin-top: 8px;
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
            <li class="active">
                <a href="#"><i class="fa-solid fa-chalkboard-user"></i> Pertemuan</a>
            </li>
            <li>
                <a href="./absensi.php"><i class="fa-solid fa-user-check"></i> Absensi Saya</a>
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
                    <div class="badge-icon"><i class="fa-solid fa-video"></i></div>
                    <h1>Daftar Pertemuan</h1>
                </div>
                <p class="section-subtitle">Pantau riwayat dan jadwal pertemuan kelas Anda</p>
            </div>

            <div class="filter-container">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Cari kelas...">
                </div>
            </div>

            <div class="table-responsive-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Pertemuan</th>
                            <th>Mata Pelajaran</th>
                            <th>Tanggal & Waktu</th>
                            <th>Guru</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td data-label="Pertemuan">Ke-3</td>
                            <td data-label="Mata Pelajaran" class="class-name">Matematika Dasar</td>
                            <td data-label="Tanggal & Waktu">Senin, 18 Mei • 08:00</td>
                            <td data-label="Guru">Bapak Andi</td>
                            <td data-label="Status">
                                <span class="status-badge status-done">Selesai</span>
                            </td>
                            <td data-label="Aksi">
                                <a href="#" class="btn-action"><i class="fa-solid fa-eye"></i> Detail</a>
                            </td>
                        </tr>
                        <tr>
                            <td data-label="Pertemuan">Ke-2</td>
                            <td data-label="Mata Pelajaran" class="class-name">Fisika SMP</td>
                            <td data-label="Tanggal & Waktu">Selasa, 19 Mei • 10:30</td>
                            <td data-label="Guru">Bapak Andi</td>
                            <td data-label="Status">
                                <span class="status-badge status-ongoing">Berjalan</span>
                            </td>
                            <td data-label="Aksi">
                                <a href="#" class="btn-action" style="background-color: #007f4e; color: white; border-color: #007f4e;"><i class="fa-solid fa-right-to-bracket"></i> Masuk</a>
                            </td>
                        </tr>
                        <tr>
                            <td data-label="Pertemuan">Ke-3</td>
                            <td data-label="Mata Pelajaran" class="class-name">Kimia SMA</td>
                            <td data-label="Tanggal & Waktu">Rabu, 20 Mei • 13:00</td>
                            <td data-label="Guru">Bapak Andi</td>
                            <td data-label="Status">
                                <span class="status-badge status-upcoming">Mendatang</span>
                            </td>
                            <td data-label="Aksi">
                                <a href="#" class="btn-action"><i class="fa-solid fa-bell"></i> Ingatkan</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </main>

</body>
</html>