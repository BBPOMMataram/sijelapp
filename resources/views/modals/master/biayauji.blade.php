<div class="modal fade" id="modalbiayauji">
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
              <div class="row">
                <div class="col-10">
                  <label for="jenisproduk">Jenis Produk</label>
                  <select name="jenisproduk" id="jenisproduk">

                    <option selected="selected">orange</option>
                    <option>white</option>
                    <option>purple</option>
                  </select>
                </div>
                <div class="col-2">
                  <br>
                  <button class="btn btn-info mt-1" id="addjenisproduk">+</button>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="metode">Metode</label>
              <select name="metode" id="metode" class="select2"></select>
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