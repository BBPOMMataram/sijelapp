<div class="modal fade" id="modaldetailterimasampel">
  <div class="modal-dialog modal-lg">
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
            {{-- <input type="hidden" name="id" id="id"> --}}
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label for="nama_produk[]">Jenis Produk</label>
                  {{-- <input type="text" class="form-control" id="nama_produk" name="nama_produk"
                    placeholder="Jenis Produk"> --}}
                  
                  <select multiple="multiple" name="nama_produk[]" class="select2" id="jenisproduk"></select>
                </div>
              </div>
              {{-- <div class="col-6">
                <div class="form-group">
                  <label for="kode_sampel">Kode Sampel</label>
                  <input type="text" class="form-control" id="kode_sampel" name="kode_sampel" placeholder="Kode Sampel">
                </div>
              </div> --}}
              <div class="col-4">
                <div class="form-group">
                  <label for="nomor_surat">Nomor Surat</label>
                  <input type="text" class="form-control" id="nomor_surat" name="nomor_surat"
                    placeholder="Nomor Surat">
                </div>
              </div>
              <div class="col-4">
                <div class="form-group">
                  <label for="tanggal_surat">Tanggal Surat</label>
                  <input type="date" class="form-control" id="tanggal_surat" name="tanggal_surat" placeholder="Tanggal Surat">
                </div>
              </div>
              <div class="col-4">
                <div class="form-group">
                  <label for="tersangka">Tersangka</label>
                  <input type="text" class="form-control" id="tersangka" name="tersangka" placeholder="Tersangka">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-9">
                  <label for="id_parameter">Parameter Uji</label>
                  <select type="text" id="id_parameter" name="id_parameter" class="select2"></select>
              </div>
              <div class="col-2">
                  <label for="jumlah_pengujian">Jumlah Uji</label>
                  <input type="number" class="form-control" id="jumlah_pengujian" name="jumlah_pengujian" value="1"
                    placeholder="Jumlah Uji">
              </div>
              <div class="col-1">
                <br>
                  <button id='addparameteruji' class="btn btn-info mt-2">+</button>
              </div>
            </div>
            <div id="listparameteruji" class="mt-2 form-group row">
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