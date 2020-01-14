@extends('adminlte::page')

@section('title', 'Donatur')

@section('content_header')

@stop

@section('css')
@stop

@section('content')
    <section class="content">
        <div class="col-md-12">
            <div class="row">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="col-md-6">
                            <h4>Data Donasi Donatur <strong>{{ $donatur->nama }}</strong></h4>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form">
                        <div class="box-body">
                            <table class="table table-bordered" id="table">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nominal</th>
                                    <th>Tanggal Tranfer</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@stop

@push('js')
    <script>
        let table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('list.donatur-donasi', $donatur->id) }}',
            columns: [
                {data: "DT_Row_Index"},
                {data: 'nominal', name: 'nominal'},
                {data: 'tgl_transfer', name: 'tgl_transfer'},
            ],
            columnDefs: [
                {
                    render: function ( data ) {
                        return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    },
                    targets: [1]
                }
            ],
        });
    </script>
@endpush
