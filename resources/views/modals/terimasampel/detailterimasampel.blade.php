<div class="modal fade" id="modaldetailterimasampel">
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
            <input type="hidden" name="id" id="id">
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label for="nama_produk[]">Jenis Produk</label>
                  <select multiple="multiple" name="nama_produk[]" class="select2multiple" id="jenisproduk"></select>
                </div>
              </div>
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
              <div class="col-12">
                <div class="form-group">
                  <label for="perihal">Perihal Surat</label>
                  <input type="text" class="form-control" id="perihal" name="perihal" placeholder="Perihal Surat">
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label for="wadah">Wadah 1</label>
                  <select name="wadah1" id="wadah1" class="form-control">
                    <option value="">==Pilih wadah1==</option>
                    @foreach ($wadah1 as $item)
                      <option value="{{ $item->name }}">{{ $item->name }}</option>
                    @endforeach
                  </select>
                  </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label for="wadah">Wadah 2</label>
                  <select name="wadah2" id="wadah2" class="form-control">
                    <option value="">==Pilih wadah2==</option>
                    @foreach ($wadah2 as $item)
                      <option value="{{ $item->name }}">{{ $item->name }}</option>
                    @endforeach
                  </select>
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
                    placeholder="Jumlah Uji" min="1">
              </div>
              <div class="col-1">
                <br>
                  <button id='addparameteruji' class="btn btn-outline-light font-weight-bold mt-2 add">+</button>
              </div>
            </div>
            <div id="listparameteruji" class="mt-2 row">
            </div>
            <div id="listparameterujiedit" class="mt-2 row">
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