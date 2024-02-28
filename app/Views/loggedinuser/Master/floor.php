<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Floors
                    <a class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#add">Add Floor</a>
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblotherusers" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Branch</th>
                                    <th>Building</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($floors as $result) : ?>
                                <tr>
                                    <td><?php echo $result->name ?></td>
                                    <td><?php echo $result->branchname ?></td>
                                    <td><?php echo $result->building_name ?></td>
                                    <td><i onclick="edit('<?php echo $result->id ?>', '<?php echo  $result->name ?>', '<?php echo  $result->branch_id ?>', '<?php echo  $result->building_id ?>')" data-toggle="modal" data-target="#edit" class="fa fa-pencil-square-o editbtn"></i></td>
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
                            <h2 class="modal-title">Add Floor</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('Master/addfloor') ?>">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Floor Name</label>
                                        <input type="text" placeholder="Floor Name" name="floorname" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-12">
                                        <select onchange="handleFilterAddBuilding(event)" name="branch_id" style="width: 100%;" class="form-control mb">
                                            <option value="">Select Branch</option>
                                            <?php
                                            foreach ($lookups['branchlookup'] as $branch) : ?>
                                                <option value="<?php echo $branch->branchid; ?>"><?php echo $branch->branchname; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <select id="building_id_add" name="building_id" style="width: 100%;" class="form-control mb">
                                            <option value="building_id">Select Building</option>
                                            <?php
                                            foreach ($buildings as $building) : ?>
                                                <option style="display: none;" data-building-branch-id="<?php echo $building->branch_id; ?>" value="<?php echo $building->id; ?>"><?php echo $building->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <br />
                                <button type="submit" class="btn btn-primary">Add Floor</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="edit" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Edit Floor</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('Master/updatefloor') ?>">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Floor Name</label>
                                        <input type="text" placeholder="Floor Name" id="floorname" name="floorname" class="form-control mb" required>
                                        <input type="hidden" id="floorid" name="floorid" />
                                    </div>
                                    <div class="col-md-12">
                                        <select onchange="handleFilterEditBuilding(event)" id="branch_id" name="branch_id" style="width: 100%;" class="form-control mb">
                                            <option value="">Select Branch</option>
                                            <?php
                                            foreach ($lookups['branchlookup'] as $branch) : ?>
                                                <option value="<?php echo $branch->branchid; ?>"><?php echo $branch->branchname; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <select id="building_id" name="building_id" style="width: 100%;" class="form-control mb">
                                            <option value="building_id">Select Building</option>
                                            <?php
                                            foreach ($buildings as $building) : ?>
                                                <option style="display: none;" data-building-branch-id="<?php echo $building->branch_id; ?>" value="<?php echo $building->id; ?>"><?php echo $building->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <br/>
                                <button type="submit" class="btn btn-primary">Floor Update </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    function edit(floorid, floorname, branch_id, building_id) {
        $('#floorid').val(floorid);
        $('#floorname').val(floorname);
        $('#branch_id').val(branch_id);
        $('#building_id').val(building_id);
    }

    function remove(id) {
        if (confirm('Are you sure?')) {
            window.location.href = "<?php echo base_url('Master/deletefloor?floorid=') ?>" + id;
        }
    }

    function handleFilterAddBuilding(event) {
        var select = document.getElementById("building_id_add");
        for (var i = 0; i < select.options.length; i++) {
            var option = select.options[i];
            if (option.getAttribute("data-building-branch-id") == event.target.value) {
                option.style.display = "block";
            } else {
                option.style.display = "none";
            }
        }
    }

    function handleFilterEditBuilding(event) {
        var select = document.getElementById("building_id");
        for (var i = 0; i < select.options.length; i++) {
            var option = select.options[i];
            if (option.getAttribute("data-building-branch-id") == event.target.value) {
                option.style.display = "block";
            } else {
                option.style.display = "none";
            }
        }
    }
</script>