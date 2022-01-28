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
                        {{-- <h3 class="card-title mr-2 mt-2">
                            {{ $produksampel->permintaan->kategori->nama_kategori }}
                        </h3> --}}
                        <div class="row">
                            <div class="col">
                                <label for="pembukasegel">Penimbang</label>
                                <select name="pembukasegel" id="pembukasegel" class="form-control select2">
                                    <option value="">==Pilih penimbang==</option>
                                    @foreach ($users as $item)
                                        <option value="{{ $item->fullname }}">{{ $item->fullname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label for="saksi">Saksi 1</label>
                                <select name="saksi1" id="saksi1" class="form-control select2">
                                    <option value="" data-pangkat="" data-jabatan="">==Pilih saksi 1==</option>
                                    @foreach ($users as $item)
                                        <option value="{{ $item->fullname }}" data-pangkat="{{ $item->pangkat }}" data-jabatan="{{ $item->jabatan }}">{{ $item->fullname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body align-self-center">
                        {{-- we set width for set height of isisuratcontainer --}}
                        <textarea id="bapenimbangan" name="bapenimbangan" style="height: 160vh; width: 717px;">
                            <div style="font-weight: bold; text-decoration: underline; margin-top:100px;">Pro Justitia</div>
                            <h3 style="text-align: center; text-decoration: underline;">BERITA ACARA PENIMBANGAN BARANG BUKTI</h3>
                            <div id="isi" style="text-align: justify;">
                                {{--  --}}
                                <div 
                                    style="
                                    overflow: hidden;
                                    height: 2.4em;
                                    line-height: 1.2em;
                                    "
                                >
                                    <div class="inner-wrapper">{{
                                        '--------- Pada hari ini ' . $tglterbilang . ' bertempat di Kantor Balai Besar POM di Mataram saya : '.
                                        '---------------------------------------------------------------------------------------------------'.
                                        '---------------------------------------------------------------------------------------------------'
                                    }}</div>
                                </div>

                                {{--  --}}
                                <div 
                                    style="
                                    overflow: hidden;
                                    height: 1.2em;
                                    line-height: 1.2em;
                                    margin-top:15px;
                                    margin-bottom:15px;
                                    "
                                >
                                    <div class="inner-wrapper">{{
                                        '------------------------------------'.
                                        '<span style="font-weight: bold; text-decoration: underline;" id="pembukasegelselected"></span>'.
                                        '---------------------------------------------------------------------------------------------------'.
                                        '------------------------------------------------------'
                                    }}</div>
                                </div>

                                {{--  --}}
                                <div 
                                style="
                                    overflow: hidden;
                                    height: 1.2em;
                                    line-height: 1.2em;
                                    "
                                >
                                    <div class="inner-wrapper">{{ 
                                    'Penerima Sampel Pihak Ketiga pada Balai Besar POM di Mataram dengan disaksikan oleh : '.
                                        '------------------------------------------------------------------------'
                                    }}</div>
                                </div>

                                {{--  --}}
                                <div 
                                    style="
                                        overflow: hidden;
                                        height: 1.2em;
                                        line-height: 1.2em;
                                        margin-top: 10px;
                                        "
                                    >
                                    <div class="inner-wrapper">
                                        <div style="width:125px; display: inline-block;">--------- 1. Nama </div>: <span id="saksi1selected" ></span>
                                        {{ '------------------------------------------------------------------------------------------------'.
                                        '------------------------------------------------------------------------------------------------'}}
                                    </div>
                                </div>

                                {{--  --}}
                                <div 
                                    style="
                                        overflow: hidden;
                                        height: 1.2em;
                                        line-height: 1.2em;
                                        "
                                    >
                                    <div class="inner-wrapper">
                                        <div style="width:125px; display: inline-block;">--------- Pangkat </div>: <span id="saksi1pangkatselected"></span>
                                        {{ '------------------------------------------------------------------------------------------------'.
                                        '------------------------------------------------------------------------------------------------'}}
                                    </div>
                                </div>

                                {{--  --}}
                                <div 
                                    style="
                                        overflow: hidden;
                                        height: 1.2em;
                                        line-height: 1.2em;
                                        "
                                    >
                                    <div class="inner-wrapper">
                                        <div style="width:125px; display: inline-block;">--------- Jabatan </div>: <span id="saksi1jabatanselected"></span>
                                        {{ '------------------------------------------------------------------------------------------------'.
                                        '------------------------------------------------------------------------------------------------'}}
                                    </div>
                                </div>
                                
                                {{--  --}}
                                <div 
                                    style="
                                        overflow: hidden;
                                        height: 1.2em;
                                        line-height: 1.2em;
                                        margin-top: 10px;
                                        "
                                    >
                                    <div class="inner-wrapper">
                                        <div style="width:125px; display: inline-block;">--------- 2. Nama </div>: <span id="saksi2selected" >{{ $produksampel->permintaan->pemiliksampel->nama_petugas }}</span>
                                        {{ '------------------------------------------------------------------------------------------------'.
                                        '------------------------------------------------------------------------------------------------'}}
                                    </div>
                                </div>
                                
                                {{--  --}}
                                <div 
                                    style="
                                        overflow: hidden;
                                        height: 1.2em;
                                        line-height: 1.2em;
                                        "
                                    >
                                    <div class="inner-wrapper">
                                        <div style="width:125px; display: inline-block;">--------- Pangkat </div>: <span id="saksi2pangkatselected" >{{ $produksampel->permintaan->pemiliksampel->pangkat_petugas }}</span>
                                        {{ '------------------------------------------------------------------------------------------------'.
                                        '------------------------------------------------------------------------------------------------'}}
                                    </div>
                                </div>
                                
                                {{--  --}}
                                <div 
                                    style="
                                        overflow: hidden;
                                        height: 1.2em;
                                        line-height: 1.2em;
                                        "
                                    >
                                    <div class="inner-wrapper">
                                        <div style="width:125px; display: inline-block;">--------- Jabatan </div>: <span id="saksi2pangkatselected">{{ $produksampel->permintaan->pemiliksampel->jabatan_petugas }}</span>
                                        {{ '------------------------------------------------------------------------------------------------'.
                                        '------------------------------------------------------------------------------------------------'}}
                                    </div>
                                </div>
                                
                                {{--  --}}
                                <div id="isisuratcontainer"
                                    style="
                                        overflow: hidden;
                                        /* height: 1.2em; */
                                        line-height: 1.2em;
                                        margin-top: 10px;
                                        "
                                    >
                                    <div class="inner-wrapper">
                                        <p id="isisurat">
                                            Berdasarkan surat dari Kepala {{ $produksampel->permintaan->pemiliksampel->nama_pemilik }} nomor: {{ $produksampel->nomor_surat ?? '==nosurat tidak ditemukan==' }}
                                            tanggal {{ $produksampel->tanggal_surat ? $produksampel->tanggal_surat->isoFormat('D MMMM    Y') : '==tglsurat tidak ditemukan==' }} perihal <i>{{ $produksampel->perihal ?? '==perihal tidak ditemukan==' }}</i>,
                                            beserta lampiran-lampirannya yang menyatakan tentang peredaran Narkotika a.n tersangka <b>{{ $produksampel->tersangka ?? '==namatersangka tidak ditemukan==' }}</b>,
                                            {{ $produksampel->berat }}. <span id="titikisisurat"></span>
                                            {{-- telah melakukan penimbangan terhadap barang bukti berupa:
                                            {{ $produksampel->wadah1 ?? '==wadah1 tidak ditemukan==' }}. Setelah dibuka di dalamnya terdapat {{ $produksampel->wadah2 ?? '==wadah2 tidak ditemukan==' }}.
                                            Amplop dibuka dengan cara digunting dan plastik klip transparan berisi Barang Bukti
                                            diambil untuk selanjutnya dilakukan Penimbangan.<span id="titikisisurat"></span> --}}
                                         </p>
                                    </div>
                                </div>
                                
                                {{--  --}}
                                <div 
                                    style="
                                        overflow: hidden;
                                        height: 4.8em;
                                        line-height: 1.2em;
                                        margin-top: 10px;
                                        "
                                    >
                                    <div class="inner-wrapper">
                                        <div>
                                            {{ '--------- Demikian Berita Acara Penimbangan Barang Bukti ini dibuat dengan sebenarnya
                                            atas kekuatan sumpah jabatan guna melengkapi Berita Acara Pembukaan Segel Barang Bukti dari yang bersangkutan
                                            dan ditandatangani di Mataram pada hari '. $tglterbilang . '.'.
                                            '------------------------------------------------------------------------------------------------------'
                                            }}
                                         </div>
                                    </div>
                                </div>

                                {{--  --}}
                                <div style="position: relative;">
                                    <div style="width:50%; position: absolute; right:0; top:20px;">
                                        <div style="text-align: center; margin-bottom:60px; font-weight:bold;">Yang Membuka Segel,</div>
                                        <div style="text-align: center; font-weight: bold;" id="pembukasegelselected1"></div>
                                    </div>
                                    <div style="position: absolute; top:150px;">
                                        <div>Saksi-saksi :</div>
                                        <div style="margin-top: 15px; ">1. <span id="saksi1selected1"></span></div>
                                        <div style="margin-top: 15px; ">2. {{ $produksampel->permintaan->pemiliksampel->nama_petugas }}</div>
                                    </div>
                                </div>

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
        selector: '#bapenimbangan',
        plugins: 'print',
        // menubar: false,
        toolbar: 'print | undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent',
        branding: false,
        setup: function(editor){
            editor.on('init', function(e){
                const hisisurat = tinymce.activeEditor.dom.getSize('isisurat').h + 19;
                tinymce.activeEditor.dom.setStyle(tinymce.activeEditor.dom.select('#isisuratcontainer'), 'height', hisisurat+'px');
                tinymce.get('bapenimbangan').dom.setHTML("titikisisurat", '--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
            })
        },
        // content_style: "body {font-size: 10pt;}",
    });

    $(function () {
        $('body').on('change', '#pembukasegel', function(e){
            const pembukasegel = $(this).val();
            // if(pembukasegel){
            tinymce.get('bapenimbangan').dom.setHTML("pembukasegelselected", pembukasegel);
            tinymce.get('bapenimbangan').dom.setHTML("pembukasegelselected1", pembukasegel);
            // }
        })

        $('body').on('change', '#saksi1', function(e){
            const saksi1 = $(this).val();
            const pangkat = $(this).find(':selected').data('pangkat');
            const jabatan = $(this).find(':selected').data('jabatan')
            tinymce.get('bapenimbangan').dom.setHTML("saksi1pangkatselected", pangkat);
            tinymce.get('bapenimbangan').dom.setHTML("saksi1selected", saksi1);
            tinymce.get('bapenimbangan').dom.setHTML("saksi1jabatanselected", jabatan);
            tinymce.get('bapenimbangan').dom.setHTML("saksi1selected1", saksi1);

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