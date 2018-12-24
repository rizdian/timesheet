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
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="col-md-6">
                            <h4><strong>List Approval Placement Request Form</strong></h4>
                        </div>
                        <div class="col-md-6 text-right">
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
                                    <th>Nama Client</th>
                                    <th>Type Placement</th>
                                    <th>Nama Karyawan</th>
                                    <th>Masa Placement</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('prf.form')
    </section>
@stop

@push('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let fName = "PRF";

        let table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            "order": [[ 0, "desc" ]],
            ajax: '{!! route('data.prf') !!}',
            columns: [
                {data: 'no_prf', name: 'no_prf'},
                {data: 'nm_client', name: 'nm_client'},
                {data: 'type', name: 'type',},
                {data: 'employee.nama', name: 'employee.nama'},
                {data: 'date', name: 'date'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        function actionApprove(id) {
            swal({
                title: "Apakah anda yakin?",
                text: "Data ini akan di approve!",
                icon: "info",
                buttons: true,
                //dangerMode: true,
            }).then((willApprove) => {
                if (willApprove) {
                    $.ajax({
                        url: "{{ url('approve/prf') }}",
                        type: "POST",
                        data: {id: id},
                        success: function (data) {
                            table.ajax.reload();
                            swal("Data Telah di-Approve!", {
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

        function actionReject(id) {
            swal({
                text: 'Masukan Alasan.',
                content: "input",
                button: {
                    text: "Reject",
                    closeModal: false,
                },
                dangerMode: true,
            })
                .then(willReject => {
                    if (!willReject) throw null;

                    $.ajax({
                        url: "{{ url('reject/prf') }}",
                        type: "POST",
                        data: {
                            id: id,
                            reason: willReject
                        },
                        success: function (data) {
                            table.ajax.reload();
                            swal("Data Telah di-Reject!", {
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
                })
                .catch(err => {
                    if (err) {
                        swal("Oh noes!", "The AJAX request failed!", "error");
                    } else {
                        swal.stopLoading();
                        swal.close();
                    }
                });
        }

        function actionDetail(id) {
            $.ajax({
                url: "{{ url('prf') }}" + '/' + id + "/edit",
                type: "GET",
                success: function (data) {
                    $('#modal-form').modal('show');
                    $('.modal-title').text('Detail ' + fName);
                    $('#modal-form form')[0].reset();

                    $('#no_prf').val(data.header.no_prf);
                    $('#type').append($("<option></option>").text(data.header.type));
                    $('#nm_client').val(data.header.nm_client);
                    $('#employee').append($("<option></option>").text(data.header.employee.nama));
                    let tgl = moment(data.header.start_project).format('DD MMM YYYY') +" - "+ moment(data.header.end_project).format('DD MMM YYYY');
                    $('#SEProject').val(tgl);
                    $('#ket').val(data.header.keterangan);

                    $('#ITable tbody tr').remove();
                    $.each(data.in, function(key, value) {
                        $('#ITable tbody').append('<tr>' +
                            '<td>' + value.nama + '</td>' +
                            '<td>' + value.harga + '</td>' +
                            '</tr>');
                    });

                    $('#HTable tbody tr').remove();
                    $.each(data.hi, function(key, value) {
                        let sttus = "";
                        if (value.status == 1)
                            sttus = "Di-Approve";
                        else
                            sttus = "Di-Reject";

                        $('#HTable tbody').append('<tr>' +
                            '<td>' + value.nama + '</td>' +
                            '<td>' + sttus + '</td>' +
                            '<td>' + value.created_at + '</td>' +
                            '</tr>');
                    });
                }
            });
        }

    </script>
@endpush
