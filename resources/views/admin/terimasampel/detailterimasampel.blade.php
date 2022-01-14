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
                            <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                data-target="#modaldetailterimasampel"><i class="fa fa-plus"></i></button>
                        </h3>
                        <div class="card-tools">
                            <ul class="nav nav-pills ml-auto">
                                    {{-- <li class="nav-item mr-1">
                                    <a target="_blank" href="{{ route('print.basegel', $id) }}" class="btn btn-light"><i class="fas fa-print mr-1"></i>BA Segel</a>
                                    </li> --}}
                                <li class="nav-item mr-1">
                                  <a target="_blank" href="{{ route('print.kajiulang', $id) }}" class="btn btn-light"><i class="fas fa-print mr-1"></i>Kaji Ulang</a>
                                </li>
                                <li class="nav-item mr-3">
                                  <a target="_blank" href="{{ route('print.fplp', $id) }}" class="btn btn-light"><i class="fas fa-print mr-1"></i>FPLP</a>
                                </li>
                            </ul>
                          </div>
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
                                        <th class="align-middle">Nomor Surat</th>
                                        <th class="align-middle">Tgl Surat</th>
                                        <th class="align-middle">Tersangka</th>
                                        <th class="align-middle">Hasil Uji</th>
                                        <th class="align-middle">Saksi Ahli</th>
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
@include('modals.terimasampel.detailterimasampel')
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
        "drawCallback": function(settings){
            tippy('.basegel', {
                content: 'BA Pembukaan Segel',
                trigger: 'mouseenter',
                animation: 'scale',
            });

            tippy('.bapenimbangan', {
                content: 'BA Penimbangan',
                trigger: 'mouseenter',
                animation: 'scale',
            })

            tippy('.downloadlhu', {
                content: 'Download LHU',
                trigger: 'mouseenter',
                animation: 'scale',
            })

            tippy('.edit', {
                content: 'Edit',
                trigger: 'mouseenter',
                animation: 'scale',
            })
        },
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
            {data: 'nomor_surat', render: function(data, type, row){ return data ? data : '-'; }},
            {data: 'tanggal_surat'},
            {data: 'tersangka', render: function(data, type, row){ return data ? data : '-'; }},
            {data: 'hasil_uji', render: function(data, type, row){ return data ? data : '-'; }},
            {data: 'user.name', render: function(data, type, row){ return data ? data : '-'; }},
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
                updateListEdit(id_produk_sampel);
            }
        });
    }

    function updateListEdit(idProdukSampel){
        let urlParameterUji = "{{ route('datadetailparameteruji', "_idProd") }}"
        urlParameterUji = urlParameterUji.replace('_idProd', idProdukSampel);
        $.ajax({
            type: "GET",
            url: urlParameterUji,
            success: function (res) {
                $('#listparameterujiedit').empty();
                let list = '';
                for (const key in res) {
                    if(res[key].parameter){
                        list += '<li>'+res[key].parameter.parameter_uji+'('+res[key].parameter.metodeuji.metode+')'+'('+res[key].jumlah_pengujian+') <i onclick="deleteparameteruji('+ res[key].id_uji_produk +','+ idProdukSampel +')" class="fas fa-trash text-danger" style="cursor:pointer;"></i></li>';
                    }else{
                        list += '<li>Not found('+res[key].jumlah_pengujian+') <i onclick="deleteparameteruji('+ res[key].id_uji_produk +','+ id_produk_sampel +')" class="fas fa-trash text-danger" style="cursor:pointer;"></i></li>';
                    }
                }
                $('#listparameterujiedit').append('<ol>'+ list +'</ol>');
            }
        });
    }

    function updateList(p_uji, j_uji, p_uji_text){
        let data = '<div class="col-12 form-group row">';
            data += '<input type="hidden" name="p_uji[]" value="'+p_uji+'" />';
            data += '<div class="col-10">';
            data += '<input class="form-control" value="'+p_uji_text+'" readonly/>';
            data += '</div>';
            data += '<div class="col-1">';
            data += '<input name="j_uji[]" class="form-control" value="'+j_uji+'" readonly/>';
            data += '</div>';
            data += '<div class="col-1">';
            data += '<button class="btn btn-danger delete"><i class="fa fa-trash"></i></button>';
            data += '</div>';
            data += '</div>';

        $('#listparameteruji').append(data);
    }

    function filljenissampel() {
        $.ajax({
            type: "GET",
            url: "{{ route('dtdetailterimasampel', $id) }}",
            success: function (response) {
                // $("#jenisproduk").append("<option value=''>==Pilih Jenis Produk==</option>"); 
                $("#jenisproduk").empty();
                var len = 0;
                if(response['data'] != null){
                    len = response['data'].length;
                }

                if(len > 0){
                    // Read data and create <option >
                    for(var i=0; i<len; i++){

                    var id = response['data'][i].id_produk_sampel;
                    var namaproduk = response['data'][i].nama_produk;

                    var option = "<option value='"+id+"'>"+namaproduk+"</option>";

                    //when array ujiproduk is empty
                    if (response['data'][i].ujiproduk && response['data'][i].ujiproduk.length) {
                        continue;
                    }
                    $("#jenisproduk").append(option); 
                    }
                }
            }
        });
    }

    $(function () {
        fillparameteruji();
        // filljenissampel();

        $('#listparameteruji').on('click', '.delete', function(e){
            e.preventDefault();

            $(this).closest('.row').remove();
        })

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
                        $('#modaldetailterimasampel').modal('hide');
                        // const btnSubmit = $('button.submit');
                        // btnSubmit.prop('disabled', true)
                        // btnSubmit.removeClass('adding');
                        // $('#id').val(response.newId);
                        // $('#nama_produk').prop('disabled', true);
                        // $('#kode_sampel').prop('disabled', true);
                        // $('#addparameteruji').click();
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

            //switch to editing mode for parameteruji
            $('#addparameteruji').addClass('edit');
            $('#addparameteruji').removeClass('add');

            //hide multiple select2 jenisproduk
            $('#jenisproduk').select2('destroy');
            $('#jenisproduk').addClass('d-none');


            // const jenisprodukediting = '<div id="jenisprodukediting" class="font-weight-bold">'+ rowData['nama_produk'] +'</div>';
            const jenisprodukediting = '<input id="jenisprodukediting" name="nama_produk" class="form-control" value="'+rowData['nama_produk'] +'" />';
            $('#jenisproduk').after(jenisprodukediting);

            //fill form editing
            $.each(rowData, function (i, v) { 
                $('input[name='+i+']').val(v);
                $('select[name='+i+']').val(v).trigger('change');
                if (i === 'ujiproduk') {
                    let list = '';
                    for (const key in v) {
                        if(v[key].parameter){
                            list += '<li>'+v[key].parameter.parameter_uji+'('+v[key].parameter.metodeuji.metode+')'+'('+v[key].jumlah_pengujian+') <i onclick="deleteparameteruji('+ v[key].id_uji_produk +','+ id +')" class="fas fa-trash text-danger" style="cursor:pointer;"></i></li>';
                        }else{
                            list += '<li>Not found('+v[key].jumlah_pengujian+') <i onclick="deleteparameteruji('+ v[key].id_uji_produk +','+ id +')" class="fas fa-trash text-danger" style="cursor:pointer;"></i></li>';
                        }
                    }
                    $('#listparameterujiedit').append('<ol>'+ list +'</ol>');
                }
            });

            $('#tanggal_surat').val(rowData['tanggal_surat']);
            $('#berat').val(rowData['berat']);
            
            $('#id').val(id);
            $('.modal-title').text('Ubah Data');
            // $('button.submit').addClass('d-none');
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
                        // $('#modaldetailterimasampel').modal('hide');
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
        $('#modaldetailterimasampel').on('click', '#addparameteruji.edit', function(e){
            e.preventDefault();

            // const btnSubmit = $('button.submit');
            // if(btnSubmit.hasClass('adding')){
            //     $(btnSubmit).click();
            //     return 0;
            // }
            
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
                    updateListEdit(idProdukSampel);
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

        $('#modaldetailterimasampel').on('click', '#addparameteruji.add', function(e){
            e.preventDefault();
            const p_uji = $('#id_parameter').val();
            const p_uji_text = $('#id_parameter').select2('data')[0].text;
            const j_uji = $('#jumlah_pengujian').val();
            updateList(p_uji, j_uji, p_uji_text);
        });

        //when modal close switch to adding and reset form
        $('#modaldetailterimasampel').on('hidden.bs.modal', function(e){
            $('#modaldetailterimasampel .submit').addClass('adding');
            $('#modaldetailterimasampel .submit').removeClass('editing');

            $(this).find('form').trigger('reset');
            $(this).find('form input').prop('disabled', false);
            $(this).find('form .select2').prop('disabled', false);
            $(this).find('#listparameteruji').empty();
            $(this).find('#listparameterujiedit').empty();
            $('.submit').css('display', 'inline-block')
            $('.modal-title').text('Form Tambah Data');

            //special for detailterimasampel
            $('#addparameteruji').prop('disabled', false);
            $('input[name="jumlah_pengujian"]').prop('disabled', false);
            $('select[name="id_parameter"]').prop('disabled', false).trigger('change');
            $('#id').val('')
            $('button.submit').prop('disabled', false)

            // return select2
            $('#jenisproduk').select2({
                width: 'resolve'
            });
            $('#jenisprodukediting').remove();

            $('#addparameteruji').removeClass('edit')
            $('#addparameteruji').addClass('add')
            $('button.submit').removeClass('d-none');
        });

        //when modal open autofocus first field
        $('#modaldetailterimasampel').on('shown.bs.modal', function(e){
            $('input:text:visible:first').focus();
            filljenissampel();
        });

        //fill select kategori
        function fillparameteruji() {
            $.ajax({
                type: "GET",
                url: "{{ route('dtparameteruji') }}",
                success: function (response) {
                    // $("#id_parameter").append("<option value=''>==Pilih Parameter Uji==</option>"); 
                    var len = 0;
                    if(response['data'] != null){
                        len = response['data'].length;
                    }

                    if(len > 0){
                        // Read data and create <option >
                        for(var i=0; i<len; i++){

                        var id = response['data'][i].id_parameter;
                        var paramteruji = response['data'][i].parameter_uji;
                        var metode = response['data'][i].metodeuji.metode;

                        var option = "<option value='"+id+"'>"+paramteruji+" ("+metode+")"+"</option>";
                            
                        $("#id_parameter").append(option); 
                        }
                    }
                }
            });
        }

        $('.select2, .select2multiple').select2({
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

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #017AFC;
    }
</style>
@endpush