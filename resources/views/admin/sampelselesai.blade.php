@extends('layouts.admin.app')

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="sampelselesai" class="table table-bordered table-striped w-100">
                                <thead>
                                    <tr>
                                        <th class="align-middle">No Urut Penerimaan</th>
                                        <th class="align-middle">Kode Sampel</th>
                                        <th class="align-middle">Instansi</th>
                                        <th class="align-middle">Nama Petugas</th>
                                        <th class="align-middle">Telepon Petugas</th>
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

    const dttable = $("#sampelselesai").DataTable({
        "drawCallback": function(settings){
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
            url: "{{ route('dtsampelselesai') }}"
        },
        columns: [
            {data: 'permintaan.no_urut_penerimaan'},
            {data: 'permintaan.kode_sampel'},
            {data: 'permintaan.pemiliksampel.nama_pemilik'},
            {data: 'permintaan.pemiliksampel.nama_petugas'},
            {data: 'permintaan.pemiliksampel.telepon_petugas'},
            {data: 'status.label'},
            {data: 'actions', className: 'text-center align-middle'},
            {data: 'id_status_sampel', visible: false},
        ],
    });

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
            ]
        });
    }

    $(function () {
        //show modal for show data
        $('table').on('click', '.show', function(e){
            e.preventDefault();
            const rowData = dttable.row($(this).parents('tr')).data();
            
            $('#modalstatussampel').modal('show');
            //fill form
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

    }); // end doc ready
</script>
@endpush