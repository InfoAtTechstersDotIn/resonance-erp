<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Reservation Discounts By Course
                    <a class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#addroles">Add Reservation Discount</a>
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblseniormanagement" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Branch Name</th>
                                    <th>Course Name</th>
                                    <th>Admission Type</th>
                                    <th>Amount</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($reservationdiscount as $res) :
                                ?>
                                    <tr>
                                        <td><?php echo $res->branchname ?></td>
                                        <td><?php echo  $res->coursename ?></td>
                                        <td><?php echo  $res->admissiontypename ?></td>
                                        <td><?php echo  $res->amount ?></td>
                                        <td><i onclick="edit('<?php echo $res->id ?>', '<?php echo  $res->amount ?>', '<?php echo  $res->coursename ?>', '<?php echo  $res->branchname ?>', '<?php echo  $res->admissiontypename ?>')" data-toggle="modal" data-target="#edit" class="fa fa-pencil-square-o editbtn"></i></td>
                                        <td>
                                           <i onclick="remove('<?php echo $res->id ?>')" class='fa fa-trash'></i>
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
                            <h2 class="modal-title">Add Reservation Discount</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('admin/createreservationdiscount') ?>">
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="rolename" class="text-uppercase text-sm">Branch Name</label>
                                       <select id="branchid" name="branchid" style="width: 100%;" class="select2 form-control mb">
                                       <option value=""></option>
                                       <?php
                                       foreach ($lookups['branchlookup'] as $branch) :
                                       ?>
                                          <option value="<?php echo $branch->branchid; ?>"><?php echo $branch->branchname; ?></option>
                                       <?php
                                       endforeach;
                                       ?>
                                    </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="rolename" class="text-uppercase text-sm">Course Name</label>
                                       <select id="courseid" name="courseid" style="width: 100%;" class="select2 form-control mb">
                                       <option value=""></option>
                                       <?php
                                       foreach ($lookups['courselookup'] as $course) :
                                       ?>
                                          <option value="<?php echo $course->courseid; ?>"><?php echo $course->coursename; ?></option>
                                       <?php
                                       endforeach;
                                       ?>
                                    </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="rolename" class="text-uppercase text-sm">Admission Type</label>
                                        <select name="admissiontypeid" class="select2 form-control mb" style="width: 100%;">
                                            <option value="">select admission type</option>
                                            <option value="1">Residential</option>
                                            <option value="3">Day scholar</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="rolename" class="text-uppercase text-sm">Academic Year</label>
                                         <select id="batchid" name="batchid" style="width: 100%;" class="select2 form-control mb">
                                       <option value=""></option>
                                       <?php
                                       foreach ($lookups['batchlookup'] as $batch) :
                                       ?>
                                          <option value="<?php echo $batch->batchid; ?>"><?php echo $batch->batchname; ?></option>
                                       <?php
                                       endforeach;
                                       ?>
                                    </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="rolename" class="text-uppercase text-sm">Amount</label>
                                        <input type="text" placeholder="Amount" name="amount" class="form-control mb" required>
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
                            <h2 class="modal-title">Edit Reservation Discount</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('admin/updatereservationdiscount') ?>">
                                <br>
                                <div id="">
                                    <label class="text-uppercase text-sm">Course</label>
                                        <input type="text" disabled placeholder="coursename" name="coursename" id="coursename" class="form-control mb">
                                </div>
                                <div id="">
                                    <label class="text-uppercase text-sm">Branch</label>
                                        <input type="text" disabled placeholder="branchname" name="branchname" id="branchname" class="form-control mb">
                                </div>
                                <div id="">
                                     <label class="text-uppercase text-sm">Admission Type</label>
                                        <input type="text" disabled placeholder="admissiontypename" name="admissiontypename" id="admissiontypename" class="form-control mb">
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Amount</label>
                                        <input type="text" placeholder="Amount" name="amount" id="amount" class="form-control mb" required>
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
        
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Reservation Discounts By User
                    <!--<a class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#addroles">Add Reservation Discount</a>-->
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblseniormanagement" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($reservationdiscountbyuserid as $res) :
                                ?>
                                    <tr>
                                        <td><?php echo $res->name ?></td>
                                        <td><?php echo  $res->amount ?></td>
                                        <td><i onclick="edit1('<?php echo $res->id ?>', '<?php echo  $res->amount ?>','<?php echo  $res->name ?>')" data-toggle="modal" data-target="#edit1" class="fa fa-pencil-square-o editbtn"></i></td>
                                        <td>
                                           <i onclick="remove('<?php echo $res->id ?>')" class='fa fa-trash'></i>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="edit1" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Edit Reservation Discount By user</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <br>
                                <div id="">
                                    <label class="text-uppercase text-sm">Name</label>
                                        <input type="text" disabled placeholder="Name" name="name" id="name" class="form-control mb">
                                </div>
                            <form method="post" action="<?php echo base_url('admin/updatereservationdiscountbyuserid') ?>">
                               
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Amount</label>
                                        <input type="text" placeholder="Amount" name="amount1" id="amount1" class="form-control mb" required>
                                        <input type="hidden" name="id" id="id1" />
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

   <script>
    function edit(id, message, coursename,branchname,admissiontypename) {
        $('#id').val(id);
        $('#amount').val(message);
        $('#coursename').val(coursename);
        $('#branchname').val(branchname);
        $('#admissiontypename').val(admissiontypename);
    }
    
     function edit1(id, message,name) {
        $('#id1').val(id);
        $('#amount1').val(message);
        $('#name').val(name);
    }

    function remove(id) {
        if(confirm('Are you sure?'))
        {
            window.location.href = "<?php echo base_url('admin/deleteannouncement?id=') ?>" + id;
        }
    }
</script>     