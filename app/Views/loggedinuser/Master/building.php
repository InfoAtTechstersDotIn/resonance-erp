<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Buildings
                    <a class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#add">Add Building</a>
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblotherusers" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Branch</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($buildings as $result) : ?>
                                <tr>
                                    <td><?php echo $result->name ?></td>
                                    <td><?php echo $result->branchname ?></td>
                                    <td><i onclick="edit('<?php echo $result->id ?>', '<?php echo  $result->name ?>', '<?php echo  $result->branch_id ?>')" data-toggle="modal" data-target="#edit" class="fa fa-pencil-square-o editbtn"></i></td>
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
                            <h2 class="modal-title">Add Building</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('Master/addbuilding') ?>">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Building Name</label>
                                        <input type="text" placeholder="Building Name" name="buildingname" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-12">
                                        <select name="branch_id" style="width: 100%;" class="form-control mb">
                                            <option value="">Select Branch</option>
                                            <?php
                                            foreach ($lookups['branchlookup'] as $branch) : ?>
                                                <option value="<?php echo $branch->branchid; ?>"><?php echo $branch->branchname; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <br />
                                <button type="submit" class="btn btn-primary">Add Building</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="edit" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Edit Building</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('Master/updatebuilding') ?>">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Building Name</label>
                                        <input type="text" placeholder="Building Name" id="buildingname" name="buildingname" class="form-control mb" required>
                                        <input type="hidden" id="buildingid" name="buildingid" />
                                    </div>
                                    <div class="col-md-12">
                                        <select id="branch_id" name="branch_id" style="width: 100%;" class="form-control mb">
                                            <option value="">Select Branch</option>
                                            <?php
                                            foreach ($lookups['branchlookup'] as $branch) : ?>
                                                <option value="<?php echo $branch->branchid; ?>"><?php echo $branch->branchname; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <br/>
                                <button type="submit" class="btn btn-primary">Update Building</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    function edit(buildingid, buildingname, branch_id) {
        $('#buildingid').val(buildingid);
        $('#buildingname').val(buildingname);
        $('#branch_id').val(branch_id);
    }

    function remove(id) {
        if (confirm('Are you sure?')) {
            window.location.href = "<?php echo base_url('Master/deletebuilding?buildingid=') ?>" + id;
        }
    }
</script>