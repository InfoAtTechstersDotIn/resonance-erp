<?php
 use App\Models\UsersModel;
 ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <?php if ($_SESSION['rights'][array_search('PaymentApproval', array_column($_SESSION['rights'], 'operationname'))]->_view == 1 || $_SESSION['userdetails']->roleid == 3) : ?>
            <div class="row">
                <div class="col-md-12">
                    <h2 class="page-title">Form Approvals</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <table id="tblpaymentApproval" class="DataTable table table-striped">
                                <thead>
                                    <tr>
                                        <th>Student Name/ Application Number</th>
                                        <th>Form Type</th>
                                        <th>Data</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        <th>Updated By</th>
                                        <th>Created Date</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($formRequests as $result) :
                                    ?>
                                        <tr>
                                            <td><a target="_blank" href="<?php echo base_url('users/studentdetails') ?>?id=<?php echo $result->userid; ?>"><b><?php echo $result->name . "/ " . $result->applicationnumber ?></b></a></td>
                                            <td><?php echo $result->form_type ?></td>
                                            <td><?php 
                                            if($result->form_type =="discountApproval"){
                                                foreach (json_decode($result->data) as $key => $row) {
                                                  if($key == "discountid")
                                                  {
                                                      $UsersModel = new UsersModel();
                                                        $Detail = $UsersModel->getDiscounttype($row);
                                                        print_r("<b>Discount Type : </b>".$Detail[0]->discountname);
                                                        echo "<br>";
                                                  }elseif($key == "Amount")
                                                  {
                                                      $amount = $row;
                                                  }
                                                  else{
                                                      echo "<b>" . $key . "</b>: " . $row . "<br />";
                                                  }
                                                   } 
                                            }else
                                            {
                                                
                                            foreach (json_decode($result->data) as $key => $row) {
                                                    echo "<b>" . $key . "</b>: " . $row . "<br />";
                                                } }?></td>
                                            <td><?php echo $result->status ?></td>
                                            <td><?php echo $result->CreatedBy ?></td>
                                            <td><?php echo $result->UpdatedBy == "" ? "-" : $result->UpdatedBy ?></td>
                                            <td><?php echo date_format(date_create($result->created_timestamp), 'd/m/Y') ?></td>
                                            <td>
                                                <?php 
                                                if($result->form_type =="discountApproval")
                                                {
                                                    ?>
                                                    <input type="number" value="<?php echo $amount;?>" id="refundAmount_<?php echo $result->form_request_id ?>" />
                                                    <?php
                                                }
                                                elseif($result->form_type !="branchtransfer"){
                                                    ?>
                                                    <input type="number" id="refundAmount_<?php echo $result->form_request_id ?>" />
                                                    <?php
                                                }
                                                ?>
                                                </td>
                                                <td>
                                                <?php if($result->form_type =="discountApproval"){
                                                    if($_SESSION['userdetails']->userid == 1   ||$_SESSION['userdetails']->userid == 62   || $_SESSION['userdetails']->userid ==6766){
                                                    ?>
                                                    <a class="btn btn-success" onclick="approveFormRequest('<?php echo $result->form_request_id ?>', this);">Approve</a><br><br>
                                                <a class="btn btn-danger" onclick="rejectFormRequest('<?php echo $result->form_request_id ?>', this);">Reject</a>
                                            
                                                    <?php
                                                    }
                                                }else{
                                                    ?>
                                                <a class="btn btn-success" onclick="approveFormRequest('<?php echo $result->form_request_id ?>', this);">Approve</a><br><br>
                                                <a class="btn btn-danger" onclick="rejectFormRequest('<?php echo $result->form_request_id ?>', this);">Reject</a>
                                                <?php } ?>
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