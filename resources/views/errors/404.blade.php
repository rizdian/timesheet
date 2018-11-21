@extends('adminlte::page')

@section('title', 'Insentif')

@section('content_header')
    <h1>404 Error Page</h1>
@stop

@section('content')
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-yellow">404</h2>

            <div class="error-content">
                <h3><i class="fa fa-warning text-yellow"></i>Oops! Page not found</h3>

                <p>
                    We could not find the page you were looking for.<br/>
                    Meanwhile, you may return to <a href="{{url('/')}}">dashboard</a>.
                </p>
            </div>
            <!-- /.error-content -->
        </div>
    </section>
@stop
