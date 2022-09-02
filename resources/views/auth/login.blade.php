<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SIJELAPP - BBPOM di Mataram</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('vendor/admin/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('vendor/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('vendor/admin/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary" style="border-top: 3px solid #00A550;">
      <div class="card-header text-center">
        <a href="#" class="h1"><b>Admin </b><span style="color:#FFC300">Si</span><span style="color:#004282">je</span><span style="color:#00A550">la</span><span style="color:#7A9CBD">pp</span></a>
      </div>
      <div class="card-body">
        <p class="login-box-msg"><span style="color:#FFC300">Sistem</span> <span style="color:#004282">Jejak Telusur</span> <span style="color:#00A550">Laporan</span> <span style="color:#7A9CBD">Pengujian Pihak Ketiga</span></p>

        <form action="{{ route('login') }}" method="post">
          @csrf
          <div class="input-group mb-3">
            <input type="text" name="username" class="form-control" placeholder="Username or Email" value="{{ old('username') }}">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope" style="color: #004282"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock" style="color: #00A550"></span>
              </div>
            </div>
          </div>
          <div class="row item-center">
            @error('username')
            <div class="col-12">
              <div class="text-danger">
                  <strong>{{ $message }}</strong>
                </span>
              </div>
            </div>
            @enderror
            @error('email')
            <div class="col-12">
              <div class="text-danger">
                  <strong>{{ $message }}</strong>
                </span>
              </div>
            </div>
            @enderror
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-block font-weight-light" style="background-color:#00A550; color:#fff;">Login</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        {{-- <p class="mb-1">
          <a href="{{ route('password.request') }}">I forgot my password</a>
        </p> --}}
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="{{ asset('vendor/admin/plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('vendor/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('vendor/admin/dist/js/adminlte.min.js') }}"></script>
</body>

</html>