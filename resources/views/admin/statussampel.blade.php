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
                            <select type="text" id="id_status_sampel" name="id_status_sampel" class="select2"></select>
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tblstatussampel" class="table table-bordered table-striped w-100">
                                <thead>
                                    <tr>
                                        <th class="align-middle">No Urut Penerimaan</th>
                                        <th class="align-middle">Kode Sampel</th>
                                        <th class="align-middle">Instansi</th>
                                        <th class="align-middle">Nama Petugas</th>
                                        <th class="align-middle">Telepon Petugas</th>
                                        <th class="align-middle">Resi</th>
                                        <th class="align-middle">Status Sampel</th>
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
@include('modals.statussampel')
@endsection
@push('scripts')
<script>
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000
    });

    const dttable = $("#tblstatussampel").DataTable({
        "drawCallback": function(settings){
            tippy('.nextstep', {
                content: 'Next Step',
                trigger: 'mouseenter',
                animation: 'scale',
            });

            tippy('.show', {
                content: 'View',
                trigger: 'mouseenter',
                animation: 'scale',
            })
        },
        ordering: false,
        serverside: true,
        select: true,
        ajax: {
            url: "{{ route('dtstatussampel') }}"
        },
        columns: [
            {data: 'permintaan.no_urut_penerimaan'},
            {data: 'permintaan.kode_sampel'},
            {data: 'permintaan.pemiliksampel.nama_pemilik'},
            {data: 'permintaan.pemiliksampel.nama_petugas'},
            {data: 'permintaan.pemiliksampel.telepon_petugas'},
            {data: 'permintaan.resi', render: function(data){ return data ? data : '-'; }},
            {data: 'status.label'},
            {data: 'actions', className: 'text-center align-middle'},
            {data: 'id_status_sampel', visible: false},
        ],
    });

    //fill select kategori
    function fillstatussampel() {
        $.ajax({
            type: "GET",
            url: "{{ route('liststatussampel') }}",
            success: function (response) {
                $("#id_status_sampel").append("<option value=''>==Pilih Status==</option>"); 
                var len = 0;
                if(response != null){
                    len = response.length;
                }

                if(len > 0){
                    // Read data and create <option >
                    for(var i=0; i<len; i++){

                    var id = response[i].id;
                    var label = response[i].label;

                    var option = "<option value='"+id+"'>"+label+"</option>";
                        
                    $("#id_status_sampel").append(option); 
                    }
                }
            }
        });
    }

    function dtdetailterimasampel(idpermintaan){
        let url = "{{ route('dtdetailterimasampel', "_id") }}";
        url = url.replace('_id', idpermintaan);

        $("#detailterimasampel").DataTable().destroy();
        $("#detailterimasampel").DataTable({
            serverside: true,
            select: true,
            ajax: {
                url
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
                    }, className: 'text-nowrap'},
                {data: 'ujiproduk', render: function(data, type, row){
                    let res = '';
                    for (const key in data) {
                        res += data[key].jumlah_pengujian+'<br />';
                    }
                    return res;
                    }},
                {data: 'ujiproduk', render: function(data, type, row){
                    let res = '';
                    for (const key in data) {
                        if(data[key].parameter){
                            res += data[key].parameter.metodeuji.biaya * data[key].jumlah_pengujian+'<br />';
                        }else{
                            res += 'not found <br />';
                        }
                    }
                    return res;
                    }},
                {data: 'tersangka', render: function(data, type, row){ return data ? data : '-'; }},
                {data: 'saksi_ahli', render: function(data, type, row){ return data ? data : '-'; }},
            ]
        });
    }

    $(function () {
        fillstatussampel();
        $('.select2').select2();

        //show modal for show data
        $('table').on('click', '.show', function(e){
            e.preventDefault();
            const rowData = dttable.row($(this).parents('tr')).data();

            if ("{{ auth()->user()->level }}" === "2") {
                if (![4,5,6].includes(rowData['id_status_sampel'])) {
                    $('#cancelstep').addClass('d-none')
                }
            }else {
                $('#cancelstop').addClass('d-none')
            }
            
            $('#modalstatussampel').modal('show');
            //fill form
            $('#id_tracking').val(rowData['id_tracking']);
            //detail sampel
            dtdetailterimasampel(rowData['id_permintaan']);
            // data status
            $('#statussampel').text(rowData.status.label)
            //data sampel
            $('#no_urut_penerimaan').text(rowData.permintaan.no_urut_penerimaan)
            $('#kodesampel').text(rowData.permintaan.kode_sampel)
            $('#namasampel').text(rowData.permintaan.nama_sampel)
            $('#kemasansampel').text(rowData.permintaan.kemasan_sampel)
            $('#beratsampel').text(rowData.permintaan.berat_sampel)
            $('#jumlahsampel').text(rowData.permintaan.jumlah_sampel)
            // data pemilik
            $('#namapemilik').text(rowData.permintaan.pemiliksampel.nama_pemilik)
            $('#alamatpemilik').text(rowData.permintaan.pemiliksampel.alamat_pemilik)
            $('#namapetugas').text(rowData.permintaan.pemiliksampel.nama_petugas)
            $('#teleponpetugas').text(rowData.permintaan.pemiliksampel.telepon_petugas)
            // data tracking
            $('#waktuterima').text(rowData.permintaan.created_at);
            $('#waktuverifikasi').text(rowData.tanggal_verifikasi);
            $('#waktukajiulang').text(rowData.tanggal_kaji_ulang);
            $('#waktupembayaran').text(rowData.tanggal_pembayaran);
            $('#waktupengujian').text(rowData.tanggal_pengujian);
            $('#waktuselesaiuji').text(rowData.tanggal_selesai_uji);
            $('#waktulegalisir').text(rowData.tanggal_legalisir);
            $('#waktuselesai').text(rowData.tanggal_selesai);
            $('#waktudiambil').text(rowData.tanggal_diambil);
            $('#waktuestimasi').text(rowData.tanggal_estimasi);
        });

        $('table').on('click', '.nextstep', function (e) { 
            e.preventDefault();

            const rowData = dttable.row($(this).parents('tr')).data();
            const id = rowData['id_tracking'];
            let url = "{{ route('statussampel.nextstep', "_id") }}"
            url = url.replace('_id', id);
            data = {_token: "{{ csrf_token() }}"}

            const statusSampel = rowData['id_status_sampel'];
            let text = '';
            let icon = 'question';

            switch (statusSampel) {
                case 0:
                    text = 'Apakah berkas sampel sudah diverifikasi & akan dilanjutkan ke kaji ulang?'
                    break;
                case 1:
                    text = 'Apakah kaji ulang sudah selesai & siap lanjut ke pembayaran ?'
                    break;
                case 2:
                    text = '<div style="text-align: -webkit-center;"><div class="mb-1">Sudah dibayar? input tgl estimasi :</div><input type="datetime-local" class="form-control w-50" id="tglestimasi" /></div>'
                    break;
                case 3:
                    const produk = rowData.permintaan.produksampel;
                    console.log(produk, typeof(produk));
                    text = '<div>Apakah pengujian sampel sudah selesai, isi hasil uji ?</div><br>'

                    text += '<div class="row">'
                    text += '<div class="col">'
                    text += '<label for="namaproduk">Nama Produk</label>'
                    text += '</div>'
                    text += '<div class="col">'
                    text += '<label for="kodeproduk">Kode Produk</label>'
                    text += '</div>'
                    text += '<div class="col">'
                    text += '<label for="hasiluji">Hasil Uji</label><br />'
                    text += '</div>'
                    text += '</div>'
                    for (const key in produk) {
                        text += '<div class="row mb-1">'
                        text += '<div class="col">'
                        text += '<input type="text" name="namaproduk[]" class="form-control" value="'+produk[key].nama_produk+'" readonly />'
                        text += '</div>'
                        text += '<div class="col">'
                        text += '<input type="text" name="kodeproduk[]" class="form-control" value="'+produk[key].kode_sampel+'" readonly />'
                        text += '</div>'
                        text += '<div class="col">'
                        text += '<select id="hasil_uji[]" class="form-control">'
                        text += '<option>==Pilih Hasil==</option>'
                        text += '<option value="Positif">Positif</option>'
                        text += '<option value="Negatif">Negatif</option>'
                        text += '<option value="TMS">TMS</option>'
                        text += '<option value="MS">MS</option>'
                        text += '</select>'
                        text += '</div>'
                        text += '</div>'
                    }
                    break;
                case 4:
                    text = 'Apakah sudah selesai verifikasi LHU ?'
                    break;
                case 5:
                    text = 'Apakah sampel sudah dilegalisir ?'
                    break;
                case 6:
                    text = 'Apakah sampel sudah selesai ?'
                    break;
                case 7:
                    text = 'Apakah sampel sudah diambil ?';
                    // text += '<label>Nama Tersangka';
                    // text += '<input class="form-control" type="text" id="tersangka" />';
                    break;
                case 8:
                    text = 'Maaf sampel sudah diambil & selesai'
                    icon = 'warning';
                    break;
                default:
                    break;
            }
            
            
            Swal.fire({
                title: 'Konfirmasi',
                html: text,
                icon: icon,
                showCancelButton: true,
            }).then(function(val){

                if(statusSampel === 2){
                    data.tanggal_estimasi = $('#tglestimasi').val();
                }
                if(statusSampel === 3){
                    data.hasil_uji = $('#hasil_uji').val();
                }
                // if(statusSampel === 7){
                //     data.tersangka = $('#tersangka').val();
                // }

                if(val.isConfirmed){
                    $.ajax({
                        type: "POST",
                        url,
                        data,
                        success: function (response) {
                            if(response.status){
                                Toast.fire({
                                    icon: 'success',
                                    title: '&nbsp;'+response.msg,
                                })
                            }else{
                                Toast.fire({
                                    icon: 'warning',
                                    title: '&nbsp;'+response.msg,
                                })
                            }
                            dttable.ajax.reload(null, false);
                        }
                    });
                }
            });
        });

        $('.modal').on('click', '#cancelstep', function (e) { 
            e.preventDefault();

            const id = $('#id_tracking').val();
            let url = "{{ route('statussampel.cancelstep', "_id") }}"
            url = url.replace('_id', id);
            data = {_token: "{{ csrf_token() }}"}

            $.ajax({
                type: "POST",
                url,
                data,
                success: function (response) {
                    if(response.status){
                        Toast.fire({
                            icon: 'success',
                            title: '&nbsp;'+response.msg,
                        })
                    }else{
                        Toast.fire({
                            icon: 'warning',
                            title: '&nbsp;'+response.msg,
                        })
                    }
                    dttable.ajax.reload(null, false);
                    $('#modalstatussampel').modal('hide');
                }
            });
        });

        $('#id_status_sampel').change(function (e) { 
            e.preventDefault();
            const idStatus = $(this).val();
            if(idStatus){
                dttable.column(8).search("^"+idStatus+"$", true).draw();
            }else{
                dttable.column(8).search('').draw();
            }
        });

        $('#modalstatussampel').on('hidden.bs.modal', function(e){
            $('#cancelstep').removeClass('d-none');
        })
    }); // end doc ready
</script>
@endpush
@push('styles')
<style>
    /* for select2 */
    .card-title span.select2 {
        width: 200px !important;
    }

    .select2-container .select2-selection--single {
        height: inherit;
    }
</style>
@endpush