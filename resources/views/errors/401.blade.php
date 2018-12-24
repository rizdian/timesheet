@extends('adminlte::page')

@section('title', 'Insentif')

@section('content_header')
    <h1>401 Error Page</h1>
@stop

@section('content')
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-yellow">401</h2>

            <div class="error-content">
                <h3><i class="fa fa-warning text-yellow"></i> Oops! UNAUTHORIZED</h3>

                <p>
                    You are not authorized to access requested url.<br/>
                    Meanwhile, you may return to <a href="{{url('/')}}">dashboard</a>.
                </p>
            </div>
            <!-- /.error-content -->
        </div>
    </section>
@stop
