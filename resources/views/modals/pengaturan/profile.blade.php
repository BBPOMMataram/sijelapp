<div class="modal fade" id="modalprofile">
  <div class="modal-dialog">
    <div class="modal-content bg-primary">
      <div class="modal-header">
        <h4 class="modal-title">Form Ubah password</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- form start -->
        <form>
          <div class="card-body">
            <div class="form-group">
              <label for="current">Current Password</label>
              <input type="password" class="form-control" id="current" name="current" placeholder="Current Password">
            </div>
            <div class="form-group">
              <label for="new">New Password</label>
              <input type="password" class="form-control" id="new" name="new" placeholder="New Password">
            </div>
            <div class="form-group">
              <label for="new2">Second New Password</label>
              <input type="password" class="form-control" id="new2" name="new2" placeholder="Second New Password">
            </div>
          </div>
          <!-- /.card-body -->
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-outline-light submit">Submit</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->