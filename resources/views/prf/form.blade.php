<div class="modal" id="modal-form" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"> &times; </span>
                </button>
                <h3 class="modal-title"></h3>
            </div>
            <div class="modal-body">
                <form id="" method="post" class="" data-toggle="validator">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="no_prf">No</label>
                            <input type="text" class="form-control" id="no_prf" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="type">Type</label>
                            <select id="type" class="form-control" disabled>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nm_client">Nama Client</label>
                            <input type="text" class="form-control" id="nm_client" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="employee_id">Nama Karyawan</label>
                            <select class="form-control" id="employee" disabled>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="SEProject">Start - End Project</label>
                            <input type="text" class="form-control" id="SEProject" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Keterangan</label>
                            <textarea class="form-control" id="ket" disabled></textarea>
                        </div>
                    </div>
                    <div class="form-row col-md-12">
                        <div class="form-row" style="margin-bottom: 10px;">
                            <label for="">Insentif</label>
                        </div>
                        <table class="table table-striped table-bordered" id="ITable">
                            <thead>
                            <tr class="table-primary">
                                <th>Name</th>
                                <th>Value</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                    <div class="form-row col-md-12">
                        <div class="form-row" style="margin-bottom: 10px;">
                            <label for="">History Approval</label>
                        </div>
                        <table class="table table-striped table-bordered" id="HTable">
                            <thead>
                            <tr class="table-primary">
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action Date</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </form>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>