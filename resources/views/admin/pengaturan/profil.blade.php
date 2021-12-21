@extends('layouts.admin.app')

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card">
                    {{-- <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Sales
                        </h3>
                        <div class="card-tools">
                            <ul class="nav nav-pills ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
                                </li>
                            </ul>
                        </div>
                    </div><!-- /.card-header --> --}}
                    <div class="card-body">
                        <div class="line">
                            <div class="label">Nama</div>
                            <div class="value">{{ auth()->user()->name }}</div>
                        </div>
                        <div class="line">
                            <div class="label">Username</div>
                            <div class="value">{{ auth()->user()->username }}</div>
                        </div>
                        <div class="line">
                            <div class="label">Email</div>
                            <div class="value">{{ auth()->user()->email }}</div>
                        </div>
                        <div class="line">
                            <div class="label">Level</div>
                            <div class="value text-primary">@level(auth()->user()->level)</div>
                        </div>
                        <div class="line">
                            <div class="label">Foto Profil</div>
                            <div class="value"><img src="{{ Storage::url("profiles/".auth()->user()->image) }}" alt="profile photo" width="150px"></div>
                        </div>
                        <div class="line">
                            <button id="changepwd" class="btn btn-danger mt-3" data-toggle="modal" data-target="#modalprofile">Ubah Password</button>
                        </div>
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </section>
            <!-- /.Left col -->
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
    @include('modals.pengaturan.profile')
</section>
<!-- /.content -->
@endsection
@push('styles')
    <style>
        .label {
            font-weight: bold;
            display: inline-block;
            font-size: 20px;
            width: 120px;
            line-height: 40px;
        }

        .value {
            display: inline-block;
            font-size: 20px;
        }

        .value img {
            vertical-align: top;
            border-radius: 50%;
        }

        .value::before {
            content: ': '
        }
        
    </style>
@endpush

@push('scripts')
    <script>
        $(function () {
            $('.modal').on('click', '.submit', function(e){
                e.preventDefault();
                let data = new FormData($('form')[0]);
                data.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    type: "POST",
                    url: "{{ route('changepwd') }}",
                    data,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if(response.status){
                            $('#modalprofile').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                html: response.msg,
                            })
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Update Password',
                                html: response.msg,
                            })
                        }
                    },
                    error: function(err){
                        if(err.status == 422){
                        let errMsg = '';
                        $.each(err.responseJSON.errors, function (indexInArray, valueOfElement) {
                            $.each(valueOfElement, function (indexInArray, valueOfElement) { 
                            errMsg += '<li class="text-left">' + valueOfElement + '</li>';
                            });
                        });

                        Swal.fire({
                            icon: 'error',
                            title: err.responseJSON.message,
                            html: '<ul>' + errMsg + '</ul>',
                        })
                        }
                    }
                });
            });

            $('#modalprofile').on('hidden.bs.modal', function(e){
                $('form').trigger('reset');
            })
        });//end jq ready
    </script>
@endpush