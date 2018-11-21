<div class="modal" id="modal-form" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="" method="post" class="form-horizontal" data-toggle="validator">
                {{ csrf_field() }} {{ method_field('POST') }}
                <input type="hidden" id="id" name="id">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"> &times; </span>
                    </button>
                    <h3 class="modal-title"></h3>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="nip" class="col-md-3 control-label">Nip</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="nip" name="nip" maxlength="10" required/>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama" class="col-md-3 control-label">Nama</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="nama" name="nama" maxlength="50" required/>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tmpt_lahir" class="col-md-3 control-label">Tempat Lahir</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="tmpt_lahir" name="tmpt_lahir" maxlength="30" required/>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tgl_lahir" class="col-md-3 control-label">Tanggal Lahir</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control datepicker" id="tgl_lahir" name="tgl_lahir" required readonly/>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="alamat" class="col-md-3 control-label">Alamat</label>
                        <div class="col-md-6">
                            <textarea name="alamat" id="alamat" cols="30" rows="10"></textarea>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="division_id" class="col-md-3 control-label">Divisi</label>
                        <div class="col-md-6">
                            <select class="form-control" id="division_id" name="division_id" required style="width: 100%;">
                                @foreach($lDivisi as $key => $divisi)
                                    <option value="{{ $key }}">{{ $divisi }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-save">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>