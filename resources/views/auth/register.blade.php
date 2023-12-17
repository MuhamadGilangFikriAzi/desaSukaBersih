<!DOCTYPE html>
<html>

<head>
    <title>register</title>
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
</head>

<body>
    <div class="row justify-content-center">
        <div class="col-xl-6 col-sm-6 col-md-6">
            <div class="card o-hidden bordered-0 shadow-sm-2 my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Register</h1>
                                </div>

                                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            placeholder="Nama" value="{{ old('name') }}" required autocomplete="name"
                                            autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>NIK</label>
                                        <input id="nik" type="text"
                                            class="form-control @error('nik') is-invalid @enderror" name="nik"
                                            maxlength="16" placeholder="NIK" value="{{ old('nik') }}" required
                                            autocomplete="nik">

                                        @error('nik')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>KTP</label>
                                        <input id="ktp" type="file" accept="image/*"
                                            class="form-control @error('ktp') is-invalid @enderror" name="ktp"
                                            placeholder="ktp" value="{{ old('ktp') }}" required autocomplete="ktp">

                                        @error('ktp')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Password</label>
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            placeholder="password" required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Password Confirm</label>
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" placeholder="password_confirmation" required
                                            autocomplete="new-password">
                                    </div>

                                    <div class="form-group row mb-0">
                                        <button type="submit" class="btn btn-dark" style="width: 100%;">
                                            {{ __('Register') }}
                                        </button>
                                        <a href="{{ route('login') }}" style="width: 100%;">
                                            <button class="btn btn-dark my-2" style="width: 100%;">
                                                Back
                                            </button>
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
