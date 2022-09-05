<!-- Modal -->
<div class="modal fade" id="modaltracking" tabindex="-1" role="dialog" aria-labelledby="modalTrackingTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltrackingtitle">Tracking Sampel</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <h2>Status Sampel : <b id="statussampel">Status</b></h2>
          <div class="row">
            <div class="col-lg-6">
              <fieldset class="p-2 pt-0 h-100">
                <legend class="w-auto px-1 my-0 font-weight-bold">Data Sampel</legend>
                <div class="form-group">
                  <div class="font-weight-light">NOMOR URUT</div>
                  <div class="rounded p-2 bg-light w-auto font-weight-light"><span id="no_urut_penerimaan">No
                      Urut</span>
                  </div>
                </div>
                <div class="form-group">
                  <div class="font-weight-light">KODE SAMPEL</div>
                  <div class="rounded p-2 bg-light w-auto font-weight-light"><span id="kodesampel">KODE SAMPEL</span>
                  </div>
                </div>
                <div class="form-group">
                  <div class="font-weight-light">NAMA</div>
                  <div class="rounded p-2 bg-light w-auto font-weight-light"><span id="namasampel">NAMA</span></div>
                </div>
                <div class="form-group">
                  <div class="font-weight-light">KEMASAN</div>
                  <div class="rounded p-2 bg-light w-auto font-weight-light"><span id="kemasansampel">KEMASAN</span>
                  </div>
                </div>
                <div class="form-group">
                  <div class="font-weight-light">BERAT</div>
                  <div class="rounded p-2 bg-light w-auto font-weight-light"><span id="beratsampel">BERAT</span></div>
                </div>
                <div class="form-group">
                  <div class="font-weight-light">JUMLAH</div>
                  <div class="rounded p-2 bg-light w-auto font-weight-light"><span id="jumlahsampel">JUMLAH</span></div>
                </div>
                <input type="hidden" id="id_permintaan">
                <div class="btnContainer"></div>
              </fieldset>
            </div>
            <div class="col-lg-6">
              <fieldset class="p-2 pt-0 h-100">
                <legend class="w-auto px-1 my-0 font-weight-bold">Tracking Sampel</legend>
                <div class="form-group">
                  <div>WAKTU TERIMA</div>
                  <div class="value"><span id="waktuterima">TANGGAL</span></div>
                </div>
                <div class="form-group">
                  <div>WAKTU VERIFIKASI</div>
                  <div class="value"><span id="waktuverifikasi">TANGGAL</span></div>
                </div>
                <div class="form-group">
                  <div>WAKTU KAJI ULANG</div>
                  <div class="value"><span id="waktukajiulang">TANGGAL</span></div>
                </div>
                <div class="form-group">
                  <div>WAKTU PEMBAYARAN</div>
                  <div class="value"><span id="waktupembayaran">TANGGAL</span></div>
                </div>
                <div class="form-group">
                  <div>WAKTU PENGUJIAN</div>
                  <div class="value"><span id="waktupengujian">TANGGAL</span></div>
                </div>
                <div class="form-group">
                  <div>WAKTU SELESAI UJI</div>
                  <div class="value"><span id="waktuselesaiuji">TANGGAL</span></div>
                </div>
                <div class="form-group">
                  <div>WAKTU LEGALISIR</div>
                  <div class="value"><span id="waktulegalisir">TANGGAL</span></div>
                </div>
                <div class="form-group">
                  <div>WAKTU SELESAI</div>
                  <div class="value"><span id="waktuselesai">TANGGAL</span></div>
                </div>
                <div class="form-group">
                  <div>WAKTU DIAMBIL</div>
                  <div class="value"><span id="waktudiambil">TANGGAL</span></div>
                </div>
                <div class="form-group">
                  <div>WAKTU ESTIMASI</div>
                  <div class="value"><span id="waktuestimasi">TANGGAL</span></div>
                </div>
              </fieldset>
            </div>
            <div class="col">
              <fieldset class="p-2 pt-0">
                <legend class="w-auto px-1 my-0 font-weight-bold">Pemilik Sampel</legend>
                <div class="form-group">
                  <div>INSTANSI</div>
                  <div class="value"><span id="namapemilik">INSTANSI</span></div>
                </div>
                <div class="form-group">
                  <div>ALAMAT INSTANSI</div>
                  <div class="value"><span id="alamatpemilik">ALAMAT INSTANSI</mark>
                  </div>
                </div>
                <div class="form-group">
                  <div>Nama Petugas</div>
                  <div class="value"><span id="namapetugas">Nama Petugas</span></div>
                </div>
                <div class="form-group">
                  <div>Telepon Petugas</div>
                  <div class="value"><span id="teleponpetugas">Telepon Petugas</mark>
                  </div>
                </div>
              </fieldset>
              <fieldset class="overflow-auto p-2 pt-0">
                <legend class="w-auto px-1 my-0 font-weight-bold">Detail Sampel</legend>
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