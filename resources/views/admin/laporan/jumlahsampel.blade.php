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
                        <select name="tahun" id="tahun" class="form-control w-auto">
                            @for ($i = 2022; $i < 2025; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped w-100" style="font-size: 12px;">
                                <thead>
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">Jenis Sampel</th>
                                        <th colspan="2">Januari</th>
                                        <th colspan="2">Februari</th>
                                        <th colspan="2">Maret</th>
                                        <th colspan="2">April</th>
                                        <th colspan="2">Mei</th>
                                        <th colspan="2">Juni</th>
                                        <th colspan="2">Juli</th>
                                        <th colspan="2">Agustus</th>
                                        <th colspan="2">September</th>
                                        <th colspan="2">Oktober</th>
                                        <th colspan="2">November</th>
                                        <th colspan="2">Desember</th>
                                        <th colspan="2">Total</th>
                                    </tr>
                                    <tr>
                                        <th>masuk</th>
                                        <th>keluar</th>
                                        <th>masuk</th>
                                        <th>keluar</th>
                                        <th>masuk</th>
                                        <th>keluar</th>
                                        <th>masuk</th>
                                        <th>keluar</th>
                                        <th>masuk</th>
                                        <th>keluar</th>
                                        <th>masuk</th>
                                        <th>keluar</th>
                                        <th>masuk</th>
                                        <th>keluar</th>
                                        <th>masuk</th>
                                        <th>keluar</th>
                                        <th>masuk</th>
                                        <th>keluar</th>
                                        <th>masuk</th>
                                        <th>keluar</th>
                                        <th>masuk</th>
                                        <th>keluar</th>
                                        <th>masuk</th>
                                        <th>keluar</th>
                                        <th>masuk</th>
                                        <th>keluar</th>
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
@endsection
@push('scripts')
<script>
    function refill(tahun){
        let url = "{{ route('dtjumlahsampel',"_tahun") }}"
        url = url.replace('_tahun', tahun);

        $(".table").DataTable().destroy();
        $(".table").DataTable({
            ordering: false,
            serverside: true,
            select: true,
            pageLength: 25,
            buttons: [
                {
                    extend: 'excel',
                    autoPrint: false,
                    title: "LAPORAN JUMLAH PENGUJIAN PIHAK KETIGA",
                }
            ],
            dom: 'Bft',
            ajax: {
                url
            },
            columns: [
                {data: 'DT_RowIndex'},
                {data: 'kategori.nama_kategori'},
                {data: 'januarimasuk'},
                {data: 'januarikeluar'},
                {data: 'februarimasuk'},
                {data: 'februarikeluar'},
                {data: 'maretmasuk'},
                {data: 'maretkeluar'},
                {data: 'aprilmasuk'},
                {data: 'aprilkeluar'},
                {data: 'meimasuk'},
                {data: 'meikeluar'},
                {data: 'junimasuk'},
                {data: 'junikeluar'},
                {data: 'julimasuk'},
                {data: 'julikeluar'},
                {data: 'agustusmasuk'},
                {data: 'agustuskeluar'},
                {data: 'septembermasuk'},
                {data: 'septemberkeluar'},
                {data: 'oktobermasuk'},
                {data: 'oktoberkeluar'},
                {data: 'novembermasuk'},
                {data: 'novemberkeluar'},
                {data: 'desembermasuk'},
                {data: 'desemberkeluar'},
                {data: 'totalmasuk'},
                {data: 'totalkeluar'},
            ],
            orderCellsTop: false,
        });
    }

    $(function () {
        refill($('#tahun').val());

        $('#tahun').change(function (e) { 
            e.preventDefault();
            refill($(this).val());
        });
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

    @page {
        size: auto;
    }
</style>
@endpush