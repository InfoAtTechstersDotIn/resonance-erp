<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Product Specifications
                    <a class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#add">Add Product Specification</a>
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblotherusers" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($product_specifications as $result) : ?>
                                <tr>
                                    <td><?php echo $result->name ?></td>
                                    <td><?php echo $result->category_name ?></td>
                                    <td><i onclick="edit('<?php echo $result->id ?>', '<?php echo  $result->name ?>', '<?php echo  $result->category_id ?>')" data-toggle="modal" data-target="#edit" class="fa fa-pencil-square-o editbtn"></i></td>
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
                            <h2 class="modal-title">Add Product Specification</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('Inventory/add_product_specification') ?>">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Specification Name</label>
                                        <input type="text" placeholder="Specification Name" name="name" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-12">
                                        <select name="category_id" style="width: 100%;" class="form-control mb">
                                            <option value="">Select Category</option>
                                            <?php foreach ($categories as $category) : ?>
                                                <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <br />
                                <button type="submit" class="btn btn-primary">Add Product Specification</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="edit" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Edit Product Specification</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('Inventory/update_product_specification') ?>">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Specification Name</label>
                                        <input type="text" placeholder="Specification Name" id="name" name="name" class="form-control mb" required>
                                        <input type="hidden" id="product_specification_id" name="product_specification_id" />
                                    </div>
                                    <div class="col-md-12">
                                        <select id="category_id" name="category_id" style="width: 100%;" class="form-control mb">
                                            <option value="">Select Category</option>
                                            <?php
                                            foreach ($categories as $category) : ?>
                                                <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <br/>
                                <button type="submit" class="btn btn-primary">Update Product Specification</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    function edit(id, name, category_id) {
        $('#product_specification_id').val(id);
        $('#name').val(name);
        $('#category_id').val(category_id);
    }

    function remove(id) {
        if (confirm('Are you sure?')) {
            window.location.href = "<?php echo base_url('Inventory/delete_product_specification?product_specification_id=') ?>" + id;
        }
    }
</script>