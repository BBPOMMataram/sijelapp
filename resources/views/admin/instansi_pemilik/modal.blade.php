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
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat">
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

@push('scripts')
<script>
    // Showing filename after browse
    $('#fileImg').on('change',function(){
        //get the file name
        var fileName = $(this).val().replace('C:\\fakepath\\', "");
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
    });
</script>
@endpush