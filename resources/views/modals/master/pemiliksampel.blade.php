<div class="modal fade" id="modalpemiliksampel">
  <div class="modal-dialog">
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
            <div class="form-group">
              <label for="instansi">Instansi</label>
              <input type="text" class="form-control" id="instansi" name="instansi" placeholder="Instansi">
            </div>
            <div class="form-group">
              <label for="namapetugas">Nama Petugas</label>
              <input type="text" class="form-control" id="namapetugas" name="namapetugas" placeholder="Nama Petugas">
            </div>
            <div class="form-group">
              <label for="teleponpetugas">Telepon Petugas</label>
              <input type="text" class="form-control" id="teleponpetugas" name="teleponpetugas"
                placeholder="Telepon Petugas">
            </div>
            <div class="form-group">
              <label for="alamatinstansi">Alamat Instansi</label>
              <textarea class="form-control" rows="2" id="alamatinstansi" name="alamatinstansi"
                placeholder="Alamat Instansi"></textarea>
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