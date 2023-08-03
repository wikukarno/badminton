<div class="modal fade" id="updateSkorPertandinganModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Skor Pertandingan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form-update-skor-pertandingan" method="POST">
                @csrf
                <input type="hidden" name="id_pertandingan" id="id_pertandingan">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <div class="form-group">
                                <label>Skor Peserta 1</label>
                                <input type="number" min="0" name="skor_peserta_1" id="skor_peserta_1"
                                    class="form-control" placeholder="Skor Peserta 1" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <div class="form-group">
                                <label>Skor Peserta 2</label>
                                <input type="number" min="0" name="skor_peserta_2" id="skor_peserta_2"
                                    class="form-control" placeholder="Skor Peserta 2" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit" id="btnSimpanUpdateSkorPertandingan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
