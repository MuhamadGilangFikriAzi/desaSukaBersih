<!DOCTYPE html>
<html>

<head>
    <title>register</title>
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <script src="{{ url('limitless/global_assets/js/main/jquery.min.js') }}"></script>
    <script src="{{ url('limitless/global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('limitless/global_assets/js/plugins/loaders/blockui.min.js') }}"></script>
    <script src="{{ url('limitless/global_assets/js/plugins/ui/ripple.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                                    <h1 class="h4 text-gray-900 mb-4">Daftar Akun SIPAK</h1>
                                </div>

                                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input id="name" type="text"
                                            class="form-control mandatory @error('name') is-invalid @enderror"
                                            name="name" placeholder="Nama" data-label="Nama"
                                            value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>NIK</label>
                                        <input id="nik" type="text"
                                            class="form-control mandatory onlynumber @error('nik') is-invalid @enderror"
                                            name="nik" maxlength="16" data-label="NIK" placeholder="NIK"
                                            value="{{ old('nik') }}" required autocomplete="nik">

                                        @error('nik')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>KTP</label> <span>upload foto KTP dengan format jpeg</span>
                                        <input id="ktp" type="file" accept="image/jpeg"
                                            class="form-control mandatory @error('ktp') is-invalid @enderror"
                                            name="ktp" placeholder="ktp" data-label="KTP"
                                            value="{{ old('ktp') }}" required autocomplete="ktp">

                                        @error('ktp')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Password</label>
                                        <input id="password" type="password"
                                            class="form-control mandatory @error('password') is-invalid @enderror"
                                            name="password" placeholder="password" data-label="Password" required
                                            autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Password Konfirmasi</label>
                                        <input id="password-confirm" type="password" class="form-control mandatory"
                                            name="password_confirmation" data-label="Password Konfirmasi"
                                            placeholder="password_confirmation" required autocomplete="new-password">
                                    </div>

                                    <div class="form-group row mb-0">
                                        <button type="submit" id="submit" class="btn btn-dark" style="width: 100%;"
                                            hidden>
                                            {{ __('Daftar') }}
                                        </button>
                                        <div class="btn btn-dark btn-submit" style="width: 100%">Daftar</div>
                                        <a href="{{ route('login') }}" style="width: 100%;" class="btn btn-dark my-2">
                                            Kembali
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
<script>
    $(document).ready(function() {
        $(document).on('keyup', '.onlynumber', function() {
            let text = $(this).val()
            text = text.replace(/[^0-9]/, "");
            $(this).val(text);
        });

        let validate = () => {
            let inputan = $('.mandatory');
            let textError = '';

            inputan.each(function() {
                let value = $(this).val();
                let label = $(this).attr('data-label');

                if (value === undefined || value === '') textError += label +
                    ' wajib diisi ! <br/>';
            });

            const fileName = document.querySelector('#ktp').value;
            const extension = fileName.split('.').pop();
            console.log('filename :', fileName, ' extension : ', extension);
            if (fileName !== "" && extension.toLowerCase() !== 'jpeg') {
                textError += "Hanya bisa upload KTP Berformat .jpeg";
            }

            return textError;
        }

        $(document).on('click', '.btn-submit', function() {
            let validasi = validate()
            if (validasi === '') {
                Swal.fire({
                    title: "Apakah anda yakin?",
                    text: "Mendaftar sebagai user SIPAK?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Daftar!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#submit').click();
                    }
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Validasi",
                    html: validasi
                });
            }
        });
    })
</script>
<script src="{{ url('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ url('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

</html>
