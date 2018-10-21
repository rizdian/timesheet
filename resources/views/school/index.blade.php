<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Index Page</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
<div class="container">
    <br />
    @if (\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success') }}</p>
        </div><br />
    @endif
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>npsn</th>
            <th>nama</th>
            <th>alamat</th>
            <th>no_telp</th>
            <th colspan="2">Action</th>
        </tr>
        </thead>
        <tbody>

        @foreach($schools as $school)
            <tr>
                <td>{{$school['id']}}</td>
                <td>{{$school['npsn']}}</td>
                <td>{{$school['nama']}}</td>
                <td>{{$school['alamat']}}</td>
                <td>{{$school['no_telp']}}</td>
                <td>
                    <form action="{{action('SchoolController@destroy', $school['id'])}}" method="post">
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>