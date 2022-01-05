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
                        <div class="form-group">
                            <select name="bidang" id="bidang" class="form-control w-auto">
                                <option value="">==Pilih Komoditi==</option>
                                @foreach ($bidang as $item)
                                    <option value="{{ $item->id_kategori }}">{{ $item->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
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
                        {{-- <select name="bidang" id="bidang">
                            <option value="">==Pilih Komoditi==</option>
                            @foreach ($bidang as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                            @endforeach
                        </select> --}}
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
                                        <th class="align-middle" rowspan="3">Nama Pengambil</th>
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
{{-- @include('modals.terimasampel.detailterimasampel') --}}
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
        // ordering: false,
        buttons: [
            {
                extend: 'print',
                autoPrint: false,
                title: "LAPORAN IMPLEMENTASI SIJELAPP",
                customize: function ( doc ) {
                    $(doc.document.body).find('table').css('font-size', '5pt');
                }
            }
        ],
        dom: 'Bftipr',
        ajax: {
            url: "{{ route('dtrekapsampel') }}"
        },
        // order: [[12, 'desc']],
        columns: [
            {data: 'DT_RowIndex', ordering: false},
            {data: 'no_urut_penerimaan', render: function(data){ return data ? data : '-' }},
            {data: 'kategori.nama_kategori', render: function(data){ return data ? data : '-' }},
            {data: 'pemiliksampel.nama_pemilik', render: function(data){ return data ? data : '-' }},
            {data: 'produksampel', render: function(data, type, row){
                let res = '';
                for (const key in data) {
                    if(data[key].kode_sampel){
                        res += '- '+data[key].kode_sampel+'<br />';
                    }else{
                        res += '- not found <br />';
                    }
                }
                return res;
                }},
            {data: 'produksampel', render: function(data, type, row){
                let res = '';
                for (const key in data) {
                    if(data[key].nomor_surat){
                        res += '- '+data[key].nomor_surat+'<br />';
                    }else{
                        res += '- not found <br />';
                    }
                }
                return res;
                }},
            {data: 'produksampel', render: function(data, type, row){
                let res = '';
                var options = {year: 'numeric', month: 'long', day: 'numeric'};
                for (const key in data) {
                    if(data[key].tanggal_surat){
                        const date = new Date(data[key].tanggal_surat);
                        res += '- '+ date.toLocaleDateString("id-ID", options) +'<br />';
                    }else{
                        res += '- not found <br />';
                    }
                }
                return res;
                }},
            {data: 'produksampel', render: function(data, type, row){
                let res = '';
                for (const key in data) {
                    if(data[key].nama_produk){
                        res += '- '+data[key].nama_produk+'<br />';
                    }else{
                        res += '- not found <br />';
                    }
                }
                return res;
                }},
            {data: 'produksampel', render: function(data, type, row){
                let res = '';
                let n = 0;
                for (const key in data) {
                    res += ++n + '. ';
                    for (const k in data[key].ujiproduk) {
                        if(data[key].ujiproduk[k].parameter){
                            res += '* '+data[key].ujiproduk[k].parameter.parameter_uji+'<br />';
                        }else{
                            res += '* not found <br />';
                        }
                    }
                }
                return res;
                }},
            {data: 'produksampel', render: function(data, type, row){
                let res = '';
                for (const key in data) {
                    if(data[key].tersangka){
                        res += '- '+data[key].tersangka+'<br />';
                    }else{
                        res += '- not found <br />';
                    }
                }
                return res;
                }},
            {data: 'produksampel', render: function(data, type, row){
                let res = '';
                for (const key in data) {
                    if(data[key].id_pengembalian_bb){
                        res += '- '+data[key].id_pengembalian_bb+'<br />';
                    }else{
                        res += '-<br />';
                    }
                }
                return res;
                }},
            {data: 'produksampel', render: function(data, type, row){
                let res = '';
                for (const key in data) {
                    if(data[key].user){
                        res += '- '+data[key].user.name+'<br />';
                    }else{
                        res += '- not found <br />';
                    }
                }
                return res;
                }},
            {data: 'tanggalterima'},
            {data: 'tanggalestimasi'},
            {data: 'tanggalselesaiuji'},
            {data: 'tanggallegalisir'},
            {data: 'selesaidalamhari'},
            {data: 'produksampel', render: function(data, type, row){
                let res = '';
                for (const key in data) {
                    if(data[key].hasil_uji){
                        res += '- '+data[key].hasil_uji+'<br />';
                    }else{
                        res += '- not found <br />';
                    }
                }
                return res;
                }},
            {data: 'produksampel', render: function(data, type, row){
                let res = '';
                let n = 0;
                for (const key in data) {
                    res += ++n + '. ';
                    for (const k in data[key].ujiproduk) {
                        if(data[key].ujiproduk[k].parameter){
                            res += '* '+data[key].ujiproduk[k].parameter.metodeuji.biaya * data[key].ujiproduk[k].jumlah_pengujian+'<br />';
                        }else{
                            res += '* not found <br />';
                        }
                    }
                    
                }
                return res;
                }},
            {data: 'tracking.nama_pengambil', render: function($data){ return $data ? $data : '-'}},
            {data: 'produksampel', render: function(data, type, row){
                let res = '';
                for (const key in data) {
                    if(data[key].tandaterima){
                        res += '- '+data[key].tandaterima+'<br />';
                    }else{
                        res += '- not found <br />';
                    }
                }
                return res;
                }},
            {data: 'kategori.id_kategori', visible: false},
        ]
    });

    $('#bidang').on('change', function () {
        const idBidang = $(this).val();
            if(idBidang){
                dttable.column(21).search("^"+idBidang+"$", true).draw();
            }else{
                dttable.column(21).search('').draw();
            }
    });

    dttable.on( 'order.dt search.dt', function () {
        dttable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
            dttable.cell(cell).invalidate('dom'); 
        } );
    } ).draw();

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
    @page {
        size: auto;
    }
</style>
@endpush