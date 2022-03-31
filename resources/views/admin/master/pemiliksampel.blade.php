@extends('layouts.admin.app')

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#modalpemiliksampel">+</button>
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="pemiliksampel" class="table table-bordered table-striped w-100">
                                <thead>
                                    <tr>
                                        <th class="align-middle">No</th>
                                        <th class="align-middle">Nama Instansi</th>
                                        <th class="align-middle">Nama Petugas</th>
                                        <th class="align-middle">Telepon Petugas</th>
                                        <th class="align-middle">Email Petugas</th>
                                        <th class="align-middle">Pangkat Petugas</th>
                                        <th class="align-middle">Jabatan Petugas</th>
                                        <th class="align-middle">Alamat Instansi</th>
                                        <th class="align-middle">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@include('modals.master.pemiliksampel')
@endsection
@push('scripts')
<script>
    $(function () {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000
        });

        const dttable = $("#pemiliksampel").DataTable({
            select: true,
            serverSide: true,
            ajax: {
                url: "{{ route('dtpemiliksampel') }}"
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, orderable: false},
                {data: 'nama_pemilik'},
                {data: 'nama_petugas'},
                {data: 'telepon_petugas'},
                {data: 'email_petugas'},
                {data: 'pangkat_petugas'},
                {data: 'jabatan_petugas'},
                {data: 'alamat_pemilik'},
                {data: 'actions', className: 'text-center align-middle'},
            ]
        });

        //when submit adding
        $('#modalpemiliksampel').on('click', '.submit.adding', function(evt){
            evt.preventDefault();

            let fd = new FormData($('form')[0]);
            fd.append('_token', "{{ csrf_token() }}");
            const url = "{{ route('pemiliksampel.store') }}";

            $.ajax({
                type: 'POST',
                url: url,
                data: fd,
                cache: false,
                processData: false,
                contentType: false,
                success: function (response) {
                    Toast.fire({
                        icon: 'success',
                        title: '&nbsp;' + response.msg,
                    })
                    $('#modalpemiliksampel').modal('hide');
                    dttable.ajax.reload(null, false);
                },
                error: function(err){
                    if(err.status == 422){
                    let errMsg = '';
                    $.each(err.responseJSON.errors, function (indexInArray, valueOfElement) {
                        $.each(valueOfElement, function (indexInArray, valueOfElement) { 
                        errMsg += '<li class="text-left">' + valueOfElement + '</li>';
                        });
                    });

                    Swal.fire({
                        icon: 'error',
                        title: err.responseJSON.message,
                        html: '<ul>' + errMsg + '</ul>',
                    })
                    }
                }
            });
        });

        $('table').on('click', '.delete', function(e){
            e.preventDefault();
            const rowData = dttable.row($(this).parents('tr')).data();
            const id = rowData['id_pemilik'];
            let url = "{{ route('pemiliksampel.destroy', "_id") }}";
            url = url.replace('_id', id);

            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Data yang dihapus tidak dapat dikembalikan, hapus item ?',
                icon: 'question',
                showCancelButton: true,
            }).then(function(val){
                if(val.isConfirmed){
                $.ajax({
                    type: "DELETE",
                    url: url,
                    data: {
                    _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                    Toast.fire({
                        icon: 'success',
                        title: '&nbsp;' + response.msg,
                    })
                    dttable.ajax.reload(null, false);
                    }
                });
                }
            });
        });

        //show modal for show data
        $('table').on('click', '.show', function(e){
            e.preventDefault();
            const rowData = dttable.row($(this).parents('tr')).data();
            const id = rowData['id_pemilik'];

            $('#modalpemiliksampel').modal('show');

            //fill form editing
            $('#instansi').val(rowData['nama_pemilik']).prop('disabled', true);
            $('#namapetugas').val(rowData['nama_petugas']).prop('disabled', true);
            $('#teleponpetugas').val(rowData['telepon_petugas']).prop('disabled', true);
            $('#alamatinstansi').val(rowData['alamat_pemilik']).prop('disabled', true);
            $('.submit').css('display', 'none')
            $('.modal-title').text('Detail data');
            // $('#id').val(id);
        });

        //show modal for editing
        $('table').on('click', '.edit', function(e){
            e.preventDefault();
            const rowData = dttable.row($(this).parents('tr')).data();
            const id = rowData['id_pemilik'];

            $('#modalpemiliksampel').modal('show');
            //switch to editing mode
            $('#modalpemiliksampel .submit').addClass('editing');
            $('#modalpemiliksampel .submit').removeClass('adding');

            //fill form editing
            $('#instansi').val(rowData['nama_pemilik']);
            $('#namapetugas').val(rowData['nama_petugas']);
            $('#teleponpetugas').val(rowData['telepon_petugas']);
            $('#emailpetugas').val(rowData['email_petugas']);
            $('#pangkatpetugas').val(rowData['pangkat_petugas']);
            $('#jabatanpetugas').val(rowData['jabatan_petugas']);
            $('#alamatinstansi').val(rowData['alamat_pemilik']);
            $('#id').val(id);
            $('.modal-title').text('Ubah Data');
        });

        //when submit editing
        $('#modalpemiliksampel').on('click', '.submit.editing', function(e){
            e.preventDefault();

            let fd = new FormData($('form')[0]);
            fd.append('_method', 'PUT');
            fd.append('_token', '{{ csrf_token() }}');

            let url = "{{ route('pemiliksampel.update',"_id") }}";
            const id = fd.get('id');
            url = url.replace('_id', id);
            
            $.ajax({
                type: 'POST',
                url: url,
                data: fd,
                cache: false,
                processData: false,
                contentType: false,
                success: function (response) {
                    if(response.status){
                        Toast.fire({
                            icon: 'success',
                            title: '&nbsp;'+response.msg,
                        })
                        $('#modalpemiliksampel').modal('hide');
                        dttable.ajax.reload(null, false);
                    }else{
                        Toast.fire({
                            icon: 'error',
                            title: '&nbsp;'+response.msg,
                        })
                    }
                },
                error: function(err){
                    if(err.status == 422){
                    let errMsg = '';
                    $.each(err.responseJSON.errors, function (indexInArray, valueOfElement) {
                        $.each(valueOfElement, function (indexInArray, valueOfElement) { 
                        errMsg += '<li class="text-left">' + valueOfElement + '</li>';
                        });
                    });

                    Swal.fire({
                        icon: 'error',
                        title: err.responseJSON.message,
                        html: '<ul>' + errMsg + '</ul>',
                    })
                    }
                }
            });
        });

        //when modal close switch to adding and reset form
        $('#modalpemiliksampel').on('hidden.bs.modal', function(e){
            $('#modalpemiliksampel .submit').addClass('adding');
            $('#modalpemiliksampel .submit').removeClass('editing');

            $(this).find('form').trigger('reset');
            $(this).find('form input').prop('disabled', false);
            $(this).find('form textarea').prop('disabled', false);
            $('.submit').css('display', 'inline-block')
            $('.modal-title').text('Form Tambah Data');
        });

        //when modal open autofocus first field
        $('#modalpemiliksampel').on('shown.bs.modal', function(e){
            $('input:text:visible:first').focus();
        });

        
    }); // end doc ready
</script>
@endpush