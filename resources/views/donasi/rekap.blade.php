@extends('adminlte::page')

@section('title', 'Donasi')

@section('content_header')

@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
@stop

@section('content')
    <section class="content">
        <div class="col-md-12">
            <div class="row">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="col-md-6">
                            <h4><strong>Rekap Donasi</strong></h4>
                        </div>
                        <div class="col-md-6 text-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="POST" action="{{route('post.rekap.donasi')}}">
                        @csrf
                        <div class="box-body">
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="from_date" class="col-md-3 control-label">From</label>
                                        <input type="text" class="form-control datepicker" id="from_date"
                                               name="from_date" required readonly/>
                                        <span class="help-block with-errors"></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="to_date" class="col-md-3 control-label">To</label>
                                        <input type="text" class="form-control datepicker" id="to_date"
                                               name="to_date" required readonly/>
                                        <span class="help-block with-errors"></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary pull-right">Generate</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@stop

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $('.datepicker').datepicker({dateFormat: 'dd-M-yy'});
    </script>
@endpush
