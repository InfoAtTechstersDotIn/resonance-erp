<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Bulk Upload Employees
                    <a class="btn btn-warning" style="float: right;" href="<?php echo base_url('employees_bulk_upload_sample.xls') ?>" download>Download Sample</a>
                </h2>
                <div class="row">
                    <form enctype='multipart/form-data' method="post" action="<?php echo base_url('bulkupload/uploademployees') ?>">
                        <div class="col-md-8">
                            <input type="file" id="employees_upload" name="employees_upload" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" id="employees_bulk_upload" name="employees_bulk_upload" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Bulk Upload Students
                    <a class="btn btn-warning" style="float: right;" href="<?php echo base_url('student_bulk_upload_sample.xlsx') ?>" download>Download Sample</a>
                </h2>
                <div class="row">
                    <form enctype='multipart/form-data' method="post" action="<?php echo base_url('bulkupload/uploadstudents') ?>">
                        <div class="col-md-8">
                            <input type="file" id="students_upload" name="students_upload" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" id="student_bulk_upload" name="student_bulk_upload" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Bulk Upload Payments
                    <a class="btn btn-warning" style="float: right;" href="<?php echo base_url('payments_bulk_upload_sample.xls') ?>" download>Download Sample</a>
                </h2>
                <div class="row">
                    <form enctype='multipart/form-data' method="post" action="<?php echo base_url('bulkupload/uploadpayments') ?>">
                        <div class="col-md-8">
                            <input type="file" id="payments_upload" name="payments_upload" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" id="payment_bulk_upload" name="payment_bulk_upload" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Bulk Upload Wallet Amounts
                    <a class="btn btn-warning" style="float: right;" href="<?php echo base_url('wallet_bulk_upload_sample.xlsx') ?>" download>Download Sample</a>
                </h2>
                <div class="row">
                    <form enctype='multipart/form-data' method="post" action="<?php echo base_url('bulkupload/uploadwallet') ?>">
                        <div class="col-md-8">
                            <input type="file" id="wallet_upload" name="wallet_upload" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" id="wallet_bulk_upload" name="wallet_bulk_upload" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

<hr style="width: 100%;" />
<hr style="width: 100%;" />
<hr style="width: 100%;" />
<hr style="width: 100%;" />
<hr style="width: 100%;" />
<hr style="width: 100%;" />
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Bulk Upload Students Special
                    <a class="btn btn-warning" style="float: right;" href="<?php echo base_url('student_bulk_upload_sample.xlsx') ?>" download>Download Sample</a>
                </h2>
                <div class="row">
                    <form enctype='multipart/form-data' method="post" action="<?php echo base_url('bulkupload/uploadstudents1') ?>">
                        <div class="col-md-8">
                            <input type="file" id="students_upload" name="students_upload" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" id="student_bulk_upload" name="student_bulk_upload" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
    }
</script>