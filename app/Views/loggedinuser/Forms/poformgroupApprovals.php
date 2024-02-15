<div class="content-wrapper">
    <div class="container-fluid">
        <?php if ($_SESSION['rights'][array_search('PaymentApproval', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
            <div class="row">
                <div class="col-md-12">
                    <h2 class="page-title">PO Form Approvals</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <table id="tblpaymentApproval" class="DataTable table table-striped">
                                <thead>
                                    <tr>
                                        <th>Product Name </th>
                                        <th> Quantity</th>
                                        <th>Comment</th>
                                        
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
                                            <?php echo $result->quantity;?>
                                            </td>
                                            <td>
                                            <?php echo $result->comment;?>
                                            </td>
                                            
                                            
                                           <!--
                                            <td><a class="btn btn-success" onclick="updateFormRequest('<?php echo $result->id ?>', this);">update</a><br><br>
                                                
                                            </td> -->
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