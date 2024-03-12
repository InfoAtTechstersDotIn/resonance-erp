<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <h2 class="page-title">Asset Transfer History</h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblotherusers" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>From Branch</th>
                                    <th>From Building</th>
                                    <th>From Floor</th>
                                    <th>From Room</th>
                                    <th>To Branch</th>
                                    <th>To Building</th>
                                    <th>To Floor</th>
                                    <th>To Room</th>
                                    <th>Transferd on</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($products as $result) : ?>
                                <tr>
                                    <td><?php echo $result->product_name ?></td>
                                    <td><?php echo $result->from_branch ?></td>
                                    <td><?php echo $result->from_building ?></td>
                                    <td><?php echo $result->from_floor ?></td>
                                    <td><?php echo $result->from_room ?></td>
                                    <td><?php echo $result->to_branch ?></td>
                                    <td><?php echo $result->to_building ?></td>
                                    <td><?php echo $result->to_floor ?></td>
                                    <td><?php echo $result->to_room ?></td>
                                    <td><?php echo $result->created_at ?></td>
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