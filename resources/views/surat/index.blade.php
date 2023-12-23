@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        @role('Guest')
            <div class="alert alert-error col-sm-12 text-center" role="alert">
                Akun belum diverifikasi oleh Staff Desa!
            </div>
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
                                        <label>Type Surat</label>
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
                                        <th><b>Type Surat</b></th>
                                        <th><b>Tanggal Buat</b></th>
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
                                    @foreach ($list as $key => $data)
                                        <tr>
                                            <td><b>{{ $data->id }}</b></td>
                                            <td>{{ $data->template_surat->type_surat }}</td>
                                            <td>{{ date('d M Y', strtotime($data->created_at)) }}</td>
                                            <td>
                                                <div>
                                                    @role('User')
                                                        <a href="{{ url('/surat/edit/' . $data->id . '') }}">
                                                            <button class="btn btn-outline-dark"><i
                                                                    class="fas fa-edit"></i></button>
                                                        </a>
                                                        {{-- <a href="{{ url('/templatesurat/destroy/' . $data->id . '') }}">
                                                        <button class="btn btn-outline-dark"><i
                                                                class="fas fa-trash"></i></button>
                                                    </a> --}}
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
                            <textarea class="form-control" id="editor" name="bodySurat"></textarea>
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

    <script>
        $(document).ready(function() {
            $(document).on('click', '.reset-filter', function() {
                // document.getElementById("filter").reset();
                $('.filter').val("");
                var url = '{{ route('surat', ':id') }}';
                url = url.replace(':id', '');
            });

            // $('.bt-print').on('click', function() {
            //     let id = $(this).attr('data-id');
            //     console.log(id);
            // })

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

                        tinymce.init({
                            selector: 'textarea#editor', // Replace this CSS selector to match the placeholder element for TinyMCE
                            plugins: 'table lists',
                            toolbar: 'undo redo | fontselect | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | table',
                            font_formats: "Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
                            content_style: "@import url('https://fonts.googleapis.com/css2?family=Oswald&display=swap');"
                        });
                        // tinymce.activeEditor.setContent(data.data.bodySurat);
                    }
                });
            })

            $(document).on('click', '.btn-generate-pdf', function() {
                $("#form-submit").click();
            })
        });
    </script>
@endsection
