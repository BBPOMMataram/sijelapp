<div class="modal fade" id="modaltandaterima">
  <div class="modal-dialog">
    <div class="modal-content bg-primary">
      <div class="modal-header">
        <h4 class="modal-title">Bukti Terima</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- form start -->
        {{-- <form> --}}
          <div class="card-body">
            <div class="form-group">
              <label for="nama_pengambil">Nama Pengambil</label>
              <input type="text" class="form-control" id="nama_pengambil" name="nama_pengambil" placeholder="Nama Pengambil">
            </div>
            <div class="form-group">
              <label for="signature">Signature</label> <br />
              <canvas name="signature" id="signature" class="bg-light"></canvas>
              <button type="button" id="clear-signature" class="w-25 d-block bg-light">clear</button>
            </div>
          </div>
          <!-- /.card-body -->
        {{-- </form> --}}
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