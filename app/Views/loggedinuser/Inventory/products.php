<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Products
                    <a class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#add">Add Product</a>
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblotherusers" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Product Code</th>
                                    <th>Product Type</th>
                                    <th>Product Category</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach ($products as $result) :
                                ?>
                                    <tr>
                                        <td><?php echo $result->productname ?></td>
                                        <td><?php echo $result->quantity ?></td>
                                        <td><?php echo $result->code ?></td>
                                        <td><?php echo $result->producttype ?></td>
                                        <td><?php echo $result->categoryname ?></td>
                                        <td><i onclick="edit('<?php echo $result->id ?>', '<?php echo  $result->productname ?>', '<?php echo  $result->quantity ?>', '<?php echo $result->product_category_id ?>', '<?php echo $result->product_type_id ?>', '<?php echo $result->code ?>')" data-toggle="modal" data-target="#edit" class="fa fa-pencil-square-o editbtn"></i></td>
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
                            <h2 class="modal-title">Add Product</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('Inventory/addproduct') ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Product Name</label>
                                        <input type="text" placeholder="Product Name" name="productname" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Product Quantity</label>
                                        <input type="text" placeholder="Product quantity" name="quantity" class="form-control mb">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Product Code</label>
                                        <input type="text" placeholder="Product Code" name="code" class="form-control mb" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <select name="productcategory" style="width: 100%;" class="select2 form-control mb" required>
                                            <option value="">Select Product Category</option>
                                            <?php
                                            foreach ($productcategory as $productcategorys) :
                                            ?>
                                                <option value="<?php echo $productcategorys->id; ?>"><?php echo $productcategorys->name; ?></option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                    
                               
                                    <div class="col-md-6">
                                        <select id="producttype1" name="producttype" style="width: 100%;" class="select2 form-control mb" onchange="changeProductType();">
                                            <option value="">Select Product Type</option>
                                            <?php
                                            foreach ($producttype as $type) :
                                            ?>
                                                <option value="<?php echo $type->id; ?>"><?php echo $type->name; ?></option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                    
                                    
                                        </div>
                                        <br>
                                         <div class="row">
                                         <div class="col-md-6" id="ids" style="display:none;">
                                    <select id="productids" name="productids[]" multiple style="width: 100%;" class="select2 form-control mb">
                                            <option value="">Select Products</option>
                                            <?php
                                            foreach ($products as $prod) :
                                                if($prod->product_type_id==2){
                                            ?>
                                                <option value="<?php echo $prod->id; ?>"><?php echo $prod->productname; ?></option>
                                            <?php
                                                }
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                    </div>
                                <br />
                                <button type="submit" class="btn btn-primary">Add Product</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="edit" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Edit Product</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('Inventory/updateproduct') ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Product Name</label>
                                        <input type="text" placeholder="Product Name" id="productname" name="productname" class="form-control mb" required>
                                        <input type="hidden" id="productid" name="productid" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Product Quantity</label>
                                        <input type="text" placeholder="Product Quantity" id="quantity" name="quantity" class="form-control mb">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Product Code</label>
                                        <input type="text" placeholder="Product Code" id="code" name="code" class="form-control mb" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <select id="producttype" name="producttype" style="width: 100%;" class="form-control mb" >
                                            <option value="">Select Product Type</option>
                                            <?php
                                            foreach ($producttype as $type) :
                                            ?>
                                                <option value="<?php echo $type->id; ?>"><?php echo $type->name; ?></option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                    <select id="productcategory" name="productcategory" style="width: 100%;" class="form-control mb">
                                            <option value="">Select Product Category</option>
                                            <?php
                                            foreach ($productcategory as $productcategorys) :
                                            ?>
                                                <option value="<?php echo $productcategorys->id; ?>"><?php echo $productcategorys->name; ?></option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                    
                                </div>
                                <br />
                                <button type="submit" class="btn btn-primary">Update Product</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function changeProductType() {
        var producttype = $('#producttype1').val();
        if(producttype == 3){
        $("#ids").css("display", "block");
        }else
        {
            $("#ids").css("display", "none");
        }
    }
    function edit(productid, productname,quantity, productcategory, producttype, code) {
        $('#productid').val(productid);
        $('#productname').val(productname);
        $('#quantity').val(quantity);
        $('#productcategory').val(productcategory);
        $('#producttype').val(producttype);
        $('#code').val(code);
    }

    function remove(id) {
        if (confirm('Are you sure?')) {
            window.location.href = "<?php echo base_url('Inventory/deleteproduct?productid=') ?>" + id;
        }
    }
</script>