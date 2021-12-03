@extends('layouts/front')

@push('styles')
<style>
    .select2-results__option {
        color: #000;
    }

    .select2-container--classic .select2-results__option--highlighted.select2-results__option--selectable {
        background-color: #99CCCC;
    }
</style>
@endpush

@section('content')
<div class="tm-row">
    <div class="tm-col-left"></div>
    <main class="tm-col-right">
        <section class="tm-content">
            <h2 class="mb-5 tm-content-title">Daftar Biaya Pengujian</h2>
            <select name="idSampel" id="idSampel" class="form-control select2">
            </select>
            <button type="button" class="btn btn-primary rounded mt-4 biayauji">Cek</button>
        </section>
    </main>
</div>
@include('modals.biayauji')
@endsection

@push('scripts')
<script>

    function filllistsampel() {
        $.ajax({
            type: "GET",
            url: "{{ route('dthargaproduk') }}",
            success: function (response) {
                $("#idSampel").append("<option value=''>==Pilih Jenis Produk==</option>"); 
                var len = 0;
                if(response['data'] != null){
                    len = response['data'].length;
                }

                if(len > 0){
                    // Read data and create <option >
                    for(var i=0; i<len; i++){

                    var id = response['data'][i].id_produk;
                    var nama_produk = response['data'][i].nama_produk;

                    var option = "<option value='"+id+"'>"+nama_produk+"</option>";
                        
                    $("#idSampel").append(option); 
                    }
                }
            }
        });
    }

    $(function () {
        $('.select2').select2();

        filllistsampel();

        $('body').on('click', 'button.biayauji', function(e){
            e.preventDefault();
            $('#modalbiayauji').modal('show');

            const id = $('#idSampel').val();
            let url = "{{ route('dthargaproduk', "_id")}}";
            url = url.replace("_id", id);
            alert(id)
            
            $.ajax({
                type: "GET",
                url,
                success: function (response) {
                    const data = response.data[0];
                    $('#nama_produk').text(data.nama_produk);
                    $('.card-body').append(data.keterangan);
                }
            });
        });
    });
</script>
@endpush