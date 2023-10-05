<!-- resources/views/guruMapel/modalJadwal.blade.php -->
<div class="modal fade" id="modalAbsensi" tabindex="-1" role="dialog" aria-labelledby="modalAbsensiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAbsensiLabel">Tambah Absensi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Isi dengan form atau konten modal Anda -->
                <!-- Contoh form -->
                <form method="POST" action="{{ route('dataAbsensi.store') }}">
                        @csrf
                        <input type="hidden" id="id_gp_modal" name="id_gp">
                        <div class="form-group">
                            <label for="tanggal">Tanggal:</label>
                            <input type="date" name="tanggal" class="form-control" id="tanggal">
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
