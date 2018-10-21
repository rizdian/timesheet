@extends('layout')

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="card uper">
        <div class="card-header">
            Edit Share
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
            <form method="post" action="{{ route('school.update', $school->id) }}">
                @method('PATCH')
                @csrf
                <div class="form-group">
                    <label for="npsn">NPSN:</label>
                    <input type="text" class="form-control" name="npsn" maxlength="8" required value="{{$school->npsn}}"/>
                </div>
                <div class="form-group">
                    <label for="Nama">Nama:</label>
                    <input type="text" class="form-control" name="nama" maxlength="35" required value="{{$school->nama}}"/>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    <textarea name="alamat" class="form-control" cols="20" rows="10" required>{{$school->alamat}}</textarea>
                </div>
                <div class="form-group">
                    <label for="No Telp">No Telp:</label>
                    <input type="text" class="form-control" name="no_telp" maxlength="13" required value="{{$school->no_telp}}"/>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection