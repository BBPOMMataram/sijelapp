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
                                    lama (2021) jadi di disable--}}
                                    @for ($i = 2022; $i < (now()->year + 1); $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                        @endfor
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
                                        <th class="align-middle">Asal Sampel</th>
                                        <th class="align-middle">Shabu</th>
                                        <th class="align-middle">Ganja</th>
                                        <th class="align-middle">Ekstasi</th>
                                        <th class="align-middle">lainnya</th>
                                        <th class="align-middle">Jumlah</th>
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
    function refill(tahun){
        let url = "{{ route('dtrekapsampelpolisi') }}";
        // url = url.replace('_kategori', kategori);

        if (tahun) {
            url = "{{ route('dtrekapsampelpolisi', "_tahun") }}";
                url = url.replace('_tahun', tahun);
        }
        
        $(".table").DataTable().destroy();
        let dttable = $(".table").DataTable({
            serverSide: true, //uncomment if filter is solved
            processing: true,
            select: true,
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
                url
            },
            orderCellsTop: true,
            // columnDefs:[
            //     {targets: 21, visible: false}
            //     ],
                // stateSave: true,
            columns: [
                {data: 'DT_RowIndex', searchable: false, orderable: false},
                {data: 'nama_pemilik'},
                {data: 'shabu_count'},
                {data: 'ganja_count'},
                {data: 'ekstasi_count'},
                {data: 'lainnya_count'},
                {data: 'total_count'},
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
        refill();
        
        $('#tahun').change(function (e) { 
            e.preventDefault();
            const tahun = $(this).val();
            refill(tahun);

            if(!tahun){
                refill();
            }
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