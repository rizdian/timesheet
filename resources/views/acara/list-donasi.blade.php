@extends('adminlte::page')

@section('title', 'Donatur')

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
                            <h4>Data Donasi Acara <strong>{{ $acara->nama }}</strong></h4>
                        </div>
                        <div class="col-md-6 text-right">
                            @if($acara->status == 'aktif')
                                <a onclick="addForm()" class="btn btn-success pull-right">Tambah Donasi</a>
                            @endif
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
                                    <th>Donatur</th>
                                    <th>Nominal</th>
                                    <th>Type</th>
                                    <th>Tanggal Input</th>
                                    <th>Bukti Transfer</th>
                                    <th>Tanggal Transfer</th>
                                    <th>Verifikasi Transfer</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th colspan="2" style="text-align:right">Total:</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @include('acara.form-add-donasi')
        @include('acara.form-verifikasi')
    </section>
@stop

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
            notTF();
        });

        function notTF() {
            $("#tgl_transfer").prop('disabled', true);
            $("#filename").prop('disabled', true);
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let fName = "Donasi";

        $('.datepicker').datepicker({dateFormat: 'dd-M-yy'});

        $('#type').on('change', function () {
            if (this.value === 'cash') {
                $("#tgl_transfer").prop('disabled', true);
                $("#filename").prop('disabled', true);
            } else {
                $("#tgl_transfer").prop('disabled', false);
                $("#filename").prop('disabled', false);
            }
        });

        let table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('list.acara-donasi', $acara->id) }}',
            columns: [
                {data: "DT_Row_Index"},
                {data: 'donatur.nama', name: 'donatur.nama'},
                {data: 'nominal', name: 'nominal', render: $.fn.dataTable.render.number(',', '.', 0)},
                {data: 'type', name: 'type'},
                {data: 'created_at', name: 'created_at'},
                {
                    "data": "filename",
                    "render": function (data, type, row, meta) {
                        if (data != "-") {
                            if (type === 'display') {
                                data = '<a href="{{ url('donasi/download/') }}/' + row.id + '">' + data + '</a>';
                            }
                            return data;
                        } else {
                            return data;
                        }

                    }
                },
                {data: 'tgl_transfer', name: 'tgl_transfer'},
                {data: 'verifikasi', name: 'verifikasi'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            columnDefs: [
                {
                    render: function (data) {
                        return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    },
                    targets: [1]
                }
            ],
            footerCallback: function (row, data, start, end, display) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ?
                        i.replace(/[\Rp,]/g, '') * 1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // Total over all pages
                total = (api
                    .column(2)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0) / 1000).toFixed(3);

                // Total over this page
                pageTotal = (api
                    .column(2, {page: 'current'})
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0) / 1000).toFixed(3);

                // Update footer
                $(api.column(2).footer()).html(
                    'Rp. ' + pageTotal + ' ( Rp. ' + total + ' total)'
                );
            }
        });

        function addForm() {
            save_method = "add";
            $('input[name=_method]').val('POST');
            $('#modal-form').modal('show');
            $('#modal-form form')[0].reset();
            notTF();
            $('.modal-title').text('Tambah ' + fName);
        }

        $(function () {
            $('#modal-form form').validator().on('submit', function (e) {
                if (!e.isDefaultPrevented()) {
                    let id = $('#id').val();
                    let url = null;
                    if (save_method == 'add')
                        url = "{{ url('donasi') }}";
                    else
                        url = "{{ url('donasi') . '/' }}" + id;

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
                        url: "{{ url('donasi') }}" + '/' + id,
                        type: "POST",
                        data: {'_method': 'DELETE'},
                        success: function (data) {
                            table.ajax.reload();
                            swal("Data " + fName + " Telah dihapus!", {
                                icon: "success",
                            });
                        },
                        error: function (request, status, error) {
                            swal({
                                title: 'Oops...',
                                text: error,
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

        function verifikasiData(id) {
            swal({
                title: "Apakah anda yakin?",
                text: "Data " + fName + " ini akan di verifikasi!",
                icon: "warning",
                buttons: true,
            }).then((willVerifikasi) => {
                if (willVerifikasi) {
                    $.ajax({
                        url: "{{ url('verifikasi-donasi') }}" + '/' + id,
                        type: "POST",
                        success: function (data) {
                            table.ajax.reload();
                            swal("Data " + fName + " Telah diverifikasi!", {
                                icon: "success",
                            });
                        },
                        error: function (request, status, error) {
                            swal({
                                title: 'Oops...',
                                text: error,
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

        function verifikasiDetail(filter) {
            $('#modal-verifikasi').modal('show');
            $('#modal-verifikasi form')[0].reset();
            $('#vDate').val($(filter).data("date"));
            $('#vBy').val($(filter).data("by"));
        }
    </script>
@endpush
