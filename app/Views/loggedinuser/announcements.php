<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Announcements
                    <a class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#addroles">Add Announcement</a>
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblseniormanagement" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Announcement Date</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($announcements as $announcement) :
                                ?>
                                    <tr>
                                        <td><?php echo $announcement->id ?></td>
                                        <td><?php echo  $announcement->message ?></td>
                                        <td><?php echo  $announcement->description ?></td>
                                        <td><?php echo  $announcement->annoucement_date; ?></td>
                                        <td><i onclick="edit('<?php echo $announcement->id ?>', '<?php echo  $announcement->message ?>', '<?php echo  $announcement->description ?>')" data-toggle="modal" data-target="#edit" class="fa fa-pencil-square-o editbtn"></i></td>
                                        <td>
                                           <i onclick="remove('<?php echo $announcement->id ?>')" class='fa fa-trash'></i>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="addroles" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Add Announcement</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('admin/createannouncement') ?>">
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="rolename" class="text-uppercase text-sm">Title</label>
                                        <input type="text" placeholder="Title" name="message" class="form-control mb" required>
                                    </div>
                                     <div class="col-md-12">
                                        <label for="rolename" class="text-uppercase text-sm">Description</label>
                                        <input type="text" placeholder="Description" name="description" class="form-control mb" required>
                                    </div>
                                     <div class="col-md-12">
                                        <label for="Date" class="text-uppercase text-sm">Announcement Date</label>
                                        <input type="date" placeholder="Description" name="date" class="form-control mb" required>
                                    </div>
                                </div>
                                <button type="submit" name="createrole" class="btn btn-primary">Create Announcement</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="edit" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Edit Announcement</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('admin/updateannouncement') ?>">
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Title</label>
                                        <input type="text" placeholder="Branch Name" name="message" id="message" class="form-control mb" required>
                                        <input type="hidden" name="id" id="id" />
                                    </div>
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Branch Address</label>
                                        <input type="text" placeholder="Branch Address" name="description" id="description" class="form-control mb" required>
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