<div class="modal fade" id="tambahPerlombaanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Perlombaan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form-tambah-perlombaan" method="POST">
                @csrf
                <input type="hidden" name="id" id="id_perlombaan">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="nama">Nama Perlombaan</label>
                                <input type="text" name="nama" id="nama" class="form-control"
                                    placeholder="Nama Perlombaan">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="tanggal">Tanggal Perlombaan</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="tempat">Tempat Perlombaan</label>
                            <input type="text" name="tempat" id="tempat" class="form-control"
                                placeholder="Tempat Perlombaan">
                        </div>
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="kuota">Kuota Perlombaan</label>
                            <input type="number" name="kuota" id="kuota" class="form-control"
                                placeholder="Kuota Perlombaan">
                        </div>
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="status">Kategori Perlombaan</label>
                            <input type="text" class="form-control" name="status" id="status"
                                placeholder="Anak-anak - Dewasa">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 col-lg-12">
                            <label for="deskripsi">Deskripsi Perlombaan</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit" id="btnSimpanPerlombaan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>