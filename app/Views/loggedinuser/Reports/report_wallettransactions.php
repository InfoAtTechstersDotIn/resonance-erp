<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Wallet Transaction Report
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
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Branch</label>
                    <select name="branchid" id="branchid" onchange="filter(0)" style="width: 100%;" class="form-control mb">
                        <option value="">Select</option>
                        <?php
                        foreach ($lookups['branchlookup'] as $result) :
                        ?>
                            <option value="<?php echo $result->branchid; ?>" <?php echo (isset($_GET['branchid']) && $_GET['branchid'] != "" && $_GET['branchid'] == $result->branchid) ? "selected" : "" ?>><?php echo $result->branchname; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Wallet Type</label>
                    <select name="wallettypeid" id="wallettypeid" onchange="filter(0)" style="width: 100%;" class="form-control mb">
                        <option value="">Select</option>
                        <?php
                        foreach ($lookups['wallettypelookup'] as $result) :
                        ?>
                            <option value="<?php echo $result->wallettypeid; ?>" <?php echo (isset($_GET['wallettypeid']) && $_GET['wallettypeid'] != "" && $_GET['wallettypeid'] == $result->wallettypeid) ? "selected" : "" ?>><?php echo $result->wallettypename; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
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
                                    <th>Wallet Type</th>
                                    <th>Date</th>
                                    <th>Transaction Type</th>
                                    <th>Amount</th>
                                    <th>Transacted By</th>
                                    <th>Payment Details</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($report_wallettransactions != null) :
                                    foreach ($report_wallettransactions as $result) :
                                ?>
                                        <tr>
                                            <td>
                                                <b>Application Number:</b> <?php echo $result->applicationnumber ?><br />
                                                <b>Student Name:</b> <?php echo $result->name ?><br />
                                                <b>Gender:</b> <?php echo $result->gendername ?><br />
                                                <b>Course:</b> <?php echo $result->coursename ?><br />
                                                <b>Section:</b> <?php echo $result->sectionname ?><br />
                                                <b>Branch:</b> <?php echo $result->branchname ?><br />
                                            </td>
                                            <td>
                                                <?php echo $result->wallettypename ?>
                                            </td>
                                            <td>
                                                <?php echo $result->date ?>
                                            </td>
                                            <td>
                                                <?php echo $result->transactiontype ?>
                                            </td>
                                            <td>
                                                <?php echo $result->amount ?>
                                            </td>
                                            <td>
                                                <?php echo $result->TransactedBy ?>
                                            </td>
                                            <td>
                                                <?php echo $result->payment_details ?>
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
        var URL = "<?php echo base_url('reports/report_wallettransactions') ?>" + "?" + $('#filterForm').serialize();

        if (download == 1) {
            URL = URL + "&download=1";
        }

        window.location.href = URL;
    }
</script>