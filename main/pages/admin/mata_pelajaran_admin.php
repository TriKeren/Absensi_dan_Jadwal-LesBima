<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/matapelajaran_admin.css">
</head>

<body>
    <div class="container">

        <div class="header">
            <h2>Page Mata Pelajaran</h2>
            <button class="btn" onclick="openModal()">+ Tambah Mata Pelajaran</button>
        </div>

        <table>
            <tr>
                <th>No</th>
                <th>Nama Mata Pelajaran</th>
                <th>Jumlah Paket</th>
                <th>Aksi</th>
            </tr>

            <tr>
                <td>1</td>
                <td>Matematika Dasar</td>
                <td>3</td>
                <td>
                    <button class="edit">Edit</button>
                    <button class="hapus">Hapus</button>
                </td>
            </tr>
        </table>
    </div>

    <div class="modal" id="modalMapel">
        <div class="modal-content">
            <h2>Tambah Mata Pelajaran</h2>

            <form>
                <div class="form-group">
                    <label>Nama Mata Pelajaran</label>
                    <input type="text" placeholder="Masukkan mata pelajaran">
                </div>

                <div class="form-group">
                    <label>Jumlah Paket</label>
                    <input type="number" placeholder="Masukkan jumlah paket">
                </div>

                <div class="modal-footer">
                    <button type="button" class="close" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('modalMapel').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('modalMapel').style.display = 'none';
        }
    </script>
</body>

</html>