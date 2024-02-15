<div class="content-wrapper">
    <div class="container-fluid">
        <?php

        use App\Models\HelperModel;

        if ($_SESSION['rights'][array_search('UserApproval', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
            <div class="row">
                <div class="col-md-12">
                    <h2 class="page-title">Student Approvals</h2>
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
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </form>
                    <br />
                    <div class="row">
                        <div class="col-md-12">
                            <table id="tblApprovals" class="DataTable table table-striped">
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Branch - Cource - Admission Type - Section</th>
                                        <th>Approval Amount</th>
                                        <th>Comment</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    foreach ($PendingStudentDetails as $result) :
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
                                    ?>
                                        <tr>
                                            <?php
                                            $helperModel = new HelperModel();
                                            $Miscellaneous_Charges = $helperModel->get_fees_from_lookup($result->courseid, $result->admissiontypeid, $result->batchid, 'Miscellaneous Charges');
                                            $Intermediate_Fee = $helperModel->get_fees_from_lookup($result->courseid, $result->admissiontypeid, $result->batchid, 'Intermediate Fee');

                                            if ($result->final_misc != 0) {
                                                $fees = $result->final_misc + $Intermediate_Fee + $result->tuition_discount + $result->hostel_discount;
                                            } else {
                                                $fees = $Miscellaneous_Charges + $Intermediate_Fee + $result->tuition_discount + $result->hostel_discount;
                                            }

                                            $Role = $helperModel->get_approvallookup($result->admissiontypeid, $fees);
                                            $RoleId = $Role->roleid;

                                            ?>
                                            <td><?php echo $result->name ?><br />
                                                <a target="_blank" href="<?php echo base_url('users/studentdetails') ?>?id=<?php echo $result->userid; ?>"><b><?php echo $result->applicationnumber ?></b></a><br />
                                                <b>Status: </b><?php echo $result->applicationstatusname != "Approved" ? $result->applicationstatusname . " By {$Role->rolename}" : $result->applicationstatusname ?>
                                            </td>
                                            <td><?php echo $result->branchname ?><br />
                                                <?php echo $result->coursename ?><br />
                                                <?php echo $result->admissiontypename ?><br />
                                                <?php echo "Section: " . $result->sectionname ?>
                                            </td>
                                            <?php

                                            if ($_SESSION['userdetails']->userid == 1 || $_SESSION['userdetails']->roleid == $RoleId) {  ?>
                                                <td>
                                                    Final Tuition Fee: <b><?php echo $result->tuition_discount ?></b><br />
                                                    <?php if ($result->admissiontypeid == "1") : ?>
                                                        Final Hostel Fee: <b><?php echo $result->hostel_discount ?></b><br />
                                                    <?php endif; ?>
                                                    Miscellaneous Charges: <b><?php echo $result->final_misc != 0 ? $result->final_misc : $Miscellaneous_Charges ?></b><br />
                                                    Intermediate Fee: <b><?php echo $Intermediate_Fee ?></b><br />
                                                    Final Fees: <b><?php echo $fees; ?></b>
                                                    <br />
                                                </td>
                                                <td><input type="text" placeholder="comments" id="<?php echo $result->userid ?>comments" value="<?php echo $result->comments ?>" class="form-control mb"></td>
                                                <td>
                                                    <a class="btn btn-success" onclick="approvestudent('<?php echo $result->userid ?>', this)">Approve</a><br><br>
                                                    <a class="btn btn-danger" onclick="declinestudent('<?php echo $result->userid ?>', this)">Decline</a>
                                                </td>
                                            <?php } else { ?>
                                                <td>
                                                    Final Tuition Fee: <b><?php echo $result->tuition_discount ?></b><br />
                                                    <?php if ($result->admissiontypeid == "1") : ?>
                                                        Final Hostel Fee: <b><?php echo $result->hostel_discount ?></b><br />
                                                    <?php endif; ?>
                                                    Miscellaneous Charges: <b><?php echo $result->final_misc != 0 ? $result->final_misc : $Miscellaneous_Charges ?></b><br />
                                                    Intermediate Fee: <b><?php echo $Intermediate_Fee ?></b><br />
                                                    Final Fees: <b><?php echo $fees; ?></b>
                                                    <br />
                                                </td>
                                                <td><?php echo $result->comments ?></td>
                                                <td>
                                                    &nbsp;
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    var dt;

    dt = $('.DataTable').DataTable();

    function approvestudent(userid, anchor) {
        $('.loading').css('display', 'block');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('users/userapprovalflow') ?>",
            data: {
                approvestudent: true,
                userid: userid,
                comments: $('#' + userid + "comments").val()
            },
            success: (data, anchor1 = anchor) => {
                alert("Student Approved");
                dt
                    .row($(anchor).parents('tr'))
                    .remove()
                    .draw(false);

                $('.loading').css('display', 'none');
            }
        });
    }

    function declinestudent(userid, anchor) {
        $('.loading').css('display', 'block');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('users/userapprovalflow') ?>",
            data: {
                declinestudent: true,
                userid: userid,
                comments: $('#' + userid + "comments").val()
            },
            success: (anchor1 = anchor) => {
                dt
                    .row($(anchor).parents('tr'))
                    .remove()
                    .draw(false);
                $('.loading').css('display', 'none');
            }
        });

    }
</script>