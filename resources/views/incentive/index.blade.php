@extends('adminlte::page')

@section('title', 'Insentif')

@section('content_header')

@stop

@section('content')
    <section class="content">
        <div class="col-md-12">
            <div class="row">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="col-md-6">
                            <h4><strong>Data Insentif</strong></h4>
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
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @include('incentive.form')
    </section>
@stop

@push('js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let fName = "Insentif";

        let table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('data.incentive') !!}',
            columns: [
                {data: 'nama', name: 'nama'},
                {data: 'harga', name: 'harga', render: $.fn.dataTable.render.number( '.', ',', 2, 'Rp ' )},
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
                url: "{{ url('incentive') }}" + '/' + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function (data) {
                    $('#modal-form').modal('show');
                    $('.modal-title').text('Edit ' + fName);

                    $('#id').val(data.id);
                    $('#nama').val(data.nama);
                    $('#harga').val(data.harga);
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
                        url: "{{ url('incentive') }}" + '/' + id,
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

        $(function () {
            $('#modal-form form').validator().on('submit', function (e) {
                if (!e.isDefaultPrevented()) {
                    let id = $('#id').val();
                    let url = null;
                    if (save_method == 'add')
                        url = "{{ url('incentive') }}";
                    else
                        url = "{{ url('incentive') . '/' }}" + id;

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
