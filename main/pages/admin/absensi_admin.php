<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Absensi</title>
    <link rel="stylesheet" href="absensi_admin.css">
</head>
<body>

<div class="container">

    <div class="header">
        <h2>ABSENSI</h2>
    </div>

    <div class="card">

        <div class="filter">

            <select>
                <option>Pilih Jadwal</option>
            </select>

            <select>
                <option>Pilih Pertemuan</option>
            </select>

            <input type="text" placeholder="Cari absensi...">

        </div>

        <table>

            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Murid</th>
                    <th>Status</th>
                    <th>Waktu Absensi</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                <tr>
                    <td>1</td>
                    <td>Andi Pratama</td>
                    <td>
                        <span class="hadir">
                            Hadir
                        </span>
                    </td>
                    <td>20 Mei 2024 08:05</td>
                    <td>
                        <button class="edit">✏</button>
                        <button class="hapus">🗑</button>
                    </td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>Bella Putri</td>
                    <td>
                        <span class="hadir">
                            Hadir
                        </span>
                    </td>
                    <td>20 Mei 2024 08:10</td>
                    <td>
                        <button class="edit">✏</button>
                        <button class="hapus">🗑</button>
                    </td>
                </tr>

                <tr>
                    <td>3</td>
                    <td>Citra Lestari</td>
                    <td>
                        <span class="alpha">
                            Alpha
                        </span>
                    </td>
                    <td>-</td>
                    <td>
                        <button class="edit">✏</button>
                        <button class="hapus">🗑</button>
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>