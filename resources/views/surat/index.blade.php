@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        @role('Guest')
            <div class="alert alert-error col-sm-12 text-center" role="alert">
                Akun belum diverifikasi oleh Staff Desa!
            </div>
            @if ($user->note_reject != '' || $user->note_reject != null)
                <div class="alert alert-error col-sm-12 text-center" role="alert">
                    Akun ditolak Staff Desa dengan alasan : <br>
                    {{ $user->note_reject }}
                </div>
            @endif
        @endrole

        @hasanyrole('User|Staff Desa')
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-left"><b>Surat</b></div>
                    <div class="row p-3">
                        <div class="col-sm-12">
                            <label>Filter</label>
                        </div>
                        <div class="col-sm-12">
                            <form action="{{ route('surat') }}" method="get" enctype="multipart/form-data" class="row"
                                id="filter">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>ID</label>
                                        <input type="text" name="id" class="form-control filter"
                                            value="{{ $filter['id'] }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Jenis Surat</label>
                                        <select name="template_surat_id" class="custom-select filter" id="type_surat">
                                            <option selected value="">Pilih...</option>
                                            @foreach ($listTemplateSurat as $item)
                                                <option value="{{ $item->id }}"
                                                    @if ($filter['template_surat_id'] == $item->id) selected @endif>{{ $item->type_surat }}
                                                </option>
                                            @endforeach
                                        </select>
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
                                    @role('Staff Desa')
                                        <div class="btn btn-outline-dark btn-opendialogreport" data-toggle="modal"
                                            data-target="#report">Download Laporan Surat</div>
                                    @endrole
                                    <button type="reset" class="btn btn-outline-dark">Reset</button>
                                    <button type="submit" class="btn btn-outline-dark">Cari</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <div class="table-responsive ">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th><b>ID</b></th>
                                        <th><b>Jenis Surat</b></th>
                                        <th><b>Tanggal Buat</b></th>
                                        @role('Staff Desa')
                                            <th><b>Dibuat Oleh</b></th>
                                        @endrole
                                        <th><b>Kode Surat Diprint</b></th>
                                        <th><b>Tanggal Surat Diprint Terakhir</b></th>
                                        <th>
                                            <b>
                                                @role('User')
                                                    <a href="{{ route('suratcreate') }}">
                                                        <button type="button" class="btn btn-outline-dark"><i
                                                                class="fas fa-plus"></i> Tambah
                                                            Surat</button>
                                                    </a>
                                                @endrole
                                            </b>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($count != 0)
                                        @foreach ($list as $key => $data)
                                            <tr>
                                                <td><b>{{ $data->id }}</b></td>
                                                <td>{{ $data->template_surat->type_surat }}</td>
                                                <td>{{ date('d M Y', strtotime($data->created_at)) }}</td>
                                                @role('Staff Desa')
                                                    <td>{{ $data->user->name }}</td>
                                                @endrole
                                                <td>{{ $data->code_surat_printed != null ? $data->code_surat_printed : '-' }}
                                                </td>
                                                <td>{{ $data->printed_at != null ? date('d M Y H:i', strtotime($data->printed_at)) : '-' }}
                                                </td>
                                                <td>
                                                    <div>
                                                        @role('User')
                                                            @if ($data->code_surat_printed == null)
                                                                <a href="{{ url('/surat/edit/' . $data->id . '') }}">
                                                                    <button class="btn btn-outline-dark"><i
                                                                            class="fas fa-edit"></i></button>
                                                                </a>
                                                            @endif
                                                        @endrole
                                                        @role('Staff Desa')
                                                            <button class="btn btn-outline-dark btn-print"
                                                                data-id="{{ $data->id }}" data-toggle="modal"
                                                                data-target="#print"><i class="fas fa-print"></i></button>
                                                        @endrole
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <td colspan="6">
                                            Tidak Ada Surat
                                        </td>
                                    @endif

                                </tbody>
                                <tfoot>
                                    <td colspan="3">
                                        {{ $list->links() }}
                                    </td>
                                    <td colspan="1" style="color: grey; font-family: sans-serif;">
                                        Total entries {{ $count }}
                                    </td>
                                </tfoot>

                            </table>

                        </div>
                    </div>
                </div>
            </div>
        @endhasanyrole



    </div>

    <div class="modal fade" id="print" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="print-title">Print Surat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="print-body">
                    <form id="generatePDF" action="{{ route('geerateSuratPDF') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Surat</label>
                            <input type="text" name="jenis" class="form-control jenisSurat" disabled>
                            <input type="hidden" name="jenisSurat" class="form-control jenisSurat">

                        </div>
                        <div class="form-group">
                            <label>Kode Surat</label>
                            <input type="text" name="codeSurat" id="codeSurat" class="form-control">
                        </div>
                        <div class="documents">

                        </div>
                        <div class="form-group">
                            <label>Body Surat</label>
                            <div class="d-flex justify-content-center">
                                <textarea class="form-control" id="editor" name="bodySurat"></textarea>
                            </div>

                            <input type="hidden" name="id" class="hidden-id">
                        </div>

                        <button type="submit" id="form-submit" style="opacity: 0"></button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-generate-pdf">Print</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="report" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="report-title">Download Laporan Surat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="print-body">
                    <form id="generateReport" action="{{ route('generateReportExcel') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Jenis Surat</label>
                            <select name="template_surat_id" class="custom-select report-input" data-label="Jenis Surat"
                                id="type_surat_report">
                                <option selected value="all">Semua</option>
                                @foreach ($listTemplateSurat as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->type_surat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Print Surat</label>
                            <div class="row">
                                <div class="col-sm-5">
                                    <input type="date" name="date_start" data-label="Tanggal Awal"
                                        id="tanggal_awal_report" class="form-control report-input">
                                </div>
                                <div class="col-sm-2 text-center valign-middle">
                                    Sampai dengan
                                </div>
                                <div class="col-sm-5">
                                    <input type="date" name="date_end" data-label="Tanggal Akhir"
                                        id="tanggal_akhir_report" class="form-control report-input">
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="btn-generate-report" hidden></button>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="btn btn-primary btn-generate-report">Download Laporan</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let validateReport = () => {
                let inputan = $('.report-input');
                let textError = '';

                inputan.each(function() {
                    let value = $(this).val();
                    let label = $(this).attr('data-label');

                    if (value === undefined || value === '') textError += label +
                        ' wajib diisi ! <br/>';
                });

                if (textError === '') {
                    let tanggalAwal = $('#tanggal_awal').val();
                    let tanggalAkhir = $('#tanggal_akhir').val();

                    if (tanggalAwal > tanggalAkhir) {
                        textError += 'Tanggal Awal tidak boleh lebih besar dari tanggal akhir ! <br/>';
                    }
                }

                return textError;
            }

            tinymce.init({
                selector: 'textarea#editor', // Replace this CSS selector to match the placeholder element for TinyMCE
                plugins: 'table lists',
                toolbar: 'undo redo | fontselect | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | table',
                font_formats: "Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
                content_style: "@import url('https://fonts.googleapis.com/css2?family=Oswald&display=swap');",
                width: 800
            });

            $(document).on('click', '.reset-filter', function() {
                $('.filter').val("");
                var url = '{{ route('surat', ':id') }}';
                url = url.replace(':id', '');
            });

            $(document).on('click', '.btn-print', function() {
                let id = $(this).attr('data-id');
                $('.hidden-id').val(id);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method: "POST",
                    url: "{{ route('getDataOnPrint') }}",
                    data: {
                        'id': id
                    },
                    success: function(data) {
                        console.log(data)
                        $('#editor').val(data.data.bodySurat);
                        $('.jenisSurat').val(data.data.jenisSurat);
                        $('#codeSurat').val(data.data.codeSurat);

                        if (data.data.isRePrint) {
                            $('.btn-generate-pdf').html('Print Ulang')
                        } else {
                            $('.btn-generate-pdf').html('Print');
                        }

                        if (data.data.document !== undefined && data.data.document.length > 0) {
                            $('.documents').html("");
                            data.data.document.forEach(doc => {
                                let url = doc.value;
                                $('.documents').append(`<div class="form-group">
                                    <a href="${url}" target="_blank">Lihat ${doc.label}</a>
                                </div>`);
                            });
                        } else {
                            $('.documents').html("");
                        }

                        tinymce.get('editor').setContent(data.data.bodySurat);
                    }
                });
            });

            $(document).on('click', '.btn-generate-pdf', function() {
                $("#form-submit").click();
            })

            $(document).on('click', '.close', function() {
                console.log('close modal');
                tinymce.get('editor').setContent('');
            });

            $(document).on('click', '.btn-generate-report', function() {
                let tipeSurat = $('#type_surat_report').val();
                let tanggalAwal = $('#tanggal_awal_report').val();
                let tanggalAkhir = $('#tanggal_akhir_report').val();
                let validasi = validateReport()
                if (validasi === '') {
                    Swal.fire({
                        title: "Apakah anda yakin?",
                        text: "Download Laporan Ini?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, Download!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#btn-generate-report').click();
                            // $.ajax({
                            //     headers: {
                            //         'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            //     },
                            //     method: "POST",
                            //     url: "{{ route('generateReportExcel') }}",
                            //     data: {
                            //         'type_surat': tipeSurat,
                            //         'tanggal_awal': tanggalAwal,
                            //         'tanggal_akhir': tanggalAkhir
                            //     },
                            //     success: function(data) {
                            //         console.log('data balikannya', data);
                            //     }
                            // });
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
