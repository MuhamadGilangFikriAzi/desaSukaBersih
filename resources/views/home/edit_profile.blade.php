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

                    <form action="{{ url('/home/update/' . $id->id . '') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control" value="{{ $id->name }}">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Photo</label>
                            <img src="{{ asset('img/user/' . $id->photo) }}" alt="..." class="img-thumbnail"
                                style="width: 130px; height: 100px;">
                            <input type="file" name="photo">
                        </div>
                        <input type="submit" value="Save Change" class="btn btn-primary float-left">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
