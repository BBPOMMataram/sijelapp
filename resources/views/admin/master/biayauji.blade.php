@extends('layouts.admin.app')

@section('content')
<!-- Main content -->
<section class="content">
    <h1>BELUM JADIII, SABAARRR</h1>
    {{-- <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#modalbiayauji">+</button>
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="biayauji" class="table table-bordered table-striped w-100">
                                <thead>
                                    <tr>
                                        <th class="align-middle">No</th>
                                        <th class="align-middle">Jenis Produk</th>
                                        <th class="align-middle">Parameter Uji</th>
                                        <th class="align-middle">Metode</th>
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
    </div><!-- /.container-fluid --> --}}
</section>
<!-- /.content -->
@include('modals.master.biayauji')
@endsection
@push('scripts')
<script>
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000
    });

    const dttable = $("#biayauji").DataTable({
        select: true,
        serverSide: true,
        select: true,
        ajax: {
            url: "{{ route('dtbiayauji') }}"
        },
        columns: [
            {data: 'DT_RowIndex', searchable: false, orderable: false},
            // {data: 'parameter_uji'},
            // {data: 'metodeuji.metode'},
            // {data: 'metodeuji.kode_layanan'},
            // {data: 'metodeuji.biaya', render: $.fn.dataTable.render.number(',', null, null, 'Rp. ')},
            {data: 'actions', className: 'text-center align-middle'},
        ]
    });
    
    // function filljenisproduk() {
    //     $.ajax({
    //         type: "GET",
    //         url: "{{ route('dtjenissampel') }}",
    //         success: function (response) {
    //             $("#jenisproduk").append("<option value=''>==Pilih Jenis Produk==</option>"); 
    //             var len = 0;
    //             if(response['data'] != null){
    //                 len = response['data'].length;
    //             }

    //             if(len > 0){
    //                 // Read data and create <option >
    //                 for(var i=0; i<len; i++){

    //                 var id = response['data'][i].id;
    //                 var nama_sampel = response['data'][i].nama_sampel;

    //                 var option = "<option value='"+id+"'>"+nama_sampel+"</option>";
                        
    //                 $("#jenisproduk").append(option); 
    //                 }
    //             }
    //         }
    //     });
    // }

    $(function () {
        fillmetodeuji();
        // filljenisproduk();

        $('#jenisproduk').select2()

        $('#addjenisproduk').click(function(e){
            e.preventDefault();
            const newdata = $("#jenisproduk").data('select2').selection.$("#jenisproduk").val()
            alert(newdata);
        });

        //when submit adding
        $('#modalbiayauji').on('click', '.submit.adding', function(evt){
            evt.preventDefault();

            let fd = new FormData($('form')[0]);
            fd.append('_token', "{{ csrf_token() }}");
            const url = "{{ route('biayauji.store') }}";

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
                    $('#modalbiayauji').modal('hide');
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
            let url = "{{ route('biayauji.destroy', "_id") }}";
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

            $('#modalbiayauji').modal('show');

            //fill form
            $('#namaparameter').val(rowData['parameter_uji']).prop('disabled', true);
            $('#metode').val(rowData['id_kode_layanan']).prop('disabled', true).trigger('change');
            $('.submit').css('display', 'none')
            $('.modal-title').text('Detail data');
            // $('#id').val(id);
        });


        //show modal for editing
        $('table').on('click', '.edit', function(e){
            e.preventDefault();
            const rowData = dttable.row($(this).parents('tr')).data();
            const id = rowData['id_parameter'];

            $('#modalbiayauji').modal('show');
            //switch to editing mode
            $('#modalbiayauji .submit').addClass('editing');
            $('#modalbiayauji .submit').removeClass('adding');

            //fill form editing
            $('#namaparameter').val(rowData['parameter_uji']);
            $('#metode').val(rowData['id_kode_layanan']).trigger('change');
            $('#id').val(id);
            $('.modal-title').text('Ubah Data');
        });

        //when submit editing
        $('#modalbiayauji').on('click', '.submit.editing', function(e){
            e.preventDefault();

            let fd = new FormData($('form')[0]);
            fd.append('_method', 'PUT');
            fd.append('_token', '{{ csrf_token() }}');

            let url = "{{ route('biayauji.update',"_id") }}";
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
                        $('#modalbiayauji').modal('hide');
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
        $('#modalbiayauji').on('hidden.bs.modal', function(e){
            $('#modalbiayauji .submit').addClass('adding');
            $('#modalbiayauji .submit').removeClass('editing');

            $(this).find('form').trigger('reset');
            $(this).find('form input').prop('disabled', false);
            $(this).find('form .select2').prop('disabled', false);
            $(this).find('.select2').val('').trigger('change')
            $('.submit').css('display', 'inline-block')
            $('.modal-title').text('Form Tambah Data');
        });

        //when modal open autofocus first field
        $('#modalbiayauji').on('shown.bs.modal', function(e){
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