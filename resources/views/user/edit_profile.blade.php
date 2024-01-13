@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><b>Edit Data</b></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ url('/user/update/' . $data->id . '') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="nik" value="{{ $data->nik }}">
                        <div class="form-group">
                            <label>Role</label>
                            <input type="text" name="role" class="form-control" value="{{ $role }}" disabled>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control mandatory" data-label="Nama"
                                value="{{ $data->name }}">
                        </div>
                        <div class="form-group">
                            <label>No KK</label>
                            <input type="text" name="no_kk" class="form-control onlynumber" data-label="No KK"
                                value="{{ $data->no_kk }}" maxlength="16">
                        </div>
                        <div class="form-group">
                            <label>Agama</label>
                            <select name="agama" class="custom-select" id="type_surat" data-label="Agama">
                                <option value="">Pilih...</option>
                                @foreach ($listAgama as $value)
                                    <option value="{{ $value }}" @if ($data->agama == $value) selected @endif>
                                        {{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="custom-select" id="type_surat" data-label="Jenis Kelamin">
                                <option value="">Pilih...</option>
                                @foreach ($listJenisKelamin as $value)
                                    <option value="{{ $value }}" @if ($data->jenis_kelamin == $value) selected @endif>
                                        {{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Pekerjaan</label>
                            <input type="text" name="pekerjaan" class="form-control" data-label="Pekerjaan"
                                value="{{ $data->pekerjaan }}">
                        </div>
                        <div class="form-group">
                            <label>Tempat tanggal Lahir</label>
                            <div class="row">
                                <div class="col-sm-8">
                                    <input type="text" name="tempat_lahir" class="form-control"
                                        value="{{ $data->tempat_lahir }}">
                                </div>
                                <div class="col-sm-4">
                                    <input type="date" name="tanggal_lahir" class="form-control"
                                        value="{{ date('Y-m-d', strtotime($data->tanggal_lahir)) }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <input type="text" name="alamat" class="form-control" value="{{ $data->alamat }}">
                        </div>
                        <div class="form-group">
                            <label>Password Baru</label>
                            <input type="password" name="password" class="form-control password">
                        </div>
                        <div class="form-group">
                            <label>Password Konfirmasi</label>
                            <input type="password" name="repassword" class="form-control repassword">
                        </div>
                        <div class="form-group">
                            <label>KTP</label>
                            <img src="{{ asset('img/ktp/' . $data->ktp) }}" alt="..." class="img-thumbnail"
                                style="width: 130px; height: 100px; accept="image/jpeg">
                            <input type="file" name="ktp">
                        </div>
                        <input type="submit" value="Save Change" class="btn btn-primary float-left" id="btn-submit" hidden>
                        <div class="btn btn-primary float-left btn-submit">Submit</div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            let validate = () => {
                let inputan = $('.mandatory');
                let textError = '';
                let password = $('.password').val();

                inputan.each(function() {
                    let value = $(this).val();
                    let label = $(this).attr('data-label');

                    if (value === undefined || value === '') textError += label +
                        ' wajib diisi ! <br/>';
                });
                if (password != "") {
                    let rePassword = $('.repassword').val();
                    if (password.trim().length < 8) {
                        textError += "Password Minimal 8 karakter ! <br/>";
                    }

                    if (rePassword.trim() === "") {
                        textError += "Password Konfrimasi wajib diisi ! <br/>";
                    }

                    if (password.trim() != rePassword.trim()) {
                        textError += "Password harus sama dengan password konfirmasi ! <br/>";
                    }
                }

                return textError;
            }

            $(document).on('click', '.btn-submit', function() {
                let validasi = validate()
                if (validasi === '') {
                    Swal.fire({
                        title: "Apakah anda yakin?",
                        text: "Mengubah surat ini?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, Ubah!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#btn-submit').click();
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
        });
    </script>
@endsection
