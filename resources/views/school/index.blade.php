@extends('layout')

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="uper">
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div><br/>
        @endif
        <a href="{{ route('school.create')}}" class="btn btn-success">Tambah</a>

            <table class="table table-bordered" id="scholls-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>NPSN</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No Telepon</th>
                <th>Aksi</th>
            </tr>
            </thead>
            {{--<tbody>
                <tr>
                    <td><a href="{{ route('school.edit',$school->id)}}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('school.destroy', $school->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            </tbody>--}}
        </table>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#scholls-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('data/school') !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'npsn', name: 'npsn' },
                    { data: 'nama', name: 'nama' },
                    { data: 'alamat', name: 'alamat' },
                    { data: 'no_telp', name: 'no_telp' },
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@endpush
