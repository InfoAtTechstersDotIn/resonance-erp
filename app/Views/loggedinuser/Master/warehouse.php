<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Warehouse
                    <a class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#add">Add Warehouse</a>
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblotherusers" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Warehouse Name</th>
                                    <th>Address</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($warehouses as $result) : ?>
                                    <tr>
                                        <td><?php echo $result->name ?></td>
                                        <td><?php echo $result->address ?></td>
                                        <td><i onclick="edit('<?php echo $result->id ?>', '<?php echo  $result->name ?>', '<?php echo  $result->address ?>')" data-toggle="modal" data-target="#edit" class="fa fa-pencil-square-o editbtn"></i></td>
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
                            <h2 class="modal-title">Add Warehouse</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('master/addwarehouse') ?>">
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Name</label>
                                        <input type="text" placeholder="Warehouse Name" name="name" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Address</label>
                                        <input type="text" placeholder="Warehouse Address" name="address" class="form-control mb" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Warehouse</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="edit" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Edit Warehouse</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('master/updatewarehouse') ?>">
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Name</label>
                                        <input type="text" placeholder="Warehouse Name" name="name" id="name" class="form-control mb" required>
                                        <input type="hidden" name="warehouse_id" id="warehouse_id" />
                                    </div>
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Address</label>
                                        <input type="text" placeholder="Warehouse Address" name="address" id="address" class="form-control mb" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Warehouse</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    function edit(id, value, address) {
        $('#warehouse_id').val(id);
        $('#name').val(value);
        $('#address').val(address);
    }

    function remove(id) {
        if(confirm('Are you sure?'))
        {
            window.location.href = "<?php echo base_url('master/deletewarehouse?warehouse_id=') ?>" + id;
        }
    }
</script>