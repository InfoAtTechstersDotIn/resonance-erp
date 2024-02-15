<style>
    .logo.d-flex.justify-content-center {
    text-align: center;
}
.table-striped tbody tr:nth-of-type(odd) {
     background-color: rgb(0 82 202);
    background-color: rgb(0 82 202 / 25%);
    /* color: #fff; */
}
.total{
    
        background-color: #bfd22f;
    /* color: #fff; */
    font-weight: 900;
}

 table, td {
    border: 1px solid black;
    border-collapse: collapse;
 padding:3px 4px !important;
}

</style>
<div class="content-wrapper" style=" margin-top:-30px;">
    <div class="logo d-flex justify-content-center">
    
    
    <img src="https://maidendropgroup.com/public/images/logo1.png" alt="logo" style="width:140px;">
    
</div>
    <div class="container-fluid">
       
       
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
                                font-size:12px;
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
                                        if($res->paymenttypeid != 9){
                                        $arrTotalTransactions[$res->paymenttypeid] = 0;
                                        $arrTotalAmount[$res->paymenttypeid] = 0;
                                    ?>
                                        <th colspan="2"><b><?php echo $res->paymenttypename; ?></b></th>
                                    <?php } } ?>
                                    <th colspan="2">Total</th>
                                </tr>
                                <tr>
                                    <?php
                                    foreach ($lookups['paymenttypelookup'] as $res) {
                                         if($res->paymenttypeid != 9){
                                    ?>
                                        <th>No</th>
                                        <th>Amount</th>
                                    <?php } } ?>
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
                                             if($res->paymenttypeid != 9){
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
                                <tr class="total">
                                    <td>
                                        <b>Total</b>
                                    </td>
                                    <?php
                                    foreach ($lookups['paymenttypelookup'] as $res) {
                                         if($res->paymenttypeid != 9){
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