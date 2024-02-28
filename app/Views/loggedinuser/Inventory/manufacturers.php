<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Manufacturers
                    <a class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#add">Add Manufacturers</a>
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblotherusers" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($manufacturers as $result) :
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
                            <h2 class="modal-title">Add Manufacturers</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('Inventory/addmanufacturer') ?>">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="text-uppercase text-sm">Manufacturer Name</label>
                                        <input type="text" placeholder="Manufacturer Name" name="manufacturername" class="form-control mb" required>
                                    </div>
                                </div>
                                <br />
                                <button type="submit" class="btn btn-primary">Add Manufacturer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="edit" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Edit Manufacturer</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('Inventory/updatemanufacturer') ?>">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="text-uppercase text-sm">Manufacturer Name</label>
                                        <input type="text" placeholder="Manufacturer Name" id="manufacturername" name="manufacturername" class="form-control mb" required>
                                        <input type="hidden" id="manufacturerid" name="manufacturerid" />
                                    </div>
                                </div>
                                <br/>
                                <button type="submit" class="btn btn-primary">Update Manufacturer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    function edit(manufacturerid, manufacturername) {
        $('#manufacturerid').val(manufacturerid);
        $('#manufacturername').val(manufacturername);
    }

    function remove(id) {
        if (confirm('Are you sure?')) {
            window.location.href = "<?php echo base_url('Inventory/deletemanufacturer?manufacturerid=') ?>" + id;
        }
    }
</script>