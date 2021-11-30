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
                        <textarea id="kajiulang" name="kajiulang" class="vh-100">
                            <div style="float: right;">
                                <i style="font-size: 9px;">KUPP-1</i>            
                                <p style="font-size: 11px; margin-top: -2px;">POM-05.01.CFM.01.SOP.01.IK.02(107)/F.02 Rev.01</p>
                            </div>
                                <div style="clear: both;"></div>
                            <div style="float: left; margin-top: -25px; width: 300px;">
                                <div style="float: left; height: 50px; font-size: 11px;">Lembar&nbsp;&nbsp;</div>
                                <div style="font-size: 11px;">1&nbsp;:&nbsp;Customer</div>
                                <div style="font-size: 11px;">2&nbsp;:&nbsp;Laboratorium</div>
                                <div style="font-size: 11px;">3&nbsp;:&nbsp;Administrasi</div>
                            </div>
                                <div style="clear: both;"></div>
                                <p style="margin-top: -20px; width: 100%; text-align: center;">KAJI ULANG PERMINTAAN PENGUJIAN</p>
                            <div style="width: 100%;">
                                <div style="font-size: 12px; width: 30%; float: left;">NOMOR URUT PENERIMAAN</div>
                                <div style="font-size: 12px; float: left;">:</div>
                                <div style="font-size: 12px; float: left;">&nbsp;{{ $permintaan->no_urut_penerimaan }}</div>
                                <div style="clear: both;"></div>
                            </div>
                            <div style="width: 100%; height: 215px; border:1px solid #000;">
                                <div style="font-size: 11px; width: 30%; float: left;">Nama Sampel</div>
                                <div style="font-size: 11px; float: left;">:</div>
                                <div style="font-size: 11px; float: left; width: 69%; ">&nbsp;{{ $permintaan->nama_sampel }}</div>
                                <br>
                                <div style="font-size: 11px; width: 30%; float: left;">Nama Pemilik Sampel</div>
                                <div style="font-size: 11px; float: left;">:</div>
                                <div style="font-size: 11px; float: left; width: 69%; ">&nbsp;{{ $permintaan->pemiliksampel->nama_pemilik }}</div>
                                <br>
                                <div style="font-size: 11px; width: 30%; float: left;">Alamat Pemilik Sampel</div>
                                <div style="font-size: 11px; float: left;">:</div>
                                <div style="font-size: 11px; float: left; width: 69%;">&nbsp;{{ $permintaan->pemiliksampel->alamat_pemilik }}</div>
                                <br>
                                <div style="font-size: 11px; width: 30%; float: left;">Nama / No. Tlp. Pembawa Sampel</div>
                                <div style="font-size: 11px; float: left;">:</div>
                                <div style="font-size: 11px; float: left; width: 69%; ">&nbsp;{{ $permintaan->pemiliksampel->nama_petugas . ' / ' . $permintaan->pemiliksampel->telepon_petugas }}</div>
                                <br>
                                <div style="font-size: 11px; width: 30%; float: left;">No. Kode Sampel</div>
                                <div style="font-size: 11px; float: left;">:</div>
                                <div style="font-size: 11px; float: left; width: 69%; ">&nbsp;{{ $permintaan->kode_sampel }}</div>
                                <br>
                                <div style="font-size: 11px; width: 30%; float: left;">Kemasan dan isi/berat</div>
                                <div style="font-size: 11px; float: left;">:</div>
                                <div style="font-size: 11px; float: left; width: 69%; ">&nbsp;{{ $permintaan->kemasan_sampel . ' / ' . $permintaan->berat_sampel }}</div>
                                <br>
                                <div style="font-size: 11px; width: 30%; float: left;">Jumlah Sampel yang diterima</div>
                                <div style="font-size: 11px; float: left;">:</div>
                                <div style="font-size: 11px; float: left; width: 69%; ">&nbsp;{{ $permintaan->jumlah_sampel }}</div>
                            </div>
                            <div style="width: 100%; margin-top: 20px; height: auto;">
                                <table style="border: 1px solid #000;">
                                <tr>                
                                    <th style="border: 1px solid #000; width:5%;">No.</th>
                                    <th style="border: 1px solid #000; width:40%;">Parameter / Metode Pengujian</th>
                                    <th style="border: 1px solid #000; width:10%;">Jumlah Pengujian</th>
                                    <th style="border: 1px solid #000; width:10%;">Kode & Jenis Layanan</th>
                                    <th style="border: 1px solid #000; width:15%;">Biaya (Rp)</th>
                                    <th style="border: 1px solid #000; width:20%;">Jumlah Biaya Pengujian</th>
                                </tr>
                                @php 
                                $total = 0;
                                $totalpersampel = 0;
                                @endphp
                                @foreach ($produksampel as $item)
                                    <tr>                
                                        <td style="border: 1px solid #000; width:5%; text-align: center">{{ $loop->iteration }}</td>
                                        <td style="border: 1px solid #000; width:40%; font-size: 11px;" colspan="4">{{ $item->nama_produk }}</td>
                                    </tr>
                                    @foreach ($item->ujiproduk as $i)
                                        <tr>
                                            <td style="border: 1px solid #000; font-size: 11px;"></td>
                                            <td style="border: 1px solid #000; font-size: 11px; text-align: left;">@isset($i->parameter){{ $i->parameter->parameter_uji ?? '-' . ' ('. $i->parameter->metodeuji->metode .')' }}@endisset</td>
                                            <td style="border: 1px solid #000; font-size: 11px; text-align: center;">{{ $i->jumlah_pengujian }}</td>
                                            <td style="border: 1px solid #000; font-size: 11px; text-align: center;">@isset($i->parameter){{ $i->parameter->metodeuji->kode_layanan }}@endisset</td>
                                            <td style="border: 1px solid #000; font-size: 11px; text-align: center;">@isset($i->parameter){{ number_format($i->parameter->metodeuji->biaya,0,',','.') }}@endisset</td>
                                            <td style="border: 1px solid #000; font-size: 11px; text-align: right;">@isset($i->parameter){{ number_format($i->parameter->metodeuji->biaya * $i->jumlah_pengujian,0,',','.') }}@endisset</td>
                                        </tr>
                                        @isset($i->parameter)
                                        @php
                                        $total += $i->parameter->metodeuji->biaya * $i->jumlah_pengujian;
                                        $totalpersampel += $i->parameter->metodeuji->biaya * $i->jumlah_pengujian;
                                        @endphp
                                        @endisset
                                    @endforeach
                                    <tr>
                                        <td colspan="5" style="border: 1px solid #000; font-size: 11px;">Total biaya per sampel ({{ $item->nama_produk }})</td>
                                        <td style="border: 1px solid #000; font-size: 11px; text-align: right; font-weight: bold;">{{ number_format($totalpersampel,0,',','.') }}</td>
                                    </tr>
                                    @php
                                        $totalpersampel = 0; //reset subtotal
                                    @endphp
                                @endforeach
                            
                                <div style="clear: both;"></div>
                                <tr>
                                    <td colspan="5" style="border: 1px solid #000; font-size: 11px;">Total Biaya (Rp)</td>
                                    <td style="border: 1px solid #000; font-size: 11px; text-align: right; font-weight: bold;">{{ number_format($total,0,',','.') }}</td>
                                </tr>
                                </table>
                            </div>
                            <div></div>
                            <div style="width: 45%; margin-top: auto;">
                                <div style="border:1px solid #000; font-size: 11px; width: 99.2%;">Keterangan Laboratorium</div>
                                <div style="font-size:11px; border-bottom: 1px solid #000; border-left:1px solid #000; ; float: left; width: 5%;">1.</div>
                                <div style="font-size:11px; border-bottom: 1px solid #000; float: left; width: 56.5%;">Reagen</div>
                                <div style="font-size:11px; border-bottom: 1px solid #000; float: left; width: 5%;">:</div>
                                <div style="font-size:11px; border-bottom: 1px solid #000; border-right:1px solid #000;  float: left; width: 32.9%;">Ada / Tidak Ada
                                </div>
                                <div style="font-size:11px; border-bottom: 1px solid #000; border-left:1px solid #000; ; float: left; width: 5%;">2.</div>
                                <div style="font-size:11px; border-bottom: 1px solid #000; float: left; width: 56.5%;">Alat dan Metode Analisa</div>
                                <div style="font-size:11px; border-bottom: 1px solid #000; float: left; width: 5%;">:</div>
                                <div style="font-size:11px; border-bottom: 1px solid #000; border-right:1px solid #000;  float: left; width: 32.9%;">Ada / Tidak Ada
                                </div>
                                <div style="font-size:11px; border-bottom: 1px solid #000; border-left:1px solid #000; ; float: left; width: 5%;">3.</div>
                                <div style="font-size:11px; border-bottom: 1px solid #000; float: left; width: 56.5%;">Buku Pembanding</div>
                                <div style="font-size:11px; border-bottom: 1px solid #000; float: left; width: 5%;">:</div>
                                <div style="font-size:11px; border-bottom: 1px solid #000; border-right:1px solid #000;  float: left; width: 32.9%;">Ada / Tidak Ada
                                </div>
                                <div style="font-size:11px; border-bottom: 1px solid #000; border-left:1px solid #000; ; float: left; width: 5%;">4.</div>
                                <div style="font-size:11px; border-bottom: 1px solid #000; float: left; width: 56.5%;">Jumlah Sampel</div>
                                <div style="font-size:11px; border-bottom: 1px solid #000; float: left; width: 5%;">:</div>
                                <div style="font-size:11px; border-bottom: 1px solid #000; border-right:1px solid #000;  float: left; width: 32.9%;">Ada / Tidak Ada
                                </div>
                    
                                <div style="font-size:11px; border-bottom: 1px solid #000; float: left; border-left:1px solid #000; width: 61.5%; text-align: left;">Tanggal Selesai Uji&nbsp;&nbsp;</div>
                                <div style="font-size:11px; border-bottom: 1px solid #000; float: left; width: 5%;">:</div>
                                <div style="font-size:11px; border-bottom: 1px solid #000; border-right:1px solid #000;  float: left; width: 32.9%;">
                                </div>
                                <div style="font-size:11px; border-bottom: 1px solid #000; float: left; border-left:1px solid #000; width: 61.5%; text-align: left;">Keterangan MA (tanggal selesai)</div>
                                <div style="font-size:11px; border-bottom: 1px solid #000; float: left; width: 5%;">:</div>
                                <div style="font-size:11px; border-bottom: 1px solid #000; border-right:1px solid #000;  float: left; width: 32.9%;">
                                </div>
                    
                            <div style="clear: both;"></div>
                            </div>
                                <p style="font-size: 11px; text-align: justify; margin-top: -18px;"> *)Bila sewaktu-waktu setelah sampel diterima, terjadi kerusakan alat instrumen yang memerlukan waktu dan perbaikan cukup lama, laboratorium dapat mengganti metode pengujian yang digunakan dengan metode lain yang sesuai atau dilakukan subkontrak pengujian atas persetujuan pelanggan</p>
                            </div>
                            <div style="width: 54%; float: left; margin-top: 10px;">
                                <p style="font-size: 11px;">PNBP Balai Besar POM</p><br>
                                <p style="font-size: 11px; margin-top: -32px;">di Mataram</p><br><br>            
                                <p style="font-size: 11px;">Miftahul Azizah, A.Md.</p><br>
                            </div>
                            <div style="width: 25%; float: right; margin-top: 10px;">
                                <p style="font-size: 11px;">Mataram, {{ now()->isoFormat('D MMMM Y') }}</p><br>
                                <p style="font-size: 11px; margin-top: -32px;">Pemilik / Pembawa Sampel</p><br><br>            
                                <p style="font-size: 11px;">{{ $permintaan->pemiliksampel->nama_petugas }}</p><br>            
                            </div>        
                            <div style="width: 98%; float: left; margin: -20px;">
                                <p style="font-size: 11px; text-align: center;"></p><br>
                                <p style="font-size: 11px; text-align: center; margin-top: -32px;">Koordinator Kelompok Substansi Pengujian</p><br><br>            
                                <p style="font-size: 11px; text-align: center;">Dra. Menik Sri Witari, Apt., MM.</p><br>            
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
        selector: '#kajiulang',
        plugins: 'print',
        menubar: false,
        toolbar: "print",
        branding: false,
        toolbar_sticky: true,
    });
</script>
@endpush