<div class="modal fade" id="modalterimasampel">
  <div class="modal-dialog modal-xl">
    <div class="modal-content bg-primary">
      <div class="modal-header">
        <h4 class="modal-title">Form Tambah Data</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- form start -->
        <form>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-6">
                <input type="hidden" name="id" id="id">
                <div class="form-group">
                  <label for="id_kategori">Kategori</label>
                  <select type="text" id="id_kategori" name="id_kategori" class="select2"></select>
                </div>
                <div class="form-group">
                  <label for="no_urut_penerimaan">Nomor Urut</label>
                  <input type="text" class="form-control" id="no_urut_penerimaan" name="no_urut_penerimaan"
                    placeholder="Nomor Urut">
                </div>
                <div class="form-group">
                  <label for="id_pemilik">Pengirim</label>
                  <select type="text" id="id_pemilik" name="id_pemilik" class="select2"></select>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="row">
                  <div class="col-8">
                    <div class="form-group">
                      <label for="kode_sampel">Kode Sampel</label>
                      <input type="text" class="form-control" id="kode_sampel" name="kode_sampel" placeholder="Kode Sampel">
                    </div>
                  </div>
                  <div class="col-4">
                  <div class="form-group">
                    <label for="jumlah_sampel">Jumlah Sampel</label>
                    <input type="number" class="form-control" id="jumlah_sampel" name="jumlah_sampel"
                      placeholder="Jumlah">
                  </div>
                </div>
                </div>
                <div class="form-group">
                  <label for="kemasan_sampel">Kemasan Sampel</label>
                  <input type="text" class="form-control" id="kemasan_sampel" name="kemasan_sampel"
                    placeholder="Kemasan Sampel">
                </div>
                <div class="form-group">
                  <label for="berat_sampel">Berat Sampel</label>
                  <input type="text" class="form-control" id="berat_sampel" name="berat_sampel"
                    placeholder="Berat Sampel">
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label for="nama_sampel">Nama Sampel</label>
                  <input type="text" class="form-control" id="nama_sampel" name="nama_sampel" placeholder="Nama Sampel" multiple>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card-body -->
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-outline-light submit adding">Submit</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->