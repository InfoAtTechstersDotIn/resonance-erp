<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <h2 class="page-title">Warehouse Allocation History</h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblotherusers" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Warehouse</th>
                                    <th>Branch</th>
                                    <th>Building</th>
                                    <th>Floor</th>
                                    <th>Room</th>
                                    <th>Product Sr. No.</th>
                                    <th>Received</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($products as $result) : ?>
                                <tr>
                                    
                                    <td><?php echo $result->product_name ?></td>
                                    <td><?php echo $result->warehouse_name ?></td>
                                    <td><?php echo $result->branch_name ?></td>
                                    <td><?php echo $result->building_name ?></td>
                                    <td><?php echo $result->floor_name ?></td>
                                    <td><?php echo $result->room_name ?></td>
                                    <td><?php echo $result->product_serial_no ?></td>
                                    <td><?php echo $result->is_received ? "Yes" : "No" ?></td>
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