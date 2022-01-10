@extends('layouts/front')

@section('content')
<div class="tm-row">
    <div class="tm-col-left"></div>
    <main class="tm-col-right">
        <section class="tm-content">
            <form>
            <h2 class="mb-5 tm-content-title">Tracking Sampel</h2>
            <div><input type="text" id="resisampel" placeholder="No Resi Sampel" class="form-control px-2 rounded mb-1"
                    autofocus></div>
            {{-- {!! NoCaptcha::display() !!} --}}
            <button type="button" class="btn btn-primary rounded mt-4 track">Track</button>
        </form>
    </section>
    </main>
</div>

@include('modals.tracking')
@include('modals.tandaterima')
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
<script>
    tippy('#resisampel', {
        content: 'input resi',
        trigger: 'mouseenter',
        animation: 'scale',
      });


      function dtdetailterimasampel(idpermintaan){
        let url = "{{ route('dtdetailterimasampel', "_id") }}";
        url = url.replace('_id', idpermintaan);

        $("#detailterimasampel").DataTable().destroy();
        let dttable = $("#detailterimasampel").DataTable({
            searching: false,
            serverside: true,
            select: true,
            scrollX: true,
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
                            res += '- ' + data[key].parameter.parameter_uji+'<br />';
                        }else{
                            res += 'not found <br />';
                        }
                    }
                    return res;
                    }},
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
                {data: 'user.name', render: function(data, type, row){ return data ? data : '-'; }},
                {data: 'download'},
            ]
        });
    }

    function filldata(rowData) {
        //fill form
        //detail sampel
        dtdetailterimasampel(rowData['id_permintaan']);

        $('#modaltrackingtitle').text("Tracking Sampel No Resi : "+rowData.permintaan.resi)
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

        // tgl selesai untuk memastikan btn tampil saat sudah selesai 
        // dan tgl diambil untuk menyembunyikan btn ambil sampel setelah sampel sudah diambil
        if (rowData.tanggal_selesai !== '-' && rowData.tanggal_diambil === '-') {
            const btnAmbil = '<button class="btn btn-sm btn-info rounded" id="ambilsampel">AMBIL SAMPEL</button>';
            $('.btnContainer').empty();
            $('.btnContainer').append(btnAmbil);
            $('#id_permintaan').val(rowData['id_permintaan'])
        }else{
            $('.btnContainer').empty();
        }
    }
    
    var canvas = document.querySelector("canvas");
    var signaturePad = new SignaturePad(canvas);
    
    $(function () {
        $('body').on('click', 'button.track', function(e){
            e.preventDefault();

            const resisampel = $('#resisampel').val();
            let url = "{{ route('dttrackingsampel', "_id")}}";
            url = url.replace("_id", resisampel);
            
            let fd = new FormData($('form')[0]);
            fd.append('_token', "{{ csrf_token() }}");
            
            $.ajax({
                type: "GET",
                url,
                // data: fd,
                // cache: false,
                // processData: false,
                // contentType: false,
                success: function (response) {
                    if(response.status !== 0){
                        filldata(response.data[0]);
                        $('#modaltracking').modal('show');
                    }else{
                        Swal.fire({
                            title: 'Not Found',
                            text: response.msg,
                            icon: 'error'
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

        $('body').on('click', '#ambilsampel', function(e){
            e.preventDefault();
            $('#modaltandaterima').modal('show');
            $('#nama_pengambil').val('')
            signaturePad.clear();
        });

        $('#clear-signature').click(function(e){
            signaturePad.clear();
        });

        $('body').on('click', '#submittandaterima', function(e){
            e.preventDefault();
            const idpermintaan = $('#id_permintaan').val();
            const namapengambil = $('#nama_pengambil').val();
            let url = "{{ route('submittandaterima', "_id") }}";
            url = url.replace('_id', idpermintaan);

            let tandaterima;
            
            if(!signaturePad.isEmpty()){
                tandaterima = signaturePad.toDataURL();
            }


            data = {
                '_token': '{{ csrf_token() }}',
                'tanda_terima': tandaterima,
                'nama_pengambil': namapengambil,
            }
            $.ajax({
                type: "POST",
                url,
                data,
                success: function (response) {
                    if(response.status){
                        Swal.fire({
                            title: 'Success',
                            text: response.msg,
                            icon: 'success'
                        })

                        $('#modaltracking').modal('hide');
                        $('#modaltandaterima').modal('hide');
                    }
                },
                error: function(err){
                    if(err.status == 422){
                    console.log(err.responseJSON);
                    let errMsg = '';
                    $.each(err.responseJSON.errors, function (indexInArray, valueOfElement) {
                        $.each(valueOfElement, function (indexInArray, valueOfElement) { 
                        errMsg += '<li class="text-left">' + valueOfElement + '</li>';
                        });
                    });
                    Swal.fire({
                        title: err.responseJSON.message,
                        html: '<ul>' + errMsg + '</ul>',
                    })
                    }
                }
            });
        });
        
        $('#modaltracking').on('hidden.bs.modal', function(){
            location.reload();
        });

        $('#modaltracking').on('shown.bs.modal', function(){
            dttable.columns.adjust();
        });
    });
    
</script>
{{-- {!! NoCaptcha::renderJs('id') !!} --}}
@endpush
@push('styles')
<style>
    .modal {
        overflow-y: auto;
    }

    .dataTables_scrollHeadInner {
        width: 100%!important;
    }

    thead th { white-space: nowrap; }
</style>
@endpush