<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Daily Collection Report
                </h2>
            </div>
        </div>
        <form id="filterForm">
            <div class="row">
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Payment Date From</label>
                    <input type="text" onchange="filter(0)" placeholder="Payment Date From" name="PaymentDateFrom" class="datepicker form-control mb" value="<?php echo (isset($_GET['PaymentDateFrom']) && $_GET['PaymentDateFrom'] != "") ? $_GET['PaymentDateFrom'] : "" ?>">
                </div>
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Payment Date To</label>
                    <input type="text" onchange="filter(0)" placeholder="Payment Date To" name="PaymentDateTo" class="datepicker form-control mb" value="<?php echo (isset($_GET['PaymentDateTo']) && $_GET['PaymentDateTo'] != "") ? $_GET['PaymentDateTo'] : "" ?>">
                </div>
            </div>
        </form>
        <a class="btn btn-primary" onclick="filter(1)">Download</a>
        <br />
        <br />
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <style>
                            table,
                            th,
                            td {
                                border: 1px solid black;
                                border-collapse: collapse;
                            }
                        </style>
                        <table class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Student Details</th>
                                    <th>Branch</th>
                                    <th>Payment Amount</th>
                                    <th>Details</th>
                                    <th>Payment Date</th>
                                    <th>Payment Type</th>
                                    <th>Payment Status</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($report_collectiondetails != null) :
                                    foreach ($report_collectiondetails as $result) :
                                ?>
                                        <tr>
                                            <td>
                                                <b>Application Number:</b> <?php echo $result->applicationnumber ?><br />
                                                <b>Student Name:</b> <?php echo $result->name ?><br />
                                                <b>Gender:</b> <?php echo $result->gendername ?><br />
                                                <b>Course:</b> <?php echo $result->coursename ?><br />
                                                <b>Section:</b> <?php echo $result->sectionname ?><br />
                                            </td>
                                            <td>
                                                <?php echo $result->branchname ?>
                                            </td>

                                            <td>
                                                <?php echo $result->paymentamount ?>
                                            </td>
                                            <td>
                                                <b>Payment Details:</b> <?php echo $result->paymentdetails ?><br /><br />
                                                <b>Payment Entered By:</b> <?php echo $result->paymententeredby ?><br /><br />
                                            </td>
                                            <td>
                                                <b>Payment Date:</b> <?php echo date_format(date_create($result->paymentdate), 'd/m/Y') ?><br /><br />
                                                <b>Created Date:</b> <?php echo date_format(date_create($result->paymentcreateddate), 'd/m/Y') ?><br />
                                            </td>
                                            <td>
                                                <?php echo $result->paymenttypename ?>
                                            </td>
                                            <td>
                                                <?php echo $result->paymentstatusname ?>
                                            </td>
                                            <td>
                                                <?php echo $result->remarks ?>
                                            </td>
                                        </tr>
                                <?php endforeach;
                                endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function filter(download = 0) {
        var URL = "<?php echo base_url('reports/report_collectiondetails') ?>" + "?" + $('#filterForm').serialize();

        if (download == 1) {
            URL = URL + "&download=1";
        }

        window.location.href = URL;
    }
</script>