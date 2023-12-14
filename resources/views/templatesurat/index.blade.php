@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-left"><b>Template Surat</b></div>
                <div class="row p-3">
                    <div class="col-sm-12">
                        <label>Filter</label>
                    </div>
                    <div class="col-sm-12">
                        <form action="{{ route('templatesurat') }}" method="get" enctype="multipart/form-data" class="row"
                            id="filter">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>ID</label>
                                    <input type="text" name="id" class="form-control filter"
                                        value="{{ $filter['id'] }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tipe Surat</label>
                                    <input type="text" name="type_surat" class="form-control filter"
                                        value="{{ $filter['type_surat'] }}">
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
                                    <th><b>Jenis Surat</b></th>
                                    <th><b>Tanggal Buat</b></th>
                                    <th><b><a href="{{ route('templatesuratcreate') }}">
                                                <button type="button" class="btn btn-outline-dark"><i
                                                        class="fas fa-plus"></i> Tambah Parameter
                                                    Surat</button>
                                            </a></b></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list as $key => $data)
                                    <tr>
                                        <td><b>{{ $data->id }}</b></td>
                                        <td>{{ $data->type_surat }}</td>
                                        <td>{{ date('d M Y', strtotime($data->created_at)) }}</td>
                                        <td>
                                            <div>
                                                <a href="{{ url('/TemplateSurat/edit/' . $data->id . '') }}">
                                                    <button class="btn btn-outline-dark"><i
                                                            class="fas fa-edit"></i></button>
                                                </a>
                                                <a href="{{ url('/TemplateSurat/destroy/' . $data->id . '') }}">
                                                    <button class="btn btn-outline-dark"><i
                                                            class="fas fa-trash"></i></button>
                                                </a>
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
    </div>
@endsection
