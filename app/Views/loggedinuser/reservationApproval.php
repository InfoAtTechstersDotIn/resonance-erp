<div class="content-wrapper">
    <div class="container-fluid">
        <?php

        use App\Models\HelperModel;

        if ($_SESSION['rights'][array_search('UserApproval', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
            <div class="row">
                <div class="col-md-12">
                    <h2 class="page-title">Reservation Approvals</h2>
                    <form>
                    <div class="row">
                            <div class="col-md-4">
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
                            <div class="col-md-4">
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
                            <div class="col-md-4">
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
                                <br />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <select name="reservationstatusid" style="width: 100%;" class="form-control">
                                    <option value="">Select Reservation Status</option>
                                    <?php
                                    foreach ($lookups['reservationstatuslookup'] as $reservationstatus) :
                                    ?>
                                        <option value="<?php echo $reservationstatus->reservationstatusid; ?>" <?php echo isset($_GET['reservationstatusid']) && $_GET['reservationstatusid'] == $reservationstatus->reservationstatusid ? "selected" : "" ?>><?php echo $reservationstatus->reservationstatusname; ?></option>
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
                                        <th>Student Name/ Reservation Id</th>
                                        <th>Branch - Cource - Admission Type</th>
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
                                        if (isset($_GET['reservationstatusid'])) {
                                            if ($_GET['reservationstatusid'] == "" || $result->reservationstatusid == $_GET['reservationstatusid']) {
                                            } else {
                                                continue;
                                            }
                                        }
                                    ?>
                                        <tr>
                                            <?php
                                            $helperModel = new HelperModel();
                                           
                                            $Books = $helperModel->get_fees_from_lookup($result->courseid, $result->admissiontypeid, $result->batchid, 'Books');
                                            $Uniform = $helperModel->get_fees_from_lookup($result->courseid, $result->admissiontypeid, $result->batchid, 'Uniform');
                                            $Laundry = $helperModel->get_fees_from_lookup($result->courseid, $result->admissiontypeid, $result->batchid, 'Laundry');
                                            $Caution_Deposit = $helperModel->get_fees_from_lookup($result->courseid, $result->admissiontypeid, $result->batchid, 'Caution Deposit');
                                            $Miscellaneous_Charges = $Books+$Uniform+$Laundry+$Caution_Deposit;
                                            
                                            $Intermediate_Fee = $result->ipe_discount != 0 ? $result->ipe_discount :$helperModel->get_fees_from_lookup($result->courseid, $result->admissiontypeid, $result->batchid, 'Intermediate Fee');
                                            
                                            if ($result->final_misc != 0) {
                                                $fees = $result->final_misc + $Intermediate_Fee + $result->tuition_discount + $result->hostel_discount;
                                            } else {
                                                $fees = $Miscellaneous_Charges + $Intermediate_Fee + $result->tuition_discount + $result->hostel_discount;
                                            }

                                            $Role = $helperModel->get_approvallookup($result->admissiontypeid, $fees);
                                            $RoleId = $Role->roleid;

                                            ?>
                                            <td><?php echo $result->name ?><br />
                                                <a target="_blank" href="<?php echo base_url('users/reservationDetails') ?>?id=<?php echo $result->reservationid; ?>"><b><?php echo $result->reservation_ukey ?></b></a><br />
                                                <b>Status: </b><?php echo $result->reservationstatusname != "Approved" && $result->reservationstatusname != "Waiting" ? $result->reservationstatusname . " By {$Role->rolename}" : $result->reservationstatusname ?>
                                            </td>
                                            <td><?php echo $result->branchname ?><br />
                                                <?php echo $result->coursename ?><br />
                                                <?php echo $result->admissiontypename ?><br />
                                            </td>
                                            <?php
            
                                            if (($_SESSION['userdetails']->userid == 1 || $_SESSION['userdetails']->roleid == $RoleId) && $result->reservationstatusname == "Pending for Approval") {  ?>
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
                                                <td><input type="text" placeholder="comments" id="<?php echo $result->reservationid ?>comments" value="<?php echo $result->comments ?>" class="form-control mb"></td>
                                                <td>
                                                    <a class="btn btn-success" onclick="approvestudent('<?php echo $result->reservationid ?>', this)">Approve</a><br><br>
                                                    <a class="btn btn-danger" onclick="declinestudent('<?php echo $result->reservationid ?>', this)">Decline</a>
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

    function approvestudent(reservationid, anchor) {
        $('.loading').css('display', 'block');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('users/reservationapprovalflow') ?>",
            data: {
                approvestudent: true,
                reservationid: reservationid,
                comments: $('#' + reservationid + "comments").val()
            },
            success: (data, anchor1 = anchor) => {
                debugger;
                alert("Student Approved");
                dt
                    .row($(anchor).parents('tr'))
                    .remove()
                    .draw(false);

                $('.loading').css('display', 'none');
            }
        });
    }

    function declinestudent(reservationid, anchor) {
        $('.loading').css('display', 'block');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('users/reservationapprovalflow') ?>",
            data: {
                declinestudent: true,
                reservationid: reservationid,
                comments: $('#' + reservationid + "comments").val()
            },
            success: (anchor1 = anchor) => {
                debugger;
                dt
                    .row($(anchor).parents('tr'))
                    .remove()
                    .draw(false);
                $('.loading').css('display', 'none');
            }
        });

    }
</script>