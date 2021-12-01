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
                        <div class="card-tools">
                            <ul class="nav nav-pills ml-auto">
                                {{-- <li class="nav-item mr-1">
                                    <a target="_blank" href="{{ route('print.kajiulang', $id) }}"
                                        class="btn btn-light"><i class="fas fa-print mr-1"></i>Kaji Ulang</a>
                                </li>
                                <li class="nav-item mr-3">
                                    <a target="_blank" href="{{ route('print.fplp', $id) }}" class="btn btn-light"><i
                                            class="fas fa-print mr-1"></i>FPLP</a>
                                </li> --}}
                            </ul>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="rekapsampel" class="table table-bordered table-striped w-100">
                                <thead>
                                    <tr>
                                        <th class="align-middle" rowspan="3">No</th>
                                        <th class="align-middle" rowspan="3">No KUP</th>
                                        <th class="align-middle" rowspan="3">Komoditi</th>
                                        <th class="align-middle" rowspan="3">Asal Sampel</th>
                                        <th class="align-middle" rowspan="3">Kode Sampel</th>
                                        <th class="align-middle" rowspan="3">Nomor Surat</th>
                                        <th class="align-middle" rowspan="3">Tanggal Surat</th>
                                        <th class="align-middle" rowspan="3">Nama Sampel</th>
                                        <th class="align-middle" rowspan="3">Parameter Uji</th>
                                        <th class="align-middle" rowspan="3">Tersangka</th>
                                        <th class="align-middle" rowspan="3">Pengembalian BB</th>
                                        <th class="align-middle" rowspan="3">Saksi Ahli</th>
                                        <th class="align-middle" rowspan="3">Tanggal Terima</th>
                                        <th class="align-middle text-center" colspan="3">Tanggal Selesai</th>
                                        <th class="align-middle" rowspan="3">Selesai</th>
                                        <th class="align-middle" rowspan="3">Hasil</th>
                                        <th class="align-middle" rowspan="3">Biaya Uji</th>
                                        <th class="align-middle" rowspan="3">Tanda Terima</th>
                                    </tr>
                                    <tr>
                                        <th class="align-middle text-center" rowspan="2">Estimasi</th>
                                        <th class="align-middle text-center" colspan="2">Realisasi</th>
                                    </tr>
                                    <tr>
                                        <th class="align-middle">Lab</th>
                                        <th class="align-middle">MA</th>
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

    const dttable = $("#rekapsampel").DataTable({
        serverside: true,
        select: true,
        ordering: false,
        ajax: {
            url: "{{ route('dtrekapsampel') }}"
        },
        // order: [[12, 'desc']],
        columns: [
            {data: 'DT_RowIndex'},
            {data: 'permintaan.no_urut_penerimaan', render: function(data){ return data ? data : '-' }},
            {data: 'permintaan.kategori.nama_kategori', render: function(data){ return data ? data : '-' }},
            {data: 'permintaan.pemiliksampel.nama_pemilik', render: function(data){ return data ? data : '-' }},
            {data: 'kode_sampel', render: function(data){ return data ? data : '-' }},
            {data: 'nomor_surat', render: function(data){ return data ? data : '-' }},
            {data: 'tanggal_surat', render: function(data){ return data ? data : '-' }},
            {data: 'nama_produk', render: function(data){ return data ? data : '-' }},
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
            {data: 'tersangka', render: function(data){ return data ? data : '-' }},
            {data: 'id_pengembalian_bb', render: function(data){ return data ? data : '-' }},
            {data: 'saksi_ahli', render: function(data){ return data ? data : '-' }},
            {data: 'tanggalterima'},
            {data: 'tanggalestimasi'},
            {data: 'tanggalselesaiuji'},
            {data: 'tanggallegalisir'},


            {data: 'selesaidalamhari'},
            {data: 'hasil_uji', render: function(data, type, row){ return data ? data : '-'; }},
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
            {data: 'tandaterima'},
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
                        list += '<li>'+res[key].parameter.parameter_uji+'('+res[key].parameter.metodeuji.metode+')'+'('+res[key].jumlah_pengujian+') <i onclick="deleteparameteruji('+ res[key].id_uji_produk +','+ idProdukSampel +')" class="fas fa-trash text-danger" style="cursor:pointer;"></i></li>';
                    }else{
                        list += '<li>Not found('+res[key].jumlah_pengujian+') <i onclick="deleteparameteruji('+ res[key].id_uji_produk +','+ id_produk_sampel +')" class="fas fa-trash text-danger" style="cursor:pointer;"></i></li>';
                    }
                }
                $('#listparameteruji').append('<ol>'+ list +'</ol>');
            }
        });
    }

    $(function () {
        
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