<div class="content-wrapper">
    <div class="container-fluid">
        <?php if ($_SESSION['rights'][array_search('PaymentApproval', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
            <div class="row">
                <div class="col-md-12">
                    <h2 class="page-title">Material Form Approvals</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <table id="tblpaymentApproval" class="DataTable table table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($formRequests as $result) :
                                    ?>
                                        <tr>
                                            <td><a href="MaterialformApprovals/<?php echo $result->id ?>"><?php echo $result->id ?></a></td>
                                            <td><?php echo $result->material_requisition_status ?></td>
                                            <td><?php echo $result->CreatedBy ?></td>
                                            <td><?php echo date_format(date_create($result->created_time), 'd/m/Y') ?></td>
                                            <td>
                                                <?php if($result->material_requisition_status == "created"){
                                                    ?>
                                                <a class="btn btn-success" onclick="approveFormRequest('<?php echo $result->id ?>', this);">Approve</a>&nbsp;
                                                <a class="btn btn-danger" onclick="rejectFormRequest('<?php echo $result->id ?>', this);">Reject</a>
                                                <?php }
                                                if($result->material_requisition_status != "created"){
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
                                                <?php } ?>
                                                <div class="col-md-12" id="div_<?php echo $result->id; ?>" style="display:none;">
                                                    <div class="scale">
                                                        <p style="text-align: center;"><img src="<?php echo base_url('images/logo1.png') ?>" width="140" height="50" /></p>
                                                        <br />
                                                        <p style="text-align: right;">Date: <?php echo date("d-m-Y"); ?><br />Hyderabad</p>
                                                        <h4 style="text-align: center;"><strong><u>Material Requisition Form</u></strong></h4>
                                                        <br />

                                                        <br />
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
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    var dt;
    dt = $('.DataTable').DataTable();

    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }

    function approveFormRequest(form_group_id, anchor) {
        $('.loading').css('display', 'block');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('forms/formRequestMaterialGroupApprovalflow') ?>",
            data: {
                approveform: true,
                form_group_id: form_group_id,
            },
            success: (anchor1 = anchor) => {
                $('.loading').css('display', 'none');
                location.reload();

            }
        });

    }

    function rejectFormRequest(form_group_id, anchor) {
        $('.loading').css('display', 'block');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('forms/formRequestMaterialGroupApprovalflow') ?>",
            data: {
                form_group_id: form_group_id
            },
            success: (anchor1 = anchor) => {
                dt
                    .row($(anchor).parents('tr'))
                    .remove()
                    .draw(false);
                $('.loading').css('display', 'none');
                location.reload();

            }
        });

    }
</script>