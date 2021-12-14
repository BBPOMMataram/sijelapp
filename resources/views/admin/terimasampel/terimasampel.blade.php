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
                        <h3 class="card-title w-100">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#modalterimasampel">+</button>
                            {{-- <label for="id_kategori_filter">Kategori</label> --}}
                            <select type="text" id="id_kategori_filter" name="id_kategori_filter"
                                class="select2"></select>
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="terimasampel" class="table table-bordered table-striped w-100">
                                <thead>
                                    <tr>
                                        <th class="align-middle">No Urut Penerimaan</th>
                                        <th class="align-middle">Kategori</th>
                                        <th class="align-middle">Pemilik Sampel</th>
                                        <th class="align-middle">Kode Sampel</th>
                                        <th class="align-middle">Nama</th>
                                        <th class="align-middle">Kemasan</th>
                                        <th class="align-middle">Berat</th>
                                        <th class="align-middle">Jumlah</th>
                                        <th class="align-middle">Tanggal Terima</th>
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
@include('modals.terimasampel.terimasampel')
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

        const dttable = $("#terimasampel").DataTable({
            // responsive: true,
            serverside: true,
            select: true,
            ordering: false,
            ajax: {
                url: "{{ route('dtterimasampel') }}"
            },
            columns: [
                {data: 'no_urut'},
                {data: 'kategori.nama_kategori'},
                {data: 'pemiliksampel.nama_pemilik'},
                {data: 'kode_sampel'},
                {data: 'nama_sampel'},
                {data: 'kemasan_sampel'},
                {data: 'berat_sampel'},
                {data: 'jumlah_sampel'},
                {data: 'created_at'},
                {data: 'actions', className: 'text-center align-middle'},
                {data: 'id_kategori', visible: false},
            ],
            "drawCallback": function(settings){
                tippy('.delete', {
                    content: 'Delete',
                    trigger: 'mouseenter',
                    animation: 'scale',
                });

                tippy('.edit', {
                    content: 'Edit',
                    trigger: 'mouseenter',
                    animation: 'scale',
                });

                tippy('.show', {
                    content: 'View',
                    trigger: 'mouseenter',
                    animation: 'scale',
                })
            },
        });

        fillkategori();
        fillpengirim();

        //when submit adding
        $('#modalterimasampel').on('click', '.submit.adding', function(evt){
            evt.preventDefault();

            let fd = new FormData($('form')[0]);
            fd.append('_token', "{{ csrf_token() }}");
            const url = "{{ route('terimasampel.store') }}";

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
                    $('#modalterimasampel').modal('hide');
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
            console.log(rowData);
            const id = rowData['id_permintaan'];
            let url = "{{ route('terimasampel.destroy', "_id") }}";
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
            // const id = rowData['id_pemilik'];

            $('#modalterimasampel').modal('show');

            //fill form
            $.each(rowData, function (i, v) { 
                 $('input[name='+i+']').val(v).prop('disabled', true);
                 $('select[name='+i+']').val(v).prop('disabled', true).trigger('change');
            });

            $('.submit').css('display', 'none')
            $('.modal-title').text('Detail data');
            // $('#id').val(id);
        });

        //show modal for editing
        $('table').on('click', '.edit', function(e){
            e.preventDefault();
            const rowData = dttable.row($(this).parents('tr')).data();
            const id = rowData['id_permintaan'];

            $('#modalterimasampel').modal('show');
            //switch to editing mode
            $('#modalterimasampel .submit').addClass('editing');
            $('#modalterimasampel .submit').removeClass('adding');

            //fill form editing
            $.each(rowData, function (i, v) { 
                 $('input[name='+i+']').val(v);
                 $('select[name='+i+']').val(v).trigger('change');
            });
            $('#id').val(id);
            $('.modal-title').text('Ubah Data');
        });

        //when submit editing
        $('#modalterimasampel').on('click', '.submit.editing', function(e){
            e.preventDefault();

            let fd = new FormData($('form')[0]);
            fd.append('_method', 'PUT');
            fd.append('_token', '{{ csrf_token() }}');

            let url = "{{ route('terimasampel.update',"_id") }}";
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
                        $('#modalterimasampel').modal('hide');
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
        $('#modalterimasampel').on('hidden.bs.modal', function(e){
            $('#modalterimasampel .submit').addClass('adding');
            $('#modalterimasampel .submit').removeClass('editing');

            $(this).find('form').trigger('reset');
            $(this).find('form input').prop('disabled', false);
            $(this).find('form .select2').prop('disabled', false);
            $('.submit').css('display', 'inline-block')
            $('.modal-title').text('Form Tambah Data');
        });

        //when modal open autofocus first field
        $('#modalterimasampel').on('shown.bs.modal', function(e){
            $('input:text:visible:first').focus();
        });

        //fill select kategori
        function fillkategori() {
            $.ajax({
                type: "GET",
                url: "{{ route('dtkategori') }}",
                success: function (response) {
                    $("#id_kategori").append("<option value=''>==Pilih Kategori==</option>"); 
                    $("#id_kategori_filter").append("<option value=''>==Pilih Kategori==</option>"); 
                    var len = 0;
                    if(response['data'] != null){
                        len = response['data'].length;
                    }

                    if(len > 0){
                        // Read data and create <option >
                        for(var i=0; i<len; i++){

                        var id = response['data'][i].id_kategori;
                        var namakategori = response['data'][i].nama_kategori;

                        var option = "<option value='"+id+"'>"+namakategori+"</option>";
                            
                        $("#id_kategori").append(option); 
                        $("#id_kategori_filter").append(option); 
                        }
                    }
                }
            });
        }

        //fill select pemilik sampel
        function fillpengirim() {
            $.ajax({
                type: "GET",
                url: "{{ route('dtpemiliksampel') }}",
                success: function (response) {
                    $("#id_pemilik").append("<option value=''>==Pilih Pengirim==</option>"); 
                    var len = 0;
                    if(response['data'] != null){
                        len = response['data'].length;
                    }

                    if(len > 0){
                        // Read data and create <option >
                        for(var i=0; i<len; i++){

                        var id = response['data'][i].id_pemilik;
                        var namapetugas = response['data'][i].nama_petugas;

                        var option = "<option value='"+id+"'>"+namapetugas+"</option>";
                            
                        $("#id_pemilik").append(option); 
                        }
                    }
                }
            });
        }

        $('.select2').select2({
            width: 'resolve'
        });

        $('#id_kategori_filter').change(function (e) { 
            e.preventDefault();
            const idKat = $(this).val();
            if(idKat){
                dttable.column(10).search("^"+idKat+"$", true).draw();
            }else{
                dttable.column(10).search('').draw();
            }
        });

        $('.modal').on('change', '#id_kategori', function(e){
            e.preventDefault();
            let url = "{{ route('lastnourut',"_id") }}"
            url = url.replace("_id", $(this).val());
            
            $.ajax({
                type: "GET",
                url,
                success: function (response) {
                    if(response.no_urut_penerimaan){
                        let nourut = response.no_urut_penerimaan.substring(0,3);
                        nourut = parseInt(nourut) + 1;
                        nourut = ''+nourut;
                        if(nourut.length === 1){
                            nourut = '00' + nourut;
                        }else if(nourut.length === 2){
                            nourut = '0' + nourut;
                        }
                        nourut = nourut + "{{ now()->month . now()->year }}";
                        $('#no_urut_penerimaan').val(nourut);
                    }else{
                        $('#no_urut_penerimaan').val('001' +"{{ now()->month . now()->year }}");
                    }
                }
            });
        });

        $('.modal').on('change', '#kode_sampel, #jumlah_sampel', function(e){
            e.preventDefault();
            const kodesampel = $('#kode_sampel').val();
            const jumlahsampel = $('#jumlah_sampel').val();
            
            let kode1 = kodesampel.substr(0, kodesampel.lastIndexOf('.') + 1);
            let kode2 = kodesampel.substr(kodesampel.lastIndexOf('.') + 1);
            let no = 0;
            $('#namasampel_cont').empty();
            for (let jml = 0; jml < jumlahsampel; jml++) {
                no++;
                let data = '<div class="col-sm-1"><input type="text" readonly class="form-control-plaintext text-center text-light font-weight-bold" value="'+no+'"></div><div class="col-sm-6 mb-1"><input type="text" class="form-control" name="nama_sampel_arr[]" placeholder="Nama Sampel"></div><div class="col-sm-5"><input type="text" class="form-control" name="kode_sampel_arr[]" value="'+ kode1+kode2 +'" readonly></div>';
                kode2 = parseInt(kode2) + 1;
                $('#namasampel_cont').append(data);
            }
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

    .card-title span.select2 {
        width: 200px !important;
    }

    .select2-container .select2-selection--single {
        height: inherit;
    }
</style>
@endpush