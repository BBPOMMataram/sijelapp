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
                                data-target="#modaldetailterimasampel">+</button>
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="terimasampel" class="table table-bordered table-striped w-100">
                                <thead>
                                    <tr>
                                        <th class="align-middle">No</th>
                                        <th class="align-middle">Jenis Produk</th>
                                        <th class="align-middle">Parameter Uji</th>
                                        <th class="align-middle">Jumlah Pengujian</th>
                                        <th class="align-middle">Biaya</th>
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
@include('modals.master.detailterimasampel')
@endsection
@push('scripts')
<script>
    var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000
            });

    const dttable = $("#terimasampel").DataTable({
        serverside: true,
        select: true,
        ajax: {
            url: "{{ route('dtdetailterimasampel', $id) }}"
        },
        columns: [
            {data: 'DT_RowIndex'},
            {data: 'nama_produk', render: function(data, type, row){ return row.kode_sampel ? data + ' (' + row.kode_sampel + ')' : data}},
            {data: 'ujiproduk', render: function(data, type, row){
                let res = '';
                for (const key in data) {
                    if(data[key].parameter){
                        res += data[key].parameter.parameter_uji+'<br />';
                    }else{
                        res += 'not found <br />';
                    }
                }
                return res;
                }},
            {data: 'ujiproduk', render: function(data, type, row){
                let res = '';
                for (const key in data) {
                    res += '<tr>'+data[key].jumlah_pengujian+'</tr><br />';
                }
                return res;
                }},
            {data: 'ujiproduk', render: function(data, type, row){
                let res = '';
                for (const key in data) {
                    if(data[key].parameter){
                        res += '<tr>'+data[key].parameter.metodeuji.biaya * data[key].jumlah_pengujian+'</tr><br />';
                    }else{
                        res += 'not found <br />';
                    }
                }
                return res;
                }},
            {data: 'actions', className: 'text-center align-middle'},
        ]
    });

    //delete parameter in list modal
    function deleteparameteruji(val, id_produk_sampel){
        let url = "{{ route('deleteparameteruji', "_id") }}";
        url = url.replace('_id', val);

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
                updateList(id_produk_sampel);
            }
        });
    }

    function updateList(idProdukSampel){
        let urlParameterUji = "{{ route('datadetailparameteruji', "_idProd") }}"
        urlParameterUji = urlParameterUji.replace('_idProd', idProdukSampel);
        $.ajax({
            type: "GET",
            url: urlParameterUji,
            success: function (res) {
                $('#listparameteruji').empty();
                let list = '';
                for (const key in res) {
                    if(res[key].parameter){
                        list += '<li>'+res[key].parameter.parameter_uji+'('+res[key].jumlah_pengujian+') <i onclick="deleteparameteruji('+ res[key].id_uji_produk +','+ idProdukSampel +')" class="fas fa-trash text-danger" style="cursor:pointer;"></i></li>';
                    }else{
                        list += '<li>Not found('+res[key].jumlah_pengujian+') <i onclick="deleteparameteruji('+ res[key].id_uji_produk +','+ id_produk_sampel +')" class="fas fa-trash text-danger" style="cursor:pointer;"></i></li>';
                    }
                }
                $('#listparameteruji').append('<ol>'+ list +'</ol>');
            }
        });
    }

    $(function () {
        fillparameteruji();

        //when submit adding
        $('#modaldetailterimasampel').on('click', '.submit.adding', function(evt){
            evt.preventDefault();

            let fd = new FormData($('form')[0]);
            fd.append('_token', "{{ csrf_token() }}");
            const url = "{{ route('detailterimasampel.store', $id) }}";

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
                            title: '&nbsp;' + response.msg,
                        })
                        // $('#modaldetailterimasampel').modal('hide');
                        const btnSubmit = $('button.submit');
                        btnSubmit.prop('disabled', true)
                        btnSubmit.removeClass('adding');
                        $('#id').val(response.newId);
                        $('#nama_produk').prop('disabled', true);
                        $('#kode_sampel').prop('disabled', true);
                        $('#addparameteruji').click();
                        dttable.ajax.reload(null, false);
                    }else{
                        Toast.fire({
                            icon: 'error',
                            title: '&nbsp;' + response.msg,
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
            const id = rowData['id_produk_sampel'];
            let url = "{{ route('detailterimasampel.destroy', "_id") }}";
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
            const id = rowData['id_produk_sampel'];

            $('#modaldetailterimasampel').modal('show');

            //fill form
            $.each(rowData, function (i, v) { 
                 $('input[name='+i+']').val(v).prop('disabled', true);
                 $('select[name='+i+']').val(v).prop('disabled', true).trigger('change');
                 if (i === 'ujiproduk') {
                    let list = '';
                    for (const key in v) {
                        if(v[key].parameter){
                            list += '<li>'+v[key].parameter.parameter_uji+'('+v[key].jumlah_pengujian+') <i onclick="deleteparameteruji('+ v[key].id_uji_produk +','+ id +')" class="fas fa-trash text-danger" style="cursor:pointer;"></i></li>';
                        }else{
                            list += '<li>Not found('+v[key].jumlah_pengujian+') <i onclick="deleteparameteruji('+ v[key].id_uji_produk +','+ id +')" class="fas fa-trash text-danger" style="cursor:pointer;"></i></li>';
                        }
                    }
                    $('#listparameteruji').append('<ol>'+ list +'</ol>');
                }
            });
            $('.submit').css('display', 'none')
            $('.modal-title').text('Detail data');

            //special for detailterimasampel
            $('#addparameteruji').prop('disabled', true);
            $('input[name="jumlah_pengujian"]').prop('disabled', true);
            $('select[name="id_parameter"]').prop('disabled', true).trigger('change');

        });

        //show modal for editing
        $('table').on('click', '.edit', function(e){
            e.preventDefault();
            const rowData = dttable.row($(this).parents('tr')).data();
            const id = rowData['id_produk_sampel'];

            $('#modaldetailterimasampel').modal('show');
            //switch to editing mode
            $('#modaldetailterimasampel .submit').addClass('editing');
            $('#modaldetailterimasampel .submit').removeClass('adding');

            //fill form editing
            $.each(rowData, function (i, v) { 
                $('input[name='+i+']').val(v);
                $('select[name='+i+']').val(v).trigger('change');
                if (i === 'ujiproduk') {
                    let list = '';
                    for (const key in v) {
                        if(v[key].parameter){
                            list += '<li>'+v[key].parameter.parameter_uji+'('+v[key].jumlah_pengujian+') <i onclick="deleteparameteruji('+ v[key].id_uji_produk +','+ id +')" class="fas fa-trash text-danger" style="cursor:pointer;"></i></li>';
                        }else{
                            list += '<li>Not found('+v[key].jumlah_pengujian+') <i onclick="deleteparameteruji('+ v[key].id_uji_produk +','+ id +')" class="fas fa-trash text-danger" style="cursor:pointer;"></i></li>';
                        }
                    }
                    $('#listparameteruji').append('<ol>'+ list +'</ol>');
                }
            });
            $('#id').val(id);
            $('.modal-title').text('Ubah Data');
        });

        //when submit editing
        $('#modaldetailterimasampel').on('click', '.submit.editing', function(e){
            e.preventDefault();

            let fd = new FormData($('form')[0]);
            fd.append('_method', 'PUT');
            fd.append('_token', '{{ csrf_token() }}');

            let url = "{{ route('detailterimasampel.update',"_id") }}";
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
                        $('#modaldetailterimasampel').modal('hide');
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

        // add parameter in list
        $('#modaldetailterimasampel').on('click', '#addparameteruji', function(e){
            e.preventDefault();

            const btnSubmit = $('button.submit');
            if(btnSubmit.hasClass('adding')){
                $(btnSubmit).click();
                return 0;
            }
            
            let fd = new FormData($('form')[0]);
            fd.append('_token', "{{ csrf_token() }}");
            
            const idProdukSampel = fd.get('id');
            let url = "{{ route('storeparameteruji', "_idProdukSampel") }}";
            url = url.replace('_idProdukSampel', idProdukSampel);

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
                    dttable.ajax.reload(null, false);
                    updateList(idProdukSampel);
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
        })

        //when modal close switch to adding and reset form
        $('#modaldetailterimasampel').on('hidden.bs.modal', function(e){
            $('#modaldetailterimasampel .submit').addClass('adding');
            $('#modaldetailterimasampel .submit').removeClass('editing');

            $(this).find('form').trigger('reset');
            $(this).find('form input').prop('disabled', false);
            $(this).find('form .select2').prop('disabled', false);
            $(this).find('#listparameteruji').empty();
            $('.submit').css('display', 'inline-block')
            $('.modal-title').text('Form Tambah Data');

            //special for detailterimasampel
            $('#addparameteruji').prop('disabled', false);
            $('input[name="jumlah_pengujian"]').prop('disabled', false);
            $('select[name="id_parameter"]').prop('disabled', false).trigger('change');
            $('#id').val('')
            $('button.submit').prop('disabled', false)

        });

        //when modal open autofocus first field
        $('#modaldetailterimasampel').on('shown.bs.modal', function(e){
            $('input:text:visible:first').focus();
        });

        //fill select kategori
        function fillparameteruji() {
            $.ajax({
                type: "GET",
                url: "{{ route('dtparameteruji') }}",
                success: function (response) {
                    $("#id_parameter").append("<option value=''>==Pilih Parameter Uji==</option>"); 
                    var len = 0;
                    if(response['data'] != null){
                        len = response['data'].length;
                    }

                    if(len > 0){
                        // Read data and create <option >
                        for(var i=0; i<len; i++){

                        var id = response['data'][i].id_parameter;
                        var paramteruji = response['data'][i].parameter_uji;

                        var option = "<option value='"+id+"'>"+paramteruji+"</option>";
                            
                        $("#id_parameter").append(option); 
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