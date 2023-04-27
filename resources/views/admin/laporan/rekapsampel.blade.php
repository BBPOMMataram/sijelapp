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
                                <select name="tahun" id="tahun" class="form-control w-auto">
                                    <option value="">==Tahun==</option>
                                    {{-- <option value="2021">2021</option> --}} {{-- karena ga ada timestamps di data
                                    lama --}}
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                </select>
                                <select name="bulan" id="bulan" class="form-control w-auto ml-2">
                                    <option value="">==Bulan==</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
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
                            <table class="table table-bordered table-striped w-100">
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
    function refill(kategori, tahun, bulan){
        let url = "{{ route('dtrekapsampel', "_kategori") }}";
        url = url.replace('_kategori', kategori);

        if (tahun) {
            url = "{{ route('dtrekapsampel', ["_kategori", "_tahun"]) }}";

            if(bulan){
                url = "{{ route('dtrekapsampel', ["_kategori", "_tahun","_bulan"]) }}";
                url = url.replace('_kategori', kategori);
                url = url.replace('_tahun', tahun);
                url = url.replace('_bulan', bulan);
            }else{
                url = url.replace('_kategori', kategori);
                url = url.replace('_tahun', tahun);
            }
        }
        
        $(".table").DataTable().destroy();
        let dttable = $(".table").DataTable({
            // serverSide: true, //uncomment if filter is solved
            processing: true,
            select: true,
            buttons: [
                {
                    extend: 'excel',
                    // autoPrint: false,
                    // title: "LAPORAN IMPLEMENTASI SIJELAPP",
                    // customize: function ( doc ) {
                    //     $(doc.document.body).find('table').css('font-size', '5pt');
                    // }
                }
            ],
            dom: 'Blftipr',
            ajax: {
                url
            },
            orderCellsTop: true,
            // columnDefs:[
            //     {targets: 21, visible: false}
            //     ],
                // stateSave: true,
            columns: [
                {data: 'DT_RowIndex', searchable: false, orderable: false},
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
                {data: 'tanggallegalisir'},
                {data: 'tanggalselesai'},
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
                {data: 'tandaterima'},
            ]
        });

        //untuk urutkan no saat redraw misal di search filter
        dttable.on( 'order.dt search.dt', function () {
            dttable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
                dttable.cell(cell).invalidate('dom'); 
            } );
        } ).draw();
    }

    $(function () {
        $.fn.dataTable.ext.errMode = 'throw';
        const idBidang = $('#bidang').val();
        
        refill(idBidang);
        
        $('#bidang').on('change', function (e) {
            const kategori = $(this).val();
            const tahun = $('#tahun').val();
            const bulan = $('#bulan').val();
            
            if(!kategori){
                kategori = null;
            }
            
            if(tahun){
                refill(kategori, tahun);
                if(bulan){
                    refill(kategori, tahun, bulan);
                }
            }else{
                refill(kategori)
            }
        });

        $('#tahun').change(function (e) { 
            e.preventDefault();
            const tahun = $(this).val();
            const bulan = $('#bulan').val();
            let kategori = $('#bidang').val();

            if(!kategori){
                kategori = null;
            }

            if(!bulan){
                refill(kategori, tahun);
            }else{
                refill(kategori, tahun, bulan);

                if(!tahun){
                    $('#bulan').val('');
                }
            }

        });

        $('#bulan').change(function (e) { 
            e.preventDefault();
            const tahun = $('#tahun').val();
            const bulan = $(this).val();
            let kategori = $('#bidang').val();

            if(!tahun){
                alert('Silahkan pilih tahun terlebih dahulu ya..');
                return 0;
            }
            
            if(!kategori){
                kategori = null;
            }
            refill(kategori, tahun, bulan);
        });


    });
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