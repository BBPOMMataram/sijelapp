<div class="modal fade" id="modaltandaterima">
  <div class="modal-dialog">
    <div class="modal-content bg-info">
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
              <input type="text" class="form-control" id="nama_pengambil" name="nama_pengambil">
            </div>
            <div class="form-group">
              <label for="signature">Signature</label> <br />
              <canvas name="signature" id="signature" class="bg-light" width="200px"></canvas>
              <a href="#" id="clear-signature" class="btn btn-danger rounded w-25 d-block">clear</a>
            </div>
          </div>
          <!-- /.card-body -->
        {{-- </form> --}}
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-outline-light" id="submittandaterima">Submit</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->