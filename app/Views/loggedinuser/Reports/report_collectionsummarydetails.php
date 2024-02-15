<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Daily Collection Summary Report
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
                        <table class="table table-striped">
                            <?php
                            $arrTotalTransactions = [];
                            $arrTotalAmount = [];

                            $totalTotalTrasactions = 0;
                            $totalTotalAmount = 0;

                            ?>
                            <thead>
                                <tr>
                                    <th rowspan="2">Branch</th>

                                    <?php
                                    foreach ($lookups['paymenttypelookup'] as $res) {
                                        $arrTotalTransactions[$res->paymenttypeid] = 0;
                                        $arrTotalAmount[$res->paymenttypeid] = 0;
                                    ?>
                                        <th colspan="2"><?php echo $res->paymenttypename; ?></th>
                                    <?php } ?>
                                    <th colspan="2">Total</th>
                                </tr>
                                <tr>
                                    <?php
                                    foreach ($lookups['paymenttypelookup'] as $res) {
                                    ?>
                                        <th>Transactions</th>
                                        <th>Amount</th>
                                    <?php } ?>
                                    <th>Transactions</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <?php
                            ?>
                            <tbody>
                                <?php
                                foreach ($lookups['branchlookup'] as $branch) :
                                ?>
                                    <tr>
                                        <td>
                                            <b><?php echo $branch->branchname ?></b>
                                        </td>
                                        <?php
                                        $totalTransactions = 0;
                                        $totalAmount = 0;
                                        foreach ($lookups['paymenttypelookup'] as $res) {
                                        ?>
                                            <td>
                                                <?php foreach ($report_collectionsummarydetails as $result) {
                                                    if ($result->paymenttypeid == $res->paymenttypeid && $result->branchid == $branch->branchid) {
                                                        $totalTransactions += $result->NoOfTransactions;
                                                        $arrTotalTransactions[$res->paymenttypeid] += $result->NoOfTransactions;
                                                        echo $result->NoOfTransactions;
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php foreach ($report_collectionsummarydetails as $result) {
                                                    if ($result->paymenttypeid == $res->paymenttypeid && $result->branchid == $branch->branchid) {
                                                        $totalAmount += $result->paymentamount;
                                                        $arrTotalAmount[$res->paymenttypeid] += $result->paymentamount;
                                                        echo $result->paymentamount;
                                                    }
                                                }
                                                ?>
                                            </td>
                                        <?php
                                        }
                                        ?>
                                        <td><b>
                                                <?php
                                                $totalTotalTrasactions += $totalTransactions;
                                                echo $totalTransactions;
                                                ?></b>
                                        </td>
                                        <td><b>
                                                <?php
                                                $totalTotalAmount += $totalAmount;
                                                echo $totalAmount;
                                                ?></b>
                                        </td>
                                    </tr>
                                <?php endforeach;
                                ?>
                                <tr>
                                    <td>
                                        <b>Total</b>
                                    </td>
                                    <?php
                                    foreach ($lookups['paymenttypelookup'] as $res) {
                                    ?>
                                        <td><b>
                                                <?php
                                                echo $arrTotalTransactions[$res->paymenttypeid];
                                                ?></b>
                                        </td>
                                        <td><b>
                                                <?php
                                                echo $arrTotalAmount[$res->paymenttypeid];
                                                ?></b>
                                        </td>
                                    <?php
                                    }
                                    ?>
                                    <td><b>
                                            <?php
                                            echo $totalTotalTrasactions;
                                            ?></b>
                                    </td>
                                    <td><b>
                                            <?php
                                            echo $totalTotalAmount;
                                            ?></b>
                                    </td>
                                </tr>
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
        var URL = "<?php echo base_url('reports/report_collectionsummarydetails') ?>" + "?" + $('#filterForm').serialize();

        if (download == 1) {
            URL = URL + "&download=1";
        }

        window.location.href = URL;
    }
</script>