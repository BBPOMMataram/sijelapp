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
                                data-target="#modal">+</button>
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
@include('modals.master.wadah2')
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
    $(function () {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000
    });

    const dttable = $("table").DataTable({
        select: true,
        serverSide: true,
        ajax: {
            url: "{{ route('wadah2.index') }}"
        },
        columns: [
            {data: 'DT_RowIndex', searchable: false, orderable: false},
            {data: 'name'},
            {data: 'actions', className: 'text-center align-middle'},
        ]
    });

        $('.modal').on('click', '.submit', function(evt){
            evt.preventDefault();

            let fd = new FormData($('form')[0]);
            fd.append('_token', "{{ csrf_token() }}");
            let url = "{{ route('wadah2.store') }}";
            const id = fd.get('id');

            if(id){ //editmode
                fd.append('_method', 'PUT');
                url = "{{ route('wadah2.update',"_id") }}";
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
            let url = "{{ route('wadah2.destroy', "_id") }}";
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

        //when modal close switch to adding and reset form
        $('#modal').on('hidden.bs.modal', function(e){
            $('form').trigger('reset');
        });

        //when modal open autofocus first field
        $('#modal').on('shown.bs.modal', function(e){
            $('input:text:visible:first').focus();
        });

        
    }); // end doc ready
</script>
@endpush