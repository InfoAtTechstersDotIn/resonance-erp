<div class="content-wrapper">
    <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="page-title">Bulk Out Pass List</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <table id="tblpaymentApproval" class="DataTable table table-striped">
                                <thead>
                                    <tr>
                                        <th>Form Type</th>
                                        <th>Data</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        <th>Updated By</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($forms as $result) :
                                    ?>
                                        <tr>
                                            <td><?php echo $result->form_type ?></td>
                                            <td>
                                                <?php echo $result->sectionname;?> |
                                                <?php echo $result->branchname;?> |
                                            <a href="bulkoutpass/<?php echo $result->form_group_id ?>"><?php echo $result->form_group_id ?></a>
                                            </td>
                                            <td><?php echo $result->status ?></td>
                                            <td><?php echo $result->CreatedBy ?></td>
                                            <td><?php echo $result->UpdatedBy == "" ? "-" : $result->UpdatedBy ?></td>
                                            <td><?php echo date_format(date_create($result->created_timestamp), 'd/m/Y') ?></td>
                                           <td><?php 
                                           if($result->status=="approved")
                                           {
                                               ?>
                                               <a class="btn btn-success" href="https://maidendropgroup.com/public/payments/printbulkoutpass?formgroupid=<?php echo $result->form_group_id ?>">Print</a>
                                             
                        <div class="col-md-12" id="div_<?php echo $result->form_group_id;?>" style="display:none;">
                            <div class="scale">
                                <p style="text-align: center;"><img src="<?php echo base_url('images/logo.png') ?>" width="110" height="110" /></p>
                                <br />
                                <p style="text-align: right;">Date: <?php echo date("d-m-Y"); ?><br />Hyderabad</p>
                                <h4 style="text-align: center;"><strong><u>Out Pass</u></strong></h4>
                                <table style="width: 100%;margin: 0;">
                                     <tr >
                                         <td ><span style="width: 10%;"></span></td>
                                        <td ><span style="width: 40%;">ProductName</span></td>
                                        <td ><span style="width: 10%;">: </span></td>
                                        <td ><span style="width: 40%;"> <?php 
                                        foreach (json_decode($result->data) as $key => $row) {
                                            if( $key == "ProductName")
                                            echo $row;
                                        }
                                        ?></span></td>
                                        <br>
                                    </tr>
                                    <tr
                                    <tr >
                                         <td ><span style="width: 10%;"></span></td>
                                        <td ><span style="width: 40%;">Branch</span></td>
                                        <td ><span style="width: 10%;">: </span></td>
                                        <td ><span style="width: 40%;"> <?php 
                                        foreach (json_decode($result->data) as $key => $row) {
                                            if( $key == "Branchid")
                                            echo $row;
                                        }
                                        ?></span></td>
                                        <br>
                                    </tr>
                                    <tr >
                                         <td ><span style="width: 10%;"></span></td>
                                        <td ><span style="width: 40%;">Quantity</span></td>
                                        <td ><span style="width: 10%;">: </span></td>
                                        <td ><span style="width: 40%;"> <?php 
                                        foreach (json_decode($result->data) as $key => $row) {
                                            if( $key == "Quantity")
                                            echo $row;
                                        }
                                        ?></span></td>
                                        <br>
                                    </tr>
                                    <tr >
                                         <td ><span style="width: 10%;"></span></td>
                                        <td ><span style="width: 40%;">Purpose</span></td>
                                        <td ><span style="width: 10%;">: </span></td>
                                        <td ><span style="width: 40%;"> <?php 
                                        foreach (json_decode($result->data) as $key => $row) {
                                            if( $key == "Purpose")
                                            echo $row;
                                        }
                                        ?></span></td>
                                        <br>
                                    </tr>
                                    <tr >
                                         <td ><span style="width: 10%;"></span></td>
                                        <td ><span style="width: 40%;">Reason for Replacement / New</span></td>
                                        <td ><span style="width: 10%;">: </span></td>
                                        <td ><span style="width: 40%;"> <?php 
                                        foreach (json_decode($result->data) as $key => $row) {
                                            if( $key == "Reason")
                                            echo $row;
                                        }
                                        ?></span></td>
                                        <br>
                                    </tr>
                                </table>
                               
                                <p style="margin-top:500px;">Clerk-in-Charge
                                    <span style="float:right">PRINCIPAL</span>
                                </p>
                            </div>
                            
                        </div>
               
                                               <?php
                                           }?></td>
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
    var dt;
    dt = $('.DataTable').DataTable();

    function approveFormRequest(form_request_id, anchor) {
        $('.loading').css('display', 'block');
        var refundAmount = $("#refundAmount_" + form_request_id).val();

        if (refundAmount != "" && refundAmount != "0") {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('forms/formRequestApprovalflow') ?>",
                data: {
                    approveform: true,
                    form_request_id: form_request_id,
                    refundAmount: refundAmount
                },
                success: (anchor1 = anchor) => {
                    dt
                        .row($(anchor).parents('tr'))
                        .remove()
                        .draw(false);
                    $('.loading').css('display', 'none');
                }
            });
        } else {
            alert("Refund Amount cannot be 0");
            $('.loading').css('display', 'none');
        }
    }

    function rejectFormRequest(paymentid, anchor) {
        $('.loading').css('display', 'block');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('forms/formRequestApprovalflow') ?>",
            data: {
                rejectpayment: true,
                form_request_id: paymentid
            },
            success: (anchor1 = anchor) => {
                dt
                    .row($(anchor).parents('tr'))
                    .remove()
                    .draw(false);
                $('.loading').css('display', 'none');
            }
        });

    }
</script>