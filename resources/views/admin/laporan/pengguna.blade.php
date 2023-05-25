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
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped w-100">
                                <thead>
                                    <tr>
                                        <th class="align-middle">No</th>
                                        <th class="align-middle">Instansi</th>
                                        <th class="align-middle">Tanggal layanan</th>
                                        <th class="align-middle">Nama Pengguna</th>
                                        <th class="align-middle">HP</th>
                                        <th class="align-middle">Email</th>
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
    $(function () {
        function refill(tahun, bulan){
            let url = "{{ route('dtpengguna') }}";

            if (tahun) {
                url = "{{ route('dtpengguna', ["_tahun"]) }}";
                
                if(bulan){
                    url = "{{ route('dtpengguna', ["_tahun","_bulan"]) }}";
                    url = url.replace('_tahun', tahun);
                    url = url.replace('_bulan', bulan);
                }else{
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
                    }
                ],
                dom: 'Blftipr',
                ajax: {
                    url
                },
                orderCellsTop: true,
                columns: [
                    {data: 'DT_RowIndex', searchable: false, orderable: false},
                    {data: 'nama_pemilik', render: function(data){ return data ? data : '-' }},
                    {data: 'tanggalterima'},
                    {data: 'nama_petugas', render: function(data){ return data ? data : '-' }},
                    {data: 'telepon_petugas', render: function(data){ return data ? data : '-' }},
                    {data: 'email_petugas', render: function(data){ return data ? data : '-' }},
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

        $.fn.dataTable.ext.errMode = 'throw';
        
        refill();

        $('#tahun').change(function (e) { 
            e.preventDefault();
            const tahun = $(this).val();

            refill(tahun);
        });

        $('#bulan').change(function (e) { 
            e.preventDefault();
            const tahun = $('#tahun').val();
            const bulan = $(this).val();

            if(!tahun){
                alert('Silahkan pilih tahun terlebih dahulu ya..');
                $(this).val("");
                return 0;
            }
            refill(tahun, bulan);
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