@extends('adminlte::page')

@section('title', 'Donasi')

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
                            <div class="col-md-8">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="acara_id" class="col-md-3 control-label">Nama Acara</label>
                                        <select class="form-control" id="acara_id" name="acara_id" required>
                                            @foreach($lacara as $key => $name)
                                                <option value="{{ $key }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
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
@endpush
