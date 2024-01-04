@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><b>Tambah Template Surat</b>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="{{ route('templatesuratstore') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Type Surat</label>
                            <input type="text" name="type_surat"
                                placeholder="Masukan Type Surat, contoh : Surat Keterangan Usaha" class="form-control"
                                value="{{ old('type_surat') }}">
                            @if ($errors->has('type_surat'))
                                <span class="text-danger">{{ $errors->first('type_surat') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Code Surat</label> <br>
                            <span>Gunakan Tag berikut agar nomor surat terus berjalan <br> [TAHUN] =
                                tahun surat &emsp; [BULAN] = Bulan surat &emsp; [URUTAN] = urutan nomor surat</span>
                            <input type="text" name="code_surat" placeholder="Masukan Code Surat, contoh : UK.06.02"
                                class="form-control" value="{{ old('code_surat') }}">
                            @if ($errors->has('code_surat'))
                                <span class="text-danger">{{ $errors->first('code_surat') }}</span>
                            @endif
                        </div>
                        <div>
                            <label>Data Untuk Surat</label>
                            <div class="form-group" id="inputan">
                                <div class="row">
                                    <div class="col-md-3">Label</div>
                                    <div class="col-md-3">Tag</div>
                                    <div class="col-md-3">Type</div>
                                    <div class="col-md-3"><button type="button" id="btnAddInput"
                                            class="btn btn-outline-dark"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                                <div class="row row-inputan my-1" data-id="0">
                                    <div class="col-md-3">
                                        <input type="text" name="TemplateSuratdetail[0][label]"
                                            placeholder="Masukan Label" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="TemplateSuratdetail[0][tag]"
                                            placeholder="Masukan tag (tanpa spasi)" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <select name="TemplateSuratdetail[0][input_type]" class="custom-select">
                                            <option selected>Pilih...</option>
                                            <option value="text">Text</option>
                                            <option value="date">Tanggal</option>
                                            <option value="document">Dokumen</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3"><button data-id="0" type="button"
                                            class="btn btn-hapus btn-outline-dark"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Surat</label><br>
                            <span>Gunakan Tag berikut <br>
                                [TANGGALCETAK] = Tanggal cetak surat</span>
                            <textarea class="form-control editor" id="editor" name="body_surat"></textarea>
                        </div>

                        <div class="text-right">
                            <input class="btn btn-primary" type="submit" name="submit" value="submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            var i = 0;
            $("#btnAddInput").click(function() {
                i++;
                $("#inputan").append(`
                <div class="row row-inputan my-1" data-id="${i}">
                    <div class="col-md-3">
                        <input type="text" name="TemplateSuratdetail[${i}][label]"
                            placeholder="Masukan Label" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="TemplateSuratdetail[${i}][tag]"
                            placeholder="Masukan tag (tanpa spasi)" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <select name="TemplateSuratdetail[${i}][input_type]" class="custom-select">
                            <option selected>Pilih...</option>
                            <option value="text">Text</option>
                            <option value="date">Tanggal</option>
                            <option value="document">Dokumen</option>
                        </select>
                    </div>
                    <div class="col-md-3"><button type="button" data-id="${i}" class="btn btn-hapus btn-outline-dark"><i class="fas fa-trash"></i></button>
                    </div>
                </div>`);
            });

            $(document).on('click', '.btn-hapus', function() {
                console.log('masuk');
                $(this).parents('.row.row-inputan').remove();
            });

            tinymce.init({
                selector: 'textarea#editor',
                plugins: 'table lists',
                toolbar: 'undo redo | fontselect | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | table',
                font_formats: "Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
                content_style: "@import url('https://fonts.googleapis.com/css2?family=Oswald&display=swap');"
            });
        });
    </script>
@endsection
