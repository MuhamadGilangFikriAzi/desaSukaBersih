@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-left"><b>Parameter Surat</b></div>

                <div class="text-right mx-4 my-2">
                    <a href="{{ route('parametersuratcreate') }}">
                        <button type="button" class="btn btn-outline-dark"><i class="fas fa-plus"></i> Add Parameter
                            Surat</button>
                    </a>
                </div>
                <div class="card-body text-center">
                    <div class="table-responsive ">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th><b>ID</b></th>
                                    <th><b>Jenis Surat</b></th>
                                    <th><b>Action</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td>
                                        <input type="text" name="ID" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" name="type" class="form-control">
                                    </td>
                                </tr>
                                @foreach ($list as $key => $data)
                                    <tr>
                                        <td><b>{{ $data->id }}</b></td>
                                        <td>{{ $data->type_surat }}</td>
                                        <td>
                                            <div>
                                                <a href="{{ url('/parametersurat/edit/' . $data->id . '') }}">
                                                    <button class="btn btn-outline-dark"><i
                                                            class="fas fa-edit"></i></button>
                                                </a>
                                                <a href="{{ url('/parametersurat/destroy/' . $data->id . '') }}">
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
