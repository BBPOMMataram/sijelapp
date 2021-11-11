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
                <option value="">==Pilih Sampel==</option>

                <option value="1">Pilih Sampel</option>
            </select>
            <button type="button" class="btn btn-primary rounded mt-4" data-toggle="modal" data-target="#modalTracking">Cek</button>
        </section>
    </main>
</div>
@endsection

@push('scripts')
<script>
    $(function () {
        $('.select2').select2();
    });
</script>
@endpush