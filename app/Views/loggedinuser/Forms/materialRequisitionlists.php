<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Material Requisition List</h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblpaymentApproval" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                        <th>Product Name </th>
                                        <th>Actual Quantity</th>
                                        <th>Approved Quantity</th>
                                        <th>Delivered Quantity</th>
                                        <th>Comment</th>
                                        <th>Purpose</th>
                                       
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                    foreach ($forms as $result) :
                                       
                                    ?>
                                        <tr>
                                            <td>
                                            <?php echo $result->name;?>
                                            </td>
                                            <td>
                                            <?php echo $result->approved_quantity;?>
                                            </td>
                                            <td>
                                            <?php echo $result->quantity;?>
                                            </td>
                                            <td>
                                            <?php echo $result->delivered_quantity;?>
                                            </td>
                                            <td>
                                            <?php echo $result->comment;?>
                                            </td>
                                            <td>
                                            <?php echo $result->purpose;?>
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