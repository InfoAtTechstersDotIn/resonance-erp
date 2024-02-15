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
                                    <th>Name</th>
                                    <th>Actual Quantity</th>
                                    <th>Approved Quantity</th>
                                    <th>Delivered Quantity</th>
                                    <th>Updated By</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($forms as $result) :
                                ?>
                                    <tr>
                                        <td>
                                            <?php 
                                                echo $result->name;
                                             ?>
                                        </td>
                                        <td>
                                            <?php 
                                                echo $result->approved_quantity;
                                             ?>
                                        </td>
                                        <td>
                                            <?php 
                                                echo $result->quantity;
                                             ?>
                                        </td>
                                        <td>
                                            <?php 
                                                echo $result->delivered_quantity;
                                             ?>
                                        </td>
                                        <td><?php echo $result->UpdatedBy == "" ? "-" : $result->UpdatedBy ?></td>
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