@extends('layouts.admin.app')

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped w-100">
                                <thead>
                                    <tr>
                                        <th class="align-middle">No</th>
                                        <th class="align-middle">Label</th>
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
@include('modals.master.statusuji')
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

        const dttable = $("table").DataTable({
            select: true,
            serverside: true,
            ajax: {
                url: "{{ route('dtstatusuji') }}"
            },
            columns: [
                {data: 'DT_RowIndex'},
                {data: 'label'},
                {data: 'actions', className: 'text-center align-middle'},
            ]
        });

        //show modal for editing
        $('table').on('click', '.edit', function(e){
            e.preventDefault();
            const rowData = dttable.row($(this).parents('tr')).data();
            const id = rowData['id'];

            $('#modalstatusuji').modal('show');
            //switch to editing mode
            $('#modalstatusuji .submit').addClass('editing');
            $('#modalstatusuji .submit').removeClass('adding');

            //fill form editing
            $('#label').val(rowData['label']);
            $('#id').val(id);
            $('.modal-title').text('Form Ubah Data');
        });

        //when submit editing
        $('#modalstatusuji').on('click', '.submit.editing', function(e){
            e.preventDefault();

            let fd = new FormData($('form')[0]);
            fd.append('_method', 'PUT');
            fd.append('_token', '{{ csrf_token() }}');

            let url = "{{ route('statusuji.update',"_id") }}";
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
                        $('#modalstatusuji').modal('hide');
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
        $('#modalstatusuji').on('hidden.bs.modal', function(e){
            $('#modalstatusuji .submit').addClass('adding');
            $('#modalstatusuji .submit').removeClass('editing');

            $(this).find('form').trigger('reset');
            $(this).find('form input').prop('disabled', false);
            $(this).find('form textarea').prop('disabled', false);
            $('.submit').css('display', 'inline-block')
            $('.modal-title').text('Form Tambah Data');
        });

        //when modal open autofocus first field
        $('#modalstatusuji').on('shown.bs.modal', function(e){
            $('input:text:visible:first').focus();
        });

        
    }); // end doc ready
</script>
@endpush