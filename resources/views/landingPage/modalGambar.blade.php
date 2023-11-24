<!-- Modal -->
<div class="modal fade" id="modalGambar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="closeCustomModal()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>                      
            <div class="modal-body">
                <img id="gambarModal" src="" alt="Gambar Modal" class="img-fluid">
                <!-- Input tersembunyi untuk menyimpan id_galeri -->
                <input type="hidden" id="id_galeri_modal" name="id_galeri_modal">
            </div>
        </div>
    </div>
</div>
<script>
    // Tutup modal dengan ID "modalGambar" secara manual
    function closeCustomModal() {
        $('#modalGambar').modal('hide');
    }
</script>
