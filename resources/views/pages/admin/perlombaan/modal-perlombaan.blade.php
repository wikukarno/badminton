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
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="nama">Nama Perlombaan</label>
                                <input type="text" name="nama_perlombaan" id="nama_perlombaan" class="form-control"
                                    placeholder="Nama Perlombaan">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="tanggal">Tanggal Pendaftaran Dibuka</label>
                                <input type="date" name="tanggal_pendaftaran_dibuka" id="tanggal_pendaftaran_dibuka"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="tanggal">Tanggal Pendaftaran Ditutup</label>
                                <input type="date" name="tanggal_pendaftaran_ditutup"
                                    id="tanggal_pendaftaran_ditutup" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6 mb-3">
                            <label for="tempat">Tempat Perlombaan</label>
                            <input type="text" name="tempat_pelaksanaan" id="tempat_pelaksanaan" class="form-control"
                                placeholder="Tempat Perlombaan">
                        </div>
                        <div class="col-12 col-lg-6 mb-3">
                            <label for="kategori_perlombaan">Kategori Perlombaan</label>
                            <select name="kategori_perlombaan" id="kategori_perlombaan" class="form-control">
                                <option value="Single">Single</option>
                                <option value="Double">Double</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 col-lg-12">
                            <label for="deskripsi_perlombaan">Deskripsi Perlombaan</label>
                            <textarea name="deskripsi_perlombaan" id="deskripsi_perlombaan" class="form-control"></textarea>
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
