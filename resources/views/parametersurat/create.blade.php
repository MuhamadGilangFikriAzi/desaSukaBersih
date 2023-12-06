@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><b>Add Parameter Surat</b>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="{{ route('parametersuratstore') }}" method="post" enctype="multipart/form-data">
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
                            <label>Code Surat</label>
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
                                        <input type="text" name="parametersuratdetail[0][label]"
                                            placeholder="Masukan Label" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="parametersuratdetail[0][tag]"
                                            placeholder="Masukan tag (tanpa spasi)" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <select name="parametersuratdetail[0][input_type]" class="custom-select">
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
                            <label>Surat</label>
                            <textarea class="form-control editor" name="body_surat"></textarea>
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
                        <input type="text" name="parametersuratdetail[${i}][label]"
                            placeholder="Masukan Label" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="parametersuratdetail[${i}][tag]"
                            placeholder="Masukan tag (tanpa spasi)" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <select name="parametersuratdetail[${i}][input_type]" class="custom-select">
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

            ClassicEditor
                .create(document.querySelector('.editor'), {
                    toolbar: {
                        items: [
                            'fontFamily',
                            'fontSize',
                            'fontColor',
                            'bold',
                            'italic',
                            'underline',
                            'alignment',
                            'bulletedList',
                            'numberedList',
                            'outdent',
                            'indent',
                            'blockQuote',
                            'insertTable',
                            'undo',
                            'redo'
                        ]
                    },
                    language: 'en',
                    table: {
                        contentToolbar: [
                            'tableColumn',
                            'tableRow',
                            'mergeTableCells'
                        ]
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
@endsection
