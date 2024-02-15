<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Product Categories
                    <a class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#add">Add Productcategory</a>
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblotherusers" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Product category Name</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach ($productcategorys as $result) :
                                ?>
                                    <tr>
                                        <td><?php echo $result->name ?></td>
                                        <td><i onclick="edit('<?php echo $result->id ?>', '<?php echo  $result->name ?>')" data-toggle="modal" data-target="#edit" class="fa fa-pencil-square-o editbtn"></i></td>
                                        <td><i onclick="remove('<?php echo $result->id ?>')" class='fa fa-trash'></i></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="add" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Add Product category</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('Inventory/addproductcategory') ?>">
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Product Category Name</label>
                                        <input type="text" placeholder="Product category Name" name="productcategoryname" class="form-control mb" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Vendor</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="edit" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Edit productcategory</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('Inventory/updateproductcategory') ?>">
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Product Category Name</label>
                                        <input type="text" placeholder="Product Category Name" name="productcategoryname" id="productcategoryname" class="form-control mb" required>
                                        <input type="hidden" name="productcategoryid" id="productcategoryid" />
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Update productcategory</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function edit(productcategoryid, productcategoryname) {
        $('#productcategoryid').val(productcategoryid);
        $('#productcategoryname').val(productcategoryname);
    }

    function remove(productcategoryid) {
        if(confirm('Are you sure?'))
        {
            window.location.href = "<?php echo base_url('Inventory/deleteproductcategory?productcategoryid=') ?>" + productcategoryid;
        }
    }
</script>