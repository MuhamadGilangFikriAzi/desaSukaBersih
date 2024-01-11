@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-left"><b>User</b></div>
                <div class="row p-3">
                    <div class="col-sm-12">
                        <label>Filter</label>
                    </div>
                    <div class="col-sm-12">
                        <form action="{{ route('user') }}" method="get" enctype="multipart/form-data" class="row"
                            id="filter">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="name" class="form-control filter"
                                        value="{{ $filter['name'] }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tanggal Buat</label>
                                    <input type="date" name="created_at" class="form-control filter"
                                        value="{{ $filter['created_at'] }}">
                                </div>
                            </div>

                            <div class="col-sm-12 text-right">
                                <button type="reset" class="btn btn-outline-dark">Reset</button>
                                <button type="submit" class="btn btn-outline-dark">Cari</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td><b>No</b></td>
                                    <td><b>Nama</b></td>
                                    <td><b>Role</b></td>
                                    <td><b>Tanggal Buat</b></td>
                                    <td><b>Action</b></td>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($list as $key => $l)
                                    <tr>
                                        <td><b>{{ $key + 1 }}</b></td>
                                        <td>{{ $l->name }}</td>
                                        <td>{{ $l->roles->pluck('name')[0] }}</td>
                                        <td>{{ date('d M Y', strtotime($l->created_at)) }}</td>
                                        <td>
                                            <div>
                                                <button class="btn btn-outline-dark btn-show" data-id="{{ $l->id }}"
                                                    data-toggle="modal" data-target="#show">Show</button>
                                            </div>
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No data available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <td colspan="3">
                                    {{ $list->links() }}
                                </td>
                                <td colspan="1" style="color: grey; font-family: sans-serif;">
                                    Total entries {{ $data }}
                                </td>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="show" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="show-title">Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="show-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" disabled>
                        <input type="hidden" name="" id="userID">
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <input type="text" name="role" id="role" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label>NIK</label>
                        <input type="text" name="nik" id="nik" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label>Agama</label>
                        <input type="text" name="agama" id="agama" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <input type="text" name="jenisKelamin" id="jenisKelamin" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat" id="alamat" cols="30" rows="10" class="form-control" disabled></textarea>
                    </div>
                    <div class="form-group">
                        <label>KTP</label><br>
                        <img src="" alt="..." class="img-thumbnail" style="width: 80%; height: 500px;"
                            id="ktp">
                    </div>
                </div>
                <div class="modal-footer">
                    @role('Staff Desa')
                        <div class="for-footer">
                            <button type="button" class="btn btn-outline-dark btn-verif" data-id="">Verifikasi
                                User</button>
                            <button type="button" class="btn btn-outline-dark btn-staffDesa" data-id="">Jadikan Staff
                                Desa</button>
                        </div>
                    @endrole
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            // $('.bt-print').on('click', function() {
            //     let id = $(this).attr('data-id');
            //     console.log(id);
            // })

            $(document).on('click', '.btn-show', function() {
                let id = $(this).attr('data-id');
                console.log('idnya', id);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method: "POST",
                    url: "{{ route('getDataUserByID') }}",
                    data: {
                        'id': id
                    },
                    success: function(data) {
                        let resp = data.data;
                        let urlImg = "{{ asset('img/ktp/') }}";
                        urlImg += "/" + resp.data.ktp;
                        $('#nama').val(resp.data.name);
                        $('#agama').val(resp.data.agama);
                        $('#alamat').val(resp.data.alamat);
                        $('#nik').val(resp.data.nik);
                        $('#jenisKelamin').val(resp.data.jenis_kelamin);
                        $('#ktp').attr("src", urlImg)
                        $('#role').val(resp.role)
                        $('#userID').val(resp.data.id);
                        console.log(data)
                    }
                });
            })

            $(document).on('click', '.btn-verif', function() {
                Swal.fire({
                    title: "Apakah anda yakin?",
                    text: "Melakukan Verifikasi terhadap akun ini?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Verifikasi!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        giveRole("User")
                    }
                });
            });

            $(document).on('click', '.btn-staffDesa', function() {
                Swal.fire({
                    title: "Apakah anda yakin?",
                    text: "Memberikan akses akun sebagai Staff Desa?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Berikan!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        giveRole("Staff Desa")
                    }
                });
            });

            function giveRole(role) {
                let id = $('#userID').val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method: "POST",
                    url: "{{ route('giveUserRole') }}",
                    data: {
                        'id': id,
                        'role': role
                    },
                    success: function(data) {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Akun telah terverifikasi",
                            icon: "success"
                        });
                        $('#show').modal().hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                    }
                });
            }
        });
    </script>
@endsection
