<!-- resources/views/guruMapel/modalJadwal.blade.php -->
<div class="modal fade" id="modalJadwal" tabindex="-1" role="dialog" aria-labelledby="modalJadwalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalJadwalLabel">Add Jadwal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Isi dengan form atau konten modal Anda -->
                <!-- Contoh form -->
                <form method="POST" action="{{ route('guruMapelJadwal.store') }}">
                    @csrf
                    <input type="hidden" id="id_gp_modal" name="id_gp">
                    <div class="form-group">
                        <label for="hari">Pilih Hari:</label>
                        <select class="form-control" id="hari" name="hari">
                            <option value="senin">Senin</option>
                            <option value="selasa">Selasa</option>
                            <option value="rabu">Rabu</option>
                            <option value="kamis">Kamis</option>
                            <option value="jumat">Jumat</option>
                            <option value="sabtu">Sabtu</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jam_mulai">Jam Mulai:</label>
                        <input type="time" name="jam_mulai" class="form-control" id="jam_mulai">
                    </div>
                    <div class="form-group">
                        <label for="jam_selesai">Jam Selesai:</label>
                        <input type="time" name="jam_selesai" class="form-control" id="jam_selesai">
                    </div>
               
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
        </div>
    </div>
</div>
