@extends('layouts.admin.app')

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body align-self-center">
                        {{-- we set width for set height of isisuratcontainer --}}
                        <textarea id="pengantar" name="pengantar" style="height: 160vh; width: 717px;">
                            <div class="inner-wrapper">
                                <div style="width:75px; display: inline-block; margin-top:100px;">Nomor </div>: <span>R-PP.01.01.18A.18A1.</span>
                                <span style="display: inline-block; margin-left:200px;">Mataram, {{$date}}</span>
                            </div>
                            <div class="inner-wrapper">
                                <div style="width:75px; display: inline-block; margin-top:15px;">Lampiran </div>: <span>1 (satu) berkas</span>
                            </div>
                            <div class="inner-wrapper">
                                <div style="width:75px; display: inline-block; margin-top:15px;">Hal </div>: <span>Hasil Pengujian Laboratorium</span>
                            </div>
                            
                            <div class="inner-wrapper">
                                <div style="margin-top:60px;">Yth. Kepala  {{ $produksampel->permintaan->pemiliksampel->nama_pemilik }}</div>
                            </div>

                            <div class="inner-wrapper">
                                <div style="margin-top:20px; margin-bottom:30px;">{{ $produksampel->permintaan->pemiliksampel->alamat_pemilik }}</div>
                            </div>

                            <div class="inner-wrapper">
                                <p id="isisurat" style="line-height: 2em">
                                    Menindaklanjuti surat dari Kepala {{ $produksampel->permintaan->pemiliksampel->nama_pemilik }} nomor: {{ $produksampel->nomor_surat ?? '==nosurat tidak ditemukan==' }}
                                    tanggal {{ $produksampel->tanggal_surat ? $produksampel->tanggal_surat->isoFormat('D MMMM    Y') : '==tglsurat tidak ditemukan==' }} perihal <i>{{ $produksampel->perihal ?? '==perihal tidak ditemukan==' }}</i>,
                                    bersama ini kami sampaikan Hasil Pengujian laboratorium terhadap barang bukti dimaksud 
                                    sesuai Laporan Pengujian Laboratorium Nomor : {{ $produksampel->kode_sampel ?: '==nomor pengujian tidak ditemukan==' }} tanggal {{ $produksampel->tanggal_surat ? $produksampel->tanggal_surat->isoFormat('D MMMM    Y') : '==tglsurat tidak ditemukan==' }}
                                    sebagaimana terlampir.
                                    </p>
                                    <p>Demikian disampaikan untuk maklum.</p>
                            </div>

                            <div style="position: relative;">
                                <div style="width:50%; position: absolute; right:0; top:20px;">
                                    <div style="text-align: center; margin-bottom:120px;">Kepala Balai Besar POM di Mataram</div>
                                    <div style="text-align: center;"">Dra. I Gusti Ayu Adhi Aryapatni, Apt.</div>
                                </div>
                                
                                <div style="position: absolute; top:150px;">
                                    <div style="margin-top:100px;">Tembusan :</div>
                                        <ol style="padding-left: 17px;">
                                            <li>Deputi Bidang Penindakan Badan POM RI di Jakarta</li>
                                            <li>Direktorat Pengawasan Distribusi dan Pelayanan Obat, Narkotika, Psikotropika dan
                                                Prekursor Badan POM RI di Jakarta.</li>
                                        </ol>
                                    </div>
                                </div>
                        </textarea>
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
<script src='https://cdn.tiny.cloud/1/s12j0hwmr9utgkygqnc7se5sym4az21leofblzpc1vapbr4p/tinymce/5/tinymce.min.js'
    referrerpolicy="origin">
</script>
<script>
    tinymce.init({
        selector: '#pengantar',
        content_css: "/vendor/admin/dist/css/basegel.css",
        plugins: 'print',
        //menubar: false,
        toolbar: "print",
        branding: false,
        content_style: "body {font-size: 11pt; font-family: Arial}",
    });

    $(function () {
        $('body').on('change', '#pembukasegel', function(e){
            const pembukasegel = $(this).val();
            // if(pembukasegel){
            tinymce.get('pengantar').dom.setHTML("pembukasegelselected", pembukasegel);
            tinymce.get('pengantar').dom.setHTML("pembukasegelselected1", pembukasegel);
            // }
        })
        
        $('.select2').select2();

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

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #017AFC;
    }
</style>
@endpush