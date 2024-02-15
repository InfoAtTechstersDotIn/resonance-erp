<div class="content-wrapper">
    <div class="container-fluid">
        <?php if ($_SESSION['rights'][array_search('PaymentApproval', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>
            <div class="row">
                <div class="col-md-12">
                    <h2 class="page-title">Reservation Payment Approvals</h2>
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
                                <label class="text-uppercase text-sm">From Date</label>
                                <input type="text" value="<?php echo isset($_GET['fromdate']) ? $_GET['fromdate'] : "" ?>" placeholder="dd/mm/yy" name="fromdate" class="form-control mb datepicker">
                            </div>
                            <div class="col-md-4">
                                <label class="text-uppercase text-sm">To Date</label>
                                <input type="text" value="<?php echo isset($_GET['todate']) ? $_GET['todate'] : "" ?>" placeholder="dd/mm/yy" name="todate" class="form-control mb datepicker">
                            </div>
                            <div class="col-md-3">
                                <br />
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-12">
                            <table id="tblpaymentApproval" class="DataTable table table-striped">
                                <thead>
                                    <tr>
                                        <th>Reservation Payment Id</th>
                                        <th>Name/ Reservation Number</th>
                                        <th>Payment Status</th>
                                        <th>Payment</th>
                                        <th>Payment Date</th>
                                        <th>Payment Type</th>
                                        <th>Payment Details</th>
                                        <th>Amount Received By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    foreach ($PendingPaymentDetails as $result) :
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
                                        if (isset($_GET['fromdate'])) {
                                            if ($_GET['fromdate'] == "" || date_create($result->paymentdate) >= date_create($_GET['fromdate'])) {
                                            } else {
                                                continue;
                                            }
                                        }
                                        if (isset($_GET['todate'])) {
                                            if ($_GET['todate'] == "" || date_create($result->paymentdate) <= date_create($_GET['todate'])) {
                                            } else {
                                                continue;
                                            }
                                        }
                                    ?>
                                        <tr>
                                            <td><a target="_blank" href="<?php echo base_url('payments/generatereservationreceipt?type=view&') ?>&reservationpaymentid=<?php echo $result->reservation_paymentid; ?>"><?php echo $result->reservation_paymentid ?></a></td>
                                            <td><?php echo $result->studentName ?><br /><a target="_blank" href="<?php echo base_url('users/reservationDetails') ?>?id=<?php echo $result->reservationid; ?>"><b><?php echo $result->reservation_ukey ?></b></a></td>
                                            <td><?php echo $result->paymentstatusname ?></td>
                                            <td><?php echo $result->paymentamount ?></td>
                                            <td><?php echo date_format(date_create($result->paymentdate), 'd/m/Y') ?></td>
                                            <td><?php echo $result->paymenttypename ?></td>
                                            <td><?php echo $result->otherdetails ?></td>
                                            <td><a target="_blank" href="<?php echo base_url('users/employeedetails') . "/" . $result->receivedbyid; ?>"><b><?php echo $result->receivedby ?></b></a></td>
                                            <td><a class="btn btn-success" onclick="approvePayment('<?php echo $result->reservation_paymentid ?>', this, '<?php echo $result->reservationid ?>');">Approve</a><br><br>
                                                <a class="btn btn-danger" onclick="rejectPayment('<?php echo $result->reservation_paymentid ?>', this, '<?php echo $result->reservationid ?>');">Reject</a>
                                            </td>
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

    function approvePayment(reservation_paymentid, anchor, reservationid) {
        $('.loading').css('display', 'block');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('payments/reservationpaymentapprovalflow') ?>",
            data: {
                approvepayment: true,
                reservation_paymentid: reservation_paymentid,
                reservationid: reservationid
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

    function rejectPayment(reservation_paymentid, anchor, reservationid) {
        $('.loading').css('display', 'block');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('payments/reservationpaymentapprovalflow') ?>",
            data: {
                rejectpayment: true,
                reservation_paymentid: reservation_paymentid,
                reservationid: reservationid
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