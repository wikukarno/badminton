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
                                <div class="d-flex justify-content-between">
                                    <input type="number" min="0" max="30" name="skor_peserta_1_set_1"
                                        id="skor_peserta_1_set_1" class="form-control mr-2" placeholder="Set 1"
                                        required>
                                    <input type="number" min="0" name="skor_peserta_1_set_2"
                                        id="skor_peserta_1_set_2" class="form-control mx-2" placeholder="Set 2"
                                        required>
                                    <input type="number" min="0" name="skor_peserta_1_set_3"
                                        id="skor_peserta_1_set_3" class="form-control ml-2" placeholder="Set 3">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <div class="form-group">
                                <label>Skor Peserta 2</label>
                                <div class="d-flex justify-content-between">
                                    <input type="number" min="0" name="skor_peserta_2_set_1"
                                        id="skor_peserta_2_set_1" class="form-control mr-2" placeholder="Set 1"
                                        required>
                                    <input type="number" min="0" name="skor_peserta_2_set_2"
                                        id="skor_peserta_2_set_2" class="form-control mx-2" placeholder="Set 2"
                                        required>
                                    <input type="number" min="0" name="skor_peserta_2_set_3"
                                        id="skor_peserta_2_set_3" class="form-control ml-2" placeholder="Set 3">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <div class="form-group">
                                <label>Durasi (Menit)</label>
                                <input type="number" min="0" name="durasi" id="durasi" class="form-control"
                                    placeholder="Durasi Pertandingan" required>
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

<!-- Winner Modal -->
<div class="modal fade" id="winnerModal" tabindex="-1" role="dialog" aria-labelledby="winnerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="winnerModalLabel">Informasi Hasil Pertandingan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="winnerMessage">
                <!-- Winner message will be displayed here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
