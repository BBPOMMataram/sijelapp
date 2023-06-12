@extends('layouts.admin.app')
@section('content')
@include('admin.guestbook.modal')
<section class="content">
    <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal">
                                +
                            </button> --}}
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped w-100">
                                <thead>
                                    <tr>
                                        <th class="align-middle">No</th>
                                        <th class="align-middle">Nama</th>
                                        <th class="align-middle">Layanan</th>
                                        <th class="align-middle">HP</th>
                                        <th class="align-middle">Instansi</th>
                                        <th class="align-middle">Alamat</th>
                                        <th class="align-middle">Email</th>
                                        <th class="align-middle">Pangkat</th>
                                        <th class="align-middle">Jabatan</th>
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
@endsection
@push('scripts')
<script>
    $(function(){
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000
        });

        const dttable = $("table").DataTable({
            select: true,
            serverSide: true,
            dom: "Bfrtlip",
            buttons: [
                {
                    text:'Excel',
                    extend: 'excelHtml5'
                }
            ],
            ajax: {
                url: "{{ route('guestbook_dt') }}"
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, orderable: false},
                {data: 'name'},
                {data: 'service'},
                {data: 'hp'},
                {data: 'company'},
                {data: 'address'},
                {data: 'email'},
                {data: 'pangkat'},
                {data: 'jabatan'},
                {data: 'actions', className: 'text-center align-middle'},
            ]
        });

        $('.modal').on('click', '.submit', function(){
            let fd = new FormData($('form')[0]);
            fd.append('_token', "{{ csrf_token() }}");
            let url = "{{ route('guestbook.store') }}";
            const id = fd.get('id');

            let isEditMode = id || false;

            if(isEditMode){
                fd.append('_method', 'PUT');
                url = "{{ route('guestbook.update',"_id") }}";
                url = url.replace('_id', id);
            }

            $.ajax({
                type: 'POST',
                url,
                data: fd,
                processData: false,
                contentType:false,
                success: function (response) {
                    if(response.status){
                        Toast.fire({
                            icon: 'success',
                            title: '&nbsp;'+response.msg,
                        })

                        if(isEditMode){
                            $('#modal').modal('hide');
                        }

                        resetModal();
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
        
        // ON DELETE
        $('table').on('click', '.delete', function(e){
            e.preventDefault();
            const rowData = dttable.row($(this).parents('tr')).data();
            const id = rowData['id'];
            let url = "{{ route('guestbook.destroy', "_id") }}";
            url = url.replace('_id', id);

            Swal.fire({
                title: 'Are you sure ?',
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

        // ON EDITING
        $('table').on('click', '.edit', function(e){
            e.preventDefault();
            const rowData = dttable.row($(this).parents('tr')).data();
            const id = rowData['id'];

            //fill form editing
            $.each(rowData, function (i, v) { 
                if (i === 'selfie') {
                    addImageContainerEl(v);
                    return;
                }
                $('input[name='+i+']').val(v);
                $('select[name='+i+']').val(v);
            });
            
            $('#modal-mode').text('Edit data');
            $('#id').val(id);
            $('#modal').modal('show');
        });

        //ON SHOWING MODAL
        $('table').on('click', '.show', function(e){
            e.preventDefault();
            const rowData = dttable.row($(this).parents('tr')).data();
            const id = rowData['id'];

            //fill form
            $.each(rowData, function (i, v) { 
                if (i === 'selfie') {
                    addImageContainerEl(v);
                    $('#fileImg').parent().css('display', 'none');
                    return;
                }
                $('input[name='+i+']').val(v).prop('disabled', true);
                $('select[name='+i+']').val(v).prop('disabled', true).trigger('change');
            });
            
            $('.submit').css('display','none');
            $('#modal-mode').text('View Data');
            $('#id').val('');
            $('#modal').modal('show');
        });

        //ON MODAL HIDDEN close switch to adding and reset form
        $('#modal').on('hidden.bs.modal', function(e){
            resetModal();
        });

        //autofocus first field ON MODAL OPEN
        $('#modal').on('shown.bs.modal', function(e){
            $('input:text:visible:first').focus();
        });

        function addImageContainerEl(v) {
            let el = '<div class="form-group" id="img-container">';
                el += v;
                el += '</div>';
            $('.form-group').last().after(el);
            $('#img-container>img').attr('width', '300rem');
        }

        function resetModal(){
            $('#modal-mode').text('Add a new data');
            $('form').trigger('reset');
            $('form input').prop('disabled', false);
            $('#fileImg').parent().css('display', 'inline-block');
            $('#img-container').remove();
            $('#warning-on-edit').remove();
            $('.submit').css('display', 'inline-block');
            $('#id').val(null);
            $('#fileImg').next('.custom-file-label').html('Choose a file'); //reset the "Choose a file" label
            dttable.ajax.reload(null, false);
        }

        $("#modal").keyup(function(event) {
            if (event.keyCode === 13) {
                $(".submit").click();
            }
        });
    }); // end function ready
</script>
@endpush