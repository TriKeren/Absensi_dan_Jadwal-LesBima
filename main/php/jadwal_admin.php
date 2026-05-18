<!DOCTYPE html>
            <td>Senin</td>
            <td>10:00 - 12:00</td>
            <td>
                <button class="edit">Edit</button>
                <button class="hapus">Hapus</button>
            </td>
        </tr>
    </table>
</div>

<div class="modal" id="modalJadwal">
    <div class="modal-content">
        <h2>Tambah Jadwal</h2>

        <form>
            <div class="form-group">
                <label>Mata Pelajaran</label>
                <select>
                    <option>Matematika</option>
                    <option>Fisika</option>
                </select>
            </div>

            <div class="form-group">
                <label>Paket</label>
                <select>
                    <option>Paket A</option>
                    <option>Paket B</option>
                </select>
            </div>

            <div class="form-group">
                <label>Guru</label>
                <input type="text" placeholder="Masukkan nama guru">
            </div>

            <div class="form-group">
                <label>Hari</label>
                <select>
                    <option>Senin</option>
                    <option>Selasa</option>
                    <option>Rabu</option>
                </select>
            </div>

            <div class="form-group">
                <label>Jam</label>
                <input type="time">
            </div>

            <div class="modal-footer">
                <button type="button" class="close" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(){
        document.getElementById('modalJadwal').style.display='block';
    }

    function closeModal(){
        document.getElementById('modalJadwal').style.display='none';
    }
</script>

</body>
</html>