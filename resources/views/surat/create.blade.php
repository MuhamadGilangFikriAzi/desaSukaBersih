@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><b>Tambah Surat</b>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="{{ route('suratstore') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Type Surat</label>
                            <select name="template_surat_id" class="custom-select" id="type_surat">
                                <option selected>Pilih...</option>
                                @foreach ($listTemplateSurat as $item)
                                    <option value="{{ $item->id }}">{{ $item->type_surat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="additional-input">

                        </div>

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
                let inputan = $('.mandatory');
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
                        text: "Membuat Mengajukan surat dengan data ini?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya!"
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
                        data.data.details.forEach(element => {
                            console.log('label 1', element.label);
                            if (element.input_type === 'text') {
                                html += `
                                    <div class="form-group">
                                        <label>${element.label}</label>
                                        <input type="text" name="detail[${i}][value]" data-label="${element.label}" placeholder="Masukan ${element.label}" class="form-control mandatory">
                                        <input type="hidden" name="detail[${i}][tag]" value="${element.tag}">
                                        <input type="hidden" name="detail[${i}][label]" value="${element.label}">
                                        <input type="hidden" name="detail[${i}][input_type]" value="${element.input_type}">
                                    </div>`
                            }

                            if (element.input_type === 'date') {
                                html += `
                                    <div class="form-group">
                                        <label>${element.label}</label>
                                        <input type="date" name="detail[${i}][value]" data-label="${element.label}" placeholder="Masukan ${element.label}" class="form-control mandatory">
                                        <input type="hidden" name="detail[${i}][tag]" value="${element.tag}">
                                        <input type="hidden" name="detail[${i}][label]" value="${element.label}">
                                        <input type="hidden" name="detail[${i}][input_type]" value="${element.input_type}">
                                    </div>`
                            }

                            if (element.input_type === 'document') {
                                html += `
                                    <div class="form-group">
                                        <label>${element.label}</label>
                                        <input type="file" accept="application/pdf" data-label="${element.label}" name="detail[${i}][value]" placeholder="Masukan ${element.label}" class="form-control mandatory">
                                        <input type="hidden" name="detail[${i}][tag]" value="${element.tag}">
                                        <input type="hidden" name="detail[${i}][label]" value="${element.label}">
                                        <input type="hidden" name="detail[${i}][input_type]" value="${element.input_type}">
                                    </div>`
                            }
                            i++;
                        });

                        $('.additional-input').html(html);
                    }
                });
            });
        });
    </script>
@endsection
