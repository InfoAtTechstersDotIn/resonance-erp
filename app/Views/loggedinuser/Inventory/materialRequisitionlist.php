<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Material Requisitions</h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblpaymentApproval" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Branch Name</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th>Approved By</th>
                                    <th>Action</th>
                                    <th>Print</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($forms as $result) :
                                ?>
                                    <tr>
                                        <td>
                                            <a href="materialrequisitionforms/<?php echo $result->id ?>"><?php echo $result->id ?></a>
                                        </td>
                                        <td><?php echo $result->branchname;?></td>
                                        <td><?php echo $result->material_requisition_status ?></td>
                                        <td><?php echo date_format(date_create($result->created_time), 'd/m/Y') ?></td>
                                        <td><?php echo $result->UpdatedBy;?></td>
                                       
                                        <td><a class="btn btn-success" href="Transfer?materialid=<?php echo $result->id;?>">Transfer</a></td>
                                        <td><?php
                                            if ($result->material_requisition_status == "approved") {
                                                $db = db_connect();
                                                $query = $db->query("SELECT Fr.*,p.name as productname,mri.quantity, Cr.name AS CreatedBy, Up.Name as UpdatedBy FROM material_requisition Fr
                                                JOIN material_requisition_items mri on Fr.id = mri.material_requisition_id
                                                JOIN product p on mri.product_id = p.id
                                                JOIN employeedetails Cr on Fr.created_by = Cr.userid
                                                LEFT JOIN employeedetails Up on Fr.updated_by = Up.userid
                                                                    WHERE Fr.id='{$result->id}'");
                                                $results = $query->getResult();
                                                $db->close();
                                           ?>
                                                <a class="btn btn-success" onclick="printDiv('div_<?php echo $result->id; ?>')">Print</a>

                                                <div class="col-md-12" id="div_<?php echo $result->id; ?>" style="display:none;">
                                                    <div class="scale">
                                                        <p style="text-align: center;"><img src="<?php echo base_url('images/logo1.png') ?>" width="140" height="50" /></p>
                                                        <br />
                                                        <p style="text-align: right;">Date: <?php echo date("d-m-Y"); ?><br />Hyderabad</p>
                                                        <h4 style="text-align: center;"><strong><u>Material Requisition Form</u></strong></h4>
                                                        <br />

                                                        <br />
                                                        Material Requistion Id: <?php
                                                                echo $result->id;
                                                                ?>
                                                       
                                                        <br />
                                                        Branch: <?php
                                                                echo $result->branchname;
                                                                ?>
                                                        <br />
                                                        Status: <?php
                                                                echo $result->material_requisition_status . " (" . $result->UpdatedBy . ")";
                                                                ?>
                                                        <br />
                                                        <table style="width: 100%;margin: 0;">

                                                            <tr>
                                                                <td><span style="width: 20%;"><b>ProductName</b></span></td>
                                                                <td><span style="width: 20%;"><b>Quantity</b></td>
                                                            </tr>
                                                            <br />
                                                            <?php
                                                            foreach ($results as $item) {
                                                            ?>
                                                                <tr>
                                                                    <td><span style="width: 20%;"><?php
                                                                                                   
                                                                                                            echo $item->productname;
                                                                                                
                                                                                                    ?></span></td>
                                                                    <td><span style="width: 20%;"> <?php
                                                                                                
                                                                                                            echo $item->quantity;
                                                                                                    
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