<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">counsoller mapping
                    <a class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#addroles">Add counsoller mapping</a>
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblseniormanagement" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Employee Name</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th>Update Date</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i=1;
                                foreach ($counsollermapping as $announcement) :
                                ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td><?php echo  $announcement->name ?></td>
                                        <td><?php echo  $announcement->employeename ?></td>
                                        <td><?php 
                                        if($announcement->is_active == 1)
                                        {
                                            echo "Active";
                                        }else
                                        {
                                            echo "In-active";
                                        }
                                        ?></td>
                                        <td><?php echo  $announcement->created_at; ?></td>
                                        <td><?php echo  $announcement->update_at; ?></td>
                                        <td>
                                            <?php
                                             if($announcement->is_active == 1)
                                        {
                                            ?>
                                            <i onclick="edit('<?php echo $announcement->id ?>', '<?php echo  $announcement->name ?>', '<?php echo  $announcement->employeename ?>')" data-toggle="modal" data-target="#edit" class="fa fa-pencil-square-o editbtn"></i></td>
                                    <?php } ?>
                                    </tr>
                                <?php $i++; endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="addroles" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Add counsoller mapping</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('admin/createcounsollermapping') ?>">
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="rolename" class="text-uppercase text-sm">Name</label>
                                        <input type="text" placeholder="Name" name="name" class="form-control mb" required>
                                    </div>
                                     <div class="col-md-12">
                                        <label>Select Employee To Assign</label>
                                                        <select name="userid" class="select2 form-control mb" required style="width:100%">
                                                            <option value="">Select Employee</option>
                                                            <?php foreach ($EmployeeDetail as $res) :
                                                            ?>
                                                                <option value="<?php echo $res->userid; ?>"><?php echo $res->name; ?></option>
                                                            <?php
                                                            endforeach;
                                                            ?>

                                                        </select>
                                    </div>
                                </div>
                                <button type="submit" name="createrole" class="btn btn-primary">Create</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="edit" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Edit counsoller mapping</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('admin/updatecounsollermapping') ?>">
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Name</label>
                                        <input type="text" placeholder="Branch Name" name="name" id="message" class="form-control mb" required>
                                        <input type="hidden" name="id" id="id" />
                                    </div>
                                    <div class="col-md-12">
                                         <label>Select Employee To Assign</label>
                                                        <select name="userid" class="select2 form-control mb" required style="width:100%">
                                                            <option value="">Select Employee</option>
                                                            <?php foreach ($EmployeeDetail as $res) :
                                                            ?>
                                                                <option value="<?php echo $res->userid; ?>"><?php echo $res->name; ?></option>
                                                            <?php
                                                            endforeach;
                                                            ?>

                                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Branch</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

   <script>
    function edit(id, message, description) {
        $('#id').val(id);
        $('#message').val(message);
        $('#description').val(description);
    }

    function remove(id) {
        if(confirm('Are you sure?'))
        {
            window.location.href = "<?php echo base_url('admin/deleteannouncement?id=') ?>" + id;
        }
    }
</script>     