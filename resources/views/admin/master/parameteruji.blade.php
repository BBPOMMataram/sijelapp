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
                                data-target="#modalparameteruji">+</button>
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="parameteruji" class="table table-bordered table-striped w-100">
                                <thead>
                                    <tr>
                                        <th class="align-middle">No</th>
                                        <th class="align-middle">Parameter Uji</th>
                                        <th class="align-middle">Metode</th>
                                        <th class="align-middle">Kode</th>
                                        <th class="align-middle">Kode</th>
                                        <th class="align-middle">Biaya (Rp)</th>
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
@include('modals.master.parameteruji')
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

        const dttable = $("#parameteruji").DataTable({
            select: true,
            serverSide: true,
            select: true,
            ajax: {
                url: "{{ route('dtparameteruji') }}"
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, orderable: false},
                {data: 'parameter_uji'},
                {data: 'metodeuji.metode'},
                {data: 'kode'},
                {data: 'metodeuji.kode_layanan'},
                {data: 'metodeuji.biaya', render: $.fn.dataTable.render.number(',', null, null, 'Rp. ')},
                {data: 'actions', className: 'text-center align-middle'},
            ]
        });

        fillmetodeuji();

        //when submit adding
        $('#modalparameteruji').on('click', '.submit.adding', function(evt){
            evt.preventDefault();

            let fd = new FormData($('form')[0]);
            fd.append('_token', "{{ csrf_token() }}");
            const url = "{{ route('parameteruji.store') }}";

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
                    $('#modalparameteruji').modal('hide');
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
            const id = rowData['id_parameter'];
            let url = "{{ route('parameteruji.destroy', "_id") }}";
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
            const id = rowData['id_parameter'];

            $('#modalparameteruji').modal('show');

            //fill form
            $('#namaparameter').val(rowData['parameter_uji']).prop('disabled', true);
            $('#metode').val(rowData['id_kode_layanan']).prop('disabled', true).trigger('change');
            $('#kode').val(rowData['kode']).prop('disabled', true);
            $('.submit').css('display', 'none')
            $('.modal-title').text('Detail data');
            // $('#id').val(id);
        });


        //show modal for editing
        $('table').on('click', '.edit', function(e){
            e.preventDefault();
            const rowData = dttable.row($(this).parents('tr')).data();
            const id = rowData['id_parameter'];

            $('#modalparameteruji').modal('show');
            //switch to editing mode
            $('#modalparameteruji .submit').addClass('editing');
            $('#modalparameteruji .submit').removeClass('adding');

            //fill form editing
            $('#namaparameter').val(rowData['parameter_uji']);
            $('#metode').val(rowData['id_kode_layanan']).trigger('change');
            $('#kode').val(rowData['kode']);
            $('#id').val(id);
            $('.modal-title').text('Ubah Data');
        });

        //when submit editing
        $('#modalparameteruji').on('click', '.submit.editing', function(e){
            e.preventDefault();

            let fd = new FormData($('form')[0]);
            fd.append('_method', 'PUT');
            fd.append('_token', '{{ csrf_token() }}');

            let url = "{{ route('parameteruji.update',"_id") }}";
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
                        $('#modalparameteruji').modal('hide');
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
        $('#modalparameteruji').on('hidden.bs.modal', function(e){
            $('#modalparameteruji .submit').addClass('adding');
            $('#modalparameteruji .submit').removeClass('editing');

            $(this).find('form').trigger('reset');
            $(this).find('form input').prop('disabled', false);
            $(this).find('form select').prop('disabled', false);
            $(this).find('form .select2').prop('disabled', false);
            $(this).find('.select2').val('').trigger('change')
            $('.submit').css('display', 'inline-block')
            $('.modal-title').text('Form Tambah Data');
        });

        //when modal open autofocus first field
        $('#modalparameteruji').on('shown.bs.modal', function(e){
            $('input:text:visible:first').focus();
        });

        //fill select data metode
        function fillmetodeuji() {
            $.ajax({
                type: "GET",
                url: "{{ route('dtmetodeuji') }}",
                success: function (response) {
                    $("#metode").append("<option value=''>==Pilih Metode Uji==</option>"); 
                    var len = 0;
                    if(response['data'] != null){
                        len = response['data'].length;
                    }

                    if(len > 0){
                        // Read data and create <option >
                        for(var i=0; i<len; i++){

                        var id = response['data'][i].id_kode_layanan;
                        var metode = response['data'][i].metode;

                        var option = "<option value='"+id+"'>"+metode+"</option>";
                            
                        $("#metode").append(option); 
                        }
                    }
                }
            });
        }

        $('.select2').select2({
            width: 'resolve'
        });
        
    }); // end doc ready
</script>
@endpush
@push('styles')
    <style>
        /* for select2 */
        span.select2 {
            width: 100% !important;
        }
        .select2-container .select2-selection--single {
            height: inherit;
        }
    </style>
@endpush