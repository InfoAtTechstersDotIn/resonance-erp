<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Branch Master
                    <a class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#add">Add Branch</a>
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblotherusers" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Branch Name</th>
                                    <th>Coordinates</th>
                                    <th>Branch Address</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach ($lookups['branchlookup'] as $result) :
                                ?>
                                    <tr>
                                        <td><?php echo $result->branchname ?></td>
                                        <td><?php echo $result->latitude . ", " . $result->longitude ?></td>
                                        <td><?php echo $result->branch_address ?></td>
                                        <td><i onclick="edit('<?php echo $result->branchid ?>', '<?php echo  $result->branchname ?>', '<?php echo  $result->latitude ?>', '<?php echo  $result->longitude ?>', '<?php echo  $result->branch_address ?>')" data-toggle="modal" data-target="#edit" class="fa fa-pencil-square-o editbtn"></i></td>
                                        <td><i onclick="remove('<?php echo $result->branchid ?>')" class='fa fa-trash'></i></td>
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
                            <h2 class="modal-title">Add Branch</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('master/addbranch') ?>">
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Branch Name</label>
                                        <input type="text" placeholder="Branch Name" name="name" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Branch Address</label>
                                        <input type="text" placeholder="Branch Address" name="branch_address" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Latitude</label>
                                        <input type="text" placeholder="Latitude" name="latitude" class="form-control mb">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Longitude</label>
                                        <input type="text" placeholder="Longitude" name="longitude" class="form-control mb">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Branch</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="edit" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Edit Branch</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('master/updatebranch') ?>">
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Branch Name</label>
                                        <input type="text" placeholder="Branch Name" name="name" id="name" class="form-control mb" required>
                                        <input type="hidden" name="id" id="id" />
                                    </div>
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Branch Address</label>
                                        <input type="text" placeholder="Branch Address" name="branch_address" id="branch_address" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Latitude</label>
                                        <input type="text" placeholder="Latitude" name="latitude" id="latitude" class="form-control mb">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Longitude</label>
                                        <input type="text" placeholder="Longitude" name="longitude" id="longitude" class="form-control mb">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Branch</button>
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
            window.location.href = "<?php echo base_url('master/deletebranch?id=') ?>" + id;
        }
    }
</script>