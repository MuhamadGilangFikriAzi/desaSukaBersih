@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><b>Edit Surat</b>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="{{ route('suratupdate') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Type Surat</label>
                            <select name="template_surat_id" class="custom-select" id="type_surat" disabled>
                                <option>Pilih...</option>
                                @foreach ($listTemplateSurat as $item)
                                    <option value="{{ $item->id }}" @if ($surat->template_surat_id == $item->id) selected @endif>
                                        {{ $item->type_surat }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="id" value="{{ $surat->id }}">
                        </div>

                        @foreach ($suratDetail as $key => $detail)
                            <div class="form-group">
                                <label>{{ $detail->label }}</label>
                                @if ($detail->input_type == 'text')
                                    <input type="text" name="detail[{{ $key }}][value]"
                                        placeholder="Masukan {{ $detail->label }}" class="form-control inputan"
                                        value="{{ $detail->value }}" data-label="{{ $detail->label }}">
                                @endif
                                @if ($detail->input_type == 'date')
                                    <input type="text" name="detail[{{ $key }}][value]"
                                        placeholder="Masukan {{ $detail->label }}" class="form-control inputan"
                                        value="{{ $detail->value }}" data-label="{{ $detail->label }}">
                                @endif
                                @if ($detail->input_type == 'document')
                                    <input type="file" accept="application/pdf"
                                        name="detail[{{ $key }}][value]"
                                        placeholder="Masukan {{ $detail->label }}" class="form-control"
                                        value="{{ asset('document/archive/' . $detail->value) }}">
                                    <span>{{ $detail->value }}</span>
                                @endif

                                <input type="hidden" name="detail[{{ $key }}][tag]" value="{{ $detail->tag }}">
                                <input type="hidden" name="detail[{{ $key }}][label]"
                                    value="{{ $detail->label }}">
                                <input type="hidden" name="detail[{{ $key }}][input_type]"
                                    value="{{ $detail->input_type }}">
                                <input type="hidden" name="detail[{{ $key }}][id]" value="{{ $detail->id }}">
                            </div>
                        @endforeach

                        <div class="text-right">
                            <div class="btn btn-primary btn-submit">Submit</div>
                            <input class="btn btn-primary" type="submit" name="submit" id="submit" value="submit"
                                hidden>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {

            let validate = () => {
                let inputan = $('.inputan');
                let textError = '';

                inputan.each(function() {
                    let value = $(this).val();
                    let label = $(this).attr('data-label');

                    if (value === undefined || value === '') textError += label +
                        ' wajib diisi ! <br/>';
                });

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

            $(document).on('change', '#type_surat', function() {
                var id = $(this).val();
                console.log('idnya', id);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method: "POST",
                    url: "{{ route('onChangeTypeSurat') }}",
                    data: {
                        'id': id
                    },
                    success: function(data) {
                        var html = ''
                        var i = 0;


                    }
                });
            });
        });
    </script>
@endsection
