<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Holidays
                    <a class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#addroles">Add Holidays</a>
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblseniormanagement" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($holidays as $holiday) :
                                ?>
                                    <tr>
                                        <td><?php echo $holiday->id ?></td>
                                        <td><?php echo  $holiday->title ?></td>
                                        <td><?php echo  $holiday->from_date ?> <?php echo  $holiday->to_date ?></td>
                                        <td><i onclick="edit('<?php echo $holiday->id ?>', '<?php echo  $holiday->title ?>', '<?php echo  $holiday->from_date ?>')" data-toggle="modal" data-target="#edit" class="fa fa-pencil-square-o editbtn"></i></td>
                                        <td>
                                           <i onclick="remove('<?php echo $holiday->id ?>')" class='fa fa-trash'></i>
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
                            <h2 class="modal-title">Add Holidays</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('admin/createholiday') ?>">
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="rolename" class="text-uppercase text-sm">Title</label>
                                        <input type="text" placeholder="Title" name="message" class="form-control mb" required>
                                    </div>
                                     <div class="col-md-12">
                                        <label for="rolename" class="text-uppercase text-sm">From Date</label>
                                        <input type="date" placeholder="From Date" name="from_date" class="form-control mb" required>
                                    </div>
                                     <div class="col-md-12">
                                        <label for="rolename" class="text-uppercase text-sm">To Date</label>
                                        <input type="date" placeholder="To date" name="to_date" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="rolename" class="text-uppercase text-sm">Admission Type</label>
                                        <select name="admissiontypeid" class="form-control mb">
                                            <option value="">select admission type</option>
                                            <option value="1">Residential</option>
                                            <option value="3">Day scholar</option>
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