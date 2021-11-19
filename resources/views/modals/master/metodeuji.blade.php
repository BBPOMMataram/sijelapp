<div class="modal fade" id="modalmetodeuji">
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
              <label for="metode">Metode</label>
              <input type="text" class="form-control" id="metode" name="metode" placeholder="Metode">
            </div>
            <div class="form-group">
              <label for="kodelayanan">Kode Layanan</label>
              <input type="text" class="form-control" id="kodelayanan" name="kodelayanan" placeholder="Kode Layanan">
            </div>
            <div class="form-group">
              <label for="biaya">Biaya</label>
              <input type="text" class="form-control" id="biaya" name="biaya" placeholder="Biaya">
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