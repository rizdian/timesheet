@extends('adminlte::page')

@section('title', 'Placement Request Form')

@section('content_header')

@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
@stop

@section('content')
    <section class="content">
        <div class="col-md-12">
            <div class="row">
                <form role="form" id="pForm" method="post" action="{{ url('prf') }}">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <div class="col-md-6">
                                <h4><strong>Placement Request Form</strong></h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="submit" class="btn btn-primary pull-right">Proses</button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                            {{ csrf_field() }} {{ method_field('POST') }}
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="no_prf">No</label>
                                    <input type="text" class="form-control" id="no_prf" name="no_prf" required value="{{$noFinal}}" readonly="readonly">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="type">Type</label>
                                    <select id="type" class="form-control" name="type">
                                        <option value="new">New</option>
                                        <option value="extention">Extention</option>
                                        <option value="replace">Replace</option>
                                        <option value="trial">Trial</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="nm_client">Nama Client</label>
                                    <input type="text" class="form-control" id="nm_client" name="nm_client" required maxlength="50">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="employee_id">Nama Karyawan</label>
                                    <select class="form-control" id="employee_id" name="employee_id" required>
                                        @foreach($lKry as $key => $kry)
                                            <option value="{{ $kry->id }}">{{ $kry->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="SEProject">Start - End Project</label>
                                    <input type="text" class="form-control" id="SEProject" name="SEProject" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Keterangan</label>
                                    <textarea class="form-control" name="keterangan" id="" cols="30"
                                              rows="5"></textarea>
                                </div>
                            </div>
                            <div class="form-row col-md-12">
                                <div class="form-row" style="margin-bottom: 10px;">
                                    <h4><strong>Pilih Insentif</strong></h4>
                                </div>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr class="table-primary">
                                        <th></th>
                                        <th>Name</th>
                                        <th>Value</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($lInsen as $key => $value)
                                        <tr>
                                            <td><input type="checkbox" value="{{$value->id}}" name="insentif_id[{{$value->id}}]"></td>
                                            <td>{{$value->nama}}</td>
                                            <td>{{$value->harga}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@stop

@push('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        let fName = "PRF";
        $('#SEProject').daterangepicker({
            locale: {
                format: 'D/M/Y'
            }
        });

    </script>
@endpush
