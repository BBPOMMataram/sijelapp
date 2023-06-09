<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Form {{$title}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 class="text-right mr-4 text-info" id="modal-mode">Add a new data</h5>
                <!-- general form elements -->
                <!-- form start -->
                <form onsubmit="return false">
                    <input type="hidden" name="id" id="id">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
                        <div class="form-group">
                            <label for="service">Layanan</label>
                            <input type="text" class="form-control" name="service" id="service">
                        </div>
                        <div class="form-group">
                            <label for="hp">HP</label>
                            <input type="text" class="form-control" name="hp" id="hp">
                        </div>
                        <div class="form-group">
                            <label for="company">Instansi</label>
                            <input type="text" class="form-control" name="company" id="company">
                        </div>
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <input type="text" class="form-control" name="address" id="address">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" id="email">
                        </div>
                        <div class="form-group">
                            <label for="pangkat">Pangkat</label>
                            <input type="text" class="form-control" name="pangkat" id="pangkat">
                        </div>
                        <div class="form-group">
                            <label for="jabatan">Jabatan</label>
                            <input type="text" class="form-control" name="jabatan" id="jabatan">
                        </div>
                    </div>
                    <!-- /.card-body -->
                </form>
                <!-- /.card -->
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="close" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary submit">Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>