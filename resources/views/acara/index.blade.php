@extends('adminlte::page')

@section('title', 'Donatur')

@section('content_header')

@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <style>
        .ui-datepicker-calendar {
            display: none;
        }
    </style>
@stop

@section('content')
    <section class="content">
        <div class="col-md-12">
            <div class="row">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="col-md-6">
                            <h4><strong>Data Acara</strong></h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <a onclick="addForm()" class="btn btn-success pull-right">Tambah</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form">
                        <div class="box-body">
                            <table class="table table-bordered" id="table">
                                <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th>Periode</th>
                                    <th>Status</th>
                                    <th>Closing By</th>
                                    <th>Closing Date</th>
                                    <th>Actual Donasi</th>
                                    <th>Jumlah Donasi</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @include('acara.form')
    </section>
@stop

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.date-picker').datepicker( {
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                dateFormat: 'MM yy',
                onClose: function(dateText, inst) {
                    $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                }
            });

            $('[data-toggle="tooltip"]').tooltip();
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let fName = "Acara";

        $('.datepicker').datepicker({dateFormat: 'M-yy'});

        let table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('data.acara') !!}',
            columns: [
                {data: 'nama', name: 'nama'},
                {data: 'deskripsi', name: 'deskripsi'},
                {data: 'periode', name: 'periode'},
                {data: 'status', name: 'status'},
                {data: 'closing_by', name: 'closing_by'},
                {data: 'closing_date', name: 'closing_date'},
                {data: 'actual_donasi', name: 'actual_donasi' , render: $.fn.dataTable.render.number(',', '.', 0)},
                {data: 'jumlah_donasi', name: 'jumlah_donasi'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        function addForm() {
            save_method = "add";
            $('input[name=_method]').val('POST');
            $('#modal-form').modal('show');
            $('#modal-form form')[0].reset();
            $('.modal-title').text('Tambah ' + fName);
        }

        function editForm(id) {
            save_method = 'edit';
            $('input[name=_method]').val('PATCH');
            $('#modal-form form')[0].reset();
            $.ajax({
                url: "{{ url('acara') }}" + '/' + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    $('#modal-form').modal('show');
                    $('.modal-title').text('Edit ' + fName);

                    $('#id').val(data.id);
                    $('#nama').val(data.nama);
                    $('#deskripsi').val(data.deskripsi);
                    $('#periode').val(data.periode);
                    $('#status').val(data.status);
                },
                error: function () {
                    swal({
                        title: 'Oops...',
                        text: "Data Tidak Ada",
                        type: 'error',
                        timer: '1500'
                    })
                }
            });
        }

        function deleteData(id) {
            swal({
                title: "Apakah anda yakin?",
                text: "Data " + fName + " ini akan di hapus!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{ url('acara') }}" + '/' + id,
                        type: "POST",
                        data: {'_method': 'DELETE'},
                        success: function (data) {
                            table.ajax.reload();
                            swal("Data " + fName + " Telah dihapus!", {
                                icon: "success",
                            });
                        },
                        error: function () {
                            swal({
                                title: 'Oops...',
                                text: data.message,
                                type: 'error',
                                timer: '1500'
                            })
                        }
                    });

                } else {
                    swal("Dibatalkan!");
                }
            });
        }

        function closeForm(id) {
            swal({
                content: {
                    element: "input",
                    attributes: {
                        placeholder: "Masukan Total Donasi yang diterima!",
                        type: "input",
                    },
                },
                icon: "info",
                buttons: true,
            }).then((isTotal) => {
                if (isTotal) {
                    $.ajax({
                        url: "{{ url('close-acara') . '/' }}" + id,
                        type: "POST",
                        dataType: 'json',
                        data: { "total": isTotal },
                        success: function (data) {
                            $('#modal-form').modal('hide');
                            table.ajax.reload();
                            swal({
                                title: 'Success!',
                                icon: "success",
                                text: data.message,
                                timer: '1500'
                            })
                        },
                        error: function (xhr, status, error) {
                            let err = JSON.parse(xhr.responseText);
                            swal({
                                title: 'Oops...',
                                text: "Kesalahan Input Data",
                                icon: 'error',
                                timer: '1500'
                            })
                        }
                    });
                } else {
                    swal("Dibatalkan!");
                }
            });
        }

        $(function () {
            $('#modal-form form').validator().on('submit', function (e) {
                if (!e.isDefaultPrevented()) {
                    let id = $('#id').val();
                    let url = null;
                    if (save_method == 'add')
                        url = "{{ url('acara') }}";
                    else
                        url = "{{ url('acara') . '/' }}" + id;

                    $.ajax({
                        url: url,
                        type: "POST",
                        data: new FormData($("#modal-form form")[0]),
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            $('#modal-form').modal('hide');
                            table.ajax.reload();
                            swal({
                                title: 'Success!',
                                icon: "success",
                                text: data.message,
                                timer: '1500'
                            })
                        },
                        error: function (xhr, status, error) {
                            let err = JSON.parse(xhr.responseText);
                            swal({
                                title: 'Oops...',
                                text: "Kesalahan Input Data",
                                icon: 'error',
                                timer: '1500'
                            })
                        }
                    });
                    return false;
                }
            });
        });
    </script>
@endpush
