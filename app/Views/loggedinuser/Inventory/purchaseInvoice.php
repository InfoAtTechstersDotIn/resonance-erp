<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Purchase Invoices
                    <a class="btn btn-success" style="float: right;" href="<?php echo base_url('Inventory/create_purchase_invoice') ?>" >Add Purchase Invoice</a>
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblotherusers" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Invoice No.</th>
                                    <th>Inoive Date</th>
                                    <th>Vendor</th>
                                    <th>Warehouse</th>
                                    <th>Generated on</th>
                                    <th>Details</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($purchase_invoices as $result) :?>
                                    <tr>
                                        <td><?php echo $result->invoice_no ?></td>
                                        <td><?php echo $result->invoice_date ?></td>
                                        <td><?php echo $result->vendor_name ?></td>
                                        <td><?php echo $result->warehouse_name ?></td>
                                        <td><?php echo date('d-m-Y h:i A', strtotime($result->created_at)) ?></td>
                                        <td><a href="<?php echo base_url('Inventory/purchase_invoice_details/'.$result->id) ?>">View Details</a></td>
                                        <td><i onclick="remove('<?php echo $result->id ?>')" class='fa fa-trash'></i></td>
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

<script>
    function remove(id) {
        if (confirm('Are you sure?')) {
            // window.location.href = "<?php echo base_url('Inventory/deleteproduct?productid=') ?>" + id;
        }
    }
</script>