<div class="modal fade" id="showPerlombaanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                                <input type="text" name="nama_perlombaan" id="show_nama_perlombaan" class="form-control"
                                    placeholder="Nama Perlombaan" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="tanggal">Tanggal Pendaftaran Dibuka</label>
                                <input type="date" name="tanggal_pendaftaran_dibuka" id="show_tanggal_pendaftaran_dibuka" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="tanggal">Tanggal Pendaftaran Ditutup</label>
                                <input type="date" name="tanggal_pendaftaran_ditutup" id="show_tanggal_pendaftaran_ditutup" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6 mb-3">
                            <label for="tempat">Tempat Perlombaan</label>
                            <input type="text" name="tempat_pelaksanaan" id="show_tempat_pelaksanaan" class="form-control"
                                placeholder="Tempat Perlombaan" readonly>
                        </div>
                        <div class="col-12 col-lg-6 mb-3">
                            <label for="kategori_perlombaan">Kategori Perlombaan</label>
                            <input type="text" class="form-control" name="kategori_perlombaan" id="show_kategori_perlombaan"
                                placeholder="Single / Team" readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 col-lg-12">
                            <label for="deskripsi_perlombaan">Deskripsi Perlombaan</label>
                            <textarea name="deskripsi_perlombaan" id="show_deskripsi_perlombaan" class="form-control" readonly></textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>