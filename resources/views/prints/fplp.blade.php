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
                            {{ $permintaan->kategori->nama_kategori }}
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <textarea id="fplp" name="fplp" style="height: 600px;">
                            <p style="margin-top: -20px; width: 100%; text-align: center;">FORMULIR PENGAJUAN<br>LAYANAN PUBLIK BADAN POM</p>
                            <div style="width:100%;">
                                <table width="90%" style="margin-left: auto; margin-right: auto; font-size: 12px;">
                                    <tr>
                                        <td style="width:50%; border:1px solid #000; padding: 0; padding-left: 2px;">Tanggal: {{ $permintaan->created_at ? $permintaan->created_at->isoFormat('D MMM Y') : $permintaan->tanggal_terima ? $permintaan->tanggal_terima->isoFormat('D MMM Y') : '-'}}</td>
                                        <td style="width:50%; border:1px solid #000; padding: 0; padding-left: 2px;">Nomor FP-LP : 1170.4.0120.0000-0000/N-INS/2</td>
                                    </tr>
                                </table>
                            </div>
                        <div style="clear: both;"></div>
                
                        {{-- <div style="width: 100%; margin-top: 20px; height: auto;"> --}}
                            <p style="font-size: 12; text-align: justify;">Sehubungan dengan peraturan di bidang pengawasan obat dan makanan, bersama ini kami:</p>
                        {{-- </div> --}}
                        <div style="width: 100%; margin-top: 20px; height: auto; margin-left:auto; margin-right:auto;">
                            <div style="width: 50%;height: auto; border:1px solid #000; float: left; border-right: 0px; padding: 5px;">
                                <p style="font-size: 12; text-align: justify; margin: 0;">DATA PRODUSEN/PEMOHON</p>
                                <div style="width: 20%; float: left;">Nama</div>
                                <div style="width: 5%; float: left;">:</div>
                                <div style="width: 75%; float: left;">{{ $permintaan->pemiliksampel->nama_pemilik }}</div>
                                <div style="width: 20%; float: left;">Alamat</div>
                                <div style="width: 5%; float: left;">:</div>
                                <div style="width: 75%; float: left;">{{ $permintaan->pemiliksampel->alamat_pemilik }}</div>
                                <div style="width: 20%; float: left;">Telp. / Fax</div>
                                <div style="width: 5%; float: left;">:</div>
                                <div style="width: 75%; float: left;">{{ '-' }}</div>
                                <div style="width: 20%; float: left;">Email</div>
                                <div style="width: 5%; float: left;">:</div>
                                <div style="width: 75%; float: left;">{{ '-' }}</div>
                            </div>
                            <div style="width: 45%;height: auto; border:1px solid #000; float: left; padding: 5px;">
                                <p style="font-size: 12; text-align: justify; margin: 0;"></p>
                                <div style="width: 20%; float: left;">Nama</div>
                                <div style="width: 5%; float: left;">:</div>
                                <div style="width: 75%; float: left;">{{ $permintaan->pemiliksampel->nama_petugas }}</div>
                                <div style="width: 20%; float: left;">Alamat</div>
                                <div style="width: 5%; float: left;">:</div>
                                <div style="width: 75%; float: left;">{{ '-' }}</div>
                                <div style="width: 20%; float: left;">Telp. / Fax</div>
                                <div style="width: 5%; float: left;">:</div>
                                <div style="width: 75%; float: left;">{{ $permintaan->pemiliksampel->telepon_petugas }}</div>
                                <div style="width: 20%; float: left;">Email</div>
                                <div style="width: 5%; float: left;">:</div>
                                <div style="width: 75%; float: left;"></div>
                            </div>
                        </div>
                        <div style="clear: both;"></div>
                        {{-- <div style="width: 100%; margin-top: 20px; height: auto;"> --}}
                            <p style="font-size: 12; text-align: justify;">Mengajukan permohonan layanan publik di Badan Pengawas Obat dan Makanan atas produk /  jasa sejumlah layanan sebagaimana tersebut dibawah ini, lengkap dengan dokumen sesuai persyaratan.</p>
                        {{-- </div> --}}
                        {{-- <div style="width: 100%;height: auto; margin-top:-40px;"> --}}
                            <table style="border: 1px solid #000;">
                            <tr>                
                                <th rowspan="2"  style="border: 1px solid #000; width:5%;">No.</th>
                                <th rowspan="2"  style="border: 1px solid #000; width:40%;">NAMA & URAIAN PRODUK</th>
                                <th rowspan="2"  style="border: 1px solid #000; width:15%;">KODE & JENIS LAYANAN**)</th>
                                <th colspan="4" style="border: 1px solid #000; width:20%;">Catatan Petugas</th>
                            </tr>
                            <tr>                
                                <th  style="border: 1px solid #000; width:5%;">SD</th>
                                <th  style="border: 1px solid #000; width:5%;">SP</th>
                                <th  style="border: 1px solid #000; width:10%;">Tarif</th>
                                <th  style="border: 1px solid #000; width:20%;">Keterangan</th>
                            </tr>
                
                            @php 
                            $total = 0;
                            @endphp
                            @foreach ($produksampel as $item)
                            <tr>                
                                <td style="border: 1px solid #000; width:5%; text-align: center">{{ $loop->iteration }}</td>
                                <td style="border: 1px solid #000; width:40%; font-size: 11px;" colspan="6">{{ $item->nama_produk }}</td>
                            </tr>
                                @foreach ($item->ujiproduk as $i)
                                    <tr>
                                        <td style="border: 1px solid #000; font-size: 11px;"></td>
                                        <td style="border: 1px solid #000; font-size: 11px;"></td>
                                        <td style="border: 1px solid #000; font-size: 11px;">{{ $i->parameter->metodeuji->kode_layanan }}</td>
                                        <td style="border: 1px solid #000; font-size: 11px; text-align: left;"></td>
                                        <td style="border: 1px solid #000; font-size: 11px; text-align: center;"></td>
                                        <td style="border: 1px solid #000; font-size: 11px; text-align: center;">{{ number_format($i->parameter->metodeuji->biaya,0,',','.') }}</td>
                                        <td style="border: 1px solid #000; font-size: 11px; text-align: right;">{{ $i->jumlah_pengujian .' x '. number_format($i->parameter->metodeuji->biaya,0,',','.') }}</td>
                                    </tr>
                                    @php
                                    $total += $i->parameter->metodeuji->biaya * $i->jumlah_pengujian;
                                    @endphp
                                @endforeach
                            <div style="clear: both;"></div>
                            @endforeach
                            <tr>
                                <td colspan="2" style="border: 1px solid #000; font-size: 11px;">Jumlah Produk : </td>
                                <td colspan="3" style="border: 1px solid #000; font-size: 11px;">Jumlah Biaya</td>
                                <td colspan="2" style="border: 1px solid #000; font-size: 11px; text-align: right; font-weight:bold;"> {{ number_format($total,0,',','.') }}</td>
                            </tr>
                            </table>
                        {{-- </div> --}}
                        {{-- <div style="width: 100%; margin-top: -20px; height: auto;"> --}}
                            <p style="font-size: 12; text-align: justify;">SD: Syarat Dokumen &nbsp; SP: Status Permohonan &nbsp; LL: Lulus Lengkap &nbsp; LTL: Lulus Tidak Lengkap &nbsp; TL: Tidak Lulus</p>
                        {{-- </div> --}}
                        
                        <div style="width: 100%; margin-top: 15px; height: auto;">
                            <p style="font-size: 12; text-align: justify; margin: 0;">1) &nbsp;&nbsp;Tabel rincian FP-LP dapat disesuaikan dengan banyaknya item layanan yang diajukan</p>
                            <p style="font-size: 12; text-align: justify; margin: 0;">2) &nbsp;&nbsp;Data isian FP-LP merupakan dasar penerbitan Surat Perintah Bayar (SPB-LP)</p>
                            <p style="font-size: 12; text-align: justify; margin: 0;">*) &nbsp;&nbsp;Diisi oleh petugas layanan publik BPOM</p>
                            <p style="font-size: 12; text-align: justify; margin: 0;">**) &nbsp;&nbsp;Diisi oleh pemohon (jika telah memahami) atau petugas layanan publik BPOM</p>
                        </div>
                      <div style="width: 54%; float: left; margin-top: 10px;">
                            <p style="font-size: 11px;">Pemohon,</p><br><br>
                            <p style="font-size: 11px;">{{ $permintaan->pemiliksampel->nama_petugas }}</p><br>
                        </div>
                        <div style="width: 25%; float: right; margin-top: 10px;">
                            <p style="font-size: 11px;">Petugas Layanan Publik</p><br><br>
                            <p style="font-size: 11px;">Miftahul Azizah, A.Md.</p><br>            
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
        selector: '#fplp',
        plugins: 'print',
        menubar: "file",
        toolbar: "print"
    });
</script>
@endpush