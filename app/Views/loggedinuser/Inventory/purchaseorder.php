<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Form List</h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblpaymentApproval" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th>Print</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($purchaseorder as $result) :
                                ?>
                                    <tr>
                                        <td>
                                            <a href="purchaseorderlist/<?php echo $result->id ?>"><?php echo $result->id ?></a>
                                        </td>
                                        <td><?php echo $result->purchase_order_status ?></td>
                                        <td><?php echo date_format(date_create($result->created_timestamp), 'd/m/Y') ?></td>
                                        <td><?php
                                            if ($result->status == "approved") {
                                            ?>
                                                <a class="btn btn-success" onclick="printDiv('div_<?php echo $result->form_group_id; ?>')">Print</a>

                                                <div class="col-md-12" id="div_<?php echo $result->form_group_id; ?>" style="display:none;">
                                                    <div class="scale">
                                                        <p style="text-align: center;"><img src="<?php echo base_url('images/logo1.png') ?>" width="140" height="50"  /></p>
                                                        <br />
                                                        <p style="text-align: right;">Date: <?php echo date("d-m-Y"); ?><br />Hyderabad</p>
                                                        <h4 style="text-align: center;"><strong><u>Material Requisition Form</u></strong></h4>
                                                        <br />

                                                        Branch: <?php
                                                                foreach (json_decode($result->data) as $key => $row) {
                                                                    if ($key == "Branchid")
                                                                        echo $row;
                                                                }
                                                                ?>
                                                        <br />
                                                        Status: <?php
                                                                echo $result->status . " (" . $result->UpdatedBy . ")";
                                                                ?>
                                                        <br />
                                                        <table style="width: 100%;margin: 0;">

                                                            <tr>
                                                                <td><span style="width: 20%;"><b>ProductName</b></span></td>
                                                                <td><span style="width: 20%;"><b>Quantity</b></td>
                                                            </tr>
                                                            <br />
                                                            <?php
                                                            foreach ($result->items as $item) {
                                                            ?>
                                                                <tr>
                                                                    <td><span style="width: 20%;"><?php
                                                                                                    foreach (json_decode($item->data) as $key => $row) {
                                                                                                        if ($key == "ProductName")
                                                                                                            echo $row;
                                                                                                    }
                                                                                                    ?></span></td>
                                                                    <td><span style="width: 20%;"> <?php
                                                                                                    foreach (json_decode($item->data) as $key => $row) {
                                                                                                        if ($key == "Quantity")
                                                                                                            echo $row;
                                                                                                    }
                                                                                                    ?></span></td>
                                                                </tr>
                                                            <?php
                                                            }
                                                            ?>
                                                        </table>

                                                        <p style="margin-top:100px;">Clerk-in-Charge
                                                            <span style="float:right">PRINCIPAL</span>
                                                        </p>
                                                    </div>

                                                </div>

                                            <?php
                                            } ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
<script>