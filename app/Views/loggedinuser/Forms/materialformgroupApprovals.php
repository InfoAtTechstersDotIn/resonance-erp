<div class="content-wrapper">
    <div class="container-fluid">
        <?php if ($_SESSION['rights'][array_search('PaymentApproval', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
            <div class="row">
                <div class="col-md-12">
                    <h2 class="page-title">Material Form Group Approvals</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <table id="tblpaymentApproval" class="DataTable table table-striped">
                                <thead>
                                    <tr>
                                        <th>Product Name </th>
                                        <th>Actual Quantity</th>
                                        <th>Approve Quantity</th>
                                        <th>Comment</th>
                                        <th>Purpose</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($formRequests as $result) :
                                       
                                    ?>
                                        <tr>
                                            <td>
                                            <?php echo $result->productname;?>
                                            </td>
                                            <td>
                                            <?php echo $result->approved_quantity;?>
                                            </td>
                                            <td>
                                            <input type="number" value="<?php echo $result->quantity;?>" id="quantity_<?php echo $result->id ?>" style="width: 3.3em">
                                            </td>
                                            <td>
                                            <?php echo $result->comment;?>
                                            </td>
                                            <td>
                                            <?php echo $result->purpose;
                                            
                                            ?>
                                            </td>
                                            
                                           
                                            <td><a class="btn btn-success" onclick="updateFormRequest('<?php echo $result->id ?>', this);">update</a><br><br>
                                                
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

    function updateFormRequest(form_request_id, anchor) {
        $('.loading').css('display', 'block');
        var quantity = $("#quantity_" + form_request_id).val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('forms/formRequestMaterialUpdateflow') ?>",
                data: {
                    form_request_id: form_request_id,
                    quantity:quantity
                },
                success: (anchor1 = anchor) => {
                    $('.loading').css('display', 'none');
                }
            });
        
    }
</script>