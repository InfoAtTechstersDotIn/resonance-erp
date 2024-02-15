<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Concerns

                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblseniormanagement" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Student Name</th>
                                    <th>Father Name</th>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    <th>Description</th>
                                    <th>Contact Time</th>
                                    <th>Branch</th>
                                    <th>Status</th>
                                    <th>Assigned To</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($concerns as $concern) :
                                ?>
                                    <tr>
                                        <td><?php echo $concern->id ?></td>
                                        <td><?php echo  $concern->name ?> - <?php echo  $concern->applicationnumber;?></td>
                                        <td><?php echo  $concern->fathername ?></td>
                                        <td><?php echo  $concern->categoryname ?></td>
                                        <td><?php echo  $concern->subcategoryname ?></td>
                                        <td><?php echo  $concern->details; ?></td>
                                        <td><?php echo  $concern->from_time . ' - ' . $concern->to_time; ?></td>
                                        <td><?php echo  $concern->branchname; ?></td>
                                        <td><?php echo  $concern->status; ?></td>
                                        
                                        <td><?php echo  $concern->assignedname; ?></td>
                                        <td>
                                            <?php if ($concern->status == 'Pending' && $concern->assigned_to == '') { ?>

                                                <button class="btn btn-success user_status" student_id="<?php echo $concern->userid; ?>" uid="<?php echo $concern->id; ?>" ustatus="<?php echo "Resolved"; ?>">Assign</button>

                                            <?php } else { ?>



                                            <?php } ?>

                                        </td>

                                    </tr>

                                    <div class="modal modal-danger fade" id="modal_popup">

                                        <div class="modal-dialog modal-sm">
                                            <form action="<?php echo base_url('admin/concern_status_changed'); ?>" method="post">
                                                <div class="modal-content">

                                                    <div class="modal-header" height: 115px;margin-top: 19px;>

                                                        <!-- <h4 style="margin-top: 50px;text-align: center;">Are you sure, do you change status?</h4> -->
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
                                                        <input type="hidden" name="id" id="user_id" value="">
                                                        <!-- <input type="hidden" name="student_id" id="student_id" value=""> -->
                                                        <!-- <input type="hidden" name="status" id="user_status" value=""> -->

                                                    </div>

                                                    <div class="modal-footer">
                                                        <input type="submit" value="submit" class="btn btn-success" name="submit">
                                                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>

                                                        <!-- <button type="submit" name="submit" class="btn btn-success">Yes</button> -->

                                                    </div>

                                                </div>

                                            </form>

                                        </div>

                                    </div>
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
        <script type="text/javascript">
            $(document).on('click', '.user_status', function() {

                var id = $(this).attr('uid'); //get attribute value in variable
                var status = $(this).attr('ustatus'); //get attribute value in variable
                var student_id = $(this).attr('student_id'); //get attribute value in variable
                $('#user_id').val(id); //pass attribute value in ID
                $('#user_status').val(status); //pass attribute value in ID
                $('#student_id').val(student_id);
                $('#modal_popup').modal({
                    backdrop: 'static',
                    keyboard: true,
                    show: true
                }); //show modal popup

            });
        </script>
        <script>
            function edit(id, message, description) {
                $('#id').val(id);
                $('#message').val(message);
                $('#description').val(description);
            }

            function remove(id) {
                if (confirm('Are you sure?')) {
                    window.location.href = "<?php echo base_url('admin/deleteannouncement?id=') ?>" + id;
                }
            }
        </script>