@extends('layout')

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="card uper">
        <div class="card-header">
            Add School
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br />
            @endif
            <form method="post" action="{{ route('school.store') }}">
                <div class="form-group">
                    @csrf
                    <label for="npsn">NPSN:</label>
                    <input type="text" class="form-control" name="npsn" min="1" max="8" required/>
                </div>
                <div class="form-group">
                    <label for="Nama">Nama:</label>
                    <input type="text" class="form-control" name="nama" min="1" max="35" required/>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    <textarea name="alamat" class="form-control" cols="20" rows="10" required></textarea>
                </div>
                <div class="form-group">
                    <label for="No Telp">No Telp:</label>
                    <input type="text" class="form-control" name="no_telp" min="1" max="13" required/>
                </div>
                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </div>
    </div>
@endsection
