@extends('adminlte::page')

@section('title', 'Siswa')

@section('content_header')

@stop

@section('content')
    <section class="content">
        <div class="col-md-12">
            <div class="row">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="col-md-6">
                            <h4><strong>Data Siswa</strong></h4>
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
                                    <th>NISN</th>
                                    <th>Nama</th>
                                    <th>tempat_lahir</th>
                                    <th>tanggal_lahir</th>
                                    <th>jen_kel</th>
                                    <th>agama</th>
                                    <th>alamat</th>
                                    <th>id_sekolah</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @include('student.form')
    </section>
@stop

@push('js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table =  $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('data.student') !!}',
            columns: [
                { data: 'nisn', name: 'nisn' },
                { data: 'nama', name: 'nama' },
                { data: 'tempat_lahir', name: 'tempat_lahir' },
                { data: 'tanggal_lahir', name: 'tanggal_lahir' },
                { data: 'jen_kel', name: 'jen_kel' },
                { data: 'agama', name: 'agama' },
                { data: 'alamat', name: 'alamat' },
                { data: 'id_sekolah', name: 'id_sekolah' },
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        function addForm() {
            save_method = "add";
            $('input[name=_method]').val('POST');
            $('#modal-form').modal('show');
            $('#modal-form form')[0].reset();
            $('.modal-title').text('Tambah Siswa');
        }

        function editForm(id) {
            save_method = 'edit';
            $('input[name=_method]').val('PATCH');
            $('#modal-form form')[0].reset();
            $.ajax({
                url: "{{ url('student') }}" + '/' + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#modal-form').modal('show');
                    $('.modal-title').text('Edit Siswa');

                    $('#id').val(data.id);
                    $('#nisn').val(data.nisn);
                    $('#nama').val(data.nama);
                    $('#tempat_lahir').val(data.tempat_lahir);
                    $('#tanggal_lahir').val(data.tanggal_lahir);
                    $('#jen_kel').val(data.jen_kel);
                    $('#agama').val(data.agama);
                    $('#alamat').val(data.alamat);
                    $('#id_sekolah').val(data.id_sekolah);
                },
                error : function() {
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
                text: "Data Siswa ini akan di hapus!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url : "{{ url('student') }}" + '/' + id,
                        type : "POST",
                        data : {'_method' : 'DELETE'},
                        success : function(data) {
                            table.ajax.reload();
                            swal("Data Siswa Telah dihapus!", {
                                icon: "success",
                            });
                        },
                        error : function () {
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

        $(function(){
            $('#modal-form form').validator().on('submit', function (e) {
                if (!e.isDefaultPrevented()){
                    var id = $('#id').val();
                    if (save_method == 'add')
                        url = "{{ url('student') }}";
                    else
                        url = "{{ url('student') . '/' }}" + id;

                    $.ajax({
                        url : url,
                        type : "POST",
                        data: new FormData($("#modal-form form")[0]),
                        contentType: false,
                        processData: false,
                        success : function(data) {
                            $('#modal-form').modal('hide');
                            table.ajax.reload();
                            swal({
                                title: 'Success!',
                                icon: "success",
                                text: data.message,
                                timer: '1500'
                            })
                        },
                        error : function(xhr, status, error){
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
