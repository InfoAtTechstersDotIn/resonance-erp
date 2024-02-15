<div class="content-wrapper">
    <div class="container-fluid">
        <?php if ($_SESSION['rights'][array_search('PaymentApproval', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
            <div class="row">
                <div class="col-md-12">
                    <h2 class="page-title">Form Approvals</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <table id="tblpaymentApproval" class="DataTable table table-striped">
                                <thead>
                                    <tr>
                                        <th>Student Name/ Application Number</th>
                                        <th>Branch name / Section Name</th>
                                        <th>Form Type</th>
                                        <th>Data</th>
                                        <th>In Time</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        <th>Updated By</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($formRequests as $result) :
                                    ?>
                                        <tr>
                                            <td><a target="_blank" href="<?php echo base_url('users/studentdetails') ?>?id=<?php echo $result->userid; ?>"><b><?php echo $result->name . "/ " . $result->applicationnumber ?></b></a></td>
                                            <td><?php echo $result->branchname.'/'.$result->sectionname ?></td>
                                            <td><?php echo $result->form_type ?></td>
                                            <td><?php foreach (json_decode($result->data) as $key => $row) {
                                                    echo "<b>" . $key . "</b>: " . $row . "<br />";
                                                } ?></td>
                                                <td><?php echo $result->indata
                                                
                                                ?></td>
                                            <td><?php echo $result->status ?></td>
                                            <td><?php echo $result->CreatedBy ?></td>
                                            <td><?php echo $result->UpdatedBy == "" ? "-" : $result->UpdatedBy ?></td>
                                            <td><?php echo date_format(date_create($result->created_timestamp), 'd/m/Y') ?></td>
                                            <td>
                                                <?php if($result->status == "approved"){
                                                    ?>
                                                 <a class="btn btn-success" style="background-color: #00203d;" data-toggle="modal" data-target="#editoutpass_<?php echo $result->form_request_id;?>"> <i class='fa fa-pencil'></i></a>
                                            <?php } if($result->status == "created"){
                                                    ?>
                                                <a class="btn btn-success" onclick="approveFormRequest('<?php echo $result->form_request_id ?>', this);">Approve</a>&nbsp;
                                                <a class="btn btn-danger" onclick="rejectFormRequest('<?php echo $result->form_request_id ?>', this);">Reject</a>
                                                <?php }
                                                ?>
                                            </td>
                                        </tr>
                                       
                              <div class="modal fade" id="editoutpass_<?php echo $result->form_request_id;?>" tabindex="-1" role="dialog">
                              <div class="modal-dialog" role="document">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h2 class="modal-title">Edit RF Id</h2>
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -45px;">
                                          <span>&times;</span>
                                       </button>
                                    </div>
                                    <div class="modal-body">
                                       <form method="post" action="<?php echo base_url('api/studentoutpassedit') ?>">
                                          <br>
                                          <div class="row">
                                              <div class="col-md-3">
                                                 </div>
                                             <div class="col-md-6">
                                                <input type="hidden" name="form_request_id" value="<?php echo $result->form_request_id; ?>" />
                                                <input type="hidden" name="web" value="1" />

                                                <label class="text-uppercase text-sm">In Time</label>
                                            
                                            
                                                 <input type="datetime-local" placeholder="Enter In time " name="intime" class="form-control mb" required>
                                             </div>
                                             <div class="col-md-3">
                                                 </div>
                                             <br />
                                             <br />
                                             <br />
                                             <br />
                                            
                                          </div>
                                          <div>&nbsp;</div>
                                          <button type="submit" name="addInvoice" class="btn btn-primary" style="margin-left: 236px;">Submit</button>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                             <?php
                                        $websites = array("183.83.218.213");
$good = "1 received";
$successValue;

echo "<h1>Site Status  ".date("h:i:s")."</h1>";

foreach ($websites as $url){
    unset($result);
    $successValue = "DOWN";
    exec("ping -c 1 '$url'", $result);
    foreach($result as $line) {
		print_R($line);
        if (strpos($line,$good) == TRUE){
            $successValue = "UP";
        }
    }
    echo "<strong>Address: ".$url." </strong>";
        if ($successValue == "UP") {
            echo " Site is ".$successValue;

        } else {
            echo "Site is ".$successValue;
    }
   
    echo "<br><br>";
}

?>
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