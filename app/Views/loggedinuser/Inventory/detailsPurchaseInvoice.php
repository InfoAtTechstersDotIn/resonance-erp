<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Purchase Invoice Details</h2>

                <div class="row">
                    <div class="col-lg-6">
                        <h3 class="mb-2">General Information</h3>
                        <table class="table table-bordered">
                            <tr>
                                <td class="h5">Invoice No.</td>
                                <td class="h5"><?php echo $purchase_invoice->invoice_no ?></td>
                            </tr>
                            <tr>
                                <td class="h5">Invoice Date</td>
                                <td class="h5"><?php echo $purchase_invoice->invoice_date ?></td>
                            </tr>
                            <tr>
                                <td class="h5">Vendor Name</td>
                                <td class="h5"><?php echo $purchase_invoice->vendor_name ?></td>
                            </tr>
                            <tr>
                                <td class="h5">Warehouse Name</td>
                                <td class="h5"><?php echo $purchase_invoice->warehouse_name ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-12">
                        <h3 class="mb-2">Invoice Items</h3>
                        <table class="table table-bordered">
                        <tr>
                            <td>Sr. No.</td>
                            <td>Manufacturer</td>
                            <td>Product</td>
                            <td>Price</td>
                            <td>Quantity</td>
                            <td>GST Percentage</td>
                            <td>Total</td>
                        </tr>
                        <?php foreach ($purchase_invoice_items as $key => $item) :?>
                            <tr>
                                <td><?php echo $key + 1 ?></td>
                                <td><?php echo $item->manufacturer_name ?></td>
                                <td><?php echo $item->product_name ?></td>
                                <td><?php echo $item->price ?></td>
                                <td><?php echo $item->quantity ?></td>
                                <td><?php echo $item->gst ?></td>
                                <td><?php echo $item->total ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </table>
                    </div>
                    <div class="col-lg-12">
                        <h3 class="mb-2">Total Amount = <?php echo $purchase_invoice_total->total_amount; ?></h3>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>