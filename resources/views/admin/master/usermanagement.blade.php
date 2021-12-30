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
                                data-target="#modalusermanagement">+</button>
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped w-100">
                                <thead>
                                    <tr>
                                        <th class="align-middle">No</th>
                                        <th class="align-middle">Name</th>
                                        <th class="align-middle">Username</th>
                                        <th class="align-middle">Email</th>
                                        <th class="align-middle">Nama Lengkap</th>
                                        <th class="align-middle">Pangkat</th>
                                        <th class="align-middle">Jabatan</th>
                                        <th class="align-middle">Image</th>
                                        <th class="align-middle">Level</th>
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
@include('modals.master.usermanagement')
@endsection
@push('styles')
    <style>
        /* center vertical for datatables */
        table.dataTable tbody td { 
            vertical-align: middle;
        }
    </style>
@endpush
@push('scripts')
<script>
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000
    });

    const dttable = $("table").DataTable({
        select: true,
        serverside: true,
        ajax: {
            url: "{{ route('usermanagement.index') }}"
        },
        columns: [
            {data: 'DT_RowIndex'},
            {data: 'name'},
            {data: 'username'},
            {data: 'email'},
            {data: 'fullname'},
            {data: 'pangkat'},
            {data: 'jabatan'},
            {data: 'image', className: 'text-center'},
            {data: 'level_string'},
            {data: 'actions', className: 'text-center align-middle'},
            {data: 'level', visible: false}, //for an each on show data
        ]
    });

    $(function () {
        $('.modal').on('click', '.submit', function(evt){
            evt.preventDefault();

            let fd = new FormData($('form')[0]);
            fd.append('_token', "{{ csrf_token() }}");
            let url = "{{ route('usermanagement.store') }}";
            const id = fd.get('id');

            if(id){ //editmode
                fd.append('_method', 'PUT');
                url = "{{ route('usermanagement.update',"_id") }}";
                url = url.replace('_id', id);
            }
            
            $.ajax({
                type: 'POST',
                url,
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

        $('table').on('click', '.delete', function(e){
            e.preventDefault();
            const rowData = dttable.row($(this).parents('tr')).data();
            const id = rowData['id'];
            let url = "{{ route('usermanagement.destroy', "_id") }}";
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

        $('.modal').on('click', '#resetpwd', function(e){
            e.preventDefault();

            const id = $('#id').val();
            let url = "{{ route('usermanagement.resetpwd', "_id") }}";
            url = url.replace('_id', id);
            
            Swal.fire({
                title: 'Konfirmasi Reset Password',
                text: 'Yakin ingin reset password user ini ?',
                icon: 'question',
                showCancelButton: true,
            }).then(function(val){
                if(val.isConfirmed){
                $.ajax({
                    type: "POST",
                    url,
                    data: {
                    _token: "{{ csrf_token() }}",
                    _method: "PUT",
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
        })

        //show modal for show data
        $('table').on('click', '.show', function(e){
            e.preventDefault();
            const rowData = dttable.row($(this).parents('tr')).data();
            const id = rowData['id'];

            $('#level option[value="0"]').remove();
            $('#level').append('<option value="0">Super Admin</option>');
            //fill form
            $.each(rowData, function (i, v) { 
                if (i === 'image') {
                    let el = '<div class="form-group">';
                        el += v;
                        el += '</div>';
                    $('.form-group').last().after(el);
                    $('#image').addClass('d-none');

                    return;
                }
                $('input[name='+i+']').val(v).prop('disabled', true);
                $('select[name='+i+']').val(v).prop('disabled', true).trigger('change');
            });
            
            
            $('.alert').addClass('d-none');
            $('.submit').addClass('d-none');
            $('.modal-title').text('Detail Data');
            $('#id').val('');
            $('#modalusermanagement').modal('show');
        });

        $('table').on('click', '.edit', function(e){
            e.preventDefault();
            const rowData = dttable.row($(this).parents('tr')).data();
            const id = rowData['id'];

            if(rowData['level'] === 0){
                $('#level option[value="0"]').remove();
                $('#level').append('<option value="0">Super Admin</option>');
                $('#level').attr('readonly', true);
            }
            //fill form editing
            $.each(rowData, function (i, v) { 
                if (i === 'image') {
                    let el = '<div class="form-group">';
                        el += v;
                        el += '</div>';
                    $('.form-group').last().after(el);
                    return;
                }
                $('input[name='+i+']').val(v);
                $('select[name='+i+']').val(v);
            });
            
            const el = '<input type="button" class="btn btn-danger" id="resetpwd" value="Reset Password" />';
            $('.form-group').last().after(el);

            $('.alert').addClass('d-none');
            $('.modal-title').text('Form Ubah Data');
            $('#id').val(id);
            $('#modalusermanagement').modal('show');
        });

        //when modal close switch to adding and reset form
        $('#modalusermanagement').on('hidden.bs.modal', function(e){
            $('form').trigger('reset');
            $('form input').prop('disabled', false);
            $('form select').prop('disabled', false);

            $('#level option[value="0"]').remove();
            $('#image').removeClass('d-none');
            $('.form-group').last().remove();
            $('.alert').removeClass('d-none');
            $('.submit').removeClass('d-none');
            $('.modal-title').text('Form Tambah Data');
            $('#id').val('');
            $('#resetpwd').remove();
        });

        //when modal open autofocus first field
        $('#modalusermanagement').on('shown.bs.modal', function(e){
            $('input:text:visible:first').focus();
        });

        
    }); // end doc ready
</script>
@endpush