<!-- Modal -->
<div class="modal fade" id="modaltracking" tabindex="-1" role="dialog" aria-labelledby="modalTrackingTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltrackingtitle" style="color: #000;">Tracking Sampel</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card-body text-dark">
          <h2>Status Sampel : <b id="statussampel">Status</b></h2>
          <div class="row">
            <div class="col-lg-6">
              <fieldset class="border p-2 pt-0 h-100">
                <legend class="w-auto px-1 my-0">Data Sampel</legend>
                <div class="form-group">
                  <div class="font-weight-bold">NOMOR URUT</div>
                  <div><mark class="rounded font-weight-bold"><span id="no_urut_penerimaan">No Urut</span></mark>
                  </div>
                </div>
                <div class="form-group">
                  <div class="font-weight-bold">KODE SAMPEL</div>
                  <div><mark class="rounded font-weight-bold"><span id="kodesampel">KODE SAMPEL</span></mark></div>
                </div>
                <div class="form-group">
                  <div class="font-weight-bold">NAMA</div>
                  <div class="text-justify"><mark class="rounded font-weight-bold"><span
                        id="namasampel">NAMA</span></mark></div>
                </div>
                <div class="form-group">
                  <div class="font-weight-bold">KEMASAN</div>
                  <div><mark class="rounded font-weight-bold"><span id="kemasansampel">KEMASAN</span></mark></div>
                </div>
                <div class="form-group">
                  <div class="font-weight-bold">BERAT</div>
                  <div><mark class="rounded font-weight-bold"><span id="beratsampel">BERAT</span></mark></div>
                </div>
                <div class="form-group">
                  <div class="font-weight-bold">JUMLAH</div>
                  <div><mark class="rounded font-weight-bold"><span id="jumlahsampel">JUMLAH</span></mark></div>
                </div>
                <input type="hidden" id="id_permintaan">
                <div class="btnContainer"></div>
              </fieldset>
            </div>
            <div class="col-lg-6">
              <fieldset class="border p-2 pt-0 h-100">
                <legend class="w-auto px-1 my-0">Tracking Sampel</legend>
                <div class="form-group">
                  <div class="font-weight-bold">WAKTU TERIMA</div>
                  <div><mark class="rounded font-weight-bold"><span id="waktuterima">TANGGAL</span></mark></div>
                </div>
                <div class="form-group">
                  <div class="font-weight-bold">WAKTU VERIFIKASI</div>
                  <div><mark class="rounded font-weight-bold"><span id="waktuverifikasi">TANGGAL</span></mark></div>
                </div>
                <div class="form-group">
                  <div class="font-weight-bold">WAKTU KAJI ULANG</div>
                  <div><mark class="rounded font-weight-bold"><span id="waktukajiulang">TANGGAL</span></mark></div>
                </div>
                <div class="form-group">
                  <div class="font-weight-bold">WAKTU PEMBAYARAN</div>
                  <div><mark class="rounded font-weight-bold"><span id="waktupembayaran">TANGGAL</span></mark></div>
                </div>
                <div class="form-group">
                  <div class="font-weight-bold">WAKTU PENGUJIAN</div>
                  <div><mark class="rounded font-weight-bold"><span id="waktupengujian">TANGGAL</span></mark></div>
                </div>
                <div class="form-group">
                  <div class="font-weight-bold">WAKTU SELESAI UJI</div>
                  <div><mark class="rounded font-weight-bold"><span id="waktuselesaiuji">TANGGAL</span></mark></div>
                </div>
                <div class="form-group">
                  <div class="font-weight-bold">WAKTU LEGALISIR</div>
                  <div><mark class="rounded font-weight-bold"><span id="waktulegalisir">TANGGAL</span></mark></div>
                </div>
                <div class="form-group">
                  <div class="font-weight-bold">WAKTU SELESAI</div>
                  <div><mark class="rounded font-weight-bold"><span id="waktuselesai">TANGGAL</span></mark></div>
                </div>
                <div class="form-group">
                  <div class="font-weight-bold">WAKTU DIAMBIL</div>
                  <div><mark class="rounded font-weight-bold"><span id="waktudiambil">TANGGAL</span></mark></div>
                </div>
                <div class="form-group">
                  <div class="font-weight-bold">WAKTU ESTIMASI</div>
                  <div><mark class="rounded font-weight-bold"><span id="waktuestimasi">TANGGAL</span></mark></div>
                </div>
              </fieldset>
            </div>
            <div class="col">
              <fieldset class="border p-2 pt-0">
                <legend class="w-auto px-1 my-0">Pemilik Sampel</legend>
                <div class="form-group">
                  <div class="font-weight-bold">INSTANSI</div>
                  <div><mark class="rounded font-weight-bold"><span id="namapemilik">INSTANSI</span></mark></div>
                </div>
                <div class="form-group">
                  <div class="font-weight-bold">ALAMAT INSTANSI</div>
                  <div><mark class="rounded font-weight-bold"><span id="alamatpemilik">ALAMAT INSTANSI</span></mark>
                  </div>
                </div>
                <div class="form-group">
                  <div class="font-weight-bold">Nama Petugas</div>
                  <div><mark class="rounded font-weight-bold"><span id="namapetugas">Nama Petugas</span></mark></div>
                </div>
                <div class="form-group">
                  <div class="font-weight-bold">Telepon Petugas</div>
                  <div><mark class="rounded font-weight-bold"><span id="teleponpetugas">Telepon Petugas</span></mark>
                  </div>
                </div>
              </fieldset>
              <fieldset class="border p-2 pt-0">
                <legend class="w-auto px-1 my-0">Detail Sampel</legend>
                  <table id="detailterimasampel" class="table text-dark bg-transparent w-100">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Jenis Produk</th>
                        <th>Parameter Uji</th>
                        <th>Jumlah Pengujian</th>
                        <th>Biaya</th>
                        <th>Hasil Uji</th>
                        <th>Tersangka</th>
                        <th>Saksi Ahli</th>
                        <th>Download</th>
                    </tr>
                  </thead>
                </table>
              </fieldset>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>