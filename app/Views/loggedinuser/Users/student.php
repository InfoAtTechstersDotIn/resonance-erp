<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Students
                    <?php

                    use App\Models\HelperModel;

                    if ($_SESSION['rights'][array_search('Student', array_column($_SESSION['rights'], 'operationname'))]->_add == 1) : ?>
                        <!-- <a class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#addstudent">Add Student</a> -->
                        <!-- <a class="btn btn-success" style="float: right;" target="_blank" href="<?php echo base_url('users/addstudent') ?>">Add Student</a> -->
                        <!-- <a class="btn btn-success" data-toggle="modal" data-target="#quickaddstudent">Quick Add Student</a> -->
                        <!-- <button onclick="printApplicationForm(<?php echo $userid; ?>);return false;" class="btn btn-warning">Print Empty Application Form<span class="glyphicon glyphicon-tick"></span></button> -->
                        <!-- <div id="divprint" style="display: none;"></div> -->
                        
                        <!-- <a class="btn btn-success" data-toggle="modal" data-target="#Resofast" style="float: right;margin-left:10px">Add Student from Resofast</a> -->
                        <!-- <a class="btn btn-warning" data-toggle="modal" data-target="#Registration" style="float: right;margin-left:10px">Add Student from Registrations</a> -->
                        <!--<a target="_blank" class="btn btn-default" href="<?php echo base_url("users/addstudent") ?>" style="float: right;">Add Student</a>-->
                    <?php endif; ?>
                </h2>
                <?php if($_SESSION['userdetails']->roleid !=12){
                    ?>
                
                <form>
                    <div class="row">
                        <div class="col-md-3">
                            <select name="branchid" style="width: 100%;" class="form-control">
                                <option value="">Select Branch</option>
                                <?php
                                foreach ($lookups['branchlookup'] as $branch) :
                                ?>
                                    <option value="<?php echo $branch->branchid; ?>" <?php echo isset($_GET['branchid']) && $_GET['branchid'] == $branch->branchid ? "selected" : "" ?>><?php echo $branch->branchname; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="courseid" style="width: 100%;" class="form-control">
                                <option value="">Select Course</option>
                                <?php
                                foreach ($lookups['courselookup'] as $course) :
                                ?>
                                    <option value="<?php echo $course->courseid; ?>" <?php echo isset($_GET['courseid']) && $_GET['courseid'] == $course->courseid ? "selected" : "" ?>><?php echo $course->coursename; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="admissiontypeid" style="width: 100%;" class="form-control">
                                <option value="">Select Admission Type</option>
                                <?php
                                foreach ($lookups['admissiontypelookup'] as $admissiontype) :
                                ?>
                                    <option value="<?php echo $admissiontype->admissiontypeid; ?>" <?php echo isset($_GET['admissiontypeid']) && $_GET['admissiontypeid'] == $admissiontype->admissiontypeid ? "selected" : "" ?>><?php echo $admissiontype->admissiontypename; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="sectionid" style="width: 100%;" class="form-control mb">
                                <option value="">Select Section</option>
                                <?php
                                foreach ($lookups['sectionlookup'] as $section) :
                                ?>
                                    <option value="<?php echo $section->sectionid; ?>"><?php echo $section->sectionname; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <select name="applicationstatusid" style="width: 100%;" class="form-control">
                                <option value="">Select Application Status</option>
                                <?php
                                foreach ($lookups['applicationstatuslookup'] as $applicationstatus) :
                                ?>
                                    <option value="<?php echo $applicationstatus->applicationstatusid; ?>" <?php echo isset($_GET['applicationstatusid']) && $_GET['applicationstatusid'] == $applicationstatus->applicationstatusid ? "selected" : "" ?>><?php echo $applicationstatus->applicationstatusname; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="secondlanguageid" style="width: 100%;" class="form-control">
                                <option value="">Select Second Language</option>
                                <?php
                                foreach ($lookups['secondlanguagelookup'] as $secondlanguage) :
                                ?>
                                    <option value="<?php echo $secondlanguage->secondlanguageid; ?>" <?php echo isset($_GET['secondlanguageid']) && $_GET['secondlanguageid'] == $secondlanguage->secondlanguageid ? "selected" : "" ?>><?php echo $secondlanguage->secondlanguagename; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </form>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblStudents" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Application Number</th>
                                    <th>Student Name</th>
                                    <th>Application Status</th>
                                    <th>Gender</th>
                                    <th>Branch</th>
                                    <th>Cource - Admission Type - Section</th>
                                    <th>Mobile</th>
                                    <th>Comments</th>
                                    <?php if ($_SESSION['rights'][array_search('Student', array_column($_SESSION['rights'], 'operationname'))]->_delete == 1) : ?>
                                        <th>Delete</th>
                                    <?php endif; ?>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($StudentDetails as $result) :
                                    if (isset($_GET['branchid'])) {
                                        if ($_GET['branchid'] == "" || $result->branchid == $_GET['branchid']) {
                                        } else {
                                            continue;
                                        }
                                    }
                                    if (isset($_GET['courseid'])) {
                                        if ($_GET['courseid'] == "" || $result->courseid == $_GET['courseid']) {
                                        } else {
                                            continue;
                                        }
                                    }
                                    if (isset($_GET['admissiontypeid'])) {
                                        if ($_GET['admissiontypeid'] == "" || $result->admissiontypeid == $_GET['admissiontypeid']) {
                                        } else {
                                            continue;
                                        }
                                    }
                                    if (isset($_GET['sectionid'])) {
                                        if ($_GET['sectionid'] == "" || $result->sectionid == $_GET['sectionid']) {
                                        } else {
                                            continue;
                                        }
                                    }
                                    if (isset($_GET['applicationstatusid'])) {
                                        if ($_GET['applicationstatusid'] == "" || $result->applicationstatusid == $_GET['applicationstatusid']) {
                                        } else {
                                            continue;
                                        }
                                    }
                                    if (isset($_GET['secondlanguageid'])) {
                                        if ($_GET['secondlanguageid'] == "" || $result->secondlanguageid == $_GET['secondlanguageid']) {
                                        } else {
                                            continue;
                                        }
                                    }
                                ?>
                                    <tr>
                                        <?php
                                        if ($result->applicationstatusname <> "Approved") {
                                            $helperModel = new HelperModel();
                                            $Miscellaneous_Charges = $helperModel->get_fees_from_lookup($result->courseid, $result->admissiontypeid, $result->batchid, 'Miscellaneous Charges');
                                            $Intermediate_Fee = $helperModel->get_fees_from_lookup($result->courseid, $result->admissiontypeid, $result->batchid, 'Intermediate Fee');

                                            $fees = $Miscellaneous_Charges + $Intermediate_Fee + $result->tuition_discount + $result->hostel_discount;

                                            $Role = $helperModel->get_approvallookup($result->admissiontypeid, $fees);
                                            $RoleId = $Role->roleid;
                                        }
                                        ?>
                                        <td><?php echo $result->applicationnumber ?>
                                            <?php
                                          //  echo $_SESSION['rights'][array_search('Student', array_column($_SESSION['rights'], 'operationname'))]->_view;
                                            $helperModel = new HelperModel();
                                           $promoted = $helperModel->studentpromoteddiscount($StudentDetail->userid);
                                            if ($result->applicationstatusname != "Dropped Out" && ($_SESSION['userdetails']->rolename == "CFO" || $_SESSION['userdetails']->rolename == "Super Admin") && $promoted==1) :
                                                echo "<a href='" . base_url('users/dropstudent?id=') . $result->userid . "' class='btn btn-danger'>Drop</a>";
                                            endif;
                                            if ($result->applicationstatusname != "Dropped Out" && ($_SESSION['userdetails']->rolename == "CFO" || $_SESSION['userdetails']->rolename == "Super Admin" || $_SESSION['userdetails']->rolename == "Administrator") && $promoted==1) :
                                            if($result->courseid == 1 || $result->courseid == 4 || $result->courseid ==7){
                                             echo "<a href='" . base_url('users/promotestudent?id=') . $result->userid . "' class='btn btn-success'>Promote</a>";
                                            }
                                              endif;?>
                                        </td>
                                        <?php
                                        if ($_SESSION['rights'][array_search('Student', array_column($_SESSION['rights'], 'operationname'))]->_edit == 1 || $result->applicationstatusname == "Declined") : ?>
                                            <td>
                                                <a target="_blank" href="<?php echo base_url('users/studentdetails') ?>?id=<?php echo $result->userid; ?>"><?php echo $result->name ?></a>
                                            </td>
                                        <?php
                                        else :
                                        ?>
                                            <td><?php echo $result->name ?></td>
                                        <?php
                                        endif;
                                        ?>
                                        <td>
                                            <?php echo $result->applicationstatusname != "Approved" ? $result->applicationstatusname . " By {$Role->rolename}" : $result->applicationstatusname ?>
                                        </td>
                                        <td><?php echo $result->gendername ?></td>
                                        <td><?php echo $result->branchname ?></td>
                                        <td><?php echo $result->coursename . ", " . $result->admissiontypename . "<br />Section: " . $result->sectionname ?></td>
                                        <td><?php echo $result->mobile1 . "<br />" . $result->mobile2 ?></td>
                                        <td><?php echo $result->comments; ?></td>
                                        <?php if ($_SESSION['rights'][array_search('Student', array_column($_SESSION['rights'], 'operationname'))]->_delete == 1) : ?>
                                            <td>
                                                <?php
                                                $html = "<a href='" . base_url('users/deletestudent') . "?id=" . $result->userid . "' class='btn-del'><i class='fa fa-trash'></i></a>";
                                                echo $html; ?></i>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
        <?php }else{ ?>
        <br />
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblStudents" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Application Number</th>
                                    <th>Student Name</th>
                                    <th>Edit</th>
                                    <th>Print</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($StudentDetails as $result) :
                                ?>
                                    <tr>
                                        <?php
                                       
                                        ?>
                                        <td><?php echo $result->application_number ?>
                                           
                                        </td>
                                        <?php
                                        if ($_SESSION['rights'][array_search('Student', array_column($_SESSION['rights'], 'operationname'))]->_edit == 1 || $result->applicationstatusname == "Declined") : ?>
                                            <td>
                                                <a target="_blank" href="<?php echo base_url('users/studentdetails') ?>?id=<?php echo $result->id; ?>"><?php echo $result->name ?></a>
                                            </td>
                                        <?php
                                        else :
                                        ?>
                                            <td><?php echo $result->name ?></td>
                                        <?php
                                        endif;
                                        ?>
                                        <td>
                                                <a target="_blank" href="<?php echo base_url('users/studentdetails') ?>?id=<?php echo $result->id; ?>"><i class="fa fa-pencil-square-o editbtn"></i></a>
                                            </td>
                                         <td>
                                              <?php if( $_SESSION['is_singleprint'] ==1){ 
                                                $helperModel = new HelperModel();
                                                $print = $helperModel->student_tc_log($result->userid);
                                                if($print == 0){
                                              ?>
                                                <a target="_blank" href="<?php echo base_url('forms/transferCertificate') ?>?userId=<?php echo $result->userid; ?>&batchid=<?php echo $_SESSION['activebatch']; ?>">Generate Transfer Certificate</a>
                                            <?php } }else
                                            {
                                                ?>
                                                <a target="_blank" href="<?php echo base_url('forms/transferCertificate') ?>?userId=<?php echo $result->userid; ?>&batchid=<?php echo $_SESSION['activebatch']; ?>">Generate Transfer Certificate</a>
                                                <?php
                                            } ?>
                                            </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php } ?>
                <div class="modal fade" id="Resofast" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document" style="width: 80vw">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title">Load Student Details From Resofast</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="get" action="<?php echo base_url('users/addstudent') ?>">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="text-uppercase text-sm">Reso Fast Hallticket Number</label>
                                            <input type="text" placeholder="Reso Fast Hallticket Number" name="resofast" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <br />
                                            <button type="submit" class="btn btn-primary">Load</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="Registration" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document" style="width: 80vw">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title">Load Student Details From Registrations</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="get" action="<?php echo base_url('users/addstudent') ?>">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="text-uppercase text-sm">Registration Id</label>
                                            <input type="text" placeholder="Registration Id" name="registration" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <br />
                                            <button type="submit" class="btn btn-primary">Load</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.btn-del').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href')
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    document.location.href = href;
                }
            })

    })
</script>