<div class="modal fade" id="tambahWasitModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Wasit</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form-tambah-wasit" method="POST">
                @csrf
                <input type="hidden" name="id_wasit" id="id_wasit">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="nama">Nama Wasit</label>
                                <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Wasit">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="phone">Nomor Telepon</label>
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="Nomor telepon">
                        </div>
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="status">Status</label>
                            <input type="text" name="status" id="status" class="form-control" placeholder="Wasit A">
                        </div>
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="photo">Foto</label>
                            <input type="file" class="form-control" name="photo" id="photo" />
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 col-lg-12">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit" id="btnSimpanWasit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>