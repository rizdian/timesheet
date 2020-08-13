<div class="modal" id="modal-form" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="" method="post" class="form-horizontal" data-toggle="validator">
                {{ csrf_field() }} {{ method_field('POST') }}
                <input type="hidden" id="id" name="id">
                <input type="hidden" id="acara_id" name="acara_id" value="{{$acara->id}}"/>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"> &times; </span>
                    </button>
                    <h3 class="modal-title"></h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="division_id" class="col-md-3 control-label">Donatur</label>
                        <div class="col-md-6">
                            <select class="form-control" id="donatur_id" name="donatur_id" required style="width: 100%;">
                                @foreach($lDonatur as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nominal" class="col-md-3 control-label">Nominal</label>
                        <div class="col-md-6">
                            <input type="number" class="form-control" id="nominal" name="nominal" required/>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="type" class="col-md-3 control-label">Type</label>
                        <div class="col-md-6">
                            <select class="form-control" name="type" id="type">
                                <option value="cash">Cash</option>
                                <option value="transfer">Transfer</option>
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tgl_lahir" class="col-md-3 control-label">Tanggal Transfer</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control datepicker" id="tgl_transfer" name="tgl_transfer" readonly/>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama" class="col-md-3 control-label">Bukti Bayar</label>
                        <div class="col-md-6">
                            <input type="file" name="filename" class="form-control" id="filename">
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
