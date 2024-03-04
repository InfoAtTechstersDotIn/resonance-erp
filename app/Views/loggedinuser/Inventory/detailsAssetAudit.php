<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Asset Audit Details</h2>

                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="mb-2">General Information</h3>
                        <table class="table table-bordered">
                            <tr>
                                <td class="h5">Branch</td>
                                <td class="h5"><?php echo $asset_audit->branchname ?></td>
                            </tr>
                            <tr>
                                <td class="h5">Audit Date</td>
                                <td class="h5"><?php echo $asset_audit->date ?></td>
                            </tr>
                            <tr>
                                <td class="h5">Remark</td>
                                <td class="h5"><?php echo $asset_audit->remark ?></td>
                            </tr>
                        </table>
                    </div>

                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div>
                            <h4>Pending Items</h4>
                        </div>
                        <table class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Product Code</th>
                                    <th>Manufracturer Code</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pending_items as $result) :?>
                                    <tr>
                                        <td><?php echo $result->name ?></td>
                                        <td><?php echo $result->product_serial_no ?></td>
                                        <td><?php echo $result->manufacturer_serial_no ?></td>
                                        <td><?php echo $result->status ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <div>
                            <h4>Scanned Items</h4>
                        </div>
                        <table class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Product Code</th>
                                    <th>Manufracturer Code</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($scanned_items as $result) :?>
                                    <tr>
                                        <td><?php echo $result->name ?></td>
                                        <td><?php echo $result->product_serial_no ?></td>
                                        <td><?php echo $result->manufacturer_serial_no ?></td>
                                        <td><?php echo $result->status ?></td>
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