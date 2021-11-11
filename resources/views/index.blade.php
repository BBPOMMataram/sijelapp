@extends('layouts/front')

@section('content')
<div class="tm-row">
    <div class="tm-col-left"></div>
    <main class="tm-col-right">
        <section class="tm-content">
            <h2 class="mb-5 tm-content-title">Tracking Sampel</h2>
            {{-- <p class="mb-5">Diagoona is provided by TemplateMo website. You are allowed to use this template for
                your websites. You are NOT allowed to redistribute this template ZIP file for a download purpose on any
                template collection website.</p> --}}
            <div><input type="text" name="kodeSampel" id="kodeSampel" placeholder="Kode Sampel"
                    class="form-control px-2 rounded" autofocus></div>
            {{--
            <hr class="mb-5"> --}}
            {{-- <p class="mb-5">Diagoona is Bootstrap v4.4.1 layout. This BG is 50% transparent. You can set the
                background images auto play settings (true or false in line number 33) in templatemo-script.js file in
                js folder.</p> --}}
            <button type="button" class="btn btn-primary rounded mt-4" data-toggle="modal" data-target="#modalTracking">Track</button>
        </section>
    </main>
</div>

@include('modals.tracking')
@endsection

@push('scripts')
    <script>
        tippy('#kodeSampel', {
        content: 'input kode sampel',
        trigger: 'mouseenter',
        animation: 'scale',
      });
    </script>
@endpush