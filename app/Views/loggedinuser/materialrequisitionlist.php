<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Material Requisition Master
                    <a class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#add">Add Material Requisition</a>
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblotherusers" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Material Requisition Name</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach ($lookups['materialrequisition'] as $result) :
                                ?>
                                    <tr>
                                        <td><?php echo $result->materialrequisitionname ?></td>
                                        <td><i onclick="edit('<?php echo $result->materialrequisitionid ?>', '<?php echo  $result->materialrequisitionname ?>')" data-toggle="modal" data-target="#edit" class="fa fa-pencil-square-o editbtn"></i></td>
                                        <td><i onclick="remove('<?php echo $result->materialrequisitionid ?>')" class='fa fa-trash'></i></td>
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
                            <h2 class="modal-title">Add material requisition</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('master/addmaterialrequisition') ?>">
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Material Requisition Name</label>
                                        <input type="text" placeholder="Material Requisition Name" name="name" class="form-control mb" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="edit" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Edit material requisition</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('master/updatematerialrequisition') ?>">
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">material requisition Name</label>
                                        <input type="text" placeholder="Branch Name" name="name" id="name" class="form-control mb" required>
                                        <input type="hidden" name="id" id="id" />
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function edit(id, value, latitude, longitude, branch_address) {
        $('#id').val(id);
        $('#name').val(value);
        $('#latitude').val(longitude);
        $('#longitude').val(longitude);
        $('#branch_address').val(branch_address);
    }

    function remove(id) {
        if(confirm('Are you sure?'))
        {
            window.location.href = "<?php echo base_url('master/deletematerialrequisition?id=') ?>" + id;
        }
    }
</script>