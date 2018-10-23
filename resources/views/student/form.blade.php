<div class="modal" id="modal-form" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form-siswa" method="post" class="form-horizontal" data-toggle="validator">
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
                        <label for="nisn" class="col-md-3 control-label">NISN</label>
                        <div class="col-md-6">
                            <input type="number" class="form-control" id="nisn" name="nisn" maxlength="10" autofocus required/>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama" class="col-md-3 control-label">Nama</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="nama" name="nama" maxlength="35" required/>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tempat_lahir" class="col-md-3 control-label">Tempat Lahir</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" maxlength="15" required/>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lahir" class="col-md-3 control-label">Tanggal Lahir</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir" maxlength="15" required/>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jen_kel" class="col-md-3 control-label">Jenis Kelamin</label>
                        <div class="col-md-6">
                            <select class="form-control" id="jen_kel" name="jen_kel">
                                <option value="0">Laki-laki</option>
                                <option value="1">Perempuan</option>
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="agama" class="col-md-3 control-label">Agama</label>
                        <div class="col-md-6">
                            <select class="form-control" id="agama" name="agama">
                                <option value="Islam">Islam</option>
                                <option value="Protestan">Protestan</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Khonghucu">Khonghucu</option>
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="alamat" class="col-md-3 control-label">Alamat</label>
                        <div class="col-md-6">
                            <textarea id="alamat" name="alamat" class="form-control" cols="20" rows="10" required></textarea>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="id_sekolah" class="col-md-3 control-label">Sekolah</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="id_sekolah" name="id_sekolah" required/>
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