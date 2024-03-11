<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <h2 class="page-title">Warehouse Items</h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblotherusers" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Warehouse</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($products as $result) : ?>
                                <tr>
                                    <td><?php echo $result->product_name ?></td>
                                    <td><?php echo $result->item_quantity ?></td>
                                    <td><?php echo $result->warehouse_name ?></td>
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